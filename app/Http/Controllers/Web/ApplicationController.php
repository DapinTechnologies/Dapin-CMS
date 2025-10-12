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
use Illuminate\Support\Facades\Validator;

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
        
        \Log::info('ApplicationController initialized', [
            'title' => $this->title,
            'route' => $this->route,
            'view' => $this->view
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        \Log::info('Application form index method called');
        
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        \Log::info('Fetching programs, provinces and application settings');
        
        try {
            $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();
            $data['provinces'] = Province::where('status', '1')->orderBy('title', 'asc')->get();
            $data['applicationSetting'] = ApplicationSetting::where('slug', 'admission')->where('status', '1')->firstOrFail();

            \Log::info('Data fetched successfully', [
                'programs_count' => $data['programs']->count(),
                'provinces_count' => $data['provinces']->count(),
                'application_setting' => $data['applicationSetting'] ? 'found' : 'not found'
            ]);

            \Log::info('Rendering application form view');
            return view($this->view.'.create', $data);

        } catch (\Exception $e) {
            \Log::error('Error in application index method', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            throw $e;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Log::info('=== APPLICATION SUBMISSION PROCESS STARTED ===');
        
        // Log incoming data (excluding files for security)
        \Log::info('Raw request data received:', [
            'all_data' => $request->except(['kcse_certificate', 'kcse_result_slip', '_token']),
            'files_present' => [
                'kcse_certificate' => $request->hasFile('kcse_certificate') ? 'YES' : 'NO',
                'kcse_result_slip' => $request->hasFile('kcse_result_slip') ? 'YES' : 'NO'
            ],
            'file_details' => [
                'kcse_certificate' => $request->file('kcse_certificate') ? [
                    'name' => $request->file('kcse_certificate')->getClientOriginalName(),
                    'size' => $request->file('kcse_certificate')->getSize(),
                    'mime' => $request->file('kcse_certificate')->getMimeType()
                ] : null,
                'kcse_result_slip' => $request->file('kcse_result_slip') ? [
                    'name' => $request->file('kcse_result_slip')->getClientOriginalName(),
                    'size' => $request->file('kcse_result_slip')->getSize(),
                    'mime' => $request->file('kcse_result_slip')->getMimeType()
                ] : null
            ]
        ]);

        // Field Validation with detailed logging
        \Log::info('Starting validation process');
        
        $validationRules = [
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
        ];

        \Log::info('Validation rules defined', ['rules' => $validationRules]);

        try {
            $validatedData = $request->validate($validationRules);
            \Log::info('✅ Validation passed successfully');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('❌ Validation failed', [
                'errors' => $e->errors(),
                'failed_fields' => array_keys($e->errors())
            ]);
            
            return redirect()->back()
                   ->withErrors($e->errors())
                   ->withInput()
                   ->with('toastr', [
                       'type' => 'error',
                       'message' => 'Please fix the validation errors and try again.',
                       'title' => 'Validation Error'
                   ]);
        }

        // Database transaction with comprehensive logging
        \Log::info('Starting database transaction');
        DB::beginTransaction();

        try {
            \Log::info('Creating new Application model instance');
            $student = new Application;

            // Student data mapping with logging
            \Log::info('Mapping request data to Application model');
            
            $studentData = [
                'program_id'        => $request->program,
                'apply_date'        => now(),
                'first_name'        => $request->first_name,
                'last_name'         => $request->last_name,
                'dob'               => $request->dob,
                'phone'             => $request->phone,
                'email'             => $request->email,
                'national_id'       => $request->national_id,
                'gender'            => $request->gender,
                'kcse_index_no'     => $request->kcse_index_no,
                'kcse_year'         => $request->kcse_year,
                'kcse_grade'        => $request->kcse_grade,
                'county_id'         => $request->county,
                'sub_county_id'     => $request->sub_county,
                'present_address'   => $request->physical_address,
                'mode_of_study'     => $request->mode_of_education,
                'status'            => 1 // Pending status
            ];

            \Log::info('Student data mapped', ['student_data' => $studentData]);
            
            // Assign data to model
            foreach ($studentData as $key => $value) {
                $student->$key = $value;
            }

            // File uploads with detailed logging
            \Log::info('Processing file uploads');
            
            if ($request->hasFile('kcse_certificate')) {
                \Log::info('Uploading KCSE certificate');
                $certificatePath = $request->file('kcse_certificate')->store('certificates', 'public');
                $student->kcse_certificate = $certificatePath;
                \Log::info('✅ KCSE certificate uploaded successfully', [
                    'original_name' => $request->file('kcse_certificate')->getClientOriginalName(),
                    'storage_path' => $certificatePath,
                    'file_size' => $request->file('kcse_certificate')->getSize()
                ]);
            } else {
                \Log::warning('KCSE certificate file not found in request');
            }

            if ($request->hasFile('kcse_result_slip')) {
                \Log::info('Uploading KCSE result slip');
                $resultSlipPath = $request->file('kcse_result_slip')->store('result_slips', 'public');
                $student->kcse_result_slip = $resultSlipPath;
                \Log::info('✅ KCSE result slip uploaded successfully', [
                    'original_name' => $request->file('kcse_result_slip')->getClientOriginalName(),
                    'storage_path' => $resultSlipPath,
                    'file_size' => $request->file('kcse_result_slip')->getSize()
                ]);
            } else {
                \Log::warning('KCSE result slip file not found in request');
            }

            // Save the application
            \Log::info('Attempting to save student application to database');
            
            if ($student->save()) {
                \Log::info('✅ Student application saved successfully', [
                    'student_id' => $student->id,
                    'email' => $student->email,
                    'phone' => $student->phone
                ]);
            } else {
                \Log::error('❌ Failed to save student application');
                throw new \Exception('Failed to save student application to database');
            }

            // Generate registration number
            \Log::info('Generating registration number');
            $registrationNumber = '100-' . str_pad($student->id, 4, '0', STR_PAD_LEFT);
            $student->registration_no = $registrationNumber;
            
            \Log::info('Saving registration number', [
                'registration_number' => $registrationNumber,
                'student_id' => $student->id
            ]);
            
            if ($student->save()) {
                \Log::info('✅ Registration number saved successfully', [
                    'student_id' => $student->id,
                    'registration_number' => $registrationNumber
                ]);
            } else {
                \Log::error('❌ Failed to save registration number');
                throw new \Exception('Failed to save registration number');
            }

            // Commit transaction
            DB::commit();
            \Log::info('✅ Database transaction committed successfully');

            // Send SMS Notification (non-blocking)
            \Log::info('Attempting to send SMS notification');
            try {
                $this->sendRegistrationConfirmationSMS($student);
                \Log::info('✅ SMS notification sent successfully');
            } catch (\Exception $smsException) {
                \Log::warning('SMS sending failed but continuing', [
                    'error' => $smsException->getMessage(),
                    'student_id' => $student->id,
                    'phone' => $student->phone
                ]);
                // Continue execution even if SMS fails
            }

            \Log::info('=== APPLICATION SUBMISSION COMPLETED SUCCESSFULLY ===', [
                'student_id' => $student->id,
                'registration_number' => $registrationNumber,
                'email' => $student->email,
                'timestamp' => now()->toDateTimeString()
            ]);

            return redirect('/')->with([
                'toastr' => [
                    'type' => 'success',
                    'message' => 'Application was submitted successfully! Your registration number is ' . $registrationNumber,
                    'title' => 'Success'
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('❌ APPLICATION SUBMISSION FAILED', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString(),
                'student_data_at_failure' => isset($student) ? [
                    'email' => $student->email ?? 'N/A',
                    'phone' => $student->phone ?? 'N/A',
                    'first_name' => $student->first_name ?? 'N/A'
                ] : 'Student object not created',
                'request_data' => $request->except(['kcse_certificate', 'kcse_result_slip', '_token'])
            ]);

            DB::rollBack();
            \Log::info('Database transaction rolled back due to error');

            // Check for specific common errors
            if (str_contains($e->getMessage(), 'unique')) {
                $errorMessage = 'The email, phone, or KCSE index number already exists in our system.';
            } elseif (str_contains($e->getMessage(), 'foreign key')) {
                $errorMessage = 'Invalid program, county, or sub-county selected.';
            } else {
                $errorMessage = 'There was an error submitting your application. Please try again.';
            }

            return redirect()->back()
                   ->withInput()
                   ->with('toastr', [
                       'type' => 'error',
                       'message' => $errorMessage,
                       'title' => 'Error'
                   ]);
        }
    }

    /**
     * Send registration confirmation SMS to student
     */
    protected function sendRegistrationConfirmationSMS($student)
    {
        \Log::info('SMS: Starting SMS sending process', [
            'student_id' => $student->id,
            'phone' => $student->phone,
            'name' => $student->first_name . ' ' . $student->last_name
        ]);

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

        \Log::info('SMS: Payload prepared', [
            'api_url' => $apiUrl,
            'formatted_phone' => $this->formatPhoneNumberForSms($student->phone),
            'message_length' => strlen($message)
        ]);

        try {
            $response = Http::withOptions(['verify' => false])
                ->timeout(30)
                ->post($apiUrl, $payload);

            \Log::info('SMS: API response received', [
                'status_code' => $response->status(),
                'response_body' => $response->body()
            ]);

            if ($response->successful()) {
                \Log::info('✅ SMS sent successfully', [
                    'student_id' => $student->id,
                    'phone' => $student->phone,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                \Log::error('❌ Failed to send SMS', [
                    'student_id' => $student->id,
                    'phone' => $student->phone,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            \Log::error('❌ Exception while sending SMS', [
                'student_id' => $student->id,
                'phone' => $student->phone,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Format phone number for SMS API
     */
    protected function formatPhoneNumberForSms($phone)
    {
        \Log::debug('Formatting phone number for SMS', ['original_phone' => $phone]);
        
        // Remove all non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        \Log::debug('Phone after cleaning', ['cleaned_phone' => $phone]);
        
        // If starts with 0, replace with 254
        if (strlen($phone) == 9 && $phone[0] == '0') {
            $formatted = '254' . substr($phone, 1);
            \Log::debug('Formatted as 9-digit starting with 0', ['formatted' => $formatted]);
            return $formatted;
        }
        
        // If starts with 7 or 1 and has 9 digits, add 254
        if (strlen($phone) == 9 && in_array($phone[0], ['7', '1'])) {
            $formatted = '254' . $phone;
            \Log::debug('Formatted as 9-digit starting with 7 or 1', ['formatted' => $formatted]);
            return $formatted;
        }
        
        // If already in 254 format, return as is
        if (strlen($phone) == 12 && strpos($phone, '254') === 0) {
            \Log::debug('Already in 254 format', ['formatted' => $phone]);
            return $phone;
        }
        
        // Return original if no pattern matches
        \Log::warning('Phone number format not recognized, returning original', ['formatted' => $phone]);
        return $phone;
    }
}