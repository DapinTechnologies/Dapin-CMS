<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Auth;
use Toastr;
use App\Models\StudentEnroll;
use App\Models\FeeStructureItem;
use App\Models\PrintSetting;
use App\Models\FeesCategory;
use App\Models\Transaction;
use App\Models\Semester;
use App\Models\Faculty;
use App\Models\Session;
use App\Models\Program;
use App\Models\Section;
use App\Models\Fee;
use App\Models\Invoice;
use App\Models\MpesaSetting;
use App\Models\BankMpesaDetails;
use App\Models\Payment;
use App\Models\FeePayment;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Browsershot\Browsershot;
use App\Services\SmsService;
use App\Models\BankAccount;
use App\Models\Bursary;
use App\Models\User;

class FeesStudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
// In Student.php model
public function getFullNameAttribute()
{
    return "{$this->first_name} {$this->last_name}";
}


    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_fees_due', 1);
        $this->route = 'admin.fees-student';
        $this->view = 'admin.fees-student';
        $this->path = 'student';
        $this->access = 'fees-student';

$this->middleware('permission:'.$this->access.'-multi-assign', ['only' => ['assignMultiple', 'storeMultiple']]);

        $this->middleware('permission:'.$this->access.'-due', ['only' => ['index']]);
        $this->middleware('permission:'.$this->access.'-quick-assign', ['only' => ['quickAssign','quickAssignStore']]);
        $this->middleware('permission:'.$this->access.'-quick-received', ['only' => ['quickReceived','quickReceivedStore']]);
        $this->middleware('permission:'.$this->access.'-action', ['only' => ['index','pay','unpay','cancel']]);
        $this->middleware('permission:'.$this->access.'-report', ['only' => ['report']]);
        $this->middleware('permission:'.$this->access.'-print', ['only' => ['report','print','multiPrint']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function index(Request $request)
{

   // Handle reminder request
    if ($request->has('send_reminder')) {
        return $this->handleReminderRequest($request);
    }

    $data['title'] = $this->title;
    $data['route'] = $this->route;
    $data['view'] = $this->view;
    $data['path'] = $this->path;
    $data['access'] = $this->access;

    // Initialize filter values
    $data['selected_faculty'] = $faculty = $request->faculty ?? '0';
    $data['selected_program'] = $program = $request->program ?? '0';
    $data['selected_session'] = $session = $request->session ?? '0';
    $data['selected_semester'] = $semester = $request->semester ?? '0';
    $data['selected_section'] = $section = $request->section ?? '0';
    $data['selected_category'] = $category = $request->category ?? '0';
    $data['selected_student_id'] = $student_id = $request->student_id ?? null;

    // Get filter options
    $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
    $data['categories'] = FeesCategory::where('status', '1')->orderBy('title', 'asc')->get();
    $data['print'] = PrintSetting::where('slug', 'fees-receipt')->first();

    // Get dependent filter options
    if(!empty($faculty) && $faculty != '0'){
        $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();
    }

    if(!empty($program) && $program != '0'){
        $sessions = Session::where('status', 1);
        $sessions->with('programs')->whereHas('programs', function ($query) use ($program){
            $query->where('program_id', $program);
        });
        $data['sessions'] = $sessions->orderBy('id', 'desc')->get();
    }

    if(!empty($program) && $program != '0'){
        $semesters = Semester::where('status', 1);
        $semesters->with('programs')->whereHas('programs', function ($query) use ($program){
            $query->where('program_id', $program);
        });
        $data['semesters'] = $semesters->orderBy('id', 'asc')->get();
    }

    if(!empty($program) && $program != '0' && !empty($semester) && $semester != '0'){
        $sections = Section::where('status', 1);
        $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($program, $semester){
            $query->where('program_id', $program);
            $query->where('semester_id', $semester);
        });
        $data['sections'] = $sections->orderBy('title', 'asc')->get();
    }

    // Get invoices with proper eager loading - similar to quickAssign
    $query = Invoice::with([
        'studentEnroll.student',
        'studentEnroll.program.faculty',
        'studentEnroll.session',
        'studentEnroll.semester',
        'studentEnroll.section',
        'fees' => function($query) {
            $query->with(['category', 'payments']);
        }
    ]);

    // Apply filters
    if($faculty != '0'){
        $query->whereHas('studentEnroll.program', function($q) use ($faculty) {
            $q->where('faculty_id', $faculty);
        });
    }

    if($program != '0'){
        $query->whereHas('studentEnroll', function($q) use ($program) {
            $q->where('program_id', $program);
        });
    }

    if($session != '0'){
        $query->whereHas('studentEnroll', function($q) use ($session) {
            $q->where('session_id', $session);
        });
    }

    if($semester != '0'){
        $query->whereHas('studentEnroll', function($q) use ($semester) {
            $q->where('semester_id', $semester);
        });
    }

    if($section != '0'){
        $query->whereHas('studentEnroll', function($q) use ($section) {
            $q->where('section_id', $section);
        });
    }

    if($category != '0'){
        $query->whereHas('fees', function($q) use ($category) {
            $q->where('category_id', $category);
        });
    }

    if(!empty($student_id)){
        $query->whereHas('studentEnroll.student', function($q) use ($student_id) {
            $q->where('student_id', 'LIKE', '%'.$student_id.'%');
        });
    }

    // Get only pending/unpaid/partial invoices
        $data['invoices'] = $query->whereIn('payment_status', ['pending', 'unpaid', 'partial'])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($invoice) {
                // Calculate totals from payments table
                $totalPaid = $invoice->payments->sum('amount');
                $amountDue = $invoice->total_fee - $totalPaid;

                // Update payment status based on payments
                $paymentStatus = $invoice->payment_status;
                if ($totalPaid >= $invoice->total_fee) {
                    $paymentStatus = 'paid';
                } elseif ($totalPaid > 0) {
                    $paymentStatus = 'partial';
                }

                // Add calculated fields
                $invoice->amount_paid = $totalPaid;
                $invoice->amount_due = $amountDue;
                $invoice->payment_status = $paymentStatus;

                return $invoice;
            });

        // Get all active students for edit dropdown
        $data['students'] = StudentEnroll::with('student')
            ->where('status', '1')
            ->orderBy('id', 'desc')
            ->get();

        return view($this->view . '.index', $data);
    }

    // Add this method to your existing controller
