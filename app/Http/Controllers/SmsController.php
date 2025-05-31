<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SmsConfiguration;
use App\Models\SMSMessage;
use App\Services\SMSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsController extends Controller
{
    protected $smsService;

    // Constructor injection for SMSService
    public function __construct(SMSService $smsService)
    {
        $this->smsService = $smsService;
    }

    // Send a test SMS (can accept phone and message via request)
public function sendTestSms(Request $request)
{
    $phoneNumber = $request->input('phone', '0725547867');
    $message = $request->input('message', 'Test message from system API');

    if (substr($phoneNumber, 0, 1) === '0') {
        $phoneNumber = '254' . substr($phoneNumber, 1);
    }

    $result = $this->smsService->sendSingleSMS($phoneNumber, $message);
    $balance = $this->smsService->getBalance();

    return response()->json([
        'status' => $result ? 'success' : 'error',
        'message' => $result ? 'SMS sent successfully' : 'Failed to send SMS',
        'recipient' => $phoneNumber,
        'message_content' => $message,
        'current_balance' => $balance,
        'timestamp' => now()->toDateTimeString(),
    ]);
}

    // Display SMS messages list
    public function index()
    {
        $title = 'SMS SEND';
        $access = 'sms';
        $rows = 'row';

        $messages = SMSMessage::orderBy('sent_at', 'desc')->get();

        $filteredMessages = collect();
        $bulkDisplayed = false;

        foreach ($messages as $message) {
            if ($message->is_bulk) {
                if (!$bulkDisplayed) {
                    $filteredMessages->push($message);
                    $bulkDisplayed = true;
                }
            } else {
                $filteredMessages->push($message);
            }
        }

        return view('admin.sms.index', compact('title', 'access', 'rows', 'filteredMessages'));
    }

    // Search SMS messages with filters
    public function search(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string',
            'message_type' => 'nullable|string',
        ]);

        $query = SMSMessage::query();

        if ($request->filled('phone')) {
            $normalizedPhone = $this->normalizePhoneNumber($request->phone);
            $query->where('phone_number', $normalizedPhone);
        }

        if ($request->filled('message_type')) {
            if ($request->message_type == 'individual') {
                $query->where('is_bulk', false);
            } elseif ($request->message_type == 'bulk') {
                $query->where('is_bulk', true);
            }
        }

        $messages = $query->get();

        $filteredMessages = collect();
        $bulkDisplayed = false;

        foreach ($messages as $message) {
            if ($message->is_bulk) {
                if (!$bulkDisplayed) {
                    $filteredMessages->push($message);
                    $bulkDisplayed = true;
                }
            } else {
                $filteredMessages->push($message);
            }
        }

        $title = 'SMS SEND';
        $access = 'sms';
        $rows = 'row';

        return view('admin.sms.index', compact('title', 'access', 'rows', 'filteredMessages'));
    }

    // Normalize phone number to international format
    private function normalizePhoneNumber($phone)
    {
        if (substr($phone, 0, 2) == '07') {
            return '+254' . substr($phone, 1);
        }
        return $phone;
    }

    // Show SMS detail and related students
    public function show($id)
    {
        $message = SMSMessage::findOrFail($id);
        $title = 'SMS Detail';
        $access = 'sms';
        $students = [];

        if ($message->is_bulk) {
            $phoneNumbers = explode(',', $message->phone_number);
            $students = Student::whereIn('phone', $phoneNumbers)->get();
        } else {
            $student = Student::where('phone', $message->phone_number)->first();
            if ($student) {
                $students[] = $student;
            }
        }

        return view('admin.sms.show', compact('message', 'title', 'access', 'students'));
    }

    // Show SMS balance from external API
    public function showBalance()
    {
        $smsConfig = SmsConfiguration::first();

        if (!$smsConfig) {
            return view('admin.sms.balance')->with('balance', 'No SMS configuration found.');
        }

        $response = Http::post('https://smsportal.dapintechnologies.com/sms/v3/profile', [
            'api_key' => $smsConfig->api_key
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $balance = $data['credit_balance'] ?? 'Balance not available';
        } else {
            $balance = 'Failed to authenticate API key.';
        }

        return view('admin.sms.balance', compact('balance'));
    }

    // Show SMS configuration form
    public function create()
    {
        $title = 'SMS SEND';
        $access = 'sms';
        $students = Student::all();
        return view('admin.sms.create', compact('title', 'students', 'access'));
    }

    // Send bulk SMS to selected or all students
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $smsConfig = SmsConfiguration::first();
        if (!$smsConfig) {
            return redirect()->back()->with('error', 'SMS configuration not found.');
        }

        if ($request->has('all_students') && $request->all_students == 1) {
            $students = Student::all();
        } else {
            $request->validate([
                'students' => 'required|array',
            ]);
            $students = Student::whereIn('id', $request->students)->get();
        }

        $messageTemplate = $request->message;

        foreach ($students as $student) {
            $message = str_replace(
                ['[first_name]', '[last_name]', '[student_id]', '[batch]', '[faculty]', '[program]', '[session]', '[semester]', '[section]', '[father_name]', '[mother_name]', '[email]', '[phone]'],
                [$student->first_name, $student->last_name, $student->student_id, $student->batch, $student->faculty, $student->program, $student->session, $student->semester, $student->section, $student->father_name, $student->mother_name, $student->email, $student->phone],
                $messageTemplate
            );

            $this->sendSms($student->phone, $message);
        }

        return redirect()->back()->with('success', 'Bulk SMS sent successfully!');
    }

    // Helper method to send SMS
    private function sendSms($phoneNumber, $message)
    {
        $smsConfig = SmsConfiguration::first();

        if (!$smsConfig) {
            Log::error('SMS configuration not found.');
            return 'SMS configuration not found.';
        }

        $response = Http::post($smsConfig->api_url, [
            'api_key' => $smsConfig->api_key,
            'serviceId' => $smsConfig->service_id,
            'from' => 'Dapin',
            'date_send' => now()->format('Y-m-d H:i:s'),
            'messages' => [
                [
                    'mobile' => $phoneNumber,
                    'message' => $message,
                    'client_ref' => rand(10000, 99999)
                ]
            ]
        ]);

        $responseJson = $response->json();
        Log::info('SMS Response Full Data:', ['response' => $responseJson]);

        $status = 'Failed';
        if ($response->successful() && isset($responseJson['status']) && $responseJson['status'] == 'success') {
            $status = 'Success';
        } elseif (isset($responseJson['detailed_status'])) {
            $allSuccessful = true;
            foreach ($responseJson['detailed_status'] as $msgStatus) {
                if ($msgStatus['status'] != 'success') {
                    $allSuccessful = false;
                    Log::warning('SMS to recipient failed', ['recipient' => $phoneNumber, 'status' => $msgStatus]);
                }
            }
            $status = $allSuccessful ? 'Success' : 'Partial Failure';
        }

        SMSMessage::create([
            'phone_number' => $phoneNumber,
            'message' => $message,
            'is_bulk' => true,
            'status' => $status,
            'sent_at' => now(),
            'api_configuration_id' => $smsConfig->id,
        ]);

        if ($status === 'Success') {
            return 'SMS sent successfully!';
        } else {
            Log::error('SMS sending failed or missing status key', ['response' => $responseJson]);
            return 'Failed to send SMS.';
        }
    }

    // Send SMS to individual student
    public function sendIndividual(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'message' => 'required|string',
        ]);

        $student = Student::find($request->student_id);

        $message = str_replace(
            ['[first_name]', '[last_name]', '[student_id]'],
            [$student->first_name, $student->last_name, $student->student_id],
            $request->message
        );

        $smsConfig = SmsConfiguration::first();

        if (!$smsConfig) {
            Log::error('SMS configuration not found.');
            return redirect()->back()->with('error', 'SMS configuration not found.');
        }

        try {
            $data = [
                'api_key' => $smsConfig->api_key,
                'serviceId' => $smsConfig->service_id,
                'from' => 'Dapin',
                'messages' => [
                    [
                        'mobile' => $student->phone,
                        'message' => $message,
                        'client_ref' => rand(10000, 99999)
                    ]
                ]
            ];

            $response = Http::timeout(120)->post($smsConfig->api_url, $data);

            Log::info('SMS Response Full Data:', ['response' => $response->json()]);

            if (!isset($response->json()['status_code']) || $response->json()['status_code'] != 1000) {
                Log::error('Unexpected API response or invalid credentials', ['response' => $response->json()]);
                return redirect()->back()->with('error', 'Failed to send SMS. Please check API credentials.');
            }

            SMSMessage::create([
                'phone_number' => $student->phone,
                'message' => $message,
                'is_bulk' => false,
                'status' => $response->json()['status_code'] == 1000 ? 'Success' : 'Failed',
                'sent_at' => now(),
                'api_configuration_id' => $smsConfig->id,
            ]);

            return redirect()->back()->with('success', 'SMS sent successfully!');
        } catch (\Exception $e) {
            Log::error('Error sending SMS: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send SMS. Please try again.');
        }
    }

    // Send SMS notification after registration
    public function sendSmsNotification($student)
    {
        $smsConfig = SmsConfiguration::find(1);

        if (!$smsConfig) {
            Log::error('SMS configuration not found.');
            return;
        }

        $message = "Dear {$student->first_name} {$student->last_name}, your registration is successful. Your student ID is {$student->student_id}.";

        $response = Http::post($smsConfig->api_url, [
            'api_key' => $smsConfig->api_key,
            'serviceId' => $smsConfig->service_id,
            'from' => 'YourSchool',
            'messages' => [
                [
                    'mobile' => $student->phone,
                    'message' => $message,
                    'client_ref' => rand(10000, 99999)
                ]
            ]
        ]);

        Log::info('SMS Response:', ['response' => $response->json()]);
    }

    // Show SMS credits on admin dashboard
    public function showCredits()
    {
        $smsConfig = SmsConfiguration::first();
        $balance = 'No SMS configuration found';

        if ($smsConfig) {
            $apiKey = $smsConfig->api_key;

            $response = Http::post('https://smsportal.dapintechnologies.com/sms/v3/profile', [
                'api_key' => $apiKey
            ]);

            if ($response->successful()) {
                $balance = $response->json()['balance'] ?? 'Balance not available';
            } else {
                $balance = 'Failed to authenticate API key';
            }
        }

        return view('admin.index', compact('balance'));
    }

    // Store or update SMS API configuration
    public function store(Request $request)
    {
        $request->validate([
            'sms_api_url' => 'required|string',
            'sms_api_key' => 'required|string',
            'sms_service_id' => 'required|string',
        ]);

        SmsConfiguration::updateOrCreate(
            ['id' => 1],
            [
                'api_url' => $request->sms_api_url,
                'api_key' => $request->sms_api_key,
                'service_id' => $request->sms_service_id,
                'credit_balance' => 0,
            ]
        );

        return redirect()->back()->with('success', 'SMS Configuration updated successfully.');
    }
}
