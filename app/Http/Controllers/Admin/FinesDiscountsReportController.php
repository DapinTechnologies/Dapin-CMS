<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Semester;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;
use Excel;
use DB;

class FinesDiscountsReportController extends Controller
{
    protected $title = 'Fines & Discounts Report';
    protected $route = 'admin.fines-discounts-report';
    protected $view = 'admin.fines-discounts-report';

    public function __construct()
    {
        $this->middleware('permission:view financial reports');
    }

    /**
     * Display fines and discounts report
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

        // Query for invoices with fines or discounts
        $query = DB::table('invoices')
            ->select(
                'invoices.*',
                'students.first_name',
                'students.last_name',
                'students.student_id',
                'programs.title as program_title',
                'faculties.title as faculty_title',
                'semesters.title as semester_title'
            )
            ->join('student_enrolls', 'invoices.student_enroll_id', '=', 'student_enrolls.id')
            ->join('students', 'student_enrolls.student_id', '=', 'students.id')
            ->join('programs', 'student_enrolls.program_id', '=', 'programs.id')
            ->join('faculties', 'programs.faculty_id', '=', 'faculties.id')
            ->join('semesters', 'student_enrolls.semester_id', '=', 'semesters.id')
            ->where(function($q) {
                $q->where('invoices.discount_amount', '>', 0)
                  ->orWhere('invoices.fine_amount', '>', 0);
            });

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

        if ($request->adjustment_type) {
            $query->where('invoices.adjustment_type', $request->adjustment_type);
        }

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('invoices.assign_date', [$request->start_date, $request->end_date]);
        }

        $data['invoices'] = $query->get();

        // Chart data - Discounts vs Fines
        $data['discountsVsFines'] = DB::table('invoices')
            ->select(
                DB::raw("'Discounts' as type"),
                DB::raw('SUM(discount_amount) as total_amount')
            )
            ->where('discount_amount', '>', 0)
            ->unionAll(
                DB::table('invoices')
                    ->select(
                        DB::raw("'Fines' as type"),
                        DB::raw('SUM(fine_amount) as total_amount')
                    )
                    ->where('fine_amount', '>', 0)
            )
            ->get();

        // Chart data - Discounts by Faculty
        $data['discountsByFaculty'] = DB::table('invoices')
            ->select(
                'faculties.title as faculty',
                DB::raw('SUM(discount_amount) as total_amount')
            )
            ->join('student_enrolls', 'invoices.student_enroll_id', '=', 'student_enrolls.id')
            ->join('programs', 'student_enrolls.program_id', '=', 'programs.id')
            ->join('faculties', 'programs.faculty_id', '=', 'faculties.id')
            ->where('discount_amount', '>', 0)
            ->groupBy('faculties.title')
            ->get();

        // Chart data - Fines by Faculty
        $data['finesByFaculty'] = DB::table('invoices')
            ->select(
                'faculties.title as faculty',
                DB::raw('SUM(fine_amount) as total_amount')
            )
            ->join('student_enrolls', 'invoices.student_enroll_id', '=', 'student_enrolls.id')
            ->join('programs', 'student_enrolls.program_id', '=', 'programs.id')
            ->join('faculties', 'programs.faculty_id', '=', 'faculties.id')
            ->where('fine_amount', '>', 0)
            ->groupBy('faculties.title')
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
 * Export fines & discounts report to Excel
 */
public function export(Request $request)
{
    // Query for invoices (same as index method)
    $query = DB::table('invoices')
        ->select(
            'invoices.*',
            'students.first_name',
            'students.last_name',
            'students.student_id',
            'programs.title as program_title',
            'faculties.title as faculty_title',
            'semesters.title as semester_title'
        )
        ->join('student_enrolls', 'invoices.student_enroll_id', '=', 'student_enrolls.id')
        ->join('students', 'student_enrolls.student_id', '=', 'students.id')
        ->join('programs', 'student_enrolls.program_id', '=', 'programs.id')
        ->join('faculties', 'programs.faculty_id', '=', 'faculties.id')
        ->join('semesters', 'student_enrolls.semester_id', '=', 'semesters.id')
        ->where(function($q) {
            $q->where('invoices.discount_amount', '>', 0)
              ->orWhere('invoices.fine_amount', '>', 0);
        });

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

    if ($request->adjustment_type) {
        $query->where('invoices.adjustment_type', $request->adjustment_type);
    }

    if ($request->start_date && $request->end_date) {
        $query->whereBetween('invoices.assign_date', [$request->start_date, $request->end_date]);
    }

    $invoices = $query->get();

    // Generate Excel file
    return Excel::download(new FinesDiscountsExport($invoices), 'fines-discounts-report.xlsx');
}

}

