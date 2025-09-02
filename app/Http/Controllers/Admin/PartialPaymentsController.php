<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\StudentEnroll;
use App\Models\Program;
use App\Models\Faculty;
use App\Models\Semester;
use Illuminate\Http\Request;
use DB;
use Excel;
use App\Exports\PartialPaymentsExport;

class PartialPaymentsController extends Controller
{
    protected $title = 'Partial Payments';
    protected $route = 'admin.partial-payments';
    protected $view = 'admin.partial-payments';

    public function __construct()
    {
        $this->middleware('permission:view partial payments')->only(['index', 'export']);
    }

    /**
     * Display the partial payments list
     */
    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        
        // Get filter options
        $data['faculties'] = Faculty::active()->get();
        $data['semesters'] = Semester::active()->get();
        
        // Get programs based on faculty filter if set
        if ($request->faculty) {
            $data['programs'] = Program::where('faculty_id', $request->faculty)->active()->get();
        } else {
            $data['programs'] = Program::active()->get();
        }

        // Main query for partial payments
        $query = Payment::with([
                'studentEnroll.student', 
                'studentEnroll.program.faculty', 
                'studentEnroll.semester',
                'invoice'
            ])
            ->where('payments.status', 'partial');

        // Payment methods query
        $paymentMethodsQuery = Payment::where('payments.status', 'partial')
            ->select('payment_method', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('payment_method');

        // Faculty performance query
        $facultyPerformanceQuery = Payment::where('payments.status', 'partial')
            ->select(DB::raw('faculties.title as faculty_title'), DB::raw('SUM(payments.amount) as total_amount'))
            ->join('student_enrolls', 'payments.student_enroll_id', '=', 'student_enrolls.id')
            ->join('programs', 'student_enrolls.program_id', '=', 'programs.id')
            ->join('faculties', 'programs.faculty_id', '=', 'faculties.id')
            ->groupBy('faculties.title');

        // Apply filters to all queries
        $applyFilters = function($query) use ($request) {
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
            
            if ($request->search) {
                $query->whereHas('studentEnroll.student', function($q) use ($request) {
                    $q->where('student_id', 'like', '%'.$request->search.'%')
                      ->orWhere('first_name', 'like', '%'.$request->search.'%')
                      ->orWhere('last_name', 'like', '%'.$request->search.'%');
                });
            }
        };

        // Apply filters to main query
        $applyFilters($query);
        $applyFilters($paymentMethodsQuery);

        // Apply faculty filter to faculty performance query
        if ($request->faculty) {
            $facultyPerformanceQuery->where('faculties.id', $request->faculty);
        }

        // Get the data
        $data['rows'] = $query->orderBy('payments.created_at', 'desc')->get();
        $data['paymentMethodsData'] = $paymentMethodsQuery->get();
        $data['facultyPerformanceData'] = $facultyPerformanceQuery->get();

        // Calculate total partial payment amount
        $data['totalPartialAmount'] = $query->sum('payments.amount');
        
        // Pass request parameters to view
        $data['request'] = $request->all();

        return view($this->view.'.index', $data);
    }

    /**
     * Export partial payments data
     */
    public function export(Request $request)
    {
        $filters = [
            'faculty' => $request->faculty,
            'program' => $request->program,
            'semester' => $request->semester,
            'search' => $request->search
        ];

        return Excel::download(new PartialPaymentsExport($filters), 'partial_payments_'.date('Y-m-d').'.xlsx');
    }

    public function getPrograms(Request $request)
    {
        $programs = Program::active();
        
        if ($request->faculty_id) {
            $programs->where('faculty_id', $request->faculty_id);
        }
        
        return response()->json([
            'status' => true,
            'programs' => $programs->get()
        ]);
    }
}