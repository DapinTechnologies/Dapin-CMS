<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Stkrequest;
use App\Models\Fee;
use App\Models\Transaction;
class PeseStkPsh extends Controller
{
    
    private $urltoken='Q23FDDFGHHJhggfffw12345fffKIty123455!()#@^&!%^%';

    public $whitelistips=[
       '196.201.214.200',
       '196.201.214.206',
       '196.201.213.114',
       '196.201.214.207',
       '196.201.214.208',
       '196. 201.213.44',
       '196.201.212.127',
       '196.201.212.138',
       '196.201.212.129',
       '196.201.212.136',
       '196.201.212.74',
       '196.201.212.69'
    ]; 
    public function token(){

        $consumerKey='BsAU74zUN0GsLllnOfPwtitJM6p4dsxt5XDd4lErwY5eqnU4';
        $consumerSecret='zQyxrE8WLOjmHANwNo1G4AG19NXsphiW3LJD0osRZwRRdglhkk4s9AB5GIr29FWr';
        $url='https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
     
        $response=Http::withBasicAuth($consumerKey,$consumerSecret)
        ->get($url);
        return $response['access_token'];
       }
       public function initiateStkPush(Request $request)
       {
           $feeId = $request->input('fee_id');
            //$feeCategory = FeeCategory::find($feeId);
            //dd($request->all());
            if (Str::startsWith($request->input('phone_number'), '254')) {
      // Remove '254' from the start
      $phoneNumber = $request->input('phone_number');
   
   }else{
      $number = Str::substr($request->input('phone_number'),1);
      $phoneNumber = '254' . $number;
   }
          $accessToken=$this->token();
          $url='https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
          $Passkey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
          $BusinessShortCode=174379;
          $Timestamp=Carbon::now()->format('YmdHis');
          $password=base64_encode($BusinessShortCode.$Passkey.$Timestamp);
          $TransactionType='CustomerPayBillOnline';
          $Amount=$request->input('payment_amount');
          $PartyA=$phoneNumber; 
          $PartyB=174379;
          $PhoneNumber=$phoneNumber; 
          $CallBackURL='https://urbankenyarealty.com/college/stkcallback?urltoken='.$this->urltoken;
          //$CallBackURL='https://collegemgt.dapineducation.co.ke/callback.php?urltoken='.$this->urltoken;
          $AccountReference='Fee';
          $TransactionDesc='College Fee payment';
          try{
           $response=Http::withToken($accessToken)->post($url,
          ['BusinessShortCode'=>$BusinessShortCode,
          'Password'=>$password,
          'Timestamp'=>$Timestamp,
          'TransactionType'=>$TransactionType,
          'Amount'=>$Amount,
          'PartyA'=>$PartyA,
          'PartyB'=>$PartyB,
          'PhoneNumber'=>$PhoneNumber,
          'CallBackURL'=>$CallBackURL,
          'AccountReference'=>$AccountReference,
          'TransactionDesc'=>$TransactionDesc
          
       ]);
          }
          catch(Throwable $e){
            return $e->getMessage();
           }
           
        //return $response;
        $res=json_decode($response);
        $ResponseCode=$res->ResponseCode;
        if($ResponseCode==0){
          $MerchantRequestID=$res->MerchantRequestID;
          $CheckoutRequestID=$res->CheckoutRequestID;
          $CustomerMessage=$res->CustomerMessage;
      
          //save to database
          $payment= new Stkrequest;
          $payment->phone=$PhoneNumber;
            $payment->amount = $Amount;
          $payment->reference=$AccountReference;
          $payment->description=$TransactionDesc;
          $payment->MerchantRequestID=$MerchantRequestID;
          $payment->CheckoutRequestID=$CheckoutRequestID;
          $payment->status='Requested';
          
        $payment->assign_date = $request->input('assign_date');
        $payment->due_date = $request->input('due_date');
        $payment->student_id = $request->input('student_id');  
        $payment->fee_id = $request->input('fee_id');
        $payment->pay_date = $request->input('pay_date');
        $payment->fee_category = $request->input('fee_category');
        $payment->fee_amount = $request->input('fee_amount');
        $payment->balance = $request->input('balance');
        $payment->payment_amount = $request->input('payment_amount');
          
          $payment->save();
          
          
          
          return $CustomerMessage;
        }
        }                      

        public function stkCallback(Request $request){
           
           $data=file_get_contents('php://input');
           
         $response=json_decode($data);
         $ResultCode=$response->Body->stkCallback->ResultCode;
         if($ResultCode==0){
           $MerchantRequestID=$response->Body->stkCallback->MerchantRequestID;
           $ResultDesc=$response->Body->stkCallback->ResultDesc;
           $CheckoutRequestID=$response->Body->stkCallback->CheckoutRequestID;
           $Amount=$response->Body->stkCallback->CallbackMetadata->Item[0]->Value;
           $MpesaReceiptNumber=$response->Body->stkCallback->CallbackMetadata->Item[1]->Value;
          // $Balance=$response->Body->stkCallback->CallbackMetadata->Item[2]->Value;
           $TransactionDate=$response->Body->stkCallback->CallbackMetadata->Item[3]->Value;
           $PhoneNumber=$response->Body->stkCallback->CallbackMetadata->Item[4]->Value;
          
          $payment= Stkrequest::where('CheckoutRequestID',$CheckoutRequestID)
          ->first();
          $payment->status='Paid';
          $payment->TransactionDate=$TransactionDate;
          $payment->MpesaReceiptNumber=$MpesaReceiptNumber;
          $payment->ResultDesc=$ResultDesc;
          $payment->save();
          $Amount=$payment->amount;
         
         
         
          $existingFee = Fee::where('student_id', $payment->student_id)
            ->where('fee_category_id', $feeCategory->id) 
            ->first();
            
            if ($existingFee) {
            $existingFee->amount += $Amount;
            $existingFee->status = '1'; 
            $existingFee->save();
            } else {
            $fee = new Fee();
            $fee->student_enroll_id = $payment->student_id;
           $fee->fee_category_id = $feeCategory->id;
            $fee->amount = $Amount;
            $fee->due_date = now()->addDays(30);
            $fee->status = '1';
            $fee->save();
        }
        //     do {
        //     $transactionId = Str::random(16);
        // } while (Transaction::where('transaction_id', $transactionId)->exists());

        // $transaction = new Transaction();
        // $transaction->transaction_id = $transactionId; // Unique transaction ID
        //  $transaction->transactionable_type = get_class($fee); // App\Models\Fee
        // $transaction->transactionable_id = $fee->id;


        // $transaction->amount = $Amount;
        // $transaction->transation_type = '1';
        // $transaction->status = 'completed';
        // $transaction->save();
            
            
        }
        else{
           $ResultDesc=$response->Body->stkCallback->ResultDesc;
           
           $CheckoutRequestID=$response->Body->stkCallback->CheckoutRequestID;
           
           $payment= Stkrequest::where('CheckoutRequestID',$CheckoutRequestID)
          ->first();
          $payment->ResultDesc=$ResultDesc;
          $payment->status='Failed';
          $payment->save();
          
          
          
          
          
          
        
        }
          

    }
}
