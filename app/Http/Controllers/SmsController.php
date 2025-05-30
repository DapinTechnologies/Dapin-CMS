<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\SMSService;
use App\Models\SmsConfiguration;
use App\Models\SMSMessage;
class SmsController extends Controller
{
    public function index()
    {
        $title = 'SMS SEND';
        $access = 'sms';
        $rows= 'row';
        $messages = SMSMessage::orderBy('sent_at', 'desc')->get();
        // Filter to display only one message if it's a bulk message 
       $filteredMessages = collect(); $bulkDisplayed = false; 
       foreach ($messages as $message) { if ($message->is_bulk) 
       { 
       if (!$bulkDisplayed) 
       { 
       $filteredMessages->push($message);
        $bulkDisplayed = true; }
        } else {
        $filteredMessages->push($message);
        }

    }
        return view('admin.sms.index',compact('title','access','rows','filteredMessages'));
    }


    public function search(Request $request)
{
    // Validate the input
    $request->validate([
        'phone' => 'nullable|string',
        'message_type' => 'nullable|string',
    ]);

    // Base query
    $query = SMSMessage::query();

    // Normalize and filter by phone number if provided
    if ($request->filled('phone')) {
        $normalizedPhone = $this->normalizePhoneNumber($request->phone);
        $query->where('phone_number', $normalizedPhone);
    }

    // Filter by message type if provided
    if ($request->filled('message_type')) {
        if ($request->message_type == 'individual') {
            $query->where('is_bulk', false);
        } elseif ($request->message_type == 'bulk') {
            $query->where('is_bulk', true);
        }
    }

    // Fetch messages
    $messages = $query->get();

    // Filter to display only one message if it's a bulk message 
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

private function normalizePhoneNumber($phone)
{
    // Check if the phone number starts with '07' and replace it with '+2547'
    if (substr($phone, 0, 2) == '07') {
        return '+254' . substr($phone, 1);
    }

    // Return the phone number as is if it already has the country code
    return $phone;
}

public function show($id)
 { 
    $message = SMSMessage::findOrFail($id);
     $title = 'SMS Detail'; $access = 'sms';
      // Fetch the student for the phone number
       $students = []; 
       if ($message->is_bulk) 
       { 
        // Assuming the phone numbers in the message are separated by commas 
        $phoneNumbers = explode(',', $message->phone_number); 
        $students = Student::whereIn('phone', $phoneNumbers)->get();
     } 
     else 
     { 
        // For individual messages
         $student = Student::where('phone', $message->phone_number)->first();
          if ($student) { $students[] = $student; 
        } 
    } 
    return view('admin.sms.show', compact('message', 'title', 'access', 'students'));
 }



public function showBalance(SMSService $smsService)
{
    // Fetch the SMS configuration from the database
    $smsConfig = SmsConfiguration::first();

    // Check if configuration exists
    if (!$smsConfig) {
        return view('admin.sms.balance')->with('balance', 'No SMS configuration found in the database.');
    }

    $apiKey = $smsConfig->api_key;

    // Make the API request
    $response = Http::post('https://smsportal.dapintechnologies.com/sms/v3/profile', [
        'api_key' => $apiKey
    ]);

    // Check the response and return the balance
    if ($response->successful()) {
        $data = $response->json();
        $balance = isset($data['credit_balance']) ? $data['credit_balance'] : 'Balance not available';
        return view('admin.sms.balance')->with('balance', $balance);
    }

    return view('admin.sms.balance')->with('balance', 'Failed to authenticate API key.');
}




    public function create()
    {
        $title = 'SMS SEND';
        $access = 'sms';
        $students = Student::all(); // Fetch all students to display in the form
        return view('admin.sms.create', compact('title', 'students','access'));
    }

    public function send(Request $request, SMSService $smsService)
    {
        // Validate the request
        $request->validate([
            'message' => 'required|string',
        ]);
    
        // Retrieve SMS API configuration from the database
        $smsConfig = SmsConfiguration::first(); // Assuming the first record contains the configuration
    
        if (!$smsConfig) {
            return redirect()->back()->with('error', 'SMS configuration not found.');
        }
    
        // Check if "All Students" is selected
        if ($request->has('all_students') && $request->all_students == 1) {
            // Get all students
            $students = Student::all();
        } else {
            // Validate selected students if not sending to all
            $request->validate([
                'students' => 'required|array',
            ]);
    
            // Get the selected students
            $students = Student::whereIn('id', $request->students)->get();
        }
    
        $messageTemplate = $request->message;
    
        // Loop through students and send the message
        foreach ($students as $student) {
            // Replace placeholders with student-specific details
            $message = str_replace(
                [
                    '[first_name]', '[last_name]', '[student_id]', '[batch]', '[faculty]', 
                    '[program]', '[session]', '[semester]', '[section]', '[father_name]', 
                    '[mother_name]', '[email]', '[phone]'
                ],
                [
                    $student->first_name, $student->last_name, $student->student_id, $student->batch, 
                    $student->faculty, $student->program, $student->session, $student->semester, 
                    $student->section, $student->father_name, $student->mother_name, $student->email, 
                    $student->phone
                ],
                $messageTemplate
            );
    
            // Send SMS using the `sendSMS` method
            $smsService->sendSMS($smsConfig->api_key, [$student->phone], $message, true);
        }
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Bulk SMS sent successfully!');
    }
    private function sendSms($phoneNumber, $message)
{
    $smsConfig = SmsConfiguration::first(); // Assuming the first record contains the configuration

    if (!$smsConfig) {
        Log::error('SMS configuration not found in the database.');
        return 'SMS configuration not found.';
    }

    $smsUrl = $smsConfig->api_url;
    $apiKey = $smsConfig->api_key;
    $serviceId = $smsConfig->service_id;

    Log::info('Sending SMS with following details:', [
        'url' => $smsUrl,
        'api_key' => $apiKey,
        'service_id' => $serviceId,
        'phone_number' => $phoneNumber,
        'message' => $message
    ]);

    $response = Http::post($smsUrl, [
        'api_key' => $apiKey,
        'serviceId' => $serviceId,
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

    // Determine the status based on the API response
    $status = 'Failed'; // Default status
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

    // Log status and save the result
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

       
    

    

    // public function send(Request $request)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'message' => 'required|string',
    //     ]);
    
    //     // Check if "All Students" is selected
    //     if ($request->has('all_students') && $request->all_students == 1) {
    //         // Get all students
    //         $students = Student::all();
    //     } else {
    //         // Validate selected students if not sending to all
    //         $request->validate([
    //             'students' => 'required|array',
    //         ]);
    
    //         // Get the selected students
    //         $students = Student::whereIn('id', $request->students)->get();
    //     }
    
    //     $messageTemplate = $request->message;
    
    //     // Loop through students and send the message
    //     foreach ($students as $student) {
    //         // Replace placeholders with student-specific details
    //         $message = str_replace(
    //             [
    //                 '[first_name]', '[last_name]', '[student_id]', '[batch]', '[faculty]', 
    //                 '[program]', '[session]', '[semester]', '[section]', '[father_name]', 
    //                 '[mother_name]', '[email]', '[phone]'
    //             ],
    //             [
    //                 $student->first_name, $student->last_name, $student->student_id, $student->batch, 
    //                 $student->faculty, $student->program, $student->session, $student->semester, 
    //                 $student->section, $student->father_name, $student->mother_name, $student->email, 
    //                 $student->phone
    //             ],
    //             $messageTemplate
    //         );
    
    //         // Send SMS using the `sendSms` method
    //         $this->sendSms($student->phone, $message);
    //     }
    
    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'Bulk SMS sent successfully!');
    // }
    public function sendIndividual(Request $request)
    {
        // Validate the form data
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
    
        // Retrieve the SMS API configuration from the database
        $smsConfig = SmsConfiguration::first(); // Assuming the configuration is stored in the first row
    
        // Check if configuration exists
        if (!$smsConfig) {
            Log::error('SMS configuration not found in the database.');
            return redirect()->back()->with('error', 'SMS configuration not found.');
        }
    
        try {
            // Prepare the data for the API request
            $data = [
                'api_key' => $smsConfig->api_key,
                'serviceId' => $smsConfig->service_id,
                'from' => 'Dapin', // Replace with an approved sender ID
                'messages' => [
                    [
                        'mobile' => $student->phone,
                        'message' => $message,
                        'client_ref' => rand(10000, 99999)
                    ]
                ]
            ];
    
            // Send SMS using Http client with increased timeout
            $response = Http::timeout(120)->post($smsConfig->api_url, $data);
    
            // Log the response
            Log::info('SMS Response Full Data:', ['response' => $response->json()]);
    
            // Check if the response structure is as expected
            if (!isset($response->json()['status_code']) || $response->json()['status_code'] != 1000) {
                Log::error('Unexpected API response structure or Invalid Credentials', ['response' => $response->json()]);
                return redirect()->back()->with('error', 'Failed to send SMS. Please check the API credentials and try again.');
            }
    
            // Save SMS message in the database
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
            Log::error('Error sending SMS: ', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to send SMS. Please try again.');
        }
    }
    
    
// public function sendIndividual(Request $request)
// {
//     // Validate the form data
//     $request->validate([
//         'student_id' => 'required|exists:students,id',
//         'message' => 'required|string',
//     ]);


//     $student = Student::find($request->student_id);

  
//     $message = str_replace(
//         ['[first_name]', '[last_name]', '[student_id]'],
//         [$student->first_name, $student->last_name, $student->student_id],
//         $request->message
//     );

//     $this->sendSms($student->phone, $message);
//     return redirect()->back()->with('success', 'Bulk SMS sent successfully!');
// }





// New method to send SMS after registration
public function sendSmsNotification($student)
{
    // Retrieve SMS API configuration from the database
    $smsConfig = SmsConfiguration::find(1); // Assuming the configuration is stored in row with id 1

    // Check if configuration exists
    if (!$smsConfig) {
        Log::error('SMS configuration not found.');
        return;
    }

    // Prepare the SMS message
    $message = "Dear {$student->first_name} {$student->last_name}, your registration is successful. Your student ID is {$student->student_id}.";
    
    // Use configuration values to send SMS
    $response = Http::post($smsConfig->api_url, [
        'api_key' => $smsConfig->api_key,
        'serviceId' => $smsConfig->service_id,
        'from' => 'YourSchool', // Replace with an approved sender ID
        'messages' => [
            [
                'mobile' => $student->phone, // Use student's phone number
                'message' => $message,
                'client_ref' => rand(10000, 99999)
            ]
        ]
    ]);

    // Log and return the response
    Log::info('SMS Response:', ['response' => $response->json()]);
}


// public function showDashboard(SMSService $smsService)
// {
//     $apiKey = config('services.sms.api_key');
//     $credits = $smsService->checkBalance($apiKey);
//     return view('admin.credit', compact('credits'));
// }

public function showCredits(SmsService $smsService)
 { 
 
    $apiKey = config('services.sms.api_key');
     $balance = $smsService->checkBalance($apiKey); 
     return view('admin.index', compact('balance')); }







public function store(Request $request)
{

   // dd($request->all());
    $request->validate([
        'sms_api_url' => 'required|string',
        'sms_api_key' => 'required|string',
        'sms_service_id' => 'required|string',
    ]);

    // Update existing or create new configuration
    SmsConfiguration::updateOrCreate(
        ['id' => 1], // Single configuration row
        [
            'api_url' => $request->sms_api_url,
            'api_key' => $request->sms_api_key,
            'credit_balance' => 0 // Initial balance (can be updated via API)
        ]
    );

    return redirect()->back()->with('success', 'SMS Configuration updated successfully.');
}

public function showDashboard(SMSService $smsService)
{
    // Fetch the SMS configuration
    $smsConfig = SmsConfiguration::first();
    $balance = null;

    if ($smsConfig) {
        $apiKey = $smsConfig->api_key;

        // Make the API request to retrieve the balance
        $response = Http::post('https://smsportal.dapintechnologies.com/sms/v3/profile', [
            'api_key' => $apiKey
        ]);

        // Check the response and extract the balance if successful
        if ($response->successful()) {
            $balance = $response->json()['balance'] ?? 'Balance not available';
        } else {
            $balance = 'Failed to authenticate API key';
        }
    } else {
        $balance = 'No SMS configuration found in the database';
    }

    // Pass the balance to the view
    return view('admin.index', compact('balance'));
}




}
