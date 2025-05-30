<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\SMSMessage;
use App\Models\SmsConfiguration;
use Illuminate\Support\Facades\Log;
class SMSService
{

    protected $apiUrl; protected $serviceId; 
    public function __construct() 
    { $smsConfig = SmsConfiguration::first(); if ($smsConfig)
         { $this->apiUrl = $smsConfig->api_url; 
            $this->serviceId = $smsConfig->service_id; 



                       
         }
         }
    //protected $apiUrl = 'https://smsportal.dapintechnologies.com/sms/v3/profile';

    public function checkBalance($apiKey)
{
    // $response = Http::post($this->apiUrl, [
    //     'api_key' => $apiKey
    // ]);


//     if (is_array($data) && isset($data[0]['wallet']['credit_balance'])) {
//         return (float)$data[0]['wallet']['credit_balance'];
//     } else {
//         Log::error('Unexpected API response structure', ['response' => $data]);
//         return 'Credit balance not found in the response.';
//     }
// }

// Log::error('Failed to authenticate API key', ['api_key' => $apiKey, 'response' => $response->body()]);
// return 'Failed to authenticate API key.';




    $response = Http::post('https://smsportal.dapintechnologies.com/sms/v3/profile',
     [ 
        'api_key' => $apiKey 
    ]);



    if ($response->successful()) {
        $data = $response->json();

        if ($response->successful()) { $responseJson = $response->json();
             return $responseJson['wallet']['credit_balance'] ?? 'Balance not found'; } else 
        { Log::error('Failed to authenticate API key.', ['response' => $response->body()]);
             return 'Failed to authenticate API key.'; 
            } 
        }
       
}

    

    public function alertIfLowCredit($apiKey)
    {
        $credits = $this->checkBalance($apiKey);
        if ($credits !== null && $credits < 10) {
            // Notify the user to top up
            \Notification::send(auth()->user(), new \App\Notifications\LowSmsCredits($credits));
        }
    }

    public function sendSMS($apiKey, $recipients, $message, $isBulk = false)
    {
        $payload = [
            'api_key' => $apiKey,
            'serviceId' => $this->serviceId,
            'from' => 'Dapin',
            'date_send' => now()->format('Y-m-d H:i:s'),
            'messages' => array_map(function($recipient) use ($message) {
                return [
                    'mobile' => (string)$recipient,  // Ensure this is a string
                    'message' => $message,
                    'client_ref' => rand(10000, 99999)
                ];
            }, $recipients)
        ];
    
        Log::info('Sending SMS with payload:', ['payload' => $payload]);
    
        try {
            $response = Http::timeout(30)->post($this->apiUrl, $payload); // Increased timeout
    
            // Log the full response for debugging
            Log::info('Full SMS API Response:', ['response' => $response->body()]);
    
            $responseJson = $response->json();
            $status = 'Failed'; // Default status
            if ($response->successful() && isset($responseJson['status']) && $responseJson['status'] == 'success') {
                $status = 'Success';
            } elseif (isset($responseJson['messages'])) {
                // Check detailed statuses within the response
                $allSuccessful = true;
                foreach ($responseJson['messages'] as $msgStatus) {
                    if ($msgStatus['status'] != 'success') {
                        $allSuccessful = false;
                        Log::warning('SMS to recipient failed', ['recipient' => $msgStatus['mobile'], 'status' => $msgStatus]);
                    }
                }
                $status = $allSuccessful ? 'Success' : 'Partial Failure';
            }
    
            foreach ($recipients as $recipient) {
                SMSMessage::create([
                    'phone_number' => $recipient,
                    'message' => $message,
                    'is_bulk' => $isBulk,
                    'status' => $status,
                    'sent_at' => now(),
                    'api_configuration_id' => SmsConfiguration::first()->id,
                ]);
            }
    
            if ($status == 'Failed') {
                Log::error('Failed to send SMS:', ['response' => $response->body()]);
            }
    
            return ['status' => $status, 'remaining_credits' => $this->checkBalance($apiKey)];
        } catch (\Exception $e) {
            Log::error('Error sending SMS:', ['error' => $e->getMessage()]);
            return ['status' => 'Failed', 'error' => $e->getMessage()];
        }
    }
    

    

    public function sendSingleSMS($apiUrl, $data) 
    { 
    // Send the POST request to the SMS API 
    $response = Http::timeout(60)->post($apiUrl, $data);
     // Log the request data and response 
    Log::info('Sending SMS with data: ', 
    ['data' => $data]);
     Log::info('SMS API Response: ', 
    ['response' => $response->json()]);
     return $response->json(); 
    }
  
}