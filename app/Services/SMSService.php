<?php

namespace App\Services;

use App\Models\StudentEnroll;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\FeePayment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SmsService
{
    protected $apiUrl = 'https://smsportal.dapintechnologies.com/sms/v3/sendsms';
    protected $apiKey = '0CHxwhLRQ78MEFablqnsAtkgBNDjrJWou569KYpUd3eySPXT4ZOzv1cIiVG2mf';
    protected $from = 'Dapin';
    protected $serviceId = 0;

    /**
     * Format phone number to international format.
     */
    public function formatPhone($phone)
    {
        $phone = preg_replace('/\D+/', '', $phone);

        if (strlen($phone) == 10 && str_starts_with($phone, '0')) {
            return '254' . substr($phone, 1);
        }

        if (str_starts_with($phone, '254')) {
            return $phone;
        }

        return $phone;
    }

    /**
     * Send a message to one student.
     */
    public function sendToStudent($student, $message)
    {
        if (!$student || !$student->phone) {
            return false;
        }

        $payload = [
            'api_key'       => $this->apiKey,
            'service_id'    => $this->serviceId,
            'mobile'        => $this->formatPhone($student->phone),
            'response_type' => 'json',
            'shortcode'     => $this->from,
            'message'       => $message,
            'date_send'     => Carbon::now()->format('Y-m-d H:i:s'),
        ];

        try {
            $response = Http::withOptions(['verify' => false])
                ->post($this->apiUrl, $payload);

            Log::info('SMS sent to student', [
                'student_id' => $student->id,
                'phone'      => $student->phone,
                'response'   => $response->json()
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('SMS failed', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Process payment and send SMS notification.
     */
}