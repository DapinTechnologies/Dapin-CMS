<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Traits\FileUploader;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;
use App\Models\Student;
use App\Models\StudentEnroll;
use App\Models\EnrollSubject;
use App\Models\StudentRelative;
use App\Models\IdCardSetting;
use App\Models\StatusType;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Batch;
use App\Models\Semester;
use App\Models\Session;
use App\Models\Section;
use App\Models\Province;
use App\Models\District;
use App\Models\Grade;
use App\Models\Fee;
use App\Models\Document;
use App\Models\MailSetting;
use App\Models\Setting;
use App\Models\Field;
use App\Models\SmsConfiguration;
use App\Mail\SendPassword;
use Toastr;
use Mail;
use DB;
use App\Models\County;
 use App\Models\SubCounty;
 use Intervention\Image\Facades\Image; // Add this import
class StudentController extends Controller
{
    use FileUploader;

    protected $title;
    protected $route;
    protected $view;
    protected $path;
    protected $access;

    public function __construct()
    {
        $this->title = trans_choice('module_student', 1);
        $this->route = 'admin.student';
        $this->view = 'admin.student';
        $this->path = 'students';
        $this->access = 'student';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index', 'show', 'status', 'sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
        $this->middleware('permission:'.$this->access.'-password-print', ['only' => ['printPassword', 'multiPrintPassword']]);
        $this->middleware('permission:'.$this->access.'-password-change', ['only' => ['passwordChange']]);
        $this->middleware('permission:'.$this->access.'-card', ['only' => ['index', 'card']]);
        $this->middleware('permission:'.$this->access.'-import', ['only' => ['index', 'import', 'importStore']]);
    }

    public function index(Request $request)
    {
        $data = [
            'title'  => $this->title,
            'route'  => $this->route,
            'view'   => $this->view,
            'path'   => $this->path,
            'access' => $this->access,
            'faculties' => Faculty::where('status', 1)->orderBy('title', 'asc')->get(),
            'statuses'  => StatusType::where('status', 1)->orderBy('title', 'asc')->get(),
            'print' => IdCardSetting::where('slug', 'student-card')->first(),
        ];

        $filters = [
            'faculty' => $request->faculty ?? '0',
            'program' => $request->program ?? '0',
            'session' => $request->session ?? '0',
            'semester' => $request->semester ?? '0',
            'section' => $request->section ?? '0',
            'status' => $request->status ?? '0',
            'student_id' => $request->student_id ?? null,
        ];

        $query = Student::query();
        if ($filters['faculty'] !== '0') {
            $query->whereHas('program', function ($q) use ($filters) {
                $q->where('faculty_id', $filters['faculty']);
            });
        }
        if ($filters['student_id']) {
            $query->where('student_id', 'LIKE', "%{$filters['student_id']}%");
        }
        if ($filters['status'] !== '0') {
            $query->whereHas('statuses', function ($q) use ($filters) {
                $q->where('status_type_id', $filters['status']);
            });
        }

        $data['rows'] = $query->orderBy('student_id', 'desc')->get();
        return view("{$this->view}.index", $data);
    }

    public function create()
    {
        return view("{$this->view}.create", [
            'title' => $this->title,
            'route' => $this->route,
            'view' => $this->view,
            'path' => $this->path,
            'batches' => Batch::where('status', 1)->orderBy('id', 'desc')->get(),
            'statuses' => StatusType::where('status', 1)->orderBy('title', 'asc')->get(),
            'provinces' => Province::where('status', 1)->orderBy('title', 'asc')->get(),
        ]);
    }

