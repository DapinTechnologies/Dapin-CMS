<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Semester;
use App\Models\FeesCategory;
use App\Models\Payment;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class FeeCollectionReportController extends Controller
{
    protected $title = 'Fee Collection Summary Report';
    protected $route = 'admin.fee-collection-report';
    protected $view = 'admin.fee-collection-report';

    public function __construct()
    {
        $this->middleware('permission:view fee collection reports');
    }

    /**
     * Display fee collection summary report
     */
   // In FeeCollectionReportController.php

public function index(Request $request)
{
    $data['title'] = $this->title;
    $data['route'] = $this->route;
    $data['view'] = $this->view;
    
    $data['feeCategories'] = FeesCategory::where('status', 1)->get();
    
    // Base query for payments with fees
    $query = Payment::where('status', 'completed')
        ->with([
            'invoice.fees.category',
            'studentEnroll.program.faculty',
            'studentEnroll.semester'
        ]);

    // Apply filters
    $data['selectedCategoryTitle'] = null;
    if ($request->fee_category) {
        $category = FeesCategory::find($request->fee_category);
        $data['selectedCategoryTitle'] = $category ? $category->title : null;
    }

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
        $query->whereBetween('paid_at', [
            Carbon::parse($request->start_date)->startOfDay(),
            Carbon::parse($request->end_date)->endOfDay()
        ]);
    }

    $payments = $query->get();

    // Prepare data for reports with fee category filter
    $data['monthlyData'] = $this->prepareMonthlyData($payments, $request->fee_category);
    $data['facultyDistribution'] = $this->prepareFacultyDistribution($payments, $request->fee_category);
    $data['summaryTable'] = $this->prepareSummaryTable($payments, $request->fee_category);
    $data['semesterSummary'] = $this->prepareSemesterSummary($payments, $request->fee_category);
    $data['facultySummary'] = $this->prepareFacultySummary($payments, $request->fee_category);
    $data['feeCategorySummary'] = $this->prepareFeeCategorySummary($payments, $request->fee_category);

    // Get filter options
    $data['faculties'] = Faculty::active()->get();
    $data['semesters'] = Semester::active()->get();
    
    if ($request->faculty) {
        $data['programs'] = Program::where('faculty_id', $request->faculty)->active()->get();
    } else {
        $data['programs'] = Program::active()->get();
    }
    
    $data['request'] = $request;

    return view($this->view.'.index', $data);
}

// Modified helper methods to handle fee category filtering
private function prepareMonthlyData($payments, $feeCategoryId = null)
{
    $data = [];
    $categories = FeesCategory::pluck('title')->toArray();
    
    // If a fee category is selected, only show that category
    if ($feeCategoryId) {
        $categories = [FeesCategory::find($feeCategoryId)->title];
    }
    
    foreach ($payments as $payment) {
        if (!$payment->invoice) continue;
        
        $monthName = Carbon::parse($payment->paid_at)->format('F Y');
        
        if (!isset($data[$monthName])) {
            $data[$monthName] = array_fill_keys($categories, 0);
        }
        
        if (!$payment->invoice->fees || $payment->invoice->fees->isEmpty()) continue;
        
        foreach ($payment->invoice->fees as $fee) {
            if (!$fee->category) continue;
            
            $categoryName = $fee->category->title;
            
            // If filtering by category, only include payments for that category
            if ($feeCategoryId && $fee->category_id != $feeCategoryId) {
                continue;
            }
            
            $data[$monthName][$categoryName] += $payment->amount;
        }
    }
    
    return $data;
}

private function prepareFacultyDistribution($payments, $feeCategoryId = null)
{
    $data = [];
    
    foreach ($payments as $payment) {
        if (!$payment->studentEnroll || !$payment->studentEnroll->program || !$payment->studentEnroll->program->faculty) {
            continue;
        }
        
        // Skip if filtering by fee category and payment doesn't have that category
        if ($feeCategoryId && (!$payment->invoice || 
            !$payment->invoice->fees->contains('category_id', $feeCategoryId))) {
            continue;
        }
        
        $facultyName = $payment->studentEnroll->program->faculty->title;
        $data[$facultyName] = ($data[$facultyName] ?? 0) + $payment->amount;
    }
    
    return $data;
}

private function prepareSummaryTable($payments, $feeCategoryId = null)
{
    $data = [];
    
    foreach ($payments as $payment) {
        if (!$payment->invoice || !$payment->invoice->fees || $payment->invoice->fees->isEmpty()) {
            continue;
        }
        
        if (!$payment->studentEnroll || !$payment->studentEnroll->program || 
            !$payment->studentEnroll->program->faculty || !$payment->studentEnroll->semester) {
            continue;
        }
        
        foreach ($payment->invoice->fees as $fee) {
            if (!$fee->category) continue;
            
            // Skip if filtering by fee category and this isn't the selected category
            if ($feeCategoryId && $fee->category_id != $feeCategoryId) {
                continue;
            }
            
            $facultyName = $payment->studentEnroll->program->faculty->title;
            $programName = $payment->studentEnroll->program->title;
            $semesterName = $payment->studentEnroll->semester->title;
            $categoryName = $fee->category->title;
            
            $key = $facultyName.'|'.$programName.'|'.$semesterName.'|'.$categoryName;
            
            if (!isset($data[$key])) {
                $data[$key] = [
                    'faculty' => $facultyName,
                    'program' => $programName,
                    'semester' => $semesterName,
                    'fee_category' => $categoryName,
                    'collected_amount' => 0
                ];
            }
            
            $data[$key]['collected_amount'] += $payment->amount;
        }
    }
    
    return array_values($data);
}

private function prepareSemesterSummary($payments, $feeCategoryId = null)
{
    $data = [];
    
    foreach ($payments as $payment) {
        if (!$payment->studentEnroll || !$payment->studentEnroll->semester) {
            continue;
        }
        
        // Skip if filtering by fee category and payment doesn't have that category
        if ($feeCategoryId && (!$payment->invoice || 
            !$payment->invoice->fees->contains('category_id', $feeCategoryId))) {
            continue;
        }
        
        $semesterName = $payment->studentEnroll->semester->title;
        $data[$semesterName] = ($data[$semesterName] ?? 0) + $payment->amount;
    }
    
    return $data;
}

private function prepareFacultySummary($payments, $feeCategoryId = null)
{
    $data = [];
    
    foreach ($payments as $payment) {
        if (!$payment->studentEnroll || !$payment->studentEnroll->program || !$payment->studentEnroll->program->faculty) {
            continue;
        }
        
        // Skip if filtering by fee category and payment doesn't have that category
        if ($feeCategoryId && (!$payment->invoice || 
            !$payment->invoice->fees->contains('category_id', $feeCategoryId))) {
            continue;
        }
        
        $facultyName = $payment->studentEnroll->program->faculty->title;
        $data[$facultyName] = ($data[$facultyName] ?? 0) + $payment->amount;
    }
    
    return $data;
}

private function prepareFeeCategorySummary($payments, $feeCategoryId = null)
{
    $data = [];
    
    foreach ($payments as $payment) {
        if (!$payment->invoice || !$payment->invoice->fees || $payment->invoice->fees->isEmpty()) {
            continue;
        }
        
        foreach ($payment->invoice->fees as $fee) {
            if (!$fee->category) continue;
            
            // If filtering by fee category, only include that category
            if ($feeCategoryId && $fee->category_id != $feeCategoryId) {
                continue;
            }
            
            $categoryName = $fee->category->title;
            $data[$categoryName] = ($data[$categoryName] ?? 0) + $payment->amount;
        }
    }
    
    return $data;
}
}