protected function handleReminderRequest($request)
{
    try {
        $validator = Validator::make($request->all(), [
            'student_enroll_id' => 'required|exists:student_enrolls,id',
            'invoice_id' => 'required|exists:invoices,id',
            'message' => 'required|string|max:160'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $enroll = StudentEnroll::with('student')->find($request->student_enroll_id);
        $invoice = Invoice::find($request->invoice_id);

        if (!$enroll || !$enroll->student) {
            return response()->json([
                'success' => false,
                'message' => 'Student record not found'
            ], 404);
        }

        if (empty($enroll->student->phone)) {
            return response()->json([
                'success' => false,
                'message' => 'Student phone number is missing'
            ], 400);
        }

        $formattedPhone = $this->formatPhoneNumber($enroll->student->phone);

        $apiUrl = 'https://smsportal.dapintechnologies.com/sms/v3/sendsms';
        $apiKey = '0CHxwhLRQ78MEFablqnsAtkgBNDjrJWou569KYpUd3eySPXT4ZOzv1cIiVG2mf';
        
        $payload = [
            'api_key' => $apiKey,
            'service_id' => 0,
            'mobile' => $formattedPhone,
            'response_type' => 'json',
            'shortcode' => 'Dapin',
            'message' => $request->message,
            'date_send' => now()->format('Y-m-d H:i:s'),
        ];

        $response = Http::withOptions(['verify' => false])
            ->timeout(30)
            ->post($apiUrl, $payload);

        if ($response->successful()) {
            \Log::info('SMS Reminder Sent', [
                'student_id' => $enroll->student->id,
                'invoice_id' => $invoice->id,
                'original_phone' => $enroll->student->phone,
                'formatted_phone' => $formattedPhone,
                'message' => $request->message
            ]);

            return response()->json(['success' => true]);
        }

        \Log::error('SMS API Error', [
            'status' => $response->status(),
            'response' => $response->body()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to send SMS. Please try again later.'
        ], 500);

    } catch (\Exception $e) {
        \Log::error('Reminder Exception', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

 protected function formatPhoneNumber($phone)
    {
        // Remove all non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Handle Kenyan phone numbers specifically
        if (strlen($phone) === 9 && strpos($phone, '0') === 0) {
            return '254' . substr($phone, 1);
        }
        
        if (strlen($phone) === 10 && strpos($phone, '0') === 0) {
            return '254' . substr($phone, 1);
        }
        
        // If already in international format (254...)
        if (strlen($phone) === 12 && strpos($phone, '254') === 0) {
            return $phone;
        }
        
        // Default return (shouldn't happen for valid numbers)
        return $phone;
    }

public function assignMultiple()
{
    $data['title'] = 'Assign Multiple Fee Categories';
    $data['categories'] = FeesCategory::where('status', 1)->orderBy('title')->get();

    // Load all students with their student info
    $data['students'] = StudentEnroll::with('student')
                          ->where('status', 1)
                          ->get();

    return view('admin.fees-student.assign-multiple', $data);
}


public function ajaxSearchStudents(Request $request)
{
    $term = $request->q;

    $students = StudentEnroll::with('student')
        ->where('status', 1)
        ->whereHas('student', function ($query) use ($term) {
            $query->where('student_id', 'LIKE', "%{$term}%")
                  ->orWhere('first_name', 'LIKE', "%{$term}%")
                  ->orWhere('last_name', 'LIKE', "%{$term}%");
        })
        ->limit(20)
        ->get();

    $results = [];

    foreach ($students as $enroll) {
        if ($enroll->student) {
            $results[] = [
                'id' => $enroll->id,
                'text' => "{$enroll->student->student_id} - {$enroll->student->first_name} {$enroll->student->last_name}",
            ];
        }
    }

    return response()->json($results);
}

public function storeMultiple(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:student_enrolls,id',
        'categories' => 'required|array|min:1',
        'amounts' => 'required|array|min:1',
    ]);

    $studentEnrollId = $request->student_id;
    $categories = $request->categories;
    $amounts = $request->amounts;

    if (count($categories) !== count($amounts)) {
        return redirect()->back()->withErrors(['Category and Amount count must match']);
    }

    // Save fees
    foreach ($categories as $index => $categoryId) {
        $amount = $amounts[$index];

        Fee::create([
            'student_enroll_id' => $studentEnrollId,
            'category_id' => $categoryId,
            'fee_amount' => $amount,
            'assign_date' => now(),
            'due_date' => now()->addDays(30),
            'status' => 0,
            'created_by' => auth()->id(),
        ]);
    }

    // Fetch assigned fees with category names for the student
    $assignedFees = Fee::where('student_enroll_id', $studentEnrollId)
        ->with('category')  // assuming Fee model has category() relation
        ->get();

    // Also get student details to display
    $studentEnroll = StudentEnroll::with('student')->find($studentEnrollId);

    return redirect()->back()->with([
        'success' => 'Fees assigned successfully.',
        'assignedFees' => $assignedFees,
        'studentEnroll' => $studentEnroll,
    ]);
}
public function assignedFeesHistory()
{
    // Get all student enrolls with assigned fees and student info
    $studentEnrolls = StudentEnroll::with(['student', 'fees.category'])
        ->whereHas('fees')  // Only students with fees assigned
        ->orderBy('student_id') // Or any order you want
        ->get();

    // Pass data to view
    return view('admin.fees-student.assigned-fees-history', compact('studentEnrolls'));

    
}



public function assignedFeesSummary()
{
    $totalAssigned = Fee::sum('fee_amount');
    $totalPaid = Fee::where('status', 1)->sum('fee_amount');
    $totalDue = Fee::where('status', 0)->sum('fee_amount');

    // Pass to view
    return view('admin.fees-student.fees-summary', compact('totalAssigned', 'totalPaid', 'totalDue'));
}



    /**
     * Store multiple fee categories assigned to multiple students.
     */
 



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request)
    {
        // Field Validation
        $request->validate([
            'pay_date' => 'required|date|before_or_equal:today',
            'payment_method' => 'required',
            'fee_amount' => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'fine_amount' => 'required|numeric',
            'paid_amount' => 'required|numeric',
        ]);


        $fee = Fee::find($request->fee_id);

        // Discount Calculation
        $discount_amount = 0;
        $today = date('Y-m-d');

        if(isset($fee->category)){
        foreach($fee->category->discounts->where('status', '1') as $discount){

        $availability = \App\Models\FeesDiscount::availability($discount->id, $fee->studentEnroll->student_id);

            if(isset($availability)){
            if($discount->start_date <= $today && $discount->end_date >= $today){
                if($discount->type == '1'){
                    $discount_amount = $discount_amount + $discount->amount;
                }
                else{
                    $discount_amount = $discount_amount + ( ($fee->fee_amount / 100) * $discount->amount);
                }
            }}
        }}


        // Fine Calculation
        $fine_amount = 0;
        if(empty($fee->pay_date) || $fee->due_date < $fee->pay_date){
            
            $due_date = strtotime($fee->due_date);
            $today = strtotime(date('Y-m-d')); 
            $days = (int)(($today - $due_date)/86400);

            if($fee->due_date < date("Y-m-d")){
                if(isset($fee->category)){
                foreach($fee->category->fines->where('status', '1') as $fine){
                if($fine->start_day <= $days && $fine->end_day >= $days){
                    if($fine->type == '1'){
                        $fine_amount = $fine_amount + $fine->amount;
                    }
                    else{
                        $fine_amount = $fine_amount + ( ($fee->fee_amount / 100) * $fine->amount);
                    }
                }
                }}
            }
        }


        // Net Amount Calculation
        $net_amount = ($fee->fee_amount - $discount_amount) + $fine_amount;

        
        DB::beginTransaction();
        // Update Data              
        // $fee->fee_amount = $request->fee_amount;
        $fee->discount_amount = $discount_amount;
        $fee->fine_amount = $fine_amount;
        $fee->paid_amount = $net_amount;
        $fee->pay_date = $request->pay_date;
        $fee->payment_method = $request->payment_method;
        $fee->note = $request->note;
        $fee->status = '1';
        $fee->updated_by = Auth::guard('web')->user()->id;
        $fee->save();


        // Transaction
        $transaction = new Transaction;
        $transaction->transaction_id = Str::random(16);
        $transaction->amount = $net_amount;
        $transaction->type = '1';
        $transaction->created_by = Auth::guard('web')->user()->id;
        $fee->studentEnroll->student->transactions()->save($transaction);
        DB::commit();




        //Enter SMS To SHOW PAyment Has been done

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back()->with('receipt', $fee->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unpay(Request $request, $id)
    {
        try{

            DB::beginTransaction();
            // Update Data
            $fee = Fee::findOrFail($id);
            $fee->pay_date = null;
            $fee->payment_method = null;
            $fee->note = $request->note;
            $fee->status = '0';
            $fee->updated_by = Auth::guard('web')->user()->id;
            $fee->save();


            // Transaction
            $transaction = new Transaction;
            $transaction->transaction_id = Str::random(16);
            $transaction->amount = $fee->paid_amount;
            $transaction->type = '2';
            $transaction->created_by = Auth::guard('web')->user()->id;
            $fee->studentEnroll->student->transactions()->save($transaction);
            DB::commit();


            Toastr::success(__('msg_updated_successfully'), __('msg_success'));

            return redirect()->back();
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request, $id)
    {
        // Update Data
        $fee = Fee::findOrFail($id);
        $fee->pay_date = null;
        $fee->payment_method = null;
        $fee->note = $request->note;
        $fee->status = '2';
        $fee->updated_by = Auth::guard('web')->user()->id;
        $fee->save();


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        //
        $data['title'] = trans_choice('module_fees_report', 1);
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;


        if(!empty($request->faculty) || $request->faculty != null){
            $data['selected_faculty'] = $faculty = $request->faculty;
        }
        else{
            $data['selected_faculty'] = $faculty = '0';
        }

        if(!empty($request->program) || $request->program != null){
            $data['selected_program'] = $program = $request->program;
        }
        else{
            $data['selected_program'] = $program = '0';
        }

        if(!empty($request->session) || $request->session != null){
            $data['selected_session'] = $session = $request->session;
        }
        else{
            $data['selected_session'] = $session = '0';
        }

        if(!empty($request->semester) || $request->semester != null){
            $data['selected_semester'] = $semester = $request->semester;
        }
        else{
            $data['selected_semester'] = $semester = '0';
        }

        if(!empty($request->section) || $request->section != null){
            $data['selected_section'] = $section = $request->section;
        }
        else{
            $data['selected_section'] = $section = '0';
        }

        if(!empty($request->category) || $request->category != null){
            $data['selected_category'] = $category = $request->category;
        }
        else{
            $data['selected_category'] = $category = '0';
        }

        if(!empty($request->student_id) || $request->student_id != null){
            $data['selected_student_id'] = $student_id = $request->student_id;
        }
        else{
            $data['selected_student_id'] = $student_id = null;
        }


        
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['categories'] = FeesCategory::where('status', '1')->orderBy('title', 'asc')->get();
        $data['print'] = PrintSetting::where('slug', 'fees-receipt')->first();


        // Filter Search
        if(!empty($request->faculty) && $request->faculty != '0'){
        $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();}

        if(!empty($request->program) && $request->program != '0'){
        $sessions = Session::where('status', 1);
        $sessions->with('programs')->whereHas('programs', function ($query) use ($program){
            $query->where('program_id', $program);
        });
        $data['sessions'] = $sessions->orderBy('id', 'desc')->get();}

        if(!empty($request->program) && $request->program != '0'){
        $semesters = Semester::where('status', 1);
        $semesters->with('programs')->whereHas('programs', function ($query) use ($program){
            $query->where('program_id', $program);
        });
        $data['semesters'] = $semesters->orderBy('id', 'asc')->get();}

        if(!empty($request->program) && $request->program != '0' && !empty($request->semester) && $request->semester != '0'){
        $sections = Section::where('status', 1);
        $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($program, $semester){
            $query->where('program_id', $program);
            $query->where('semester_id', $semester);
        });
        $data['sections'] = $sections->orderBy('title', 'asc')->get();}
        

        if(isset($request->faculty) || isset($request->program) || isset($request->session) || isset($request->semester) || isset($request->section) || isset($request->category) || isset($request->student_id)){
            // Filter Fees
            $fees = Fee::where('status', '!=', '0');

            if(!empty($request->faculty) || !empty($request->program) || !empty($request->session) || !empty($request->semester) || !empty($request->section)){
                $fees->whereHas('studentEnroll.program', function ($query) use ($faculty){
                    if($faculty != 0){
                    $query->where('faculty_id', $faculty);
                    }
                });

                $fees->whereHas('studentEnroll', function ($query) use ($program, $session, $semester, $section){
                    if($program != 0){
                    $query->where('program_id', $program);
                    }
                    if($session != 0){
                    $query->where('session_id', $session);
                    }
                    if($semester != 0){
                    $query->where('semester_id', $semester);
                    }
                    if($section != 0){
                    $query->where('section_id', $section);
                    }
                });
            }
            if($category != 0){
                $fees->where('category_id', $category);
            }
            if(!empty($request->student_id)){
                $fees->whereHas('studentEnroll.student', function ($query) use ($student_id){
                    if($student_id != 0){
                    $query->where('student_id', 'LIKE', '%'.$student_id.'%');
                    }
                });
            }
            
            $fees->whereHas('studentEnroll.student', function ($query){
                $query->orderBy('student_id', 'asc');
            });
            
            $data['rows'] = $fees->orderBy('updated_at', 'desc')->get();
        }


        return view($this->view.'.report', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printr($id)
    {
        //
        $data['title'] = trans_choice('module_fees_report', 1);
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = 'print-setting';

        // View
        $data['print'] = PrintSetting::where('slug', 'fees-receipt')->firstOrFail();
        $data['row'] = Fee::where('id', $id)->where('status', '1')->firstOrFail();


        return view($this->view.'.print', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function multiPrint(Request $request)
    {
        //
        $data['title'] = trans_choice('module_fees_report', 1);
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = 'print-setting';

        $fees = explode(",",$request->fees);

        // View
        $data['print'] = PrintSetting::where('slug', 'fees-receipt')->firstOrFail();
        $data['rows'] = Fee::whereIn('id', $fees)->orderBy('id', 'asc')->get();

        return view($this->view.'.multi-print', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function quickAssign(Request $request)
    {
        $data['title'] = trans_choice('module_fees_quick_assign', 1);
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        // Get fee categories from fee structures instead of directly from FeesCategory
        $data['categories'] = FeeStructureItem::with('category')
            ->whereHas('category', function($query) {
                $query->where('status', '1');
            })
            ->get()
            ->map(function($item) {
                return (object)[
                    'id' => $item->category->id,
                    'title' => $item->category->title,
                    'amount' => $item->amount, // Use the amount from fee structure
                    'original_amount' => $item->category->amount, // Original amount from category
                    'is_one_time' => $item->is_one_time
                ];
            })
            ->unique('id'); // Ensure we don't get duplicate categories

        // Active students
        $data['students'] = StudentEnroll::where('status', '1')
            ->with('student')
            ->whereHas('student', function ($query) {
                $query->where('status', '1');
            })
            ->orderBy('student_id', 'asc')
            ->get();

        // Recent invoices with detailed fee information
        $invoices = Invoice::with([
            'studentEnroll.student',
            'fees' => function($query) {
                $query->with(['category', 'payments']);
            }
        ])->orderBy('created_at', 'desc')->limit(10);

        if ($request->has('search')) {
            $search = $request->input('search');
            $invoices->where(function($query) use ($search) {
                $query->where('invoice_no', 'like', "%{$search}%")
                    ->orWhereHas('studentEnroll.student', function($q) use ($search) {
                        $q->where('student_id', 'like', "%{$search}%")
                            ->orWhere('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
            });
        }

        $data['invoices'] = $invoices->get()->map(function($invoice) {
            // Prepare detailed fee information including amounts
            $invoice->feeDetails = $invoice->fees->map(function($fee) {
                return [
                    'category_id' => $fee->category_id,
                    'amount' => $fee->amount,
                    'paid_amount' => $fee->payments->sum('amount'),
                    'due_amount' => $fee->amount - $fee->payments->sum('amount')
                ];
            });
            
            return $invoice;
        });

      $allCategories = \App\Models\FeesCategory::all();
    $data['allCategories'] = $allCategories;
    
        return view($this->view . '.quick-assign', $data);
    }

    public function quickAssignStore(Request $request)
{
    $request->validate([
        'students' => 'required|array|min:1',
        'categories' => 'required|array|min:1',
        'assign_date' => 'required|date',
        'due_date' => 'required|date|after_or_equal:assign_date',
    ]);

    $students = $request->input('students');
    $categories = $request->input('categories');
    $assignDate = $request->input('assign_date');
    $dueDate = $request->input('due_date');
    $invoiceId = $request->input('invoice_id');

    // Store student totals for SMS notification
    $studentTotals = [];

    DB::transaction(function () use ($students, $categories, $assignDate, $dueDate, $invoiceId, &$studentTotals) {
        foreach ($students as $studentId) {
            $studentTotal = 0;
            $feeIds = [];
            $feeDetails = [];

            // First delete old fees if editing an existing invoice
            if ($invoiceId) {
                Fee::where('student_enroll_id', $studentId)
                ->whereHas('invoice', function($q) use ($invoiceId) {
                    $q->where('id', $invoiceId);
                })
                ->delete();
            }

            // Handle invoice creation/update before creating fees
            if ($invoiceId) {
                // Update existing invoice
                $invoice = Invoice::findOrFail($invoiceId);
                // Clear the total as we'll recalculate it
                $studentTotal = 0;
            } else {
                // Create new invoice first
                $lastInvoice = Invoice::orderBy('id', 'desc')->first();
                $invoiceNo = $lastInvoice ? 'INV-' . str_pad((int)str_replace('INV-', '', $lastInvoice->invoice_no) + 1, 3, '0', STR_PAD_LEFT) 
                                        : 'INV-001';

                $invoice = Invoice::create([
                    'student_enroll_id' => $studentId,
                    'invoice_no' => $invoiceNo,
                    'total_fee' => 0, // Will be updated after fees are created
                    'amount_due' => 0, // Will be updated after fees are created
                    'amount_paid' => 0,
                    'payment_status' => 'pending',
                    'assign_date' => $assignDate,
                    'due_date' => $dueDate,
                    'fee_details' => [], // Will be updated after fees are created
                ]);
            }

            foreach ($categories as $categoryId) {
                $category = FeesCategory::findOrFail($categoryId);
                $feeAmount = $category->amount;

                $fee = Fee::create([
                    'student_enroll_id' => $studentId,
                    'invoice_id' => $invoice->id, // Now $invoice is properly defined
                    'category_id' => $categoryId,
                    'amount' => $feeAmount,
                    'assign_date' => $assignDate,
                    'due_date' => $dueDate,
                    'created_by' => auth()->id(),
                ]);

                $studentTotal += $feeAmount;
                $feeIds[] = $fee->id;
                
                // Build comprehensive fee details
                $feeDetails[] = [
                    'fee_id' => $fee->id,
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'description' => $category->description ?? '',
                    'amount' => $feeAmount,
                    'assign_date' => $assignDate,
                    'due_date' => $dueDate,
                    'created_at' => now()->toDateTimeString(),
                ];
            }

            // Store the total for this student for SMS notification
            $studentTotals[$studentId] = $studentTotal;

            // Prepare the complete fee details structure
            $completeFeeDetails = [
                'items' => $feeDetails,
                'total_amount' => $studentTotal,
                'generated_at' => now()->toDateTimeString(),
                'generated_by' => auth()->id(),
            ];

            // Update invoice with final amounts and details
            $invoice->update([
                'total_fee' => $studentTotal,
                'amount_due' => $studentTotal - $invoice->amount_paid,
                'fee_details' => $completeFeeDetails,
            ]);

            // Attach fees to invoice
            if (method_exists($invoice, 'fees')) {
                $invoice->fees()->saveMany(Fee::findMany($feeIds));
            }
        }
    });  

    // ✅ Send SMS Notifications
    $apiUrl = 'https://smsportal.dapintechnologies.com/sms/v3/sendsms';
    $apiKey = '0CHxwhLRQ78MEFablqnsAtkgBNDjrJWou569KYpUd3eySPXT4ZOzv1cIiVG2mf';
    $serviceId = 0;
    $from = 'Dapin';

    foreach ($students as $studentId) {
        $enroll = \App\Models\StudentEnroll::with('student')->find($studentId);
        if ($enroll && $enroll->student) {
            $student = $enroll->student;
            $name = $student->first_name . ' ' . $student->last_name;
            $studentIdCode = $student->student_id;
            $totalAmount = number_format($studentTotals[$studentId] ?? 0, 2);
            $formattedDueDate = \Carbon\Carbon::parse($dueDate)->format('d/m/Y');

            $message = "Dear {$name} ( {$studentIdCode}),\n\n";
            $message .= "Kindly settle your Outstanding fee balance of Ksh {$totalAmount} that is due on {$formattedDueDate}.\n\n";
            $message .= " For queries, contact Finance Department.\n\n";
            
            

            $payload = [
                'api_key' => $apiKey,
                'service_id' => $serviceId,
                'mobile' => $this->formatPhoneNumberForSms($student->phone),
                'response_type' => 'json',
                'shortcode' => $from,
                'message' => $message,
                'date_send' => now()->format('Y-m-d H:i:s'),
            ];

            try {
                $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
                    ->post($apiUrl, $payload);

                \Log::info('SMS API Response:', ['response' => $response->json()]);
            } catch (\Exception $e) {
                \Log::error('Exception sending SMS', ['error' => $e->getMessage()]);
            }
        }
    }

    // ✅ Fetch Invoices for View
    $invoices = \App\Models\Invoice::whereIn('student_enroll_id', $students)
        ->where('assign_date', $assignDate)
        ->where('due_date', $dueDate)
        ->with('studentEnroll.student')
        ->orderBy('assign_date', 'desc')
        ->get();

    \Toastr::success(__('msg_created_successfully'), __('msg_success'));

    return redirect()->back()->with([
        'success' => __('Fees assigned successfully.'),
        'invoices' => $invoices
    ]);
}

    public function getInvoiceDate(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'student_enroll_id' => 'required|exists:student_enrolls,id'
        ]);

        // Since your fees table doesn't have invoice_id, we'll query based on student_enroll_id
        // and other relevant fields that might connect to the invoice
        $fees = Fee::where('student_enroll_id', $request->student_enroll_id)
                    ->where('status', 0) // Assuming you want unpaid fees
                    ->with('category')
                    ->get();

        $formattedFees = $fees->map(function($fee) {
            return [
                'id' => $fee->id,
                'category_title' => $fee->category ? $fee->category->title : 'Uncategorized',
                'original_amount' => number_format($fee->fee_amount, 2),
                'original_amount_raw' => $fee->fee_amount,
                'paid_amount' => number_format($fee->paid_amount, 2),
                'paid_amount_raw' => $fee->paid_amount,
                'balance' => number_format($fee->fee_amount - $fee->paid_amount, 2)
            ];
        });

        return response()->json([
            'success' => true,
            'fees' => $formattedFees
        ]);
    }

    // In your FeeController

    public function getFees(Request $request)
    {
        $studentEnrollId = $request->input('student_enroll_id');
        $invoiceId = $request->input('invoice_id');
        
        // Get all available categories
        $categories = FeeStructureItem::with('category')
            ->whereHas('category', function($query) {
                $query->where('status', '1');
            })
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->category->id,
                    'title' => $item->category->title,
                    'amount' => $item->amount,
                    'is_one_time' => $item->is_one_time
                ];
            })
            ->unique('id')
            ->values();
        
        // Get current fees for this invoice
        $currentFees = Fee::with(['category'])
            ->where('student_enroll_id', $studentEnrollId)
            ->when($invoiceId, function($query) use ($invoiceId) {
                $query->whereHas('invoice', function($q) use ($invoiceId) {
                    $q->where('id', $invoiceId);
                });
            })
            ->get()
            ->map(function($fee) {
                $balance = $fee->amount - $fee->paid_amount;
                
                return [
                    'id' => $fee->id,
                    'category_id' => $fee->category_id,
                    'category_title' => $fee->category->title ?? 'Uncategorized',
                    'original_amount' => number_format($fee->amount, 2),
                    'original_amount_raw' => $fee->amount,
                    'paid_amount' => number_format($fee->paid_amount, 2),
                    'paid_amount_raw' => $fee->paid_amount,
                    'balance' => number_format($balance, 2),
                    'balance_raw' => $balance,
                    'assign_date' => $fee->assign_date,
                    'due_date' => $fee->due_date,
                    'is_selected' => true // Mark as selected since it's already assigned
                ];
            });
        
        return response()->json([
            'success' => true,
            'categories' => $categories,
            'current_fees' => $currentFees,
            'invoice' => $invoiceId ? Invoice::find($invoiceId) : null
        ]);
    }
    public function updateFees(Request $request)
    {
        $request->validate([
            'student_enroll_id' => 'required|exists:student_enrolls,id',
            'fee_ids' => 'required|array',
            'new_amounts' => 'required|array',
            'assign_dates' => 'sometimes|array',
            'due_dates' => 'sometimes|array'
        ]);
        
        DB::beginTransaction();
        
        try {
            foreach ($request->fee_ids as $index => $feeId) {
                $fee = Fee::findOrFail($feeId);
                
                // Validate that new amount isn't less than paid amount
                $newAmount = $request->new_amounts[$index];
                if ($newAmount < $fee->paid_amount) {
                    throw new \Exception("New amount cannot be less than paid amount (".number_format($fee->paid_amount, 2).") for ".($fee->category->title ?? 'Uncategorized'));
                }
                
                $fee->fee_amount = $newAmount;
                
                // Update dates if provided
                if (isset($request->assign_dates[$index])) {
                    $fee->assign_date = $request->assign_dates[$index];
                }
                if (isset($request->due_dates[$index])) {
                    $fee->due_date = $request->due_dates[$index];
                }
                
                $fee->save();
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Fees updated successfully'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function edit($id)
{
    $invoice = Invoice::with(['fees.category'])->findOrFail($id);
    $allCategories = FeesCategory::all();
    
    return view('your.view', compact('invoice', 'allCategories'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'assign_date' => 'required|date',
        'due_date' => 'required|date|after_or_equal:assign_date',
        'fee_categories' => 'required|json',
        'total_fee' => 'required|numeric|min:0',
    ]);

    DB::transaction(function () use ($request, $id) {
        $invoice = Invoice::findOrFail($id);
        $categories = json_decode($request->fee_categories, true);
        
        // Update basic invoice info
        $invoice->update([
            'assign_date' => $request->assign_date,
            'due_date' => $request->due_date,
            'total_fee' => $request->total_fee,
            'amount_due' => $request->total_fee - $invoice->amount_paid,
            'updated_at' => now(),
        ]);

        // Delete existing fees
        Fee::where('invoice_id', $invoice->id)->delete();
        
        // Prepare fee details
        $feeDetails = [];
        $categoriesTotal = 0;
        
        // Get all selected categories
        $selectedCategories = FeesCategory::whereIn('id', $categories)->get();
        
        // Create new fee records
        foreach ($selectedCategories as $category) {
            $fee = Fee::create([
                'student_enroll_id' => $invoice->student_enroll_id,
                'invoice_id' => $invoice->id,
                'category_id' => $category->id,
                'created_at' => now(),
            ]);
            
            $categoriesTotal += $category->amount;
            
            $feeDetails[] = [
                'fee_id' => $fee->id,
                'category_id' => $category->id,
                'category_name' => $category->title,
                'amount' => $category->amount,
                'assign_date' => $request->assign_date,
                'due_date' => $request->due_date,
            ];
        }
        
        // Update fee details in invoice
        $invoice->update([
            'fee_categories' => $categories,
            'fee_details' => [
                'items' => $feeDetails,
                'total_amount' => $categoriesTotal,
                'updated_at' => now()->toDateTimeString(),
            ],
        ]);
    });

    return redirect()->back()->with('success', 'Invoice updated successfully');
}




    public function showinvoice($id)
{
    try {
        // Validate ID
        if (!is_numeric($id) || $id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid invoice ID'
            ], 400);
        }

        // Load invoice with relationships
        $invoice = Invoice::with([
            'studentEnroll:id,student_id,program_id',
            'studentEnroll.student:id,student_id,first_name,last_name',
            'studentEnroll.program:id,name,shortcode',
            'payments:id,invoice_id,amount,payment_method,reference_number,payment_date,status,transaction_id'
        ])->findOrFail($id);

        // Calculate payment summary
        $totalAmount = $invoice->total_fee;
        $totalPaid = $invoice->amount_paid;
        $totalDue = $invoice->amount_due;

        // Get payment settings
        $bankDetails = BankMpesaDetails::first(['bank_name', 'account_name', 'account_number', 'branch']);
        $mpesaSettings = MpesaSetting::first(['paybill_number', 'consumer_key', 'consumer_secret']);

        // Prepare response data
        $response = [
            'success' => true,
            'invoice' => [
                'id' => $invoice->id,
                'invoice_no' => $invoice->invoice_no,
                'assign_date' => $invoice->assign_date,
                'due_date' => $invoice->due_date,
                'total_fee' => $invoice->total_fee,
                'amount_paid' => $invoice->amount_paid,
                'amount_due' => $invoice->amount_due,
                'payment_status' => $invoice->payment_status,
                'fee_details' => json_decode($invoice->fee_details, true),
                'fee_categories' => json_decode($invoice->fee_categories, true),
            ],
            'student' => [
                'id' => $invoice->studentEnroll->student->id,
                'student_id' => $invoice->studentEnroll->student->student_id,
                'full_name' => $invoice->studentEnroll->student->first_name . ' ' . $invoice->studentEnroll->student->last_name,
            ],
            'program' => [
                'id' => $invoice->studentEnroll->program->id,
                'name' => $invoice->studentEnroll->program->name,
                'shortcode' => $invoice->studentEnroll->program->shortcode,
            ],
            'payments' => $invoice->payments->map(function($payment) {
                return [
                    'id' => $payment->id,
                    'amount' => $payment->amount,
                    'payment_method' => $payment->payment_method,
                    'reference_number' => $payment->reference_number,
                    'payment_date' => $payment->payment_date,
                    'status' => $payment->status,
                    'transaction_id' => $payment->transaction_id,
                ];
            }),
            'paymentSummary' => [
                'total_amount' => $totalAmount,
                'total_paid' => $totalPaid,
                'total_due' => $totalDue,
                'payment_status' => $invoice->payment_status
            ],
            'bankDetails' => $bankDetails,
            'mpesaSettings' => $mpesaSettings
        ];

        return response()->json($response);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Invoice not found'
        ], 404);

    } catch (\Exception $e) {
        \Log::error('Invoice details error: ' . $e->getMessage(), [
            'exception' => $e,
            'invoice_id' => $id,
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'An error occurred while fetching invoice details',
            'error' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}

    public function getInvoiceData(Invoice $invoice)
    {
        try {
            $invoice->load(['feeCategories', 'studentEnroll.student']);
            
            $invoiceData = [
                'invoice_no' => $invoice->invoice_no,
                'student_name' => $invoice->studentEnroll->student->full_name ?? 'N/A',
                'student_id' => $invoice->studentEnroll->student->student_id ?? 'N/A',
                'assign_date' => $invoice->assign_date->format('d M Y'),
                'due_date' => $invoice->due_date->format('d M Y'),
                'status' => $invoice->payment_status,
                'total_fee' => number_format($invoice->total_fee, 2),
                'amount_paid' => number_format($invoice->amount_paid, 2),
                'amount_due' => number_format($invoice->amount_due, 2),
                'fee_categories' => $invoice->feeCategories->map(function($category) {
                    return [
                        'title' => $category->title,
                        'amount' => number_format($category->amount, 2)
                    ];
                })
            ];

            return response()->json([
                'success' => true,
                'invoice' => $invoiceData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }



    public function generatePDF($id)
    {
        // Load invoice with all necessary relationships
        $invoice = Invoice::with([
            'fees.category',  // Ensure this matches your relationship name
            'studentEnroll.student', 
            'studentEnroll.program',
            'feeCategories'  // Include if you're using this relationship
        ])->findOrFail($id);

        // For debugging - uncomment to check the data
        dd($invoice->fees->map(function($fee) {
            return [
                'id' => $fee->id,
                'category_id' => $fee->category_id,
                'category' => $fee->category,
                'amount' => $fee->fee_amount
            ];
        }));

        $bankDetails = BankMpesaDetails::first();
        
        $pdf = Pdf::loadView('admin.fees-student.pdf', [
            'invoice' => $invoice,
            'bankDetails' => $bankDetails
        ]);
        
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download("invoice-{$invoice->invoice_no}.pdf");
    }




    public function create(Invoice $invoice)
    {
        $invoice->load(['studentEnroll.student', 'feeCategories']);

        $previousPayments = FeePayment::where('invoice_id', $invoice->id)
            ->get()
            ->groupBy('fee_id')
            ->map(function ($group) {
                return $group->sum('amount_applied');
            });

        return view('admin.fees-student.payment', compact('invoice', 'previousPayments'));
    }


    public function store(Request $request)
    {
        // Validate invoice exists first
        $invoice = Invoice::findOrFail($request->invoice_id);

        $rules = [
            'invoice_id' => 'required|exists:invoices,id',
            'student_enroll_id' => 'required|exists:student_enrolls,id',
            'payment_method' => 'required|in:mpesa,bank,cash',
            'reference_number' => 'required_if:payment_method,mpesa,bank|nullable|string|max:50',
            'payment_type' => 'required|in:full,installment',
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:'.$invoice->amount_due,
                function ($attribute, $value, $fail) use ($invoice) {
                    if ($value > $invoice->amount_due) {
                        $fail('The payment amount cannot exceed the amount due.');
                    }
                }
            ],
            'fee_categories' => ['required_if:payment_type,installment', 'array'],
            'fee_categories.*' => ['required_if:payment_type,installment', 'exists:fee_categories,id'],
            'notes' => 'nullable|string',
        ];

        $validated = $request->validate($rules);

        // Create payment
        $payment = Payment::create([
            'invoice_id' => $validated['invoice_id'],
            'student_enroll_id' => $validated['student_enroll_id'],
            'payment_method' => $validated['payment_method'],
            'reference_number' => $validated['reference_number'] ?? null,
            'amount' => $validated['amount'],
            'is_installment' => $validated['payment_type'] === 'installment',
            'notes' => $validated['notes'],
        ]);

        // Attach fee categories if installment
        if ($validated['payment_type'] === 'installment') {
            $payment->feeCategories()->attach($validated['fee_categories']);
        }

        // Update invoice
        $invoice->amount_due -= $validated['amount'];
        $invoice->payment_status = $invoice->amount_due <= 0 ? 'paid' : 'partial';
        $invoice->save();

        return redirect()->back()
            ->with('success', 'Payment of '.number_format($validated['amount'], 2).' recorded successfully');
    }


    public function print($id)
    {
        $invoice = Invoice::with([
            'studentEnroll.student', 
            'studentEnroll.program', 
            'feeCategories',
            'payments'
        ])->findOrFail($id);

        $school = Setting::where('type', 'school')->pluck('value', 'key')->toArray();

        return response()->json([
            'success' => true,
            'data' => [
                'invoice' => $invoice,
                'student' => $invoice->studentEnroll->student ?? null,
                'program' => $invoice->studentEnroll->program->title ?? null,
                'fee_categories' => $invoice->feeCategories,
                'payments' => $invoice->payments,
                'school_name' => $school['school_name'] ?? null,
                'school_address' => $school['address'] ?? null,
                'school_phone' => $school['phone'] ?? null,
                'school_email' => $school['email'] ?? null,
                'school_contact' => $school['contact_email'] ?? $school['email'] ?? null,
            ]
        ]);
    }

        protected function distributeToCategories($invoiceId, $amount)
        {
            $invoice = Invoice::with('feeCategories')->findOrFail($invoiceId);
            $categories = $invoice->feeCategories;

            $distributions = collect();
            $totalRemaining = $categories->sum(function ($category) use ($invoice) {
                $paid = FeePayment::where('fee_id', $category->id)
                    ->whereHas('payment', fn($q) => $q->where('invoice_id', $invoice->id))
                    ->sum('amount_applied');
                return max(0, $category->amount - $paid);
            });

            foreach ($categories as $category) {
                $paid = FeePayment::where('fee_id', $category->id)
                    ->whereHas('payment', fn($q) => $q->where('invoice_id', $invoice->id))
                    ->sum('amount_applied');
                $remaining = max(0, $category->amount - $paid);

                $distributions->put($category->id, round(($remaining / $totalRemaining) * $amount, 2));
            }

            return $distributions;
        }

        public function payshow(Invoice $invoice)
        {
            $invoice->load(['studentEnroll.student', 'fees.category']);
            return view('admin.fees-student.payment', compact('invoice'));
        }

   public function storePayment(Request $request)
{
    $request->validate([
        'invoice_id' => 'required|exists:invoices,id',
        'student_enroll_id' => 'required|exists:student_enrolls,id',
        'amount' => 'required|numeric|min:0.01',
        'payment_method' => 'required|in:mpesa,bank,cash,bursary',
        'payment_type' => 'required|in:full,installment',
        'reference_number' => 'required_if:payment_method,m-pesa,bank|nullable|max:50',
        'notes' => 'nullable|string|max:255',
        'bursary_type' => 'required_if:payment_method,bursary|nullable|exists:bursary_types,code',
    ]);

    DB::beginTransaction();

    try {
        // Generate transaction IDs
        $receiptNo = 'RCPT-' . strtoupper(Str::random(8));
        $transactionId = 'TNS-' . strtoupper(Str::random(10));

        // Load invoice with relationships
        $invoice = Invoice::with(['fees.category', 'studentEnroll.student'])
                    ->findOrFail($request->invoice_id);

        // Calculate financial components
        $originalAmount = $invoice->total_fee;
        $discountAmount = $invoice->discount_amount ?? 0;
        $fineAmount = $invoice->fine_amount ?? 0;
        
        // Calculate current payment totals (excluding current payment)
        $totalCashPaid = Payment::where('invoice_id', $invoice->id)
                         ->where('is_bursary', 0)
                         ->sum('amount');
                         
        $totalBursaryPaid = Payment::where('invoice_id', $invoice->id)
                           ->where('is_bursary', 1)
                           ->sum('amount');

        // Calculate net amounts
        $payableAmount = $originalAmount + $fineAmount - $discountAmount;
        $remainingAmount = $payableAmount - $totalCashPaid - $totalBursaryPaid;

        // Validate payment amount
        if ($request->payment_method != 'bursary' && $request->amount > $remainingAmount) {
            throw new \Exception("Payment amount cannot exceed remaining balance of ".number_format($remainingAmount, 2));
        }

        // Handle bursary payment validation
        if ($request->payment_method == 'bursary') {
            $bursaryType = BursaryType::where('code', $request->bursary_type)->firstOrFail();
            if ($bursaryType->current_balance < $request->amount) {
                throw new \Exception("Insufficient bursary funds. Available: ".number_format($bursaryType->current_balance, 2));
            }
        }

        // Create payment record
        $paymentData = [
            'receipt_no' => $receiptNo,
            'transaction_id' => $transactionId,
            'invoice_id' => $request->invoice_id,
            'student_enroll_id' => $request->student_enroll_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'reference_number' => $request->reference_number,
            'notes' => $request->notes,
            'status' => 'completed',
            'is_installment' => $request->payment_type == 'installment',
            'installment_number' => $request->payment_type == 'installment' 
                                 ? $this->getNextInstallmentNumber($request->invoice_id) 
                                 : 0,
            'paid_at' => now(),
        ];

        // Add bursary specific fields
        if ($request->payment_method == 'bursary') {
            $paymentData['is_bursary'] = true;
            $paymentData['bursary_type'] = $request->bursary_type;
            $paymentData['bursary_notes'] = $request->notes;
            $paymentData['bursary_allocated_by'] = auth()->user()->name;
            $paymentData['bursary_allocated_at'] = now();
        }

        // Create the payment record
        $payment = Payment::create($paymentData);

        // Update invoice amounts and status
        $this->updateInvoiceAmounts($invoice);

        // Update bursary balance if applicable
        if ($request->payment_method == 'bursary') {
            $bursaryType->decrement('current_balance', $request->amount);
        }

        DB::commit();

        // Prepare receipt data
        $receiptData = $this->prepareReceiptData($payment, $invoice);

        return response()->json([
            'success' => true,
            'message' => 'Payment processed successfully',
            'receipt_data' => $receiptData,
            'redirect_url' => route('payment.receipt', $payment->id)
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Payment failed: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Update invoice amounts and status after payment
 */
protected function updateInvoiceAmounts(Invoice $invoice)
{
    // Recalculate all amounts to ensure accuracy
    $originalAmount = $invoice->total_fee;
    $discountAmount = $invoice->discount_amount ?? 0;
    $fineAmount = $invoice->fine_amount ?? 0;
    
    // Get current totals (this includes any new payments)
    $totalCashPaid = Payment::where('invoice_id', $invoice->id)
                     ->where('is_bursary', 0)
                     ->sum('amount');
                     
    $totalBursaryPaid = Payment::where('invoice_id', $invoice->id)
                       ->where('is_bursary', 1)
                       ->sum('amount');

    // Calculate net amounts
    $payableAmount = $originalAmount + $fineAmount - $discountAmount;
    $amountDue = max(0, $payableAmount - $totalCashPaid - $totalBursaryPaid);

    // Determine payment status
    $paymentStatus = 'pending';
    if ($amountDue <= 0) {
        $paymentStatus = 'paid';
    } elseif (($totalCashPaid + $totalBursaryPaid) > 0) {
        $paymentStatus = 'partial';
    }

    // Update invoice
    $invoice->update([
        'amount_due' => $amountDue,
        'payment_status' => $paymentStatus,
        'amount_paid' => $totalCashPaid,
        'bursary_allocated' => $totalBursaryPaid,
        'updated_at' => now()
    ]);
}

/**
 * Prepare comprehensive receipt data
 */
protected function prepareReceiptData(Payment $payment, Invoice $invoice = null)
{
    $invoice = $invoice ?? $payment->invoice;
    
    // Load relationships if not loaded
    if (!$payment->relationLoaded('studentEnroll')) {
        $payment->load('studentEnroll.student', 'studentEnroll.program', 'studentEnroll.session');
    }
    
    if ($invoice && !$invoice->relationLoaded('studentEnroll')) {
        $invoice->load('studentEnroll.student');
    }

    // Calculate amounts
    $originalAmount = $invoice->total_fee ?? 0;
    $discountAmount = $invoice->discount_amount ?? 0;
    $fineAmount = $invoice->fine_amount ?? 0;
    $payableAmount = $originalAmount + $fineAmount - $discountAmount;
    
    $totalCashPaid = Payment::where('invoice_id', $invoice->id)
                     ->where('is_bursary', 0)
                     ->sum('amount');
                     
    $totalBursaryPaid = Payment::where('invoice_id', $invoice->id)
                       ->where('is_bursary', 1)
                       ->sum('amount');

    $amountDue = max(0, $payableAmount - $totalCashPaid - $totalBursaryPaid);

    return [
        'receipt_no' => $payment->receipt_no,
        'transaction_id' => $payment->transaction_id,
        'invoice_no' => $invoice->invoice_no ?? 'N/A',
        'date' => $payment->paid_at?->format('Y-m-d H:i:s') ?? now()->format('Y-m-d H:i:s'),
        
        // Student information
        'student_name' => optional($payment->studentEnroll->student)->getFullNameAttribute() ?? 'N/A',
        'student_id' => optional($payment->studentEnroll->student)->student_id ?? 'N/A',
        
        // Amount breakdown
        'original_amount' => number_format($originalAmount, 2),
        'discount_amount' => number_format($discountAmount, 2),
        'fine_amount' => number_format($fineAmount, 2),
        'payable_amount' => number_format($payableAmount, 2),
        'amount_paid' => number_format($payment->amount, 2),
        'amount_due' => number_format($amountDue, 2),
        'excess_payment' => number_format($payment->excess_payment ?? 0, 2),
        
        // Payment details
        'payment_method' => ucfirst($payment->payment_method),
        'reference_number' => $payment->reference_number,
        'is_bursary' => $payment->is_bursary,
        'bursary_type' => $payment->bursary_type,
        
        // Status information
        'payment_status' => $invoice->payment_status ?? 'N/A',
        
        // Additional notes
        'discount_notes' => $invoice->adjustment_type == 'discount' ? $invoice->adjustment_notes : null,
        'fine_notes' => $invoice->adjustment_type == 'fine' ? $invoice->adjustment_notes : null,
        'bursary_notes' => $payment->bursary_notes,
        'payment_notes' => $payment->notes,
    ];
}

    private function getNextInstallmentNumber($invoiceId)
    {
        $lastInstallment = Payment::where('invoice_id', $invoiceId)
            ->where('is_installment', true)
            ->orderBy('installment_number', 'desc')
            ->first();

        return $lastInstallment ? $lastInstallment->installment_number + 1 : 1;
    }
    
    public function getFeeCategories(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
        'student_enroll_id' => 'required|exists:student_enrolls,id'
    ]);

    $fees = Fee::with(['category', 'feePayments'])
        ->where('invoice_id', $request->invoice_id)
        ->where('student_enroll_id', $request->student_enroll_id)
        ->get();

    $categories = $fees->map(function($fee) {
        $paidAmount = $fee->feePayments->sum('amount');
        $balance = $fee->amount - $paidAmount;

        return [
            'id' => $fee->category_id,
            'title' => $fee->category->title ?? 'Unknown Category',
            'amount' => $fee->amount,
            'paid_amount' => $paidAmount,
            'balance' => $balance
        ];
    });

    return response()->json([
        'success' => true,
        'categories' => $categories
    ]);
}

// Helper method to generate QR code

 public function printReceipt($paymentId)
{
    $payment = Payment::with(['studentEnroll.student.user', 'feePayments.fee.category'])
        ->findOrFail($paymentId);

    // Use paid_at if date is null, fallback to current time if both are null
    $paymentDate = $payment->date ?? $payment->paid_at ?? now();

    $receiptData = [
        'receipt_no' => $payment->receipt_no,
        'transaction_id' => $payment->transaction_id,
        'date' => $paymentDate->format('Y-m-d H:i:s'), // Safe formatting
        'student_name' => optional($payment->studentEnroll->student)->name ?? 'N/A',
        'student_id' => optional($payment->studentEnroll->student)->id ?? 'N/A',
        'amount_paid' => number_format($payment->amount, 2),
        'payment_method' => ucfirst($payment->payment_method),
        'reference_number' => $payment->reference_number,
        'qr_code' => $this->generateQrCode($payment),
        'items' => $payment->feePayments->map(function($item) {
            return [
                'category' => optional($item->fee)->category->name ?? 'N/A',
                'amount' => number_format($item->amount, 2)
            ];
        })->toArray(),
        'printReceipt' => true // Explicitly set this for the view
    ];

$html = view('admin.fees-student.receipt-pdf', ['receiptData' => $receiptData, 'printReceipt' => true])->render();


    // Generate a unique filename
    $filename = 'receipt_' . $payment->receipt_no . '_' . time() . '.pdf';

    // Ensure directory exists
    $directory = storage_path('app/public/receipts/');
    if (!file_exists($directory)) {
        mkdir($directory, 0755, true);
    }

    $pdfPath = $directory . $filename;
    
    Browsershot::html($html)
        ->format('A4')
        ->margins(10, 10, 10, 10)
        ->showBackground()
        ->save($pdfPath);

    // Return the PDF for download or printing
    return response()->file($pdfPath);
}


public function showPaymentModal($invoiceId)
{
    
    $invoice = Invoice::with(['fees', 'fees.category', 'fees.feePayments'])->find($invoiceId);
    if (!$invoice) {
        return redirect()->back()->with('error', 'Invoice not found.');
    }
    $feeCategoriesData = $invoice->fees->map(function($fee) {
        return [
            'id' => $fee->category->id ?? 0,
            'title' => $fee->category->title ?? 'Unknown',
            'amount' => $fee->amount,
            'balance' => $fee->amount - ($fee->feePayments->sum('amount') ?? 0)
        ];
    });
    $title = "Make a Payment for Invoice #$invoiceId";
   $route = 'quick.assign';
    return view('admin.fees-student.quick-assign', compact('invoice', 'feeCategoriesData', 'title', 'route'));
}



  

    /**
     * Show payment details with receipt printing option
     */
  public function show($paymentId)
{
    $payment = $this->loadPaymentWithRelations($paymentId);
    
    $printReceipt = session('print_receipt', false);
    $receiptData = session('receipt_data', $this->prepareReceiptData($payment));
    
    // Clear the print flag if we're showing the print view
    if(request()->has('print')) {
        session()->forget('print_receipt');
    }
    
    return view('admin.fees-student.show', [
        'payment' => $payment,
        'printReceipt' => $printReceipt,
        'receiptData' => $receiptData,
        'qrCode' => $this->generateQrCode($payment)
    ]);
}

    /**
     * Show receipt in printable format
     */
public function showReceipt($payment_id)
{
    // Eager load all relationships with error handling
    $payment = Payment::with([
        'invoice.studentEnroll.student',
        'invoice.studentEnroll.program',
        'invoice.studentEnroll.session',
        'invoice.fees.category',
        'feePayments.fee.category'
    ])->findOrFail($payment_id);

    // Verify all critical relationships exist
    if (!$payment->invoice || !$payment->invoice->studentEnroll) {
        abort(404, 'Required payment information not found');
    }

    return view('admin.fees-student.receipt-pdf', [
        'payment' => $payment,
        'auto_print' => true
    ]);
}

    /**
     * Download PDF receipt
     */
    public function downloadReceipt(Payment $payment)
    {
        $payment = $this->loadPaymentWithRelations($payment->id);
        $receiptData = $this->prepareReceiptData($payment);
        
        $html = view('admin.fees-student.receipt-pdf', [
            'payment' => $payment,
            'receiptData' => $receiptData,
            'qrCode' => $this->generateQrCode($payment),
            'forPrint' => true
        ])->render();

        $filename = 'receipt_'.$payment->receipt_no.'.pdf';

        $pdfPath = storage_path('app/public/receipts/'.$filename);
        
        Browsershot::html($html)
            ->format('A4')
            ->margins(10, 10, 10, 10)
            ->showBackground()
            ->save($pdfPath);

        return response()->download($pdfPath, $filename)->deleteFileAfterSend(true);
    }

    /**
     * Load payment with all necessary relationships
     */
    protected function loadPaymentWithRelations($paymentId)
    {
        return Payment::with([
            'studentEnroll.student',
            'feePayments.fee.category',
            'invoice.studentEnroll.student',
            'invoice.studentEnroll.program',
            'invoice.studentEnroll.session'
        ])->findOrFail($paymentId);
    }

    /**
     * Prepare standardized receipt data
     */
   
    /**
     * Generate QR code for payment verification
     */
protected function generateQrCode(Payment $payment)
{
    $qrData = [
        'receipt_no' => $payment->receipt_no,
        'transaction_id' => $payment->transaction_id,
        'date' => $payment->paid_at->format('Y-m-d H:i:s'), // Using paid_at instead
        'amount' => $payment->amount,
        'student_id' => optional(optional($payment->studentEnroll)->student)->id ?? 'N/A'
    ];

    return QrCode::size(150)->generate(json_encode($qrData));
}

private function formatPhoneNumberForSms($phone)
{
    // Remove all non-numeric characters
    $phone = preg_replace('/\D+/', '', $phone);

    // Convert local mobile number starting with 0 to country code 254
    if (strlen($phone) == 10 && substr($phone, 0, 1) == '0') {
        return '254' . substr($phone, 1);
    }

    // If already in international format (starting with 254), return as is
    if (substr($phone, 0, 3) == '254') {
        return $phone;
    }

    // Otherwise, just return the phone as is (may need adjustment)
    return $phone;
}




protected function calculateNextInstallmentNumber($invoiceId): int
{
    $lastInstallment = Payment::where('invoice_id', $invoiceId)
        ->where('is_installment', true)
        ->max('installment_number');
    return $lastInstallment ? $lastInstallment + 1 : 1;
}

protected function distributeEvenlyAcrossFees(Payment $payment): void
{
    $invoiceFees = $payment->invoice->fees;
    if ($invoiceFees->isNotEmpty()) {
        $amountPerFee = $payment->amount / $invoiceFees->count();
        foreach ($invoiceFees as $fee) {
            FeePayment::create([
                'payment_id' => $payment->id,
                'fee_category_id' => $fee->id,
                'amount' => round($amountPerFee, 2),
            ]);
        }
    }
}

protected function updateInvoiceStatus(Invoice $invoice, float $amount, bool $isInstallment): void
{
    $invoice->amount_paid += $amount;
    $invoice->amount_due = max(0, $invoice->total_fee - $invoice->amount_paid);
    $invoice->payment_status = $invoice->amount_due <= 0.01 ? 'paid' : 'partial';

    if ($invoice->payment_status === 'paid' && $isInstallment) {
        Payment::where('invoice_id', $invoice->id)
            ->where('is_installment', true)
            ->where('status', 'partial')
            ->update(['status' => 'completed']);
    }

    $invoice->save();
}

public function details($id)
{
    $invoice = Invoice::with(['studentEnroll.student', 'feeCategories'])->findOrFail($id);

    return response()->json([
        'invoice_no' => $invoice->invoice_no,
        'student_name' => optional($invoice->studentEnroll)->student->full_name ?? 'N/A',
        'student_id' => optional($invoice->studentEnroll)->student->student_id ?? 'N/A',
        'assign_date_formatted' => \Carbon\Carbon::parse($invoice->assign_date)->format('d M Y'),
        'due_date_formatted' => \Carbon\Carbon::parse($invoice->due_date)->format('d M Y'),
        'status' => $invoice->status,
        'total_fee' => $invoice->total_fee,
        'total_fee_formatted' => number_format($invoice->total_fee, 2),
        'amount_paid' => $invoice->amount_paid,
        'amount_paid_formatted' => number_format($invoice->amount_paid, 2),
        'amount_due' => $invoice->amount_due,
        'amount_due_formatted' => number_format($invoice->amount_due, 2),
        'fee_categories' => $invoice->feeCategories->map(function($category) {
            return [
                'title' => $category->title,
                'amount' => $category->amount,
                'amount_formatted' => number_format($category->amount, 2)
            ];
        })->toArray()
    ]);
}

public function clearPrintFlag(Payment $payment)
{
    session()->forget('print_receipt');
    return response()->json(['success' => true]);
}


public function showInvoce($id)
{
    $invoice = Invoice::with('payments')->findOrFail($id);

    $totalPaid = $invoice->payments->sum('amount');
    $totalDue = $invoice->total_amount - $totalPaid; // assuming 'total_amount' is the invoice's full charge

    return view('admin.fees-student.invoice-show', compact('invoice', 'totalPaid', 'totalDue'));
}





// public function showReceipt(Payment $payment)
// {
//     $payment->load([
//         'invoice.fees.category',
//         'studentEnroll.student',
//         'studentEnroll.program',
//         'studentEnroll.semester',
//         'studentEnroll.section',
//         'studentEnroll.session',
//         'feePayments.category'
//     ]);

//     return view('admin.fees-student.receipt', compact('payment'));
// }

public function downloadReceipt1(Payment $payment)
{
    $payment->load([
        'invoice.fees.category',
        'studentEnroll.student',
        'studentEnroll.program',
        'studentEnroll.semester',
        'studentEnroll.section',
        'studentEnroll.session',
        'feePayments.category'
    ]);

    // Render HTML with inline QR
    $html = View::make('admin.fees-student.receipt-pdf', compact('payment'))->render();

    $filename = 'receipt_' . $payment->transaction_id . '.pdf';

    return response(
        Browsershot::html($html)
            ->setOption('no-sandbox', true)
            ->format('A4')
            ->margins(10, 10, 10, 10)
            ->pdf()
    )->withHeaders([
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . $filename . '"',
    ]);
}




public function invoice()
{
    $invoices = \App\Models\Invoice::with(['studentEnroll.student'])->get();

    $invoiceData = [];

    foreach ($invoices as $invoice) {
        $student = $invoice->studentEnroll->student;

        $totalFeeAmount = $invoice->total_fee;
        $totalPaid = $invoice->amount_paid;
        $totalDue = $invoice->amount_due;
        $paymentStatus = $invoice->payment_status;

        $invoiceData[] = [
            'invoice' => $invoice,        // Make sure this key exists
            'student' => $student,
            'total_fee_amount' => $totalFeeAmount,
            'total_paid' => $totalPaid,
            'total_due' => $totalDue,
            'payment_status' => $paymentStatus,
        ];
    }

    return view('admin.fees-student.invoice', ['invoices' => $invoiceData]);
}

 public function download(Request $request)
    {
        $request->validate([
            'type' => 'required|in:pdf,image',
            'html' => 'required'
        ]);

        $html = base64_decode($request->html);
        $type = $request->type;
        $filename = 'receipt_' . time() . '.' . $type;

        try {
            if ($type === 'pdf') {
                $content = Browsershot::html($html)
                    ->format('A4')
                    ->margins(10, 10, 10, 10)
                    ->pdf();
                
                return response()->streamDownload(
                    function () use ($content) {
                        echo $content;
                    },
                    $filename,
                    ['Content-Type' => 'application/pdf']
                );
            } else { // image
                $content = Browsershot::html($html)
                    ->windowSize(800, 1200)
                    ->screenshot();
                
                return response()->streamDownload(
                    function () use ($content) {
                        echo $content;
                    },
                    $filename,
                    ['Content-Type' => 'image/png']
                );
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate download: ' . $e->getMessage());
        }
    }







    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function quickReceived()
{
    $data['title'] = trans_choice('module_fees_quick_received', 1);
    $data['route'] = $this->route;
    $data['view'] = $this->view;
    $data['path'] = $this->path;
    $data['access'] = $this->access;

    // Get active fee categories
    $data['categories'] = FeesCategory::where('status', '1')->orderBy('title', 'asc')->get();

    // Filter active students with their outstanding balances
    $students = StudentEnroll::where('status', '1')
        ->with(['student', 'fees' => function($query) {
            $query->select('student_enroll_id', DB::raw('SUM(fee_amount - discount_amount + fine_amount - paid_amount) as outstanding_balance'))
                  ->groupBy('student_enroll_id');
        }])
        ->whereHas('student', function ($query) {
            $query->where('status', '1')->orderBy('student_id', 'asc');
        })
        ->orderBy('student_id', 'asc')
        ->get();

    $data['students'] = $students;

    // Get unpaid invoices for students
    $data['invoices'] = Fee::where('status', '0')
        ->whereHas('studentEnroll', function($query) {
            $query->where('status', '1');
        })
        ->get()
        ->map(function($invoice) {
            $invoice->balance = $invoice->fee_amount - $invoice->discount_amount - $invoice->paid_amount;
            return $invoice;
        });

    // Get available banks
    $data['banks'] = BankAccount::where('status', '1')->get();

    // Get active bursaries with remaining amounts
    $data['bursaries'] = Bursary::with('fund')
        ->where('status', '1')
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->get()
        ->map(function($bursary) {
            $bursary->remaining_amount = $bursary->initial_amount - $bursary->allocated_amount;
            return $bursary;
        });

    

    // Get authorized staff who can approve waivers
    $data['authorizers'] = [
        'Jane Mwangi (Bursar)',
        'Peter Otieno (Dean)',
        'Grace Kamau (Registrar)',
    ];

    return view($this->view.'.quick-received', $data);
}

public function quickReceivedStore(Request $request)
{
    // Field Validation with additional rules
    $request->validate([
        'student' => 'required|exists:student_enrolls,id',
        'category' => 'required|exists:fees_categories,id',
        'fee_amount' => 'required|numeric|min:0',
        'discount_amount' => 'required|numeric|min:0|lte:fee_amount',
        'fine_amount' => 'required|numeric|min:0',
        'paid_amount' => 'required|numeric|min:0',
        'payment_method' => 'required|in:2,4,5,6,7,8', // cash,bank,e-wallet,bursary,m-pesa,donation
        'due_date' => 'required|date',
        'pay_date' => 'required|date|before_or_equal:today',
        'bank_id' => 'required_if:payment_method,4|exists:bank_accounts,id',
        'reference' => 'nullable|string|max:100',
        'bursary_id' => 'required_if:payment_method,6|exists:bursaries,id',
        'donor_id' => 'required_if:payment_method,8|exists:donors,id',
        'waiver_reason' => 'required_if:discount_amount,gt:0',
        'authorized_by' => 'required_if:discount_amount,gt:0',
        'send_sms' => 'nullable|boolean',
        'send_email' => 'nullable|boolean',
    ]);

    try {
        DB::beginTransaction();

        // Get student enroll
        $enroll = StudentEnroll::findOrFail($request->student);
        $student = $enroll->student;

        // Create the fee record
        $fee = new Fee;
        $fee->student_enroll_id = $request->student;
        $fee->category_id = $request->category;
        $fee->fee_amount = $request->fee_amount;
        $fee->discount_amount = $request->discount_amount;
        $fee->fine_amount = $request->fine_amount;
        $fee->paid_amount = $request->paid_amount;
        $fee->assign_date = Carbon::today();
        $fee->due_date = $request->due_date;
        $fee->pay_date = $request->pay_date;
        $fee->payment_method = $request->payment_method;
        $fee->note = $request->note;
        $fee->status = '1'; // Paid
        $fee->updated_by = Auth::guard('web')->user()->id;

        // Additional payment method details
        if ($request->payment_method == 4) { // Bank
            $fee->bank_id = $request->bank_id;
            $fee->reference = $request->reference;
        } elseif (in_array($request->payment_method, [5, 7])) { // E-Wallet or M-Pesa
            $fee->reference = $request->reference;
        } elseif ($request->payment_method == 6) { // Bursary
            $fee->bursary_id = $request->bursary_id;
            
            // Update bursary allocated amount
            $bursary = Bursary::find($request->bursary_id);
            $bursary->allocated_amount += $request->paid_amount;
            $bursary->save();
        } elseif ($request->payment_method == 8) { // Donation
            $fee->donor_id = $request->donor_id;
        }

        $fee->save();

        // If waiver was applied, record it
        if ($request->discount_amount > 0) {
            $waiver = new FeeWaiver;
            $waiver->fee_id = $fee->id;
            $waiver->amount = $request->discount_amount;
            $waiver->reason = $request->waiver_reason;
            $waiver->notes = $request->waiver_notes ?? null;
            $waiver->authorized_by = $request->authorized_by;
            $waiver->save();
        }

        // Create transaction record
        $transaction = new Transaction;
        $transaction->transaction_id = 'TXN' . strtoupper(Str::random(15));
        $transaction->amount = $request->paid_amount;
        $transaction->type = '1'; // Income
        $transaction->payment_method = $request->payment_method;
        $transaction->reference = $request->reference;
        $transaction->created_by = Auth::guard('web')->user()->id;
        $student->transactions()->save($transaction);

        // Generate and store receipt
        $receipt = new Receipt;
        $receipt->receipt_no = 'RCPT' . strtoupper(Str::random(15));
        $receipt->fee_id = $fee->id;
        $receipt->student_id = $student->id;
        $receipt->amount = $request->paid_amount;
        $receipt->generated_by = Auth::guard('web')->user()->id;
        $receipt->save();

        // Send SMS notification if enabled
        if ($request->send_sms && config('sms.notifications.fee_payment')) {
            $message = "Hi {$student->first_name} (ID: {$student->student_id}), payment of {$request->paid_amount} received. Receipt #{$receipt->receipt_no}. Balance: " . ($student->outstanding_balance - $request->paid_amount);
            
            // Call SMS service
            sendSMS($student->mobile, $message);
        }

        // Send email notification if enabled
        if ($request->send_email) {
            $data = [
                'student' => $student,
                'fee' => $fee,
                'receipt' => $receipt,
            ];
            
            Mail::to($student->email)->send(new FeePaymentReceipt($data));
        }

        DB::commit();

        // Return with receipt ID for printing
        Toastr::success(__('msg_created_successfully'), __('msg_success'));
        return redirect()->back()->with('receipt_id', $receipt->id);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Fee Payment Error: ' . $e->getMessage());
        
        Toastr::error(__('msg_created_error'), __('msg_error'));
        return redirect()->back()->withInput();
    }
}

public function getStudentInvoices(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:student_enrolls,id'
    ]);

    $invoices = Fee::where('student_enroll_id', $request->student_id)
        ->where('status', '0') // Unpaid invoices
        ->select([
            'id',
            'invoice_number',
            'fee_amount',
            'discount_amount',
            'paid_amount',
            'due_date',
            'status',
            'created_at'
        ])
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function($invoice) {
            $totalAmount = $invoice->fee_amount - $invoice->discount_amount;
            $dueAmount = $totalAmount - $invoice->paid_amount;
            
            return [
                'id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'total_amount' => $totalAmount,
                'paid_amount' => $invoice->paid_amount,
                'due_amount' => $dueAmount,
                'due_date' => $invoice->due_date->format('Y-m-d'),
                'status' => $invoice->status,
                'created_at' => $invoice->created_at->format('Y-m-d H:i:s')
            ];
        });

    return response()->json([
        'success' => true,
        'invoices' => $invoices
    ]);
}

public function batchBursaryAllocate(Request $request)
{
    $request->validate([
        'bursary_id' => 'required|exists:bursaries,id',
        'amount' => 'required|numeric|min:1',
        'students' => 'required|array|min:1',
        'students.*' => 'exists:student_enrolls,id',
        'notes' => 'nullable|string'
    ]);

    try {
        DB::beginTransaction();

        $bursary = Bursary::findOrFail($request->bursary_id);
        $totalAmount = $request->amount * count($request->students);

        // Check if bursary has sufficient balance
        if ($bursary->remaining_amount < $totalAmount) {
            return response()->json([
                'success' => false,
                'message' => 'Bursary fund has insufficient balance for this allocation'
            ], 422);
        }

        $allocations = [];
        foreach ($request->students as $studentId) {
            // Create fee record for each student
            $fee = new Fee;
            $fee->student_enroll_id = $studentId;
            $fee->category_id = 1; // Default bursary category
            $fee->fee_amount = $request->amount;
            $fee->discount_amount = 0;
            $fee->fine_amount = 0;
            $fee->paid_amount = $request->amount;
            $fee->assign_date = Carbon::today();
            $fee->due_date = Carbon::today();
            $fee->pay_date = Carbon::today();
            $fee->payment_method = 6; // Bursary
            $fee->bursary_id = $bursary->id;
            $fee->status = '1'; // Paid
            $fee->updated_by = Auth::guard('web')->user()->id;
            $fee->save();

            // Create transaction record
            $enroll = StudentEnroll::find($studentId);
            $transaction = new Transaction;
            $transaction->transaction_id = 'TXN' . strtoupper(Str::random(15));
            $transaction->amount = $request->amount;
            $transaction->type = '1'; // Income
            $transaction->payment_method = 6; // Bursary
            $transaction->created_by = Auth::guard('web')->user()->id;
            $enroll->student->transactions()->save($transaction);

            $allocations[] = $fee->id;
        }

        // Update bursary allocated amount
        $bursary->allocated_amount += $totalAmount;
        $bursary->save();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Bursary allocated successfully to ' . count($request->students) . ' students',
            'total_amount' => $totalAmount
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Batch Bursary Allocation Error: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to allocate bursary'
        ], 500);
    }
}

public function getReconciliationData(Request $request)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date'
    ]);

    $transactions = Transaction::with(['student', 'fee'])
        ->where('type', '1') // Income
        ->whereBetween('created_at', [
            Carbon::parse($request->start_date)->startOfDay(),
            Carbon::parse($request->end_date)->endOfDay()
        ])
        ->where('status', '0') // Unreconciled
        ->orderBy('created_at', 'desc')
        ->get();

    $totalAmount = $transactions->sum('amount');

    return response()->json([
        'success' => true,
        'transactions' => $transactions,
        'total_amount' => $totalAmount
    ]);
}

public function reconcilePayments(Request $request)
{
    $request->validate([
        'transaction_ids' => 'required|array|min:1',
        'transaction_ids.*' => 'exists:transactions,id'
    ]);

    try {
        DB::beginTransaction();

        $count = Transaction::whereIn('id', $request->transaction_ids)
            ->update([
                'status' => '1', // Reconciled
                'reconciled_at' => Carbon::now(),
                'reconciled_by' => Auth::guard('web')->user()->id
            ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => $count . ' transactions reconciled successfully'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Reconciliation Error: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to reconcile transactions'
        ], 500);
    }
}
}
