<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Semester;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;
use DB;

class BursaryReportController extends Controller
{
    protected $title = 'Bursary Report';
    protected $route = 'admin.bursary-report';
    protected $view = 'admin.bursary-report';

    public function __construct()
    {
        $this->middleware('permission:view bursary reports');
    }

    /**
     * Display bursary report
     */
    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        
        // Get filter options
        $data['faculties'] = Faculty::active()->get();
        $data['semesters'] = Semester::active()->get();
        $data['programs'] = Program::active()->get();

        // Query for bursary payments
        $query = DB::table('payments')
            ->select(
                'payments.*',
                'invoices.invoice_no',
                'students.first_name',
                'students.last_name',
                'students.student_id',
                'programs.title as program_title',
                'faculties.title as faculty_title',
                'semesters.title as semester_title'
            )
            ->join('invoices', 'payments.invoice_id', '=', 'invoices.id')
            ->join('student_enrolls', 'payments.student_enroll_id', '=', 'student_enrolls.id')
            ->join('students', 'student_enrolls.student_id', '=', 'students.id')
            ->join('programs', 'student_enrolls.program_id', '=', 'programs.id')
            ->join('faculties', 'programs.faculty_id', '=', 'faculties.id')
            ->join('semesters', 'student_enrolls.semester_id', '=', 'semesters.id')
            ->where('payments.is_bursary', 1);

        // Apply filters
        if ($request->faculty) {
            $query->where('faculties.id', $request->faculty);
        }

        if ($request->program) {
            $query->where('programs.id', $request->program);
        }

        if ($request->semester) {
            $query->where('semesters.id', $request->semester);
        }

        if ($request->student_name) {
            $query->where(function($q) use ($request) {
                $q->where('students.first_name', 'like', '%'.$request->student_name.'%')
                  ->orWhere('students.last_name', 'like', '%'.$request->student_name.'%');
            });
        }

        if ($request->student_id) {
            $query->where('students.student_id', 'like', '%'.$request->student_id.'%');
        }

        if ($request->reconciled == '1') {
            $query->where('payments.is_reconciled', 1);
        } elseif ($request->reconciled == '0') {
            $query->where('payments.is_reconciled', 0);
        }

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('payments.paid_at', [$request->start_date, $request->end_date]);
        }

        $data['bursaries'] = $query->get();

        // Chart data - Bursary by Faculty
        $data['bursaryByFaculty'] = DB::table('payments')
            ->select(
                'faculties.title as faculty',
                DB::raw('SUM(payments.amount) as total_amount')
            )
            ->join('invoices', 'payments.invoice_id', '=', 'invoices.id')
            ->join('student_enrolls', 'payments.student_enroll_id', '=', 'student_enrolls.id')
            ->join('programs', 'student_enrolls.program_id', '=', 'programs.id')
            ->join('faculties', 'programs.faculty_id', '=', 'faculties.id')
            ->where('payments.is_bursary', 1)
            ->groupBy('faculties.title')
            ->get();

        // Chart data - Bursary by Type
        $data['bursaryByType'] = DB::table('payments')
            ->select(
                'payments.bursary_type',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(payments.amount) as total_amount')
            )
            ->where('payments.is_bursary', 1)
            ->groupBy('payments.bursary_type')
            ->get();

        // Chart data - Reconciliation Status
        $data['reconciliationStatus'] = DB::table('payments')
            ->select(
                DB::raw('CASE WHEN is_reconciled = 1 THEN "Reconciled" ELSE "Not Reconciled" END as status'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->where('is_bursary', 1)
            ->groupBy('is_reconciled')
            ->get();

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
 * Export bursary report to Excel
 */
public function export(Request $request)
{
    // Query for bursary payments (same as index method)
    $query = DB::table('payments')
        ->select(
            'payments.*',
            'invoices.invoice_no',
            'students.first_name',
            'students.last_name',
            'students.student_id',
            'programs.title as program_title',
            'faculties.title as faculty_title',
            'semesters.title as semester_title'
        )
        ->join('invoices', 'payments.invoice_id', '=', 'invoices.id')
        ->join('student_enrolls', 'payments.student_enroll_id', '=', 'student_enrolls.id')
        ->join('students', 'student_enrolls.student_id', '=', 'students.id')
        ->join('programs', 'student_enrolls.program_id', '=', 'programs.id')
        ->join('faculties', 'programs.faculty_id', '=', 'faculties.id')
        ->join('semesters', 'student_enrolls.semester_id', '=', 'semesters.id')
        ->where('payments.is_bursary', 1);

    // Apply filters (same as index method)
    if ($request->faculty) {
        $query->where('faculties.id', $request->faculty);
    }

    if ($request->program) {
        $query->where('programs.id', $request->program);
    }

    if ($request->semester) {
        $query->where('semesters.id', $request->semester);
    }

    if ($request->student_name) {
        $query->where(function($q) use ($request) {
            $q->where('students.first_name', 'like', '%'.$request->student_name.'%')
              ->orWhere('students.last_name', 'like', '%'.$request->student_name.'%');
        });
    }

    if ($request->student_id) {
        $query->where('students.student_id', 'like', '%'.$request->student_id.'%');
    }

    if ($request->reconciled == '1') {
        $query->where('payments.is_reconciled', 1);
    } elseif ($request->reconciled == '0') {
        $query->where('payments.is_reconciled', 0);
    }

    if ($request->start_date && $request->end_date) {
        $query->whereBetween('payments.paid_at', [$request->start_date, $request->end_date]);
    }

    $bursaries = $query->get();

    // Generate Excel file
    return Excel::download(new BursaryExport($bursaries), 'bursary-report.xlsx');
}

}