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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        // Log incoming data
        \Log::info('Application submission started', [
            'request_data' => $request->except(['kcse_certificate', 'kcse_result_slip']),
            'files' => [
                'kcse_certificate' => $request->hasFile('kcse_certificate'),
                'kcse_result_slip' => $request->hasFile('kcse_result_slip')
            ]
        ]);

        // Field Validation
        \Log::info('Starting validation for application data');
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

        \Log::info('Validation passed successfully');

        try {
            \Log::info('Starting database transaction');
            DB::beginTransaction();

            $student = new Application;

            // Student data mapping
            \Log::info('Mapping student data to Application model');
            $student->program_id        = $request->program;
            $student->apply_date        = now();
            $student->first_name        = $request->first_name;
            $student->last_name         = $request->last_name;
            $student->dob               = $request->dob;
            $student->phone             = $request->phone;
            $student->email             = $request->email;
            $student->national_id       = $request->national_id;
            $student->gender            = $request->gender;
            $student->kcse_index_no     = $request->kcse_index_no;
            $student->kcse_year         = $request->kcse_year;
            $student->kcse_grade        = $request->kcse_grade;
            $student->county_id         = $request->county;
            $student->sub_county_id     = $request->sub_county;
            $student->present_address   = $request->physical_address;
            $student->mode_of_study     = $request->mode_of_education;

            // File uploads
            \Log::info('Processing file uploads');
            if ($request->hasFile('kcse_certificate')) {
                $certificatePath = $request->file('kcse_certificate')->store('certificates', 'public');
                $student->kcse_certificate = $certificatePath;
                \Log::info('KCSE certificate uploaded', ['path' => $certificatePath]);
            }
            if ($request->hasFile('kcse_result_slip')) {
                $resultSlipPath = $request->file('kcse_result_slip')->store('result_slips', 'public');
                $student->kcse_result_slip = $resultSlipPath;
                \Log::info('KCSE result slip uploaded', ['path' => $resultSlipPath]);
            }

            $student->status = 1; // Pending status
            
            \Log::info('Student data prepared', [
                'student_data' => [
                    'first_name' => $student->first_name,
                    'last_name' => $student->last_name,
                    'email' => $student->email,
                    'phone' => $student->phone,
                    'program_id' => $student->program_id,
                    'status' => $student->status
                ]
            ]);
            
            $student->save();
            \Log::info('Student application saved to database', ['student_id' => $student->id]);

            // Generate registration number
            $registrationNumber = '100-' . str_pad($student->id, 4, '0', STR_PAD_LEFT);
            $student->registration_no = $registrationNumber;
            $student->save();
            
            \Log::info('Registration number generated and saved', [
                'registration_number' => $registrationNumber,
                'student_id' => $student->id
            ]);

            DB::commit();
            \Log::info('Database transaction committed successfully');

            // Send SMS Notification
            \Log::info('Attempting to send SMS notification', [
                'student_name' => $student->first_name . ' ' . $student->last_name,
                'phone' => $student->phone,
                'registration_number' => $registrationNumber
            ]);
            
            try {
                $this->sendRegistrationConfirmationSMS($student);
                \Log::info('SMS notification sent successfully');
            } catch (\Exception $smsException) {
                \Log::error('SMS sending failed', [
                    'error' => $smsException->getMessage(),
                    'student_id' => $student->id
                ]);
                // Continue execution even if SMS fails
            }

            \Log::info('Application submission completed successfully', [
                'student_id' => $student->id,
                'registration_number' => $registrationNumber
            ]);

            return redirect('/')->with([
                'toastr' => [
                    'type' => 'success',
                    'message' => 'Application was submitted successfully! Your registration number is ' . $registrationNumber,
                    'title' => 'Success'
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Application submission failed', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['kcse_certificate', 'kcse_result_slip'])
            ]);

            DB::rollBack();
            \Log::info('Database transaction rolled back due to error');

            return redirect()->back()
                   ->withInput()
                   ->with('toastr', [
                       'type' => 'error',
                       'message' => 'There was an error submitting your application. Please try again.',
                       'title' => 'Error'
                   ]);
        }
    }

    /**
     * Send registration confirmation SMS to student
     */
    protected function sendRegistrationConfirmationSMS($student)
{
    $apiUrl = 'https://smsportal.dapintechnologies.com/sms/v3/sendsms';
    $apiKey = '0CHxwhLRQ78MEFablqnsAtkgBNDjrJWou569KYpUd3eySPXT4ZOzv1cIiVG2mf';
    $serviceId = 0;
    $from = 'Dapin';

    $name = $student->first_name . ' ' . $student->last_name;
    $message = "Dear {$name}, your application has been received. Your registration number is {$student->registration_no}. We'll contact you soon.";

    $payload = [
        'api_key' => $apiKey,
        'service_id' => $serviceId,
        'mobile' => $this->formatPhoneNumberForSms($student->phone),
        'response_type' => 'json',
        'shortcode' => $from,
        'message' => $message,
        'date_send' => now()->format('Y-m-d H:i:s'),
    ];

    try {
        $response = Http::withOptions(['verify' => false])
            ->post($apiUrl, $payload);

        if ($response->successful()) {
            Log::info('Registration SMS sent successfully', [
                'student_id' => $student->id,
                'phone' => $student->phone,
                'response' => $response->json()
            ]);
        } else {
            Log::error('Failed to send registration SMS', [
                'student_id' => $student->id,
                'phone' => $student->phone,
                'status' => $response->status(),
                'response' => $response->body()
            ]);
        }
    } catch (\Exception $e) {
        Log::error('Exception while sending registration SMS', [
            'student_id' => $student->id,
            'phone' => $student->phone,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
}

/**
 * Format phone number for SMS API
 */
protected function formatPhoneNumberForSms($phone)
{
    // Remove all non-digit characters
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    // If starts with 0, replace with 254
    if (strlen($phone) == 9 && $phone[0] == '0') {
        return '254' . substr($phone, 1);
    }
    
    // If starts with 7 or 1 and has 9 digits, add 254
    if (strlen($phone) == 9 && in_array($phone[0], ['7', '1'])) {
        return '254' . $phone;
    }
    
    // If already in 254 format, return as is
    if (strlen($phone) == 12 && strpos($phone, '254') === 0) {
        return $phone;
    }
    
    // Return original if no pattern matches
    return $phone;
}


}
