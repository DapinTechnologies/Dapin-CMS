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
use App\Models\Province;
use App\Models\District;
use App\Models\Document;
use App\Models\Program;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Session;
use App\Models\Semester;
use App\Models\Section;
use Carbon\Carbon;
use Toastr;
use Auth;
use Hash;
use DB;
use App\Services\SmsService;
use App\Models\SmsConfiguration;
use App\Models\County;
use App\Models\SubCounty;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use App\Services\ApplicationSmsService;
use Illuminate\Support\Facades\Http;
use Flasher\Laravel\FlashServiceProvider; // Ensure this is imported
use Flasher\Laravel\Flasher;
use Illuminate\Support\Str;

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
    $data['selected_batch'] = $request->batch ?? '0'; // '0' for all batches
    $data['selected_program'] = $request->program ?? '0'; // '0' for all programs
    $data['selected_status'] = $request->status ?? '99'; // '99' for all statuses
    $data['selected_start_date'] = $request->start_date ?? null;
    $data['selected_end_date'] = $request->end_date ?? null;
    $data['selected_registration_no'] = $request->registration_no ?? null;

    $data['batches'] = Batch::where('status', '1')->orderBy('id', 'desc')->get();
    $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();

    // Query applications with filters and convert the result to a collection
    $data['rows'] = collect(Application::when($request->start_date && $request->end_date, function ($query) use ($request) {
            $query->whereDate('apply_date', '>=', $request->start_date)
                  ->whereDate('apply_date', '<=', $request->end_date);
        })
        ->when($request->batch && $request->batch !== '0', fn($query) => $query->where('batch_id', $request->batch))
        ->when($request->program && $request->program !== '0', fn($query) => $query->where('program_id', $request->program))
        ->when($request->registration_no, fn($query) => $query->where('registration_no', 'LIKE', '%' . $request->registration_no . '%'))
        ->when($request->status && $request->status != '99', fn($query) => $query->where('status', $request->status))
        ->orderBy('created_at', 'desc')
        ->get());

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
   
    //dd($request->all());

    $request->validate([
        'first_name'         => 'required|string|max:255',
        'last_name'          => 'required|string|max:255',
        'dob'                => 'required|date',
        'phone'              => 'required|string|max:30',
        'email'              => 'required|email|max:255|unique:applications,email',
        'national_id'        => 'required|string|max:50',
        'gender'             => 'required|in:1,2,3',
        'program'            => 'required|integer|exists:programs,id',
        'kcse_index_no'      => 'required|string|max:50',
        'kcse_year'          => 'required|string|max:10',
        'kcse_grade'         => 'required|string|max:10',
        'kcse_certificate'   => 'required|file|mimes:pdf,jpg,jpeg,png',
        'kcse_result_slip'   => 'required|file|mimes:pdf,jpg,jpeg,png',
        'county'             => 'required|integer|exists:counties,CountyID',
        'sub_county'         => 'required|integer|exists:sub_counties,SubCountyID',
        'physical_address'   => 'nullable|string|max:255',
        'mode_of_education'  => 'required|string|in:Physical,Online,Hybrid',
    ]);

    $application = new Application();
    $application->registration_no    = uniqid('REG-'); // Or any unique logic you want
    $application->first_name         = $request->first_name;
    $application->last_name          = $request->last_name;
    $application->dob                = $request->dob;
    $application->phone              = $request->phone;
    $application->email              = $request->email;
    $application->national_id        = $request->national_id;
    $application->gender             = $request->gender;
    $application->program_id         = $request->program;
    $application->kcse_index_no      = $request->kcse_index_no;
    $application->kcse_year          = $request->kcse_year;
    $application->kcse_grade         = $request->kcse_grade;
    $application->county_id          = $request->county;
    $application->sub_county_id      = $request->sub_county;
    $application->present_address    = $request->physical_address;
    $application->mode_of_study      = $request->mode_of_education;
    $application->status             = 2; // or whatever you want

    // Save files if present
    if ($request->hasFile('kcse_certificate')) {
        $application->kcse_certificate = $request->file('kcse_certificate')->store('certificates', 'public');
    }
    if ($request->hasFile('kcse_result_slip')) {
        $application->kcse_result_slip = $request->file('kcse_result_slip')->store('result_slips', 'public');
    }

    $application->save();

    return redirect()->back()->with('success', 'Application submitted successfully!');
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
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

    // Existing data
    $data['statuses'] = StatusType::where('status', '1')->get();
    $data['batches'] = Batch::where('status', '1')->orderBy('id', 'desc')->get();
    $data['programs'] = Program::all();
    $data['counties'] = County::all();
    $data['sub_counties'] = SubCounty::where('CountyID', $application->county_id)->get();
    
    // Add these new variables
    $data['sessions'] = Session::where('status', '1')->orderBy('id', 'desc')->get();
    $data['semesters'] = Semester::where('status', '1')->orderBy('id', 'desc')->get();
    $data['sections'] = Section::where('status', '1')->orderBy('id', 'desc')->get();

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
      \Log::info('Update Request Data:', $request->all());
    \Log::info('Application Being Updated:', $application->toArray());
    // Validate the incoming request
    $validated = $request->validate([
        'program' => 'required|integer',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:applications,email,' . $application->id,
        'phone' => 'required|string|max:30',
        'gender' => 'required|in:1,2,3',
        'dob' => 'required|date',
        'kcse_index_no' => 'required|string|max:50',
        'kcse_year' => 'required|string|max:10',
        'kcse_grade' => 'required|string|max:10',
        'county' => 'required|integer',
        'sub_county' => 'required|integer',
        'session' => 'required|integer',
        'semester' => 'required|integer',
        'section' => 'required|integer',
        'student_id' => 'required|unique:students,student_id,' . ($application->student ? $application->student->id : 'NULL'),
        'mode_of_education' => 'required|string',
        'kcse_certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        'kcse_result_slip' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
    ]);

    try {
        DB::beginTransaction();

        // Handle file uploads
        $certificatePath = $application->kcse_certificate;
        $resultSlipPath = $application->kcse_result_slip;
        
        if ($request->hasFile('kcse_certificate')) {
            $certificatePath = $this->moveDocument(
                $request->file('kcse_certificate')->store('public/students/documents'),
                $application
            );
        }
        
        if ($request->hasFile('kcse_result_slip')) {
            $resultSlipPath = $this->moveDocument(
                $request->file('kcse_result_slip')->store('public/students/documents'),
                $application
            );
        }

        // Update the application
        $application->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'gender' => $validated['gender'],
            'dob' => $validated['dob'],
            'kcse_index_no' => $validated['kcse_index_no'],
            'kcse_year' => $validated['kcse_year'],
            'kcse_grade' => $validated['kcse_grade'],
            'kcse_certificate' => $certificatePath,
            'kcse_result_slip' => $resultSlipPath,
            'county_id' => $validated['county'],
            'sub_county_id' => $validated['sub_county'],
            'program_id' => $validated['program'],
            'session_id' => $validated['session'],
            'semester_id' => $validated['semester'],
            'section_id' => $validated['section'],
            'status' => 2, // Approved
        ]);

        // Generate random password
        $password = Str::random(8);

        // Create or update student record
        $studentData = [
            'student_id' => $validated['student_id'],
            'registration_no' => $application->registration_no,
            'batch_id' => $application->batch_id,
            'program_id' => $application->program_id,
            'admission_date' => $validated['admission_date'] ?? now(),
            'first_name' => $application->first_name,
            'last_name' => $application->last_name,
            'email' => $application->email,
            'phone' => $application->phone,
            'gender' => $application->gender,
            'dob' => $application->dob,
            'kcse_index_no' => $application->kcse_index_no,
            'kcse_year' => $application->kcse_year,
            'kcse_grade' => $application->kcse_grade,
            'kcse_certificate' => $certificatePath,
            'kcse_result_slip' => $resultSlipPath,
            'password' => Hash::make($password),
            'password_text' => Crypt::encryptString($password),
            'status' => 1, // Active
            'created_by' => auth()->id(),
            'county_id' => $application->county_id,
            'sub_county_id' => $application->sub_county_id,
            'mode_of_education' => $validated['mode_of_education'],
        ];

        $student = Student::updateOrCreate(
            ['email' => $application->email],
            $studentData
        );

        // Create or update student enrollment
        $enroll = StudentEnroll::updateOrCreate(
            ['student_id' => $student->id, 'session_id' => $validated['session']],
            [
                'semester_id' => $validated['semester'],
                'program_id' => $validated['program'],
                'section_id' => $validated['section'],
                'created_by' => auth()->id(),
            ]
        );

        // Assign subjects
        $enrollSubject = EnrollSubject::where('program_id', $validated['program'])
                                    ->where('semester_id', $validated['semester'])
                                    ->where('section_id', $validated['section'])
                                    ->first();

        if ($enrollSubject) {
            $enroll->subjects()->sync($enrollSubject->subjects->pluck('id'));
        }

        // Send welcome SMS
        try {
            $this->sendWelcomeSMS($student);
        } catch (\Exception $e) {
            \Log::error('SMS sending failed: ' . $e->getMessage());
        }

        DB::commit();

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));
        return redirect()->route($this->route . '.index');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Application update error: ' . $e->getMessage());
        Toastr::error(__('msg_updated_error') . ': ' . $e->getMessage(), __('msg_error'));
        return redirect()->back()->withInput();
    }
}


private function formatPhoneNumber($phoneNumber)
{
    if (substr($phoneNumber, 0, 1) === '0') {
        return '+254' . substr($phoneNumber, 1);
    }
    return $phoneNumber;
}
private function generateStudentId($application)
{
    return 'STD-' . date('Y') . '-' . str_pad($application->id, 5, '0', STR_PAD_LEFT);
}

private function moveDocument($filename, $student)
{
    $oldPath = public_path('uploads/applications/' . $filename);
    $newPath = public_path('uploads/students/' . $filename);
    
    if (file_exists($oldPath)) {
        rename($oldPath, $newPath);
        return $filename; // Return the filename to store in the database
    }
    return null;
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
        // Delete
        $this->deleteMultiMedia($this->path, $application, 'photo');
        $this->deleteMultiMedia($this->path, $application, 'signature');
        $this->deleteMultiMedia($this->path, $application, 'school_transcript');
        $this->deleteMultiMedia($this->path, $application, 'school_certificate');
        $this->deleteMultiMedia($this->path, $application, 'collage_transcript');
        $this->deleteMultiMedia($this->path, $application, 'collage_certificate');
        
        $application->delete();
        DB::commit();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
