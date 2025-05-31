<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Student;
use App\Models\Setting;
use App\Models\FeesCategory;
use App\Models\Fee;
use App\Models\MpesaSetting;
use App\Models\BankMpesaDetails;
use App\Models\PaybillDetail;
use App\Models\Transaction;
Use Auth;
use Toastr;
use Illuminate\Support\Facades\DB;
use Str;
use Illuminate\Support\Facades\Http;
use Log;
use Carbon\Carbon;
use App\Models\Stkrequest;
class PesaController extends Controller
{



     public function process($id, Request $request)
    {
        $queryData = $request->query();
    
        // Fetch Fee Category details
        $feeCategory = FeesCategory::findOrFail($id);
    
        if (empty($queryData)) {
            return redirect()->route('paymentprocess', [
                'id' => $id,
                'fee_id' => $id, // Pass fee_id here
                'student_id' => auth()->id(),
                'fee_category_id' => $feeCategory->category_id,
                'due_date' => now()->addDays(30)->format('Y-m-d'),
                'fee_amount' => $feeCategory->amount,
                'paid_amount' => 0,
                'phone_number' => auth()->user()->phone ?? '',
               
                'fee_category_title' => $feeCategory->title,
                'pay_date' => now()->format('Y-m-d'),
            ]);
        }
    
        $formData = [
            'fee_category_id' => $feeCategory->id,
            'fee_amount' => $queryData['fee_amount'] ?? $feeCategory->amount,
            'phone_number' => $queryData['phone_number'] ?? auth()->user()->phone ?? '',
            'due_date' => $queryData['due_date'] ?? now()->addDays(30)->format('Y-m-d'),
            'fee_category_title' => $queryData['fee_category_title'] ?? $feeCategory->title,
        ];
    
        return view('student.fees.mpesa_payment', [
            'paymentId' => $id,
            'feeId' => $id, // Ensure this is passed
            'queryData' => $queryData,
            'formData' => $formData,
            'feeCategoryTitle' => $feeCategory->title,
        ]);
    }
    
    
public function initiateStkPush(Request $request){
    dd($request);

}




}
