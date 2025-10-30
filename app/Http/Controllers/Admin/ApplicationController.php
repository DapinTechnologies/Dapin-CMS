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
use App\Models\County;
use App\Models\SubCounty;
use App\Models\Document;
use App\Models\Program;
use App\Models\Student;
use App\Models\Batch;
use Carbon\Carbon;
use Toastr;
use Auth;
use Hash;
use DB;
use App\Services\SmsService;
use App\Models\SmsConfiguration;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use App\Services\ApplicationSmsService;
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
        $data['rows'] = Application::with(['program', 'batch', 'county', 'subCounty'])
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
            ->orderBy('created_at', 'desc')
            ->get();

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
            'student_id' => 'required|unique:students,student_id',
            'batch' => 'required',
            'program' => 'required',
            'session' => 'required',
            'semester' => 'required',
            'section' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'admission_date' => 'required|date',
            'photo' => 'nullable|image',
            'signature' => 'nullable|image',
        ]);

        // Random Password
        $password = str_random(8);
        $data = Application::where('registration_no', $request->registration_no)->firstOrFail();

        // Insert Data
        try{
            DB::beginTransaction();
            
            $student = new Student;
            $student->student_id = $request->student_id;
            $student->registration_no = $request->registration_no;
            $student->batch_id = $request->batch;
            $student->program_id = $request->program;
            $student->admission_date = $request->admission_date;

            // Personal Information
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->father_name = $request->father_name;
            $student->mother_name = $request->mother_name;
            $student->father_occupation = $request->father_occupation;
            $student->mother_occupation = $request->mother_occupation;
            $student->email = $request->email;
            $student->password = Hash::make($password);
            $student->password_text = Crypt::encryptString($password);

            // Location Information
            $student->country = $request->country;
            $student->present_address = $request->present_address;
            $student->permanent_address = $request->permanent_address;

            // Personal Details
            $student->gender = $request->gender;
            $student->dob = $request->dob;
            $student->phone = $request->phone;
            $student->emergency_phone = $request->emergency_phone;
            $student->nationality = $request->nationality;
            $student->national_id = $request->national_id;

            // KCSE Information from application
            $student->kcse_index_no = $data->kcse_index_no;
            $student->kcse_year = $data->kcse_year;
            $student->kcse_grade = $data->kcse_grade;
            $student->mode_of_study = $data->mode_of_study;

            // County Information from application
            $student->county_id = $data->county_id;
            $student->sub_county_id = $data->sub_county_id;

            // Education Information
            $student->school_name = $request->school_name;
            $student->school_exam_id = $request->school_exam_id;
            $student->school_graduation_year = $request->school_graduation_year;
            $student->school_graduation_point = $request->school_graduation_point;
            $student->collage_name = $request->collage_name;
            $student->collage_exam_id = $request->collage_exam_id;
            $student->collage_graduation_year = $request->collage_graduation_year;
            $student->collage_graduation_point = $request->collage_graduation_point;

            // File Uploads
            if($request->hasFile('school_transcript')){
                $student->school_transcript = $this->uploadMedia($request, 'school_transcript', $this->path);
            } else {
                $student->school_transcript = $data->school_transcript;
            }
            
            if($request->hasFile('school_certificate')){
                $student->school_certificate = $this->uploadMedia($request, 'school_certificate', $this->path);
            } else {
                $student->school_certificate = $data->school_certificate;
            }
            
            if($request->hasFile('collage_transcript')){
                $student->collage_transcript = $this->uploadMedia($request, 'collage_transcript', $this->path);
            } else {
                $student->collage_transcript = $data->collage_transcript;
            }
            
            if($request->hasFile('collage_certificate')){
                $student->collage_certificate = $this->uploadMedia($request, 'collage_certificate', $this->path);
            } else {
                $student->collage_certificate = $data->collage_certificate;
            }

            // KCSE Documents from application
            $student->kcse_certificate = $data->kcse_certificate;
            $student->kcse_result_slip = $data->kcse_result_slip;

            if($request->hasFile('photo')){
                $student->photo = $this->uploadImage($request, 'photo', $this->path, 300, 300);
            } else {
                $student->photo = $data->photo;
            }
            
            if($request->hasFile('signature')){
                $student->signature = $this->uploadImage($request, 'signature', $this->path, 300, 100);
            } else {
                $student->signature = $data->signature;
            }
            
            $student->status = '1';
            $student->created_by = Auth::guard('web')->user()->id;
            $student->save();

            // Attach Status
            $student->statuses()->attach($request->statuses);

            // Student Relatives
            if(is_array($request->relations)){
                foreach($request->relations as $key => $relation){
                    if($relation != '' && $relation != null){
                        $studentRelative = new StudentRelative;
                        $studentRelative->student_id = $student->id;
                        $studentRelative->relation = $request->relations[$key];
                        $studentRelative->name = $request->relative_names[$key];
                        $studentRelative->occupation = $request->occupations[$key];
                        $studentRelative->phone = $request->relative_phones[$key];
                        $studentRelative->address = $request->addresses[$key];
                        $studentRelative->save();
                    }
                }
            }

            // Student Documents
            if(is_array($request->documents)){
                $documents = $request->file('documents');
                foreach($documents as $key => $attach){
                    $valid_extensions = array('JPG','JPEG','jpg','jpeg','png','gif','ico','svg','webp','pdf','doc','docx','txt','zip','rar','csv','xls','xlsx','ppt','pptx','mp3','avi','mp4','mpeg','3gp','mov','ogg','mkv');
                    $file_ext = $attach->getClientOriginalExtension();
                    if(in_array($file_ext, $valid_extensions, true)) {
                        $filename = $attach->getClientOriginalName();
                        $extension = $attach->getClientOriginalExtension();
                        $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;

                        $attach->move('uploads/'.$this->path.'/', $fileNameToStore);

                        $document = new Document;
                        $document->title = $request->titles[$key];
                        $document->attach = $fileNameToStore;
                        $document->save();

                        $document->students()->attach($student->id);
                    }
                }
            }

            // Student Enroll
            $enroll = new StudentEnroll();
            $enroll->student_id = $student->id;
            $enroll->program_id = $request->program;
            $enroll->session_id = $request->session;
            $enroll->semester_id = $request->semester;
            $enroll->section_id = $request->section;
            $enroll->created_by = Auth::guard('web')->user()->id;
            $enroll->save();

            // Assign Subjects
            $enrollSubject = EnrollSubject::where('program_id', $request->program)
                ->where('semester_id', $request->semester)
                ->where('section_id', $request->section)
                ->first();
            
            if(isset($enrollSubject)){
                foreach($enrollSubject->subjects as $subject){
                    $enroll->subjects()->attach($subject->id);
                }
            }

            // Application Status Update
            $data->status = '2';
            $data->updated_by = Auth::guard('web')->user()->id;
            $data->save();

            DB::commit();

            Toastr::success(__('msg_created_successfully'), __('msg_success'));
            return redirect()->route($this->route.'.index');
        }
        catch(\Exception $e){
            DB::rollBack();
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

        // Load counties and sub-counties instead of provinces and districts
        $data['counties'] = County::where('status', '1')->orderBy('CountyName', 'asc')->get();
        $data['sub_counties'] = SubCounty::where('status', '1')->orderBy('SubCountyName', 'asc')->get();
        $data['statuses'] = StatusType::where('status', '1')->get();
        $data['batches'] = Batch::where('status', '1')->orderBy('id', 'desc')->get();

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
        // Toggle status (approve/reject)
        if($application->status == 0){
            $application->status = '1'; // Approve
        } else {
            $application->status = '0'; // Reject
        }
        
        $application->updated_by = Auth::guard('web')->user()->id;
        $application->save();

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));
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
            // Delete files
            $this->deleteMultiMedia($this->path, $application, 'photo');
            $this->deleteMultiMedia($this->path, $application, 'signature');
            $this->deleteMultiMedia($this->path, $application, 'school_transcript');
            $this->deleteMultiMedia($this->path, $application, 'school_certificate');
            $this->deleteMultiMedia($this->path, $application, 'collage_transcript');
            $this->deleteMultiMedia($this->path, $application, 'collage_certificate');
            $this->deleteMultiMedia($this->path, $application, 'kcse_certificate');
            $this->deleteMultiMedia($this->path, $application, 'kcse_result_slip');
            
            $application->delete();
            DB::commit();

            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(__('msg_deleted_error'), __('msg_error'));
        }

        return redirect()->back();
    }

    /**
     * Approve and register student (additional method if needed)
     */
    public function approve($id)
    {
        $application = Application::findOrFail($id);
        $application->status = '1'; // Approved
        $application->updated_by = Auth::guard('web')->user()->id;
        $application->save();

        Toastr::success(__('Application approved successfully'), __('msg_success'));
        return redirect()->back();
    }

    /**
     * Reject application (additional method if needed)
     */
    public function reject($id)
    {
        $application = Application::findOrFail($id);
        $application->status = '0'; // Rejected
        $application->updated_by = Auth::guard('web')->user()->id;
        $application->save();

        Toastr::success(__('Application rejected successfully'), __('msg_success'));
        return redirect()->back();
    }
}