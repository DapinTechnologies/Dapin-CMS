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
    
    // Fetch programs and pass to the view
    $data['programs'] = Program::all();
    
    // Counties and SubCounties
    $data['counties'] = County::all(); // Retrieve all counties
    
    // Fetch sub-counties based on the selected county ID from $application
    $data['sub_counties'] = SubCounty::where('CountyID', $application->county_id)->get(); 

    $data['row'] = $application; // Pass the application data

    
   //dd($application);
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
    // Validate the incoming request
    $request->validate([
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
    ]);

    try {
        DB::beginTransaction();

        // Updating application status to approved
        $application->status = 2; // Approved
        $application->save();

        // Commit the transaction
        DB::commit();

        // Store success message
        session()->flash('success', 'Application has been approved successfully!');

        return redirect()->route('admin.application.index');
    } catch (\Exception $e) {
        DB::rollBack();

        // Store error message
        session()->flash('error', 'An error occurred: ' . $e->getMessage());

        return redirect()->back()->withInput();
    }
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
