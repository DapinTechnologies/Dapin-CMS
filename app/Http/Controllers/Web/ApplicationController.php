<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use App\Models\Application;
use App\Models\Province;
use App\Models\Program;
use Carbon\Carbon;
use Toastr;
use DB;

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
        $this->route = 'application';
        $this->view = 'admin.application';
        $this->path = 'student';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // dd('app');
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        
        $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();
        $data['provinces'] = Province::where('status', '1')->orderBy('title', 'asc')->get();
        $data['applicationSetting'] = ApplicationSetting::where('slug', 'admission')->where('status', '1')->firstOrFail();

        return view($this->view.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(Request $request)
{
   // dd($request->all());
    // Field Validation (add more rules as needed)
    $request->validate([
        'program'           => 'required|integer',
        'first_name'        => 'required|string|max:255',
        'last_name'         => 'required|string|max:255',
        'email'             => 'required|email|unique:applications,email',
        'phone'             => 'required|string|max:30',
        'gender'            => 'required|in:1,2,3',
        'dob'               => 'required|date',
        'kcse_index_no'     => 'required|string|max:50',
        'kcse_year'         => 'required|string|max:10',
        'kcse_grade'        => 'required|string|max:10',
        'kcse_certificate'  => 'required|file|mimes:pdf,jpg,jpeg,png',
        'kcse_result_slip'  => 'required|file|mimes:pdf,jpg,jpeg,png',
        'county'            => 'required|integer',
        'sub_county'        => 'required|integer',
        'physical_address'  => 'nullable|string|max:255',
        'mode_of_education' => 'required|string|in:Physical,Online,Hybrid',
    ]);

    try {
        DB::beginTransaction();

        $student = new Application;

        // Directly map form fields to DB columns
        $student->program_id        = $request->program;
        $student->apply_date        = now();
        $student->first_name        = $request->first_name;
        $student->last_name         = $request->last_name;
        $student->dob               = $request->dob;
        $student->phone             = $request->phone;
        $student->email             = $request->email;
        $student->national_id       = $request->national_id;
        $student->gender            = $request->gender;

        // KCSE fields
        $student->kcse_index_no     = $request->kcse_index_no;
        $student->kcse_year         = $request->kcse_year;
        $student->kcse_grade        = $request->kcse_grade;

        // County/Sub-County/Address/Mode
        $student->county_id         = $request->county;
        $student->sub_county_id     = $request->sub_county;
        $student->present_address   = $request->physical_address;
        $student->mode_of_study     = $request->mode_of_education;

        // File uploads
        if ($request->hasFile('kcse_certificate')) {
            $student->kcse_certificate = $request->file('kcse_certificate')->store('certificates', 'public');
        }
        if ($request->hasFile('kcse_result_slip')) {
            $student->kcse_result_slip = $request->file('kcse_result_slip')->store('result_slips', 'public');
        }

        // Set status to "Pending"
        $student->status = 1; // or '1' if you prefer numeric

        // Save the student data
        $student->save();

        // Set registration number (custom logic)
        // Assuming the registration number should be 100- + student ID
        $registrationNumber = '100-' . str_pad($student->id, 4, '0', STR_PAD_LEFT);
        $student->registration_no = $registrationNumber;
        $student->save();

        DB::commit();

        Toastr::success(__('msg_sent_successfully'), __('msg_success'));

             
       return redirect('/')->with('success', 'Application was submitted successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        Toastr::error(__('msg_created_error'), __('msg_error'));
        return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
}



}
