<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use App\Models\StudentRelative;
use App\Models\StudentEnroll;
use App\Models\EnrollSubject;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use App\Models\Application;
use App\Models\StatusType;
use App\Models\Document;
use App\Models\Program;
use App\Models\Student;
use App\Models\Batch;
use App\Models\County;
use App\Models\SubCounty;
use Carbon\Carbon;
use Toastr;
use Auth;
use Hash;
use DB;
use App\Services\SmsService;
use App\Models\SmsConfiguration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ApplicationController extends Controller
{
    use FileUploader;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_application', 1);
        $this->route = 'admin.application';
        $this->view = 'admin.application';
        $this->path = 'student';
        $this->access = 'application';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    { 
        $data['title'] = $this->title; 
        $data['route'] = $this->route;
        $data['view'] = $this->view; 
        $data['path'] = $this->path;
        $data['access'] = $this->access; 

        // Default selection
        $data['selected_batch'] = $request->batch ?? '0';
        $data['selected_program'] = $request->program ?? '0';
        $data['selected_status'] = $request->status ?? '99';
        $data['selected_start_date'] = $request->start_date ?? null;
        $data['selected_end_date'] = $request->end_date ?? null;
        $data['selected_registration_no'] = $request->registration_no ?? null;

        $data['batches'] = Batch::where('status', '1')->orderBy('id', 'desc')->get();
        $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();

        // Query applications with filters
        $query = Application::with(['program', 'batch', 'county', 'subCounty'])
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                $query->whereDate('apply_date', '>=', $request->start_date)
                      ->whereDate('apply_date', '<=', $request->end_date);
            })
            ->when($request->batch && $request->batch !== '0', function($query) use ($request) {
                $query->where('batch_id', $request->batch);
            })
            ->when($request->program && $request->program !== '0', function($query) use ($request) {
                $query->where('program_id', $request->program);
            })
            ->when($request->registration_no, function($query) use ($request) {
                $query->where('registration_no', 'LIKE', '%' . $request->registration_no . '%');
            })
            ->when($request->status && $request->status != '99', function($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy('created_at', 'desc');

        $data['rows'] = $query->get();

        return view($this->view . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Field Validation
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'phone' => 'required|string|max:30',
            'email' => 'required|email|max:255|unique:applications,email',
            'national_id' => 'required|string|max:50',
            'gender' => 'required|in:1,2,3',
            'program_id' => 'required|integer|exists:programs,id',
            'kcse_index_no' => 'required|string|max:50',
            'kcse_year' => 'required|string|max:10',
            'kcse_grade' => 'required|string|max:10',
            'kcse_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'kcse_result_slip' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'county_id' => 'required|integer|exists:counties,CountyID',
            'sub_county_id' => 'required|integer|exists:sub_counties,SubCountyID',
            'physical_address' => 'nullable|string|max:255',
            'mode_of_study' => 'required|string|in:Physical,Online,Hybrid',
        ]);

        try {
            DB::beginTransaction();

            // Generate registration number
            $registrationNo = 'APP-' . date('Y') . '-' . str_pad(Application::count() + 1, 5, '0', STR_PAD_LEFT);

            // Create application
            $application = new Application();
            $application->registration_no = $registrationNo;
            $application->batch_id = $request->batch_id ?? 1;
            $application->program_id = $request->program_id;
            $application->apply_date = Carbon::now()->format('Y-m-d');

            // Personal Information
            $application->first_name = $request->first_name;
            $application->last_name = $request->last_name;
            $application->dob = $request->dob;
            $application->phone = $request->phone;
            $application->email = $request->email;
            $application->national_id = $request->national_id;
            $application->gender = $request->gender;

            // KCSE Information
            $application->kcse_index_no = $request->kcse_index_no;
            $application->kcse_year = $request->kcse_year;
            $application->kcse_grade = $request->kcse_grade;

            // Location Information
            $application->county_id = $request->county_id;
            $application->sub_county_id = $request->sub_county_id;
            $application->permanent_address = $request->physical_address;
            $application->mode_of_study = $request->mode_of_study;

            // Upload KCSE documents
            if ($request->hasFile('kcse_certificate')) {
                $application->kcse_certificate = $this->uploadMedia($request, 'kcse_certificate', 'applications');
            }
            if ($request->hasFile('kcse_result_slip')) {
                $application->kcse_result_slip = $this->uploadMedia($request, 'kcse_result_slip', 'applications');
            }

            $application->status = '1';
            $application->created_by = Auth::guard('web')->user()->id;
            $application->save();

            DB::commit();

            Toastr::success(__('Application submitted successfully'), __('msg_success'));
            return redirect()->route($this->route . '.index');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing application: ' . $e->getMessage());
            Toastr::error(__('msg_created_error'), __('msg_error'));
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['row'] = $application;

        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        // Only load necessary data - no provinces or districts
        $data['counties'] = County::where('status', '1')->orderBy('title', 'asc')->get();
        $data['sub_counties'] = SubCounty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['batches'] = Batch::where('status', '1')->orderBy('id', 'desc')->get();
        $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();

        $data['row'] = $application;

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        // Field Validation for editing application data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'phone' => 'required|string|max:30',
            'email' => 'required|email|max:255|unique:applications,email,' . $application->id,
            'national_id' => 'required|string|max:50',
            'gender' => 'required|in:1,2,3',
            'program_id' => 'required|integer|exists:programs,id',
            'kcse_index_no' => 'required|string|max:50',
            'kcse_year' => 'required|string|max:10',
            'kcse_grade' => 'required|string|max:10',
            'kcse_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'kcse_result_slip' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'county_id' => 'required|integer|exists:counties,CountyID',
            'sub_county_id' => 'required|integer|exists:sub_counties,SubCountyID',
            'physical_address' => 'nullable|string|max:255',
            'mode_of_study' => 'required|string|in:Physical,Online,Hybrid',
        ]);

        DB::beginTransaction();
        
        try {
            $oldStatus = $application->status;
            
            // Update application fields
            $application->first_name = $request->first_name;
            $application->last_name = $request->last_name;
            $application->dob = $request->dob;
            $application->phone = $request->phone;
            $application->email = $request->email;
            $application->national_id = $request->national_id;
            $application->gender = $request->gender;
            $application->program_id = $request->program_id;
            $application->kcse_index_no = $request->kcse_index_no;
            $application->kcse_year = $request->kcse_year;
            $application->kcse_grade = $request->kcse_grade;
            $application->county_id = $request->county_id;
            $application->sub_county_id = $request->sub_county_id;
            $application->permanent_address = $request->physical_address;
            $application->mode_of_study = $request->mode_of_study;

            // Handle file uploads
            if ($request->hasFile('kcse_certificate')) {
                $application->kcse_certificate = $this->uploadMedia($request, 'kcse_certificate', 'applications');
            }
            if ($request->hasFile('kcse_result_slip')) {
                $application->kcse_result_slip = $this->uploadMedia($request, 'kcse_result_slip', 'applications');
            }

            // Handle status change and SMS
            $newStatus = $request->status;
            $application->status = $newStatus;
            $application->updated_by = Auth::guard('web')->user()->id;
            $application->save();

            // Send SMS based on status change
            if ($oldStatus != $newStatus) {
                if ($newStatus == '0') { // Rejected
                    $this->sendRejectionSMS($application);
                } elseif ($newStatus == '2') { // Approved
                    // Auto-register as student if approved
                    $student = $this->approveAndRegisterStudent($application);
                    $this->sendWelcomeSMS($student);
                } elseif ($newStatus == '1' && $oldStatus == '0') { // Reinstated from rejected
                    $this->sendReinstatementSMS($application);
                }
            }

            DB::commit();
            
            Toastr::success(__('Application updated successfully'), __('msg_success'));
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating application: ' . $e->getMessage());
            Toastr::error(__('Error updating application'), __('msg_error'));
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        DB::beginTransaction();
        try {
            // Delete associated files
            $this->deleteMultiMedia('applications', $application, 'kcse_certificate');
            $this->deleteMultiMedia('applications', $application, 'kcse_result_slip');
            
            $application->delete();
            DB::commit();

            Toastr::success(__('Application deleted successfully'), __('msg_success'));

        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(__('Error deleting application'), __('msg_error'));
        }

        return redirect()->back();
    }

    /**
     * Approve application and register as student (manual approval)
     */
    public function approve($id)
    {
        DB::beginTransaction();
        
        try {
            $application = Application::findOrFail($id);
            
            if ($application->status != '1') {
                Toastr::error(__('Application is not pending for approval'), __('msg_error'));
                return redirect()->back();
            }
            
            // Update application status to approved
            $application->status = '2';
            $application->updated_by = Auth::guard('web')->user()->id;
            $application->save();

            // Register as student
            $student = $this->approveAndRegisterStudent($application);

            DB::commit();
            
            Toastr::success(__('Application approved and student registered successfully'), __('msg_success'));
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error approving application: ' . $e->getMessage());
            Toastr::error(__('Error approving application'), __('msg_error'));
        }

        return redirect()->route($this->route . '.index');
    }

    /**
     * Approve application and register as student
     */
    private function approveAndRegisterStudent($application)
    {
        try {
            // Generate student ID
            $studentId = $this->generateStudentId($application);
            
            // Check if student already exists
            $existingStudent = Student::where('student_id', $studentId)->orWhere('email', $application->email)->first();
            if ($existingStudent) {
                $studentId = $this->generateStudentId($application) . rand(100, 999);
            }
            
            // Create new student
            $student = new Student();
            $student->student_id = $studentId;
            $student->registration_no = $application->registration_no;
            $student->batch_id = $application->batch_id;
            $student->program_id = $application->program_id;
            $student->admission_date = Carbon::now()->format('Y-m-d');

            // Personal Information
            $student->first_name = $application->first_name;
            $student->last_name = $application->last_name;
            $student->dob = $application->dob;
            $student->phone = $application->phone;
            $student->email = $application->email;
            $student->national_id = $application->national_id;
            $student->gender = $application->gender;
            
            // Generate random password
            $password = str_random(8);
            $student->password = Hash::make($password);
            $student->password_text = Crypt::encryptString($password);

            // Location information
            $student->county_id = $application->county_id;
            $student->sub_county_id = $application->sub_county_id;
            $student->permanent_address = $application->permanent_address;
            
            // KCSE Information
            $student->kcse_index_no = $application->kcse_index_no;
            $student->kcse_year = $application->kcse_year;
            $student->kcse_grade = $application->kcse_grade;
            $student->mode_of_study = $application->mode_of_study;

            // Move documents from applications to students folder
            if ($application->kcse_certificate) {
                $student->kcse_certificate = $this->moveDocument($application->kcse_certificate, $student);
            }
            if ($application->kcse_result_slip) {
                $student->kcse_result_slip = $this->moveDocument($application->kcse_result_slip, $student);
            }
            
            $student->status = '1';
            $student->created_by = Auth::guard('web')->user()->id;
            $student->save();

            return $student;

        } catch (\Exception $e) {
            Log::error('Error registering student: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * SMS Helper Methods
     */

    /**
     * Send welcome SMS to student
     */
    private function sendWelcomeSMS($student)
    {
        try {
            $phone = $this->formatPhoneNumber($student->phone);
            $message = "Dear {$student->first_name}, Welcome to our institution! Your application has been approved. Your Student ID: {$student->student_id}. Login details will be sent to your email.";
            
            return $this->sendSMS($phone, $message);
            
        } catch (\Exception $e) {
            Log::error('Welcome SMS failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send rejection SMS to applicant
     */
    private function sendRejectionSMS($application)
    {
        try {
            $phone = $this->formatPhoneNumber($application->phone);
            $message = "Dear {$application->first_name}, We regret to inform you that your application #{$application->registration_no} has not been successful. Thank you for your interest.";
            
            return $this->sendSMS($phone, $message);
            
        } catch (\Exception $e) {
            Log::error('Rejection SMS failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send reinstatement SMS to applicant
     */
    private function sendReinstatementSMS($application)
    {
        try {
            $phone = $this->formatPhoneNumber($application->phone);
            $message = "Dear {$application->first_name}, Your application #{$application->registration_no} has been reinstated and is now under review. Thank you.";
            
            return $this->sendSMS($phone, $message);
            
        } catch (\Exception $e) {
            Log::error('Reinstatement SMS failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Format phone number to international format
     */
    private function formatPhoneNumber($phoneNumber)
    {
        if (substr($phoneNumber, 0, 1) === '0') {
            return '+254' . substr($phoneNumber, 1);
        }
        return $phoneNumber;
    }

    /**
     * Generate student ID
     */
    private function generateStudentId($application)
    {
        return 'STD-' . date('Y') . '-' . str_pad($application->id, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Move document from applications to students folder
     */
    private function moveDocument($filename, $student)
    {
        $oldPath = public_path('uploads/applications/' . $filename);
        $newPath = public_path('uploads/students/' . $filename);
        
        if (file_exists($oldPath)) {
            if (!file_exists(dirname($newPath))) {
                mkdir(dirname($newPath), 0755, true);
            }
            
            rename($oldPath, $newPath);
            return $filename;
        }
        return null;
    }

    /**
     * Send SMS using your SMS service
     */
    private function sendSMS($phone, $message)
    {
        try {
            // Use your existing SMS service
            if (class_exists('App\Services\SmsService')) {
                $smsService = new SmsService();
                return $smsService->sendSMS($phone, $message);
            }
            
            // Alternative: Use HTTP request if you have an SMS gateway
            $smsConfig = SmsConfiguration::where('status', 1)->first();
            
            if ($smsConfig) {
                $response = Http::post($smsConfig->url, [
                    'api_key' => $smsConfig->api_key,
                    'sender_id' => $smsConfig->sender_id,
                    'phone' => $phone,
                    'message' => $message
                ]);
                
                return $response->successful();
            }
            
            Log::info('SMS would be sent to: ' . $phone . ' - Message: ' . $message);
            return true;
            
        } catch (\Exception $e) {
            Log::error('SMS sending failed: ' . $e->getMessage());
            return false;
        }
    }
}