    public function store(Request $request)
    {
//dd("hello Student Application");

        // Validate the incoming request data
        $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'program' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'admission_date' => 'required|date',
            'photo' => 'nullable|image',
            'signature' => 'nullable|image',
           'mode_of_study' => 'required|string|in:Physical,Online,Hybrid',
        ]);
   // dd($request->all());
        // Generate a random password
        $password = Str::random(8);
    
        try {
            // Begin a database transaction
            DB::beginTransaction();
    
            // Create a new Student instance
            $student = new Student();
    
            // Fill the student model with the request data
            $student->fill($request->all());
    
            // Set additional fields
            $student->password = Hash::make($password); // Hash the password
            $student->password_text = Crypt::encryptString($password); // Encrypt the password for reference
            $student->status = '1'; // Set the student status to active
            $student->created_by = Auth::id(); // Set the creator of the student record
    
            // Map mode_of_study to mode_of_education
            $student->mode_of_education = $request->mode_of_study;
    
            // Handle file uploads for photo and signature
            if ($request->hasFile('photo')) {
                $student->photo = $this->uploadFile($request->file('photo'), 'students');
            }
            if ($request->hasFile('signature')) {
                $student->signature = $this->uploadFile($request->file('signature'), 'students');
            }
    
            // Save the student record to the database
            $student->save();
    
            // Attach statuses to the student if provided
            if ($request->statuses) {
                $student->statuses()->attach($request->statuses);
            }
    
            // Format the phone number and send an SMS notification
            $phoneNumber = $this->formatPhoneNumber($student->phone);
            $this->sendSmsNotification($phoneNumber, $student);
    
            // Commit the database transaction
            DB::commit();
    
            // Show a success message and redirect to the student index page
            Toastr::success(__('msg_created_successfully'), __('msg_success'));
            return redirect()->route('admin.student.index');
        } catch (\Exception $e) {
            // Roll back the database transaction in case of an error
            DB::rollBack();
    
            // Log the error for debugging
            Log::error('Error Creating Student', ['error' => $e->getMessage()]);
    
            // Show an error message and redirect back with input data
            Toastr::error(__('msg_created_error'), __('msg_error'));
            return redirect()->back()->withInput();
        }
    }


    
    public function show($id)
    {
        return view("{$this->view}.show", [
            'title' => $this->title,
            'route' => $this->route,
            'view' => $this->view,
            'path' => $this->path,
            'row' => Student::findOrFail($id),
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
     public function edit(Student $student)
     {
         $data['title'] = $this->title;
         $data['route'] = $this->route;
         $data['view'] = $this->view;
         $data['path'] = $this->path;
     
         // Fetch batches and check if they exist
         $batches = Batch::orderBy('id', 'desc')->get();
         $data['batches'] = $batches->isEmpty() ? collect([]) : $batches; // Ensure it's not null
     
         // Fetch programs
         $data['programs'] = Program::orderBy('title', 'asc')->get();
     
         // Fetch counties
         $data['counties'] = County::orderBy('CountyName', 'asc')->get();
     
         // Fetch sub-counties
         $data['subCounties'] = SubCounty::orderBy('SubCountyName', 'asc')->get();
     
         // Pass the student record to the view
         $data['row'] = $student;
         $data['student_id'] = $student->id;
     
         // Include KCSE certificate and result slip for download verification
         $data['kcse_certificate'] = $student->kcse_certificate ? asset($student->kcse_certificate) : null;
         $data['kcse_result_slip'] = $student->kcse_result_slip ? asset($student->kcse_result_slip) : null;
     
         return view($this->view.'.edit', $data);
     }
     



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        // Field Validation
        $request->validate([
            'student_id' => 'required|unique:students,student_id,'.$student->id,
            'batch' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:students,email,'.$student->id,
            'phone' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'admission_date' => 'required|date',
            'photo' => 'nullable|image',
            'signature' => 'nullable|image',
            'kcse_result_slip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:20480', // 20MB max
            'kcse_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:20480', // 20MB max
        ]);
    
        // Update Data
        try {
            DB::beginTransaction();
    
            $student->student_id = $request->student_id;
            $student->batch_id = $request->batch;
            $student->admission_date = $request->admission_date;
    
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->father_name = $request->father_name;
            $student->mother_name = $request->mother_name;
            $student->father_occupation = $request->father_occupation;
            $student->mother_occupation = $request->mother_occupation;
            $student->email = $request->email;
    
            $student->country = $request->country;
            $student->present_province = $request->present_province;
            $student->present_district = $request->present_district;
            $student->present_village = $request->present_village;
            $student->present_address = $request->present_address;
          
            $student->permanent_address = $request->permanent_address;
    
            $student->gender = $request->gender;
            $student->dob = $request->dob;
            $student->phone = $request->phone;
        
    
            $student->religion = $request->religion;
            $student->caste = $request->caste;
            $student->mother_tongue = $request->mother_tongue;
            $student->marital_status = $request->marital_status;
            $student->blood_group = $request->blood_group;
            $student->nationality = $request->nationality;
           
    
        
    
            // Handle KCSE Result Slip
            if ($request->hasFile('kcse_result_slip')) {
                $kcseResultSlip = $request->file('kcse_result_slip');
                $kcseResultSlipName = time() . '_' . $kcseResultSlip->getClientOriginalName();
                $kcseResultSlipPath = public_path('uploads/students/kcse_result_slips/' . $kcseResultSlipName);
    
                // Save the file
                if ($kcseResultSlip->getMimeType() === 'application/pdf') {
                    $kcseResultSlip->move(public_path('uploads/students/kcse_result_slips/'), $kcseResultSlipName);
                } else {
                    Image::make($kcseResultSlip->getRealPath())
                        ->resize(800, 800, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->save($kcseResultSlipPath);
                }
    
                // Delete the old file if it exists
                if ($student->kcse_result_slip && file_exists(public_path('uploads/students/kcse_result_slips/' . $student->kcse_result_slip))) {
                    unlink(public_path('uploads/students/kcse_result_slips/' . $student->kcse_result_slip));
                }
    
                $student->kcse_result_slip = $kcseResultSlipName;
            }
    
            // Handle KCSE Certificate
            if ($request->hasFile('kcse_certificate')) {
                $kcseCertificate = $request->file('kcse_certificate');
                $kcseCertificateName = time() . '_' . $kcseCertificate->getClientOriginalName();
                $kcseCertificatePath = public_path('uploads/students/kcse_certificates/' . $kcseCertificateName);
    
                // Save the file
                if ($kcseCertificate->getMimeType() === 'application/pdf') {
                    $kcseCertificate->move(public_path('uploads/students/kcse_certificates/'), $kcseCertificateName);
                } else {
                    Image::make($kcseCertificate->getRealPath())
                        ->resize(800, 800, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->save($kcseCertificatePath);
                }
    
                // Delete the old file if it exists
                if ($student->kcse_certificate && file_exists(public_path('uploads/students/kcse_certificates/' . $student->kcse_certificate))) {
                    unlink(public_path('uploads/students/kcse_certificates/' . $student->kcse_certificate));
                }
    
                $student->kcse_certificate = $kcseCertificateName;
            }
    
            $student->photo = $this->updateImage($request, 'photo', $this->path, 300, 300, $student, 'photo');
            $student->signature = $this->updateImage($request, 'signature', $this->path, 300, 100, $student, 'signature');
            $student->updated_by = Auth::guard('web')->user()->id;
            $student->save();
    
            // Update Status
            $student->statuses()->sync($request->statuses);
    
            // Remove Old Relatives
            StudentRelative::where('student_id', $student->id)->delete();
            // Student Relatives
            if (is_array($request->relations)) {
                foreach ($request->relations as $key => $relation) {
                    if ($relation != '' && $relation != null) {
                        // Insert Data
                        $relation = new StudentRelative;
                        $relation->student_id = $student->id;
                        $relation->relation = $request->relations[$key];
                        $relation->name = $request->relative_names[$key];
                        $relation->occupation = $request->occupations[$key];
                        $relation->phone = $request->relative_phones[$key];
                        $relation->address = $request->addresses[$key];
                        $relation->save();
                    }
                }
            }
    
            // Student Documents
            if (is_array($request->documents)) {
                $documents = $request->file('documents');
                foreach ($documents as $key => $attach) {
                    // Valid extension check
                    $valid_extensions = array('JPG', 'JPEG', 'jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp', 'pdf', 'doc', 'docx', 'txt', 'zip', 'rar', 'csv', 'xls', 'xlsx', 'ppt', 'pptx', 'mp3', 'avi', 'mp4', 'mpeg', '3gp', 'mov', 'ogg', 'mkv');
                    $file_ext = $attach->getClientOriginalExtension();
                    if (in_array($file_ext, $valid_extensions, true)) {
                        // Upload Files
                        $filename = $attach->getClientOriginalName();
                        $extension = $attach->getClientOriginalExtension();
                        $fileNameToStore = str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename) . '_' . time() . '.' . $extension;
    
                        // Move file inside public/uploads/ directory
                        $attach->move('uploads/' . $this->path . '/', $fileNameToStore);
    
                        // Insert Data
                        $document = new Document;
                        $document->title = $request->titles[$key];
                        $document->attach = $fileNameToStore;
                        $document->save();
    
                        // Attach
                        $document->students()->sync($student->id);
                    }
                }
            }
    
            DB::commit();
    
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
    
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
    
            Toastr::error(__('msg_updated_error'), __('msg_error'));
    
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        DB::beginTransaction();
        // Delete
        $this->deleteMultiMedia($this->path, $student, 'photo');
        $this->deleteMultiMedia($this->path, $student, 'signature');
        $this->deleteMultiMedia($this->path, $student, 'school_transcript');
        $this->deleteMultiMedia($this->path, $student, 'school_certificate');
        $this->deleteMultiMedia($this->path, $student, 'collage_transcript');
        $this->deleteMultiMedia($this->path, $student, 'collage_certificate');

        // Detach
        $student->relatives()->delete();
        $student->statuses()->detach();
        $student->documents()->detach();
        $student->contents()->detach();
        $student->notices()->detach();
        $student->member()->delete();
        $student->hostelRoom()->delete();
        $student->transport()->delete();
        $student->notes()->delete();
        
        $student->delete();
        DB::commit();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {   
        // Set Status
        $user = Student::where('id', $id)->firstOrFail();

        if($user->login == 1){
            $user->login = 0;
            $user->save();
        }
        else {
            $user->login = 1;
            $user->save();
        }

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendPassword($id)
    {   
        //
        $user = Student::where('id', $id)->firstOrFail();

        $mail = MailSetting::where('status', '1')->first();

        if(isset($mail->sender_email) && isset($mail->sender_name)){

            $sendTo = $user->email;
            $receiver = $user->first_name.' '.$user->last_name;

            // Passing data to email template
            $data['name'] = $user->first_name.' '.$user->first_name;
            $data['student_id'] = $user->student_id;
            $data['email'] = $user->email;
            $data['password'] = Crypt::decryptString($user->password_text);

            // Mail Information
            $data['subject'] = __('msg_your_login_credentials');
            $data['from'] = $mail->sender_email;
            $data['sender'] = $mail->sender_name;
            

            // Send Mail
            Mail::to($sendTo, $receiver)->send(new SendPassword($data));

            
            Toastr::success(__('msg_sent_successfully'), __('msg_success'));
        }
        else{
            Toastr::success(__('msg_receiver_not_found'), __('msg_success'));
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printPassword($id)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        
        $data['rows'] = Student::where('id', $id)->get();

        return view($this->view.'.password-print', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function multiPrintPassword(Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        $students = explode(",",$request->students);

        // View
        $data['rows'] = Student::whereIn('id', $students)->orderBy('id', 'asc')->get();

        return view($this->view.'.password-print', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function passwordChange(Request $request)
    {
        // Field Validation
        $request->validate([
            'student_id' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        // Update Data
        $student = Student::findOrFail($request->student_id);
        $student->password = Hash::make($request->password);
        $student->password_text = Crypt::encryptString($request->password);
        $student->save();


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function card($id)
    {
        //
        $data['title']     = $this->title;
        $data['route']     = $this->route;
        $data['view']      = $this->view;
        $data['path']      = $this->path;

        $data['rows'] = Student::where('id', $id)->orderBy('student_id', 'asc')->get();

        $data['print'] = IdCardSetting::where('slug', 'student-card')->firstOrFail();

        return view('admin.id-card.print', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        //
        $data['title']     = $this->title;
        $data['route']     = $this->route;
        $data['view']      = $this->view;
        $data['access']    = $this->access;

        //
        $data['batches'] = Batch::where('status', '1')
                        ->orderBy('id', 'desc')->get();

        return view($this->view.'.import', $data);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function importStore(Request $request)
    {
        // Field Validation
        $request->validate([
            'batch' => 'required',
            'program' => 'required',
            'session' => 'required',
            'semester' => 'required',
            'section' => 'required',
            'import' => 'required|file|mimes:xlsx',
        ]);


        // Passing Data
        $data['batch'] = $request->batch;
        $data['program'] = $request->program;
        $data['session'] = $request->session;
        $data['semester'] = $request->semester;
        $data['section'] = $request->section;

        Excel::import(new StudentsImport($data), $request->file('import'));
        

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
