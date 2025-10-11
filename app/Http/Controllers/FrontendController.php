<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Inquiry;      // Ensure correct model import
use App\Models\Subscription; // Ensure correct model import

use Illuminate\Validation\Rule; // For unique email validation
use Log;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryConfirmation;
use App\Mail\InquiryReceived; 
use App\Mail\SubscriptionConfirmation; 
class FrontendController extends Controller
{
    

public function storeInquiry(Request $request)
{
    \Log::info('Inquiry submission started', $request->all());

    DB::beginTransaction();

    try {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'message' => 'required|string'
        ]);

        // Save the inquiry to the database
        $inquiry = Inquiry::create($validated);
        \Log::info('Inquiry saved to DB', ['id' => $inquiry->id]);

        // Send the inquiry email to the user
        Mail::to($validated['email'])  // Dynamic email from form input
            ->send(new InquiryReceived($inquiry));  // Using the InquiryReceived Mailable class

        // Send email to admin or other recipients if necessary (optional)

        // Commit the transaction
        DB::commit();

        // Store a success message in the session and redirect to the homepage
        session()->flash('success', 'Thank you! We have received your inquiry. We will get back to you soon.');

        // Redirect back to home
        return redirect('/');
    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Please correct the form errors',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Inquiry submission failed', ['error' => $e->getMessage()]);
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while submitting your inquiry. Please try again later.'
        ], 500);
    }
}


public function storeNewsletterSubscription(Request $request)
{
    // Validate the email input
    $validated = $request->validate([
        'email' => 'required|email|max:255|unique:subscriptions,email',
    ]);

    try {
        // Store the email in the database
        $subscription = Subscription::create([
            'email' => $validated['email'],
        ]);

        // Send the confirmation email
        Mail::to($validated['email'])->send(new SubscriptionConfirmation($validated['email']));

        // Flash success message
        session()->flash('success', 'Thank you for subscribing! You will now receive updates and newsletters from us.');

        // Redirect to home page
        return redirect('/');
    } catch (\Exception $e) {
        \Log::error('Subscription failed: ' . $e->getMessage());

        // Flash error message
        session()->flash('error', 'An error occurred. Please try again later.');

        // Redirect to home page
        return redirect('/');
    }
}


}
