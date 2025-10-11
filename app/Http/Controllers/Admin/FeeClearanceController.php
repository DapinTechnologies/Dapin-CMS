<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Invoice;
use App\Models\StudentEnroll;
use App\Models\Program;
use App\Services\SmsService;
use App\Services\EmailService;
use Illuminate\Http\Request;
use PDF;

class FeeClearanceController extends Controller
{
    protected $title = 'Fee Clearance';
    protected $route = 'admin.fee-clearance';
    protected $view = 'admin.fee-clearance';

    protected $smsService;
    protected $emailService;

    public function __construct()
    {
        $this->middleware('permission:view fee clearance')->only(['index', 'show', 'history', 'report', 'search']);
        $this->middleware('permission:clear fees')->only(['clear']);
        $this->middleware('permission:send fee notifications')->only(['notify']);
        
        
    }

    /**
     * Display the fee clearance dashboard
     */
    public function index()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        // Get counts based on invoice payment status
        $data['clearedStudents'] = Invoice::where('payment_status', 'paid')->count();
        $data['pendingStudents'] = Invoice::where('payment_status', 'pending')->count();
        $data['partialStudents'] = Invoice::where('payment_status', 'partial')->count();
        
        return view($this->view.'.index', $data);
    }

    /**
     * Search for students
     */
    public function search(Request $request)
{
    $request->validate([
        'query' => 'required|string|min:3'
    ]);

    $query = $request->input('query');

    $enrollments = StudentEnroll::with(['student', 'program'])
        ->whereHas('student', function($q) use ($query) {
            $q->where('students.student_id', 'LIKE', "%$query%")
              ->orWhere('students.first_name', 'LIKE', "%$query%")
              ->orWhere('students.last_name', 'LIKE', "%$query%")
              ->orWhere('students.email', 'LIKE', "%$query%");
        })
        ->latest()
        ->get();

    if ($enrollments->isEmpty()) {
        return redirect()->route($this->route.'.index')
            ->with('error', 'No students found matching your search criteria.');
    }

    // If only one result, redirect directly to show page
    if ($enrollments->count() === 1) {
        return redirect()->route($this->route.'.show', $enrollments->first()->id);
    }

    // For multiple results, show in index page
    return view($this->view.'.index', [
        'title' => $this->title,
        'route' => $this->route,
        'view' => $this->view,
        'student' => $enrollments->first()->student,
        'program' => $enrollments->first()->program,
        'invoices' => Invoice::where('student_enroll_id', $enrollments->first()->id)
            ->orderBy('assign_date', 'desc')
            ->get(),
        'clearedStudents' => Invoice::where('payment_status', 'paid')->count(),
        'pendingStudents' => Invoice::where('payment_status', 'pending')->count(),
        'partialStudents' => Invoice::where('payment_status', 'partial')->count(),
    ]);
}
    /**
     * Show student fee details
     */
    public function show($enroll_id)
    {
        $enrollment = StudentEnroll::with(['student', 'program'])->findOrFail($enroll_id);
        
        $invoices = Invoice::where('student_enroll_id', $enroll_id)
            ->orderBy('assign_date', 'desc')
            ->get();

        return view($this->view.'.index', [
            'title' => $this->title,
            'route' => $this->route,
            'view' => $this->view,
            'student' => $enrollment->student,
            'program' => $enrollment->program,
            'invoices' => $invoices,
            'clearedStudents' => Invoice::where('payment_status', 'paid')->count(),
            'pendingStudents' => Invoice::where('payment_status', 'pending')->count(),
            'partialStudents' => Invoice::where('payment_status', 'partial')->count(),
        ]);
    }

    public function fetchStudents(Request $request)
{
    $query = $request->input('q');
    
    $students = Student::when($query, function($q) use ($query) {
            return $q->where('student_id', 'LIKE', "%$query%")
              ->orWhere('first_name', 'LIKE', "%$query%")
              ->orWhere('last_name', 'LIKE', "%$query%")
              ->orWhere('email', 'LIKE', "%$query%");
        })
        ->limit(10)
        ->get(['id', 'student_id', 'first_name', 'last_name', 'email']);
    
    return response()->json($students);
}

/**
 * Show complete payment history for a student
 */
