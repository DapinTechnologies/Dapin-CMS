<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FrontendInquiryController extends Controller
{
    public function store(Request $request)
    {
        // Field Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        try {
            // Insert Data into Inquiry model - only use existing columns
            $inquiry = Inquiry::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'message' => $request->message ?? '',
            ]);

            // Debug: Check if inquiry was saved
            Log::info('Inquiry saved successfully. ID: ' . $inquiry->id);

            // Return success response
            return redirect()->back()->with('success', 'Thank you for your inquiry. We will get back to you soon!');

        } catch (\Exception $e) {
            Log::error('Inquiry store error: ' . $e->getMessage());
            Log::error('Inquiry store trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred. Please try again. Error: ' . $e->getMessage());
        }
    }

    public function storeNewsletter(Request $request)
    {
        //dd($request->all());
        // Field Validation
        $request->validate([
            'email' => 'required|email|max:255|unique:subscriptions,email',
        ]);

        try {
            // Insert Data into Subscription model
            $subscription = Subscription::create([
                'email' => $request->email
            ]);

            return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');

        } catch (\Exception $e) {
            Log::error('Newsletter subscription error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }
}