<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    StudentEnroll, FeesCategory, FeesMaster, Semester, Program, Section,
    Session, Faculty, Fee, FeeStructure, FeeStructureItem, Invoice, InvoiceItem
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Toastr;
use Auth;

class FeesMasterController extends Controller
{
    // Controller configuration
    protected $title = 'Fee Assignment';
    protected $route = 'admin.fees-master';
    protected $view = 'admin.fees-master';
    protected $access = 'fees-master';
    
    public function __construct()
    {
        $this->middleware('permission:'.$this->access.'-view', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
    }

    /**
     * Display fee assignment history with filtering
     */
    public function index(Request $request)
    {
        $data = $this->getBaseData();
        $data['title'] = trans_choice('module_fees_master_history', 1);
        
        // Set filter parameters from request
        $this->setFilterParameters($data, $request);
        
        // Get filter options based on selections
        $this->loadDynamicFilters($data, $request);
        
        // Get filtered fee assignments
        $data['rows'] = $this->getFilteredFeeAssignments($request);
        
        // Add additional data for view
        $data['summary'] = $this->getAssignmentSummary($data['rows']);
        
        return view($this->view.'.index', $data);
    }

    /**
     * Show form for creating new fee assignments
     */
    public function create(Request $request)
    {
        $data = $this->getBaseData();
        $data['title'] = $this->title;
        
        // Set filter parameters from request
        $this->setFilterParameters($data, $request);
        
        // Get filter options based on selections
        $this->loadDynamicFilters($data, $request);
        
        // Load fee structure if program/semester selected
        if($request->program && $request->semester) {
            $data['feeStructure'] = $this->getFeeStructureDetails($request->program, $request->semester);
        }
        
        // Get students matching filters
        if(isset($request->faculty) || isset($request->program)) {
            $data['rows'] = $this->getFilteredStudents($request);
        }
        
        return view($this->view.'.create', $data);
    }

    /**
     * Store new fee assignments
     */
    public function store(Request $request)
    {
        // Validate with custom validation rules
        $validated = $this->validateAssignmentRequest($request);
        
        try {
            DB::beginTransaction();
            
            // Get or create fee structure
            $feeStructure = $this->getOrCreateFeeStructure($validated);
            
            // Create master fee assignment record
            $feesMaster = $this->createMasterAssignment($validated, $feeStructure);
            
            // Process assignments for each student
            $result = $this->processStudentAssignments(
                $validated['students'], 
                $feesMaster, 
                $feeStructure, 
                $validated
            );
            
            DB::commit();
            
            return $this->assignmentSuccessResponse($result['count'], $result['amount']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->assignmentErrorResponse($e);
        }
    }

    /**
     * Show details of a specific fee assignment
     */
    public function show($id)
    {
        $data = $this->getBaseData();
        $data['row'] = FeesMaster::with([
                'studentEnrolls.student', 
                'feeCategories',
                'feeStructure.items.category',
                'invoices.items'
            ])->findOrFail($id);
            
        return view($this->view.'.show', $data);
    }

    /**
     * Get fee structure details via AJAX
     */
    public function getFeeStructure(Request $request)
{
    $request->validate([
        'program_id' => 'required|exists:programs,id',
        'semester_id' => 'required|exists:semesters,id'
    ]);

    $feeStructure = FeeStructure::with(['program', 'items.category'])
        ->where('program_id', $request->program_id)
        ->where('semester', $request->semester_id)
        ->first();

    if (!$feeStructure) {
        return response()->json([
            'success' => false,
            'message' => 'No fee structure found for the selected program and semester'
        ]);
    }

    // Student count calculation (now including session/section filters)
    $studentCount = StudentEnroll::where('status', '1')
        ->where('program_id', $request->program_id)
        ->where('semester_id', $request->semester_id)
        ->when($request->faculty_id, function($query) use ($request) {
            $query->whereHas('program', function($q) use ($request) {
                $q->where('faculty_id', $request->faculty_id);
            });
        })
        ->when($request->session_id, function($query) use ($request) {
            $query->where('session_id', $request->session_id);
        })
        ->when($request->section_id, function($query) use ($request) {
            $query->where('section_id', $request->section_id);
        })
        ->count();

    return response()->json([
        'success' => true,
        'fee_structure' => $feeStructure,
        'categories' => $feeStructure->items->map(function($item) {
            return [
                'id' => $item->fees_category_id,
                'title' => $item->category->title,
                'amount' => $item->amount,
                'is_one_time' => $item->is_one_time
            ];
        }),
        'total_amount' => $feeStructure->total_amount,
        'student_count' => $studentCount,
        'estimated_total' => $studentCount * $feeStructure->total_amount
    ]);
}

    // ==================== PROTECTED METHODS ==================== //

    /**
     * Get base data shared across methods
     */
    protected function getBaseData()
    {
        return [
            'title' => $this->title,
            'route' => $this->route,
            'view' => $this->view,
            
            'access' => $this->access,
            'faculties' => Faculty::where('status', '1')->orderBy('title', 'asc')->get(),
            'categories' => FeesCategory::where('status', '1')->orderBy('title', 'asc')->get()
        ];
    }

    /**
     * Set filter parameters from request
     */
    protected function setFilterParameters(&$data, $request)
    {
        $data['selected_faculty'] = $request->faculty ?? '0';
        $data['selected_session'] = $request->session ?? '0';
        $data['selected_program'] = $request->program ?? '0';
        $data['selected_semester'] = $request->semester ?? '0';
        $data['selected_section'] = $request->section ?? '0';
        $data['selected_category'] = $request->category ?? '0';
    }

    /**
     * Load dynamic filter options based on selections
     */
    protected function loadDynamicFilters(&$data, $request)
    {
        // Programs based on faculty
        if($request->faculty && $request->faculty != '0') {
            $data['programs'] = Program::where('faculty_id', $request->faculty)
                ->where('status', '1')
                ->orderBy('title', 'asc')
                ->get();
        }

        // Sessions and semesters based on program
        if($request->program && $request->program != '0') {
            $data['sessions'] = Session::where('status', 1)
                ->with('programs')
                ->whereHas('programs', function($q) use ($request) {
                    $q->where('program_id', $request->program);
                })
                ->orderBy('id', 'desc')
                ->get();

            $data['semesters'] = Semester::where('status', 1)
                ->with('programs')
                ->whereHas('programs', function($q) use ($request) {
                    $q->where('program_id', $request->program);
                })
                ->orderBy('id', 'asc')
                ->get();
        }

        // Sections based on program and semester
        if($request->program && $request->program != '0' && 
           $request->semester && $request->semester != '0') {
            $data['sections'] = Section::where('status', 1)
                ->with('semesterPrograms')
                ->whereHas('semesterPrograms', function($q) use ($request) {
                    $q->where('program_id', $request->program)
                      ->where('semester_id', $request->semester);
                })
                ->orderBy('title', 'asc')
                ->get();
        }
    }

    /**
     * Get filtered fee assignments
     */
    protected function getFilteredFeeAssignments($request)
    {
        return FeesMaster::with(['studentEnrolls.student', 'category'])
            ->when($request->faculty, fn($q) => $q->where('faculty_id', $request->faculty))
            ->when($request->program, fn($q) => $q->where('program_id', $request->program))
            ->when($request->session, fn($q) => $q->where('session_id', $request->session))
            ->when($request->semester, fn($q) => $q->where('semester_id', $request->semester))
            ->when($request->section, fn($q) => $q->where('section_id', $request->section))
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * Get summary statistics for assignments
     */
    protected function getAssignmentSummary($assignments)
    {
        return [
            'total_assignments' => $assignments->count(),
            'total_amount' => $assignments->sum('amount'),
            'total_students' => $assignments->sum(function($master) {
                return $master->studentEnrolls->count();
            }),
            'recent_assignments' => $assignments->take(5)
        ];
    }

    /**
     * Get fee structure details
     */
    protected function getFeeStructureDetails($programId, $semesterId)
    {
        return FeeStructure::with('items.category')
            ->where('program_id', $programId)
            ->where('semester', $semesterId)
            ->first();
    }

    /**
     * Get filtered students
     */
    protected function getFilteredStudents($request)
    {
        $enrolls = StudentEnroll::where('status', '1')
            ->when($request->faculty, fn($q) => $q->whereHas('program', fn($q2) => 
                $q2->where('faculty_id', $request->faculty)))
            ->when($request->program, fn($q) => $q->where('program_id', $request->program))
            ->when($request->session, fn($q) => $q->where('session_id', $request->session))
            ->when($request->semester, fn($q) => $q->where('semester_id', $request->semester))
            ->when($request->section, fn($q) => $q->where('section_id', $request->section))
            ->with('student')
            ->whereHas('student', fn($q) => $q->where('status', '1'))
            ->get();

        return $enrolls->sortBy(fn($enroll) => $enroll->student->student_id);
    }

    /**
     * Validate fee assignment request
     */
    protected function validateAssignmentRequest($request)
    {
        return $request->validate([
            'assign_date' => 'required|date|after_or_equal:today',
            'due_date' => 'required|date|after_or_equal:assign_date',
            'students' => 'required|array|min:1',
            'students.*' => 'exists:student_enrolls,id',
            'faculty' => 'nullable|exists:faculties,id',
            'program' => 'required|exists:programs,id',
            'session' => 'nullable|exists:sessions,id',
            'semester' => 'required|exists:semesters,id',
            'section' => 'nullable|exists:sections,id',
            'send_notification' => 'sometimes|boolean',
            'fee_structure_id' => 'nullable|exists:fee_structures,id'
        ]);
    }

    /**
     * Get or create fee structure
     */
    protected function getOrCreateFeeStructure($validated)
    {
        if($validated['fee_structure_id']) {
            return FeeStructure::findOrFail($validated['fee_structure_id']);
        }
        
        return FeeStructure::firstOrCreate([
            'program_id' => $validated['program'],
            'semester' => $validated['semester']
        ], [
            'faculty_id' => $validated['faculty'],
            'total_amount' => 0
        ]);
    }

    /**
     * Create master fee assignment record
     */
    protected function createMasterAssignment($validated, $feeStructure)
    {
        $categories = $feeStructure->items->pluck('fees_category_id')->unique()->toArray();
        
        return FeesMaster::create([
            'category_id' => $categories[0] ?? null,
            'faculty_id' => $validated['faculty'],
            'program_id' => $validated['program'],
            'session_id' => $validated['session'],
            'semester_id' => $validated['semester'],
            'section_id' => $validated['section'],
            'assign_date' => $validated['assign_date'],
            'due_date' => $validated['due_date'],
            'amount' => $feeStructure->total_amount,
            'created_by' => Auth::id(),
            'status' => 1,
            'fee_structure_id' => $feeStructure->id,
        ]);
    }

    /**
     * Process assignments for each student
     */
    protected function processStudentAssignments($studentIds, $feesMaster, $feeStructure, $validated)
    {
        $successCount = 0;
        $totalAmount = 0;
        
        foreach($studentIds as $enrollId) {
            $enroll = StudentEnroll::with('student')->findOrFail($enrollId);
            
            // Create invoice
            $invoice = $this->createStudentInvoice($enroll, $feeStructure, $validated);
            
            // Create fee records
            $this->createFeeRecords($invoice, $enroll, $feeStructure, $validated);
            
            // Attach to master assignment
            $feesMaster->studentEnrolls()->attach($enrollId);
            
            // Send notification if requested
            if($validated['send_notification'] && $enroll->student) {
                $this->sendStudentNotification(
                    $enroll->student, 
                    $feeStructure->total_amount, 
                    $validated['due_date']
                );
            }
            
            $successCount++;
            $totalAmount += $feeStructure->total_amount;
        }
        
        return [
            'count' => $successCount,
            'amount' => $totalAmount
        ];
    }

    /**
     * Create student invoice
     */
    protected function createStudentInvoice($enroll, $feeStructure, $validated)
    {
        $invoiceNo = 'INV-'.date('Ymd').'-'.str_pad(Invoice::count()+1, 5, '0', STR_PAD_LEFT);
        
        return Invoice::create([
            'student_enroll_id' => $enroll->id,
            'invoice_no' => $invoiceNo,
            'total_fee' => $feeStructure->total_amount,
            'amount_due' => $feeStructure->total_amount,
            'amount_paid' => 0,
            'payment_status' => 'pending',
            'assign_date' => $validated['assign_date'],
            'due_date' => $validated['due_date'],
            'created_by' => Auth::id(),
            'fee_structure_id' => $feeStructure->id,
            'fees_master_id' => $feesMaster->id ?? null
        ]);
    }

    /**
     * Create fee records for invoice
     */
    protected function createFeeRecords($invoice, $enroll, $feeStructure, $validated)
    {
        foreach($feeStructure->items as $item) {
            // Create invoice item
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'fees_category_id' => $item->fees_category_id,
                'amount' => $item->amount,
                'description' => $item->fee_category_title,
            ]);
            
            // Create fee record
            Fee::create([
                'student_enroll_id' => $enroll->id,
                'category_id' => $item->fees_category_id,
                'assign_date' => $validated['assign_date'],
                'due_date' => $validated['due_date'],
                'fee_amount' => $item->amount,
                'created_by' => Auth::id(),
                'status' => 1,
                'fee_structure_id' => $feeStructure->id,
                'invoice_id' => $invoice->id,
            ]);
        }
    }

    /**
     * Get student count for filters
     */
    protected function getStudentCountForFilters($filters)
    {
        return StudentEnroll::where('status', '1')
            ->when($filters['faculty_id'], fn($q) => $q->whereHas('program', fn($q2) => 
                $q2->where('faculty_id', $filters['faculty_id'])))
            ->when($filters['program_id'], fn($q) => $q->where('program_id', $filters['program_id']))
            ->when($filters['session_id'], fn($q) => $q->where('session_id', $filters['session_id']))
            ->when($filters['semester_id'], fn($q) => $q->where('semester_id', $filters['semester_id']))
            ->when($filters['section_id'], fn($q) => $q->where('section_id', $filters['section_id']))
            ->count();
    }

    /**
     * Send success response after assignment
     */
    protected function assignmentSuccessResponse($count, $amount)
    {
        Toastr::success(
            __('Fees assigned successfully to :count students. Total amount: :amount', [
                'count' => $count,
                'amount' => number_format($amount, 2)
            ]), 
            __('Success')
        );
        
        return redirect()->route($this->route.'.index');
    }

    /**
     * Send error response after failed assignment
     */
    protected function assignmentErrorResponse($exception)
    {
        \Log::error('Fee Assignment Error: '.$exception->getMessage());
        \Log::error($exception->getTraceAsString());
        
        Toastr::error(
            __('Failed to assign fees: ').$exception->getMessage(), 
            __('Error')
        );
        
        return redirect()->back()->withInput();
    }

    /**
     * Send SMS notification to student
     */
    protected function sendStudentNotification($student, $amount, $dueDate)
    {
        try {
            $apiUrl = 'https://smsportal.dapintechnologies.com/sms/v3/sendsms';
            $apiKey = config('services.sms.api_key');
            $serviceId = config('services.sms.service_id');
            $from = config('services.sms.from');
            
            $name = $student->first_name.' '.$student->last_name;
            $studentIdCode = $student->student_id;
            $formattedAmount = number_format($amount, 2);
            $formattedDueDate = \Carbon\Carbon::parse($dueDate)->format('d/m/Y');
            
            $message = "Hello {$name} ({$studentIdCode}), a new fee of KES {$formattedAmount} has been assigned to you. Due date: {$formattedDueDate}. Please make payment before the due date.";
            
            $payload = [
                'api_key' => $apiKey,
                'service_id' => $serviceId,
                'mobile' => $this->formatPhoneNumberForSms($student->phone),
                'response_type' => 'json',
                'shortcode' => $from,
                'message' => $message,
                'date_send' => now()->format('Y-m-d H:i:s'),
            ];
            
            $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
                ->post($apiUrl, $payload);
                
            \Log::info('SMS Notification Sent', [
                'student_id' => $student->id,
                'response' => $response->json()
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            \Log::error('Failed to send SMS notification', [
                'student_id' => $student->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Format phone number for SMS
     */
    protected function formatPhoneNumberForSms($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if(strpos($phone, '0') === 0) {
            return '254'.substr($phone, 1);
        } elseif(strpos($phone, '254') === 0) {
            return $phone;
        } elseif(strpos($phone, '+254') === 0) {
            return substr($phone, 1);
        }
        
        return $phone;
    }

    /**
 * Send payment reminder to student
 */
public function sendReminder(Request $request)
{
    $request->validate([
        'student_enroll_id' => 'required|exists:student_enrolls,id',
        'invoice_id' => 'required|exists:invoices,id',
        'message' => 'required|string|min:10'
    ]);

    try {
        $enroll = StudentEnroll::with('student')->findOrFail($request->student_enroll_id);
        $invoice = Invoice::findOrFail($request->invoice_id);
        
        if (!$enroll->student) {
            throw new \Exception('Student record not found');
        }

        // Send SMS
        $apiUrl = 'https://smsportal.dapintechnologies.com/sms/v3/sendsms';
        $apiKey = config('services.sms.api_key');
        $serviceId = config('services.sms.service_id');
        $from = config('services.sms.from');
        
        $payload = [
            'api_key' => $apiKey,
            'service_id' => $serviceId,
            'mobile' => $this->formatPhoneNumberForSms($enroll->student->phone),
            'response_type' => 'json',
            'shortcode' => $from,
            'message' => $request->message,
            'date_send' => now()->format('Y-m-d H:i:s'),
        ];
        
        $response = Http::withOptions(['verify' => false])
            ->post($apiUrl, $payload);
            
        if ($response->successful()) {
            // Log the reminder
            \Log::info('Payment reminder sent', [
                'student_enroll_id' => $enroll->id,
                'invoice_id' => $invoice->id,
                'message' => $request->message
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Reminder sent successfully'
            ]);
        }
        
        throw new \Exception('Failed to send SMS: ' . $response->body());
        
    } catch (\Exception $e) {
        \Log::error('Reminder sending failed: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}