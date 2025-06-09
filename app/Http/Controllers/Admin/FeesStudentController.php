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
use Carbon\Carbon;
use Auth;
use Toastr;
use App\Models\StudentEnroll;
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
        //
        $data['title'] = $this->title;
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
            $fees = Fee::where('status', '0');

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
            
            $data['rows'] = $fees->orderBy('id', 'desc')->get();
        }


        return view($this->view.'.index', $data);
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

    // Fetching active fee categories
    $data['categories'] = FeesCategory::where('status', '1')->orderBy('title', 'asc')->get();
    $data['feeCategories'] = $data['categories']; // Add this line to make feeCategories available

    // Fetching students
    $students = StudentEnroll::where('status', '1');
    $students->with('student')->whereHas('student', function ($query){
        $query->where('status', '1')->orderBy('student_id', 'asc');
    });
    $data['students'] = $students->orderBy('student_id', 'asc')->get();

    // Fetching invoices
    $invoices = Invoice::whereIn('payment_status', ['partial', 'pending'])
                        ->with(['studentEnroll.student'])
                        ->orderBy('due_date', 'asc');

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

    $data['invoices'] = $invoices->take(10)->get();
    $data['search'] = $request->input('search', '');

    return view($this->view.'.quick-assign', $data);
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

    $assignedFeeIds = [];
    $studentTotals = [];

    DB::transaction(function () use ($students, $categories, $assignDate, $dueDate, &$studentTotals) {
        foreach ($students as $studentId) {
            $studentTotal = 0;

            foreach ($categories as $categoryId) {
                $category = \App\Models\FeesCategory::find($categoryId);
                if (!$category) continue;

                $feeAmount = $category->amount;

                // Create or update fee
                $fee = \App\Models\Fee::updateOrCreate(
                    [
                        'student_enroll_id' => $studentId,
                        'category_id' => $categoryId,
                    ],
                    [
                        'fee_amount' => $feeAmount,
                        'assign_date' => $assignDate,
                        'due_date' => $dueDate,
                        'amount_type' => 1,
                        'created_by' => auth()->id(),
                        'updated_at' => now(),
                    ]
                );

                $studentTotal += $feeAmount;
            }

            $studentTotals[$studentId] = $studentTotal;

            // Safe Invoice Generation with table lock
            $invoiceNo = DB::table('invoices')->lockForUpdate()->max('invoice_no');
            $lastNumber = 0;

            if ($invoiceNo && preg_match('/INV-(\d+)/', $invoiceNo, $matches)) {
                $lastNumber = intval($matches[1]);
            }

            $newInvoiceNo = 'INV-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

            // Create or update the invoice
            \App\Models\Invoice::updateOrCreate(
                ['student_enroll_id' => $studentId, 'assign_date' => $assignDate, 'due_date' => $dueDate],
                [
                    'invoice_no' => $newInvoiceNo,
                    'total_fee' => $studentTotal,
                    'amount_due' => $studentTotal,
                    'amount_paid' => 0,
                    'payment_status' => 'Pending',
                ]
            );
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

            $message = "Hi {$name}-{$studentIdCode}, kindly settle your outstanding fee balance of Ksh {$totalAmount}.";

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

                \Log::info('Test SMS API Response:', ['response' => $response->json()]);
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





public function show($id)
{
$invoice = Invoice::with(['feeCategories', 'studentEnroll.student', 'studentEnroll.program'])->findOrFail($id);

    // Debugging: Uncomment to verify relationships
    // dd($invoice->fees->first()->category);
    
    $bankDetails = BankMpesaDetails::first();
    $mpesaSettings = MpesaSetting::first();

    return view('admin.fees-student.invoice-details', compact('invoice', 'bankDetails', 'mpesaSettings'));
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
        'payment_method' => 'required|in:mpesa,bank,cash',
        'payment_type' => 'required|in:full,installment',
        'reference_number' => 'required_if:payment_method,mpesa,bank|nullable|max:50',
        'notes' => 'nullable|string|max:255',
        'fee_categories' => 'required_if:payment_type,installment|array',
        'fee_categories.*' => 'exists:fee_categories,id',
    ]);

    DB::beginTransaction();

    try {
        // Generate receipt number and transaction ID
        $receiptNo = 'RCPT-' . strtoupper(Str::random(8));
        $transactionId = 'TNS-' . strtoupper(Str::random(10));

        // Get the invoice
        $invoice = Invoice::findOrFail($request->invoice_id);
        $totalAmount = $invoice->total_amount;
        $paidAmount = $invoice->paid_amount;
        $remainingAmount = $totalAmount - $paidAmount;

        // Validate installment payment doesn't exceed remaining amount
        if ($request->payment_type == 'installment' && $request->amount > $remainingAmount) {
            throw new \Exception("Installment amount cannot exceed remaining balance of " . number_format($remainingAmount, 2));
        }

        // Create payment record
        $payment = Payment::create([
            'receipt_no' => $receiptNo,
            'transaction_id' => $transactionId,
            'invoice_id' => $request->invoice_id,
            'student_enroll_id' => $request->student_enroll_id,
            'date' => now(),
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'reference_number' => $request->reference_number,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
            'status' => $request->payment_type == 'installment' ? 'partial' : 'completed',
            'is_installment' => $request->payment_type == 'installment' ? 1 : 0,
            'installment_number' => $request->payment_type == 'installment' ? $this->getNextInstallmentNumber($request->invoice_id) : 0,
        ]);

        $amountToAllocate = $request->amount;

        if ($request->payment_type === 'full') {
            // Pay all outstanding fees
            foreach ($invoice->fees as $fee) {
                $balance = $fee->amount - $fee->paid_amount;
                if ($balance > 0) {
                    $paymentAmount = min($balance, $amountToAllocate);
                    
                    FeePayment::create([
                        'fee_id' => $fee->id,
                        'payment_id' => $payment->id,
                        'amount' => $paymentAmount,
                        'date' => now(),
                    ]);
                    
                    $amountToAllocate -= $paymentAmount;
                    if ($amountToAllocate <= 0) break;
                }
            }
        } else {
            // Pay selected categories in installment
            foreach ($request->fee_categories as $categoryId) {
                $fee = $invoice->fees()->where('category_id', $categoryId)->first();
                if ($fee) {
                    $balance = $fee->amount - $fee->paid_amount;
                    if ($balance > 0) {
                        $paymentAmount = min($balance, $amountToAllocate);
                        
                        FeePayment::create([
                            'fee_id' => $fee->id,
                            'payment_id' => $payment->id,
                            'amount' => $paymentAmount,
                            'date' => now(),
                        ]);
                        
                        $amountToAllocate -= $paymentAmount;
                        if ($amountToAllocate <= 0) break;
                    }
                }
            }
        }

        // Update invoice status
        $invoice->updateStatus();

        DB::commit();

        // Generate receipt data
      // Update the receipt data generation to be more defensive
$receiptData = [
    'receipt_no' => $receiptNo,
    'transaction_id' => $transactionId,
    'date' => now()->format('Y-m-d H:i:s'),
    'student_name' => optional(optional(optional($payment->studentEnroll)->student)->user)->name ?? 'N/A',
    'student_id' => optional(optional($payment->studentEnroll)->student)->id ?? 'N/A',
    'amount_paid' => number_format($payment->amount, 2),
    'payment_method' => ucfirst($payment->payment_method),
    'reference_number' => $payment->reference_number,
    'remaining_balance' => number_format($invoice->fresh()->total_amount - $invoice->fresh()->paid_amount, 2),
    'installment_number' => $payment->installment_number,
    'is_installment' => $payment->is_installment,
    'items' => $payment->feePayments->map(function($item) {
        return [
            'category' => optional($item->fee)->category->name ?? 'N/A',
            'amount' => number_format($item->amount, 2)
        ];
    })->toArray()
];

        \Toastr::success(__('Payment has been processed successfully.'));

        return redirect()->back()->with([
            'receipt_data' => $receiptData,
            'print_receipt' => true
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        \Toastr::error(__('Payment failed: ') . $e->getMessage());
        return redirect()->back()->withInput();
    }
}

private function getNextInstallmentNumber($invoiceId)
{
    $lastInstallment = Payment::where('invoice_id', $invoiceId)
                            ->where('is_installment', 1)
                            ->orderBy('installment_number', 'desc')
                            ->first();

    return $lastInstallment ? $lastInstallment->installment_number + 1 : 1;
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


public function showReceipt(Payment $payment)
{
    // Load all necessary relationships
    $payment->load([
        'invoice' => function($query) {
            $query->with(['studentEnroll' => function($q) {
                $q->with(['student', 'program', 'session']);
            }]);
        }
    ]);

    // If you have fee items associated with payments, load them too
    if (method_exists($payment, 'feeItems')) {
        $payment->load('feeItems');
    }

    return view('admin.fees-student.receipt-pdf', compact('payment'));
}

public function showInvoice($id)
{
    $invoice = Invoice::with('payments')->findOrFail($id);

    $totalPaid = $invoice->payments->sum('amount');
    $totalDue = $invoice->total_amount - $totalPaid; // assuming 'total_amount' is the invoice's full charge

    return view('admin.fees-student.invoice-show', compact('invoice', 'totalPaid', 'totalDue'));
}


public function downloadReceipt(Payment $payment)
{
    $payment->load([
        'invoice',
        'studentEnroll.student',
        'studentEnroll.program',
        'feePayments.fee.category'
    ]);
    
    $pdf = PDF::loadView('admin.fees-student.receipt-pdf', compact('payment'));
    return $pdf->download("receipt-{$payment->id}.pdf");
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
        //
        $data['title'] = trans_choice('module_fees_quick_received', 1);
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;


        $data['categories'] = FeesCategory::where('status', '1')->orderBy('title', 'asc')->get();

        // Filter Student
        $students = StudentEnroll::where('status', '1');
        $students->with('student')->whereHas('student', function ($query){
            $query->where('status', '1');
            $query->orderBy('student_id', 'asc');
        });

        $data['students'] = $students->orderBy('student_id', 'asc')->get();

//SMS LOGIC HERE YOU HAVE BEEN INVOICED THESE CATEGORIES(Hi {Name-StudentID} kindly settle your outsatanding fee balance of{Total Amount} )
        return view($this->view.'.quick-received', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function quickReceivedStore(Request $request)
    {
        // Field Validation
        $request->validate([
            'student' => 'required',
            'category' => 'required',
            'fee_amount' => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'fine_amount' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'payment_method' => 'required',
            'due_date' => 'required|date',
            'pay_date' => 'required|date|before_or_equal:today',
        ]);


        try{
            DB::beginTransaction();
            // Insert Data
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
            $fee->status = '1';
            $fee->updated_by = Auth::guard('web')->user()->id;
            $fee->save();


            // Transaction
            $transaction = new Transaction;
            $transaction->transaction_id = Str::random(16);
            $transaction->amount = $request->paid_amount;
            $transaction->type = '1';
            $transaction->created_by = Auth::guard('web')->user()->id;
            $fee->studentEnroll->student->transactions()->save($transaction);
            DB::commit();


            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->back();
        }
        catch(\Exception $e){

            Toastr::error(__('msg_created_error'), __('msg_error'));

            return redirect()->back();
        }
    }





}
