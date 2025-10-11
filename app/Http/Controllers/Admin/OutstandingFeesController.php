<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Semester;
use App\Models\FeesCategory;
use App\Models\Invoice;
use Illuminate\Http\Request;
use DB;
use Excel;
use App\Exports\OutstandingFeesExport;
use Carbon\Carbon;

class OutstandingFeesController extends Controller
{
    protected $title = 'Outstanding Fees Report';
    protected $route = 'admin.outstanding-fees';
    protected $view = 'admin.outstanding-fees';

    public function __construct()
    {
        $this->middleware('permission:view fee collection reports');
    }

    /**
     * Display outstanding fees report
     */
    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        
        $data['feeCategories'] = FeesCategory::where('status', 1)->get();
        
        // Base query for invoices with outstanding amounts
        $query = Invoice::where('amount_due', '>', 0)
            ->with([
                'fees.category',
                'studentEnroll.program.faculty',
                'studentEnroll.semester',
                'payments'
            ]);

        // Apply filters
        if ($request->faculty) {
            $query->whereHas('studentEnroll.program', function($q) use ($request) {
                $q->where('faculty_id', $request->faculty);
            });
        }

        if ($request->program) {
            $query->whereHas('studentEnroll', function($q) use ($request) {
                $q->where('program_id', $request->program);
            });
        }

        if ($request->semester) {
            $query->whereHas('studentEnroll', function($q) use ($request) {
                $q->where('semester_id', $request->semester);
            });
        }

        if ($request->fee_category) {
            $query->whereHas('fees', function($q) use ($request) {
                $q->where('category_id', $request->fee_category);
            });
        }

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('assign_date', [$request->start_date, $request->end_date]);
        }

        $invoices = $query->get();

        // Prepare data for reports
        $data['facultyOutstanding'] = $this->prepareFacultyOutstanding($invoices);
        $data['detailedOutstanding'] = $this->prepareDetailedOutstanding($invoices);

        // Get filter options
        $data['faculties'] = Faculty::active()->get();
        $data['semesters'] = Semester::active()->get();
        $data['programs'] = Program::active()->get();
        $data['request'] = $request;

        return view($this->view.'.index', $data);
    }

    /**
     * Get programs by faculty for AJAX
     */
    public function getPrograms(Request $request)
    {
        $programs = Program::where('faculty_id', $request->faculty_id)
            ->pluck('title', 'id');
            
        return response()->json($programs);
    }

    /**
     * Export to Excel
     */
    public function export(Request $request)
    {
        // Similar filtering logic as index method
        $query = Invoice::where('amount_due', '>', 0)
            ->with([
                'fees.category',
                'studentEnroll.program.faculty',
                'studentEnroll.semester',
                'payments'
            ]);

        // Apply filters from request
        if ($request->faculty) {
            $query->whereHas('studentEnroll.program', function($q) use ($request) {
                $q->where('faculty_id', $request->faculty);
            });
        }

        if ($request->program) {
            $query->whereHas('studentEnroll', function($q) use ($request) {
                $q->where('program_id', $request->program);
            });
        }

        if ($request->semester) {
            $query->whereHas('studentEnroll', function($q) use ($request) {
                $q->where('semester_id', $request->semester);
            });
        }

        if ($request->fee_category) {
            $query->whereHas('fees', function($q) use ($request) {
                $q->where('category_id', $request->fee_category);
            });
        }

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('assign_date', [$request->start_date, $request->end_date]);
        }

        $invoices = $query->get();
        $data = $this->prepareDetailedOutstanding($invoices);

        $fileName = 'outstanding_fees_' . date('Ymd_His') . '.xlsx';

        return Excel::download(new OutstandingFeesExport($data), $fileName);
    }

    // Helper methods for data preparation
    private function prepareFacultyOutstanding($invoices)
    {
        $data = [];
        
        foreach ($invoices as $invoice) {
            $facultyName = $invoice->studentEnroll->program->faculty->title;
            $data[$facultyName] = ($data[$facultyName] ?? 0) + $invoice->amount_due;
        }
        
        return $data;
    }

    private function prepareDetailedOutstanding($invoices)
{
    $data = [];
    
    foreach ($invoices as $invoice) {
        // Get basic information
        $facultyName = $invoice->studentEnroll->program->faculty->title;
        $programName = $invoice->studentEnroll->program->title;
        $semesterName = $invoice->studentEnroll->semester->title;
        
        // Get all fee categories for this invoice
        $feeCategories = DB::table('fees')
            ->where('invoice_id', $invoice->id)
            ->join('fees_categories', 'fees.category_id', '=', 'fees_categories.id')
            ->select('fees_categories.id', 'fees_categories.title', 'fees_categories.amount')
            ->get();
        
        // Get all payments for this invoice
        $payments = DB::table('payments')
            ->where('invoice_id', $invoice->id)
            ->where('status', 'completed')
            ->sum('amount');
        
        // If no specific fee categories found, treat as general fee
        if ($feeCategories->isEmpty()) {
            $key = $facultyName.'|'.$programName.'|'.$semesterName.'|General Fees';
            
            if (!isset($data[$key])) {
                $data[$key] = [
                    'faculty' => $facultyName,
                    'program' => $programName,
                    'semester' => $semesterName,
                    'fee_category' => 'General Fees',
                    'amount_invoiced' => 0,
                    'outstanding_amount' => 0,
                ];
            }
            
            $data[$key]['amount_invoiced'] += $invoice->total_fee;
            $data[$key]['outstanding_amount'] += $invoice->amount_due;
        } else {
            // Process by fee category
            foreach ($feeCategories as $category) {
                $key = $facultyName.'|'.$programName.'|'.$semesterName.'|'.$category->title;
                
                if (!isset($data[$key])) {
                    $data[$key] = [
                        'faculty' => $facultyName,
                        'program' => $programName,
                        'semester' => $semesterName,
                        'fee_category' => $category->title,
                        'amount_invoiced' => 0,
                        'outstanding_amount' => 0,
                    ];
                }
                
                // Calculate category amount (use predefined amount or proportional)
                $categoryAmount = $category->amount ?? ($invoice->total_fee / count($feeCategories));
                
                // Calculate paid amount for this category (simple proportional distribution)
                $categoryPaid = $payments * ($categoryAmount / $invoice->total_fee);
                
                $data[$key]['amount_invoiced'] += $categoryAmount;
                $data[$key]['outstanding_amount'] += max(0, $categoryAmount - $categoryPaid);
            }
        }
    }
    
    // Calculate percentage remaining
    foreach ($data as &$item) {
        $item['percentage_remaining'] = $item['amount_invoiced'] > 0 
            ? round(($item['outstanding_amount'] / $item['amount_invoiced']) * 100, 2)
            : 0;
    }
    
    return array_values($data);
}

    private function getPaidAmountForFee($invoice, $fee)
    {
        $paidAmount = 0;
        
        foreach ($invoice->payments as $payment) {
            // Assuming payments are allocated to specific fees (adjust as per your logic)
            if ($payment->fee_id == $fee->id) {
                $paidAmount += $payment->amount;
            }
        }
        
        return $paidAmount;
    }
}