public function paymentHistory($enroll_id)
{
    $enrollment = StudentEnroll::with(['student', 'program'])->findOrFail($enroll_id);

    $allInvoices = Invoice::where('student_enroll_id', $enroll_id)
        ->orderBy('assign_date', 'desc')
        ->paginate(10);

        return view($this->view.'.payment-history', [
            'title' => $this->title,
            'route' => $this->route,
            'view' => $this->view,
            'student' => $enrollment->student,
            'program' => $enrollment->program,
            'invoices' => Invoice::where('student_enroll_id', $enroll_id)
                ->orderBy('assign_date', 'desc')
                ->get(),
            'allInvoices' => $allInvoices,
            'clearedStudents' => Invoice::where('payment_status', 'paid')->count(),
            'pendingStudents' => Invoice::where('payment_status', 'pending')->count(),
            'partialStudents' => Invoice::where('payment_status', 'partial')->count(),
        ]);
    }

    /**
     * Clear student fees
     */
    public function clear($invoice_id, Request $request)
    {
        $invoice = Invoice::with('studentEnroll.student')->findOrFail($invoice_id);
        
        // Update invoice status
        $invoice->update([
            'payment_status' => 'paid',
            'amount_paid' => $invoice->total_fee,
            'amount_due' => 0,
            'payment_date' => now()
        ]);
        
        // Generate clearance certificate
        $this->generateClearanceCertificate($invoice);
        
        // Send notification
        $this->emailService->sendFeeClearance(
            $invoice->studentEnroll->student->email,
            $invoice->studentEnroll->student->name,
            $invoice->invoice_no
        );
        
        return redirect()
            ->back()
            ->with('success', 'Invoice marked as paid successfully! Clearance certificate generated.');
    }

    /**
     * Send fee notification to student
     */
    public function notify($enroll_id, Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'method' => 'required|in:sms,email'
        ]);

        $enrollment = StudentEnroll::with('student')->findOrFail($enroll_id);
        $student = $enrollment->student;
        
        if ($request->method === 'sms') {
            $this->smsService->send($student->phone, $request->message);
        } elseif ($request->method === 'email') {
            $this->emailService->sendFeeNotification($student->email, $request->message);
        }
        
        // Log the notification
        activity()
            ->causedBy(auth()->user())
            ->performedOn($enrollment)
            ->log("Sent fee notification via {$request->method}");
        
        return redirect()
            ->back()
            ->with('success', 'Notification sent successfully!');
    }

    /**
     * Generate fee clearance report
     */
    public function generatereport(Request $request)
    {
        $status = $request->input('status', 'all');
        $program = $request->input('program', 'all');

        $query = Invoice::with(['studentEnroll.student', 'studentEnroll.program']);

        if ($status !== 'all') {
            $query->where('payment_status', $status);
        }

        if ($program !== 'all') {
            $query->whereHas('studentEnroll.program', function($q) use ($program) {
                $q->where('id', $program);
            });
        }
        
        $invoices = $query->orderBy('assign_date', 'desc')->get();
        
        if ($request->has('export')) {
            $exportType = $request->input('export');
            
            if ($exportType === 'pdf') {
                $pdf = PDF::loadView($this->view.'.report-pdf', [
                    'invoices' => $invoices,
                    'status' => $status,
                    'program' => $program !== 'all' ? Program::find($program)->name : 'All Programs',
                    'generatedDate' => now()->format('F j, Y')
                ]);
                return $pdf->download('fee-clearance-report-'.now()->format('Y-m-d').'.pdf');
            }
            
            // Handle other export types (CSV, Excel) here if needed
        }
        
        return view($this->view.'.index', [
            'title' => $this->title,
            'route' => $this->route,
            'view' => $this->view,
            'clearedStudents' => Invoice::where('payment_status', 'paid')->count(),
            'pendingStudents' => Invoice::where('payment_status', 'pending')->count(),
            'partialStudents' => Invoice::where('payment_status', 'partial')->count(),
            'reportData' => $invoices,
            'reportStatus' => $status,
            'reportProgram' => $program
        ]);
    }
    
    /**
     * Generate clearance certificate (private)
     */
    private function generateClearanceCertificate($invoice)
    {
        $data = [
            'invoice' => $invoice,
            'student' => $invoice->studentEnroll->student,
            'program' => $invoice->studentEnroll->program,
            'generatedDate' => now()->format('F j, Y')
        ];
        
        $pdf = PDF::loadView($this->view.'.clearance-certificate', $data);
        $filename = 'clearance-'.$invoice->invoice_no.'-'.now()->format('YmdHis').'.pdf';
        
        // Save to storage
        $pdf->save(storage_path('app/public/clearance/'.$filename));
        
        // Update invoice with certificate path
        $invoice->update(['clearance_certificate' => 'clearance/'.$filename]);
        
        return $filename;
    }
}