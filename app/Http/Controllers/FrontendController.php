<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Inquiry;      // Ensure correct model import
use App\Models\Subscription; // Ensure correct model import

use Illuminate\Validation\Rule; // For unique email validation
use Log;
class FrontendController extends Controller
{
    

public function storeInquiry(Request $request)
{
    dd($request->all());
    try {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'message' => 'required|string|max:1000',
        ]);

        $enquiry = new Inquiry();
        $enquiry->name = $request->name;
        $enquiry->phone = $request->phone;
        $enquiry->email = $request->email;
        $enquiry->message = $request->message;
        $enquiry->save();

        return response()->json(['success' => true]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation Failed', $e->errors());
        return response()->json(['errors' => $e->errors()], 422);
    }
}


public function storeNewsletter(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:subscriptions,email',
    ]);

    \DB::table('subscriptions')->insert([
        'email' => $request->email,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json(['success' => true]);
}
}
