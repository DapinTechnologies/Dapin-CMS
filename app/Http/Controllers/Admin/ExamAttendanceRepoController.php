<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;
use App\Imports\MarksImport;
use App\Models\ExamType;
use App\Models\Semester;
use App\Models\Program;
use App\Models\Session;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Faculty;
use App\Models\Exam;
use App\User;
use Toastr;
use Auth;

class ExamAttendanceRepoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_exam_attendance', 1);
        $this->route = 'admin.attendance-repo';
        $this->view = 'admin.attendance-repo.index';
        $this->path = 'attendance-repo';
        $this->access = 'attendance-repo';

        $this->middleware('permission:'.$this->access.'-attendance', ['only' => ['index','store']]);
        $this->middleware('permission:'.$this->access.'-import', ['only' => ['index','import','importStore']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        // Set default values for filters
        $data['selected_faculty'] = $request->faculty ?? '0';
        $data['selected_program'] = $request->program ?? null;
        $data['selected_semester'] = $request->semester ?? null;
        $data['selected_type'] = $request->type ?? '0';

        // Get filter data
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['types'] = ExamType::where('status', '1')->orderBy('title', 'asc')->get();

        // Get programs if faculty is selected
        if($data['selected_faculty'] != '0') {
            $data['programs'] = Program::where('faculty_id', $data['selected_faculty'])
                ->where('status', '1')
                ->orderBy('title', 'asc')
                ->get();
        }

        // Get semesters if program is selected
        if($data['selected_program'] != null) {
            $data['semesters'] = Semester::where('status', 1)
                ->with('programs')
                ->whereHas('programs', function ($query) use ($data) {
                    $query->where('program_id', $data['selected_program']);
                })
                ->orderBy('id', 'asc')
                ->get();
        }

        // Get attendance data by default (showing most recent data)
        $data['attendances'] = Exam::with(['studentEnroll', 'subject'])
            ->orderBy('date', 'desc')
            ->take(100) // Limit to 100 most recent records by default
            ->get()
            ->map(function($exam) {
                // Manually add exam type data to each exam record
                $exam->exam_type_data = ExamType::find($exam->exam_type_id);
                return $exam;
            });

        // Apply filters if any are selected
        if($data['selected_faculty'] != '0' || $data['selected_program'] != null || 
           $data['selected_semester'] != null || $data['selected_type'] != '0') {
            
            $attendances = Exam::query();

            // Filter by faculty through program
            if($data['selected_faculty'] != '0') {
                $attendances->whereHas('studentEnroll.program', function($query) use ($data) {
                    $query->where('faculty_id', $data['selected_faculty']);
                });
            }

            // Filter by program
            if($data['selected_program'] != null) {
                $attendances->whereHas('studentEnroll', function($query) use ($data) {
                    $query->where('program_id', $data['selected_program']);
                });
            }

            // Filter by semester
            if($data['selected_semester'] != null) {
                $attendances->whereHas('studentEnroll', function($query) use ($data) {
                    $query->where('semester_id', $data['selected_semester']);
                });
            }

            // Filter by exam type
            if($data['selected_type'] != '0') {
                $attendances->where('exam_type_id', $data['selected_type']);
            }

            $data['attendances'] = $attendances->with(['studentEnroll', 'subject'])
                ->orderBy('date', 'desc')
                ->get()
                ->map(function($exam) {
                    // Manually add exam type data to each exam record
                    $exam->exam_type_data = ExamType::find($exam->exam_type_id);
                    return $exam;
                });
        }

        // Calculate summary statistics
        if($data['attendances']->count() > 0) {
            $data['summary'] = [
                'total_students' => $data['attendances']->unique('student_enroll_id')->count(),
                'total_attended' => $data['attendances']->where('attendance', 1)->count(),
                'total_absent' => $data['attendances']->where('attendance', 0)->count(),
                'dates' => $data['attendances']->groupBy('date')->keys()->toArray()
            ];
        } else {
            $data['summary'] = [
                'total_students' => 0,
                'total_attended' => 0,
                'total_absent' => 0,
                'dates' => []
            ];
        }

        return view($this->view, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Field Validation
        $request->validate([
            'subject' => 'required',
            'type' => 'required|exists:exam_types,id,status,1',
            'date' => 'required|date|before_or_equal:today',
            'attendances' => 'required',
            'students' => 'required',
        ]);

        $attendances = explode(",",$request->attendances);

        // Get the exam type directly from database
        $examType = ExamType::where('id', $request->type)
                    ->where('status', 1)
                    ->firstOrFail();

        // Insert Data
        foreach($request->students as $key => $student_id){
            // Insert Or Update Data
            $exam = Exam::updateOrCreate(
            [
                'student_enroll_id' => $student_id, 
                'subject_id' => $request->subject,
                'exam_type_id' => $request->type
            ],[
                'student_enroll_id' => $student_id, 
                'subject_id' => $request->subject,
                'exam_type_id' => $request->type,
                'date' => $request->date,
                'marks' => $examType->marks,
                'contribution' => $examType->contribution,
                'attendance' => $attendances[$key],
                'created_by' => Auth::guard('web')->user()->id
            ]);
        }

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $data['title']     = $this->title;
        $data['route']     = $this->route;
        $data['view']      = $this->view;
        $data['access']    = $this->access;

        $data['sessions'] = Session::where('status', '1')
                        ->orderBy('id', 'desc')->get();
        $data['types'] = ExamType::where('status', '1')
                        ->orderBy('title', 'asc')->get();

        return view($this->view.'.import', $data);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function importStore(Request $request)
    {
        // Field Validation
        $request->validate([
            'session' => 'required',
            'subject' => 'required',
            'type' => 'required|exists:exam_types,id,status,1',
            'date' => 'required|date|before_or_equal:today',
            'import' => 'required|file|mimes:xlsx',
        ]);

        // Get exam type directly from database
        $examType = ExamType::where('id', $request->type)
                    ->where('status', 1)
                    ->firstOrFail();

        // Passing Data
        $data['session'] = $request->session;
        $data['subject'] = $request->subject;
        $data['type'] = $request->type;
        $data['date'] = $request->date;
        $data['examType'] = $examType; // Pass the full exam type object

        Excel::import(new MarksImport($data), $request->file('import'));

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }
}