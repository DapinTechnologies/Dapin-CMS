<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeesCategory;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use DB;
use Excel;
use App\Exports\GovernmentFeesExport;
use Carbon\Carbon;

class GovernmentFeesReportController extends Controller
{
    protected $title = 'Government Fees Report';
    protected $route = 'admin.government-fees-report';
    protected $view = 'admin.government-fees-report';

    public function __construct()
    {
        $this->middleware('permission:view government fees reports');
    }

    /**
     * Display government fees report
     */
    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        
        // Get government fee categories (where fee_type is 'government' or 'both')
        $governmentCategories = FeesCategory::whereIn('fee_type', ['government', 'both'])->get();
        
        // Base query for invoices with government fees
        $query = Invoice::whereHas('fees', function($query) use ($governmentCategories) {
                $query->whereIn('category_id', $governmentCategories->pluck('id'));
            })
            ->with(['fees', 'payments', 'studentEnroll.program.faculty', 'studentEnroll.semester']);

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

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('assign_date', [$request->start_date, $request->end_date]);
        }

        $invoicesWithGovernmentFees = $query->get();

        // Prepare data for charts
        $data['chartData'] = $this->prepareChartData($governmentCategories, $invoicesWithGovernmentFees);
        $data['categories'] = $governmentCategories;
        
        // Get filter options
        $data['faculties'] = DB::table('faculties')->where('status', 1)->get();
        $data['semesters'] = DB::table('semesters')->where('status', 1)->get();
        $data['programs'] = DB::table('programs')->where('status', 1)->get();

        // ✅ Fix: Pass $request to the view
    $data['request'] = $request;

        return view($this->view.'.index', $data);
    }

    /**
     * Export government fees report to Excel
     */
    public function export(Request $request)
    {
        // Get government fee categories
        $governmentCategories = FeesCategory::whereIn('fee_type', ['government', 'both'])->get();
        
        // Query for invoices with government fees (same as index method)
        $query = Invoice::whereHas('fees', function($query) use ($governmentCategories) {
                $query->whereIn('category_id', $governmentCategories->pluck('id'));
            })
            ->with(['fees', 'payments', 'studentEnroll.program.faculty', 'studentEnroll.semester']);

        // Apply filters (same as index method)
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

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('assign_date', [$request->start_date, $request->end_date]);
        }

        $invoicesWithGovernmentFees = $query->get();
        $chartData = $this->prepareChartData($governmentCategories, $invoicesWithGovernmentFees);

        // Generate Excel file
        return Excel::download(new GovernmentFeesExport($chartData, $governmentCategories), 'government-fees-report.xlsx');
    }

    /**
     * Get programs by faculty for AJAX
     */
    public function getPrograms(Request $request)
    {
        $programs = DB::table('programs')
            ->where('faculty_id', $request->faculty_id)
            ->where('status', 1)
            ->pluck('title', 'id');
            
        return response()->json($programs);
    }

    /**
     * Prepare chart data from invoices and categories
     */
    protected function prepareChartData($categories, $invoices)
    {
        $data = [
            'categoryAmounts' => [],
            'totalCollected' => 0,
            'totalExpected' => 0,
            'paymentStatusData' => [
                'paid' => 0,
                'partial' => 0,
                'unpaid' => 0
            ],
            'facultyDistribution' => [],
            'semesterDistribution' => []
        ];
        
        // Initialize category amounts with colors
        $colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69'];
        $colorIndex = 0;
        
        foreach ($categories as $category) {
            $data['categoryAmounts'][$category->id] = [
                'name' => $category->title,
                'expected' => 0,
                'collected' => 0,
                'color' => $colors[$colorIndex % count($colors)]
            ];
            $colorIndex++;
        }
        
        // Process invoices
        foreach ($invoices as $invoice) {
            // Track faculty and semester distribution
            $faculty = $invoice->studentEnroll->program->faculty->title ?? 'Unknown';
            $semester = $invoice->studentEnroll->semester->title ?? 'Unknown';
            
            // Get government fees in this invoice
            $governmentFees = $invoice->fees->whereIn('category_id', $categories->pluck('id'));
            
            foreach ($governmentFees as $fee) {
                $categoryId = $fee->category_id;
                $category = $categories->find($categoryId);
                
                if ($category) {
                    $data['categoryAmounts'][$categoryId]['expected'] += $category->amount;
                    $data['totalExpected'] += $category->amount;
                    
                    // Add to faculty distribution
                    $data['facultyDistribution'][$faculty] = ($data['facultyDistribution'][$faculty] ?? 0) + $category->amount;
                    
                    // Add to semester distribution
                    $data['semesterDistribution'][$semester] = ($data['semesterDistribution'][$semester] ?? 0) + $category->amount;
                }
            }
            
            // Calculate payments for government fees
            $governmentPayments = $invoice->payments->whereIn('invoice_id', $invoices->pluck('id'));
            
            foreach ($governmentPayments as $payment) {
                $data['totalCollected'] += $payment->amount;
                
                // Find which category this payment applies to (simplified)
                foreach ($governmentFees as $fee) {
                    $categoryId = $fee->category_id;
                    $data['categoryAmounts'][$categoryId]['collected'] += $payment->amount / count($governmentFees);
                }
            }
            
            // Track payment status
            $invoiceTotal = $invoice->total_fee;
            $paidAmount = $invoice->amount_paid;
            
            if ($paidAmount >= $invoiceTotal) {
                $data['paymentStatusData']['paid']++;
            } elseif ($paidAmount > 0) {
                $data['paymentStatusData']['partial']++;
            } else {
                $data['paymentStatusData']['unpaid']++;
            }
        }
        
        return $data;
    }

    
}