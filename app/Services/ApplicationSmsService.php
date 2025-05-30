<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApplicationSmsService
{
    public function sendSms($phone, $message)
    {
        $smsConfig = SmsConfiguration::first();
        if (!$smsConfig) {
            Log::error('SMS configuration not found.');
            return 'SMS configuration not found.';
        }

        $response = Http::post('https://smsportal.dapintechnologies.com/sms/v3/send', [
            'api_key' => $smsConfig->api_key,
            'serviceId' => $smsConfig->service_id,
            'from' => 'Dapin',
            'messages' => [
                [
                    'mobile' => $phone,
                    'message' => $message,
                    'client_ref' => rand(10000, 99999)
                ]
            ]
        ]);

        // Log the response for debugging
        Log::info('SMS API Response: ' . $response->body());
        Log::info('SMS API Status: ' . $response->status());

        $responseJson = $response->json();

        // Check the success status from the API response
        if ($response->successful() && isset($responseJson['status_code']) && $responseJson['status_code'] == 1000) {
            return 'SMS sent successfully!';
        } else {
            Log::error('Failed to send SMS:', ['response' => $responseJson]);
            return 'Failed to send SMS.';
        }
    }
}
