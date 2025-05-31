<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;
use App\Models\PrintSetting;
use App\Models\FeesCategory;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\Semester;
use App\Models\Faculty;
use App\Models\Session;
use App\Models\Program;
use App\Models\Section;
use App\Models\Fee;
use Carbon\Carbon;
use Toastr;
use Auth;
use DB;

class FeesStudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


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
    public function print($id)
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
 public function quickAssign()
    {
        //
        $data['title'] = trans_choice('module_fees_quick_assign', 1);
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

    foreach ($students as $studentId) {
        $studentTotal = 0;

        foreach ($categories as $categoryId) {
            $category = \App\Models\FeesCategory::find($categoryId);
            if (!$category) continue;

            $feeAmount = $category->amount;

            // Check if a fee entry already exists for this student and category
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

            $assignedFeeIds[] = $fee->id;
            $studentTotal += $feeAmount;
        }

        $studentTotals[$studentId] = $studentTotal;

        // Generate incremental invoice number
        $lastInvoice = \App\Models\Invoice::orderBy('id', 'desc')->first();
        $newNumber = 1;

        // Check for the last invoice number and increment
        if ($lastInvoice) {
            $lastInvoiceNo = $lastInvoice->invoice_no;
            if (preg_match('/INV-(\d+)/', $lastInvoiceNo, $matches)) {
                $lastNumber = intval($matches[1]);
                $newNumber = $lastNumber + 1;
            }
        }

        $invoiceNo = 'INV-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Check if an invoice already exists for the student to avoid duplicates
        \App\Models\Invoice::updateOrCreate(
            ['student_enroll_id' => $studentId, 'assign_date' => $assignDate, 'due_date' => $dueDate],
            [
                'invoice_no' => $invoiceNo,
                'total_fee' => $studentTotal,
                'amount_due' => $studentTotal, // Assuming nothing paid yet
                'amount_paid' => 0,
                'payment_status' => 'Pending',
            ]
        );
    }

    // Send SMS notifications
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

    \Toastr::success(__('msg_created_successfully'), __('msg_success'));

    return redirect()->route('fees.invoice', ['feeIds' => implode(',', $assignedFeeIds)]);
}






// Helper method to convert phone number to international format (e.g., 0725547867 => 254725547867)
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
