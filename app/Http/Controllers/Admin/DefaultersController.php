<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\StudentEnroll;
use App\Models\Program;
use App\Models\Faculty;
use App\Models\Semester;
use Illuminate\Http\Request;
use DB;
use Excel;
use App\Exports\DefaultersExport;

class DefaultersController extends Controller
{
    protected $title = 'Fee Defaulters';
    protected $route = 'admin.defaulters';
    protected $view = 'admin.defaulters';

    public function __construct()
    {
        $this->middleware('permission:view fee defaulters')->only(['index', 'export']);
    }

    /**
     * Display the defaulters list
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

        // Query for overdue defaulters only
        $query = Invoice::with([
                'studentEnroll.student', 
                'studentEnroll.program.faculty', 
                'studentEnroll.semester'
            ])
            ->where(function($q) {
                $q->where('payment_status', 'unpaid')
                  ->orWhere('payment_status', 'pending');
            })
            ->where('amount_due', '>', 0)
            ->whereDate('due_date', '<', date('Y-m-d'));

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
        
        if ($request->search) {
            $query->whereHas('studentEnroll.student', function($q) use ($request) {
                $q->where('student_id', 'like', '%'.$request->search.'%')
                  ->orWhere('first_name', 'like', '%'.$request->search.'%')
                  ->orWhere('last_name', 'like', '%'.$request->search.'%');
            });
        }

        $data['rows'] = $query->orderBy('due_date', 'asc')->get();
        
        // Calculate total amount due
        $data['totalAmountDue'] = $data['rows']->sum('amount_due');
        
        // Prepare data for charts
        $data['facultyData'] = $this->getFacultyData($data['rows']);
        $data['programData'] = $this->getProgramData($data['rows']);
        
        // Pass request parameters to view
        $data['request'] = $request->all();

        return view($this->view.'.index', $data);
    }

    /**
     * Get faculty data for chart
     */
    private function getFacultyData($rows)
    {
        $facultyCounts = [];
        
        foreach ($rows as $row) {
            $facultyName = $row->studentEnroll->program->faculty->title ?? 'Unknown';
            if (!isset($facultyCounts[$facultyName])) {
                $facultyCounts[$facultyName] = 0;
            }
            $facultyCounts[$facultyName]++;
        }
        
        return [
            'labels' => array_keys($facultyCounts),
            'data' => array_values($facultyCounts)
        ];
    }

    /**
     * Get program data for chart
     */
    private function getProgramData($rows)
    {
        $programCounts = [];
        
        foreach ($rows as $row) {
            $programName = $row->studentEnroll->program->title ?? 'Unknown';
            if (!isset($programCounts[$programName])) {
                $programCounts[$programName] = 0;
            }
            $programCounts[$programName]++;
        }
        
        return [
            'labels' => array_keys($programCounts),
            'data' => array_values($programCounts)
        ];
    }

    /**
     * Export defaulters data
     */
    public function export(Request $request)
    {
        $filters = [
            'faculty' => $request->faculty,
            'program' => $request->program,
            'semester' => $request->semester,
            'search' => $request->search
        ];

        return Excel::download(new DefaultersExport($filters), 'fee_defaulters_'.date('Y-m-d').'.xlsx');
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