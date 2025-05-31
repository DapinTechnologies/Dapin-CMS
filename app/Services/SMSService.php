<?php

namespace App\Services;

use App\Models\SmsConfiguration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class SMSService
{
    protected $config;

    public function __construct()
    {
        // Fetch SMS configuration from the database
        $this->config = SmsConfiguration::first();

        if (!$this->config) {
            throw new \Exception('SMS configuration not found in database.');
        }
    }

    /**
     * Send a single SMS
     */
    public function sendSingleSMS($phoneNumber, $message, $scheduleTime = null)
    {
        // Normalize phone number (e.g. 07xxx -> 2547xxx)
        if (!Str::startsWith($phoneNumber, '254')) {
            if (Str::startsWith($phoneNumber, '0')) {
                $phoneNumber = '254' . substr($phoneNumber, 1);
            }
        }

        $payload = [
            'api_key' => $this->config->api_key,
            'serviceId' => $this->config->service_id,
            'from' => $this->config->sender_id ?? 'Dapin', // use DB sender or default
            'messages' => [
                [
                    'mobile' => $phoneNumber,
                    'message' => $message,
                    'client_ref' => rand(10000, 99999),
                ]
            ],
        ];

        if ($scheduleTime) {
            $payload['date_send'] = $scheduleTime->format('Y-m-d H:i:s');
        }

        try {
            // Disable SSL verification for testing, remove in production!
            $response = Http::withoutVerifying()->post($this->config->api_url, $payload);

            $responseJson = $response->json();
            Log::info('SMS Send Response', ['response' => $responseJson]);

            // Check for success (adjust according to your API response)
            if ($response->successful() && isset($responseJson['status']) && $responseJson['status'] === 'success') {
                return true;
            }

            Log::error('SMS sending failed', ['response' => $responseJson]);
            return false;
        } catch (\Exception $e) {
            Log::error('SMS sending exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get current SMS balance
     */
    public function getBalance()
    {
        try {
            $payload = [
                'api_key' => $this->config->api_key,
                'serviceId' => $this->config->service_id,
            ];

            $response = Http::withoutVerifying()->post($this->config->api_url_balance ?? $this->config->api_url, $payload);

            $responseJson = $response->json();
            Log::info('SMS Balance Response', ['response' => $responseJson]);

            if ($response->successful() && isset($responseJson['balance'])) {
                return $responseJson['balance'];
            }

            return null;
        } catch (\Exception $e) {
            Log::error('SMS balance exception: ' . $e->getMessage());
            return null;
        }
    }
}
