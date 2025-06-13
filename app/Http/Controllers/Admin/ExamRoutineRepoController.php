<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrintSetting;
use App\Models\ExamRoutine;
use App\Models\ClassRoom;
use App\Models\Semester;
use App\Models\Faculty;
use App\Models\Session;
use App\Models\Program;
use App\Models\Section;
use App\Models\Subject;
use App\Models\ExamType;
use App\User;
use Toastr;
use Auth;
use DB;

class ExamRoutineRepoController extends Controller
{
    public function __construct()
    {
        $this->title = trans_choice('module_exam_routine', 1);
        $this->route = 'admin.exam-routine-repo';
        $this->view = 'admin.exam-routine-repo';
        $this->path = 'exam-routine-repo';
        $this->access = 'exam-routine-repo';

        $this->middleware('permission:' . $this->access . '-view|' . $this->access . '-create|' . $this->access . '-edit|' . $this->access . '-delete|' . $this->access . '-print', ['only' => ['index', 'show', 'report']]);
        $this->middleware('permission:' . $this->access . '-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:' . $this->access . '-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:' . $this->access . '-delete', ['only' => ['destroy']]);
        $this->middleware('permission:' . $this->access . '-print', ['only' => ['print']]);
    }

    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        // Filter Parameters
        $data['selected_faculty'] = $request->faculty ?? '0';
        $data['selected_program'] = $request->program ?? '0';
        $data['selected_session'] = $request->session ?? '0';
        $data['selected_semester'] = $request->semester ?? '0';
        $data['selected_section'] = $request->section ?? '0';
        $data['selected_type'] = $request->type ?? '0';

        // Filter Data
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['types'] = ExamType::where('status', '1')->orderBy('title', 'asc')->get();
        $data['sessions'] = Session::where('status', '1')->orderBy('id', 'desc')->get();
        $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();
        $data['semesters'] = Semester::where('status', '1')->orderBy('id', 'asc')->get();
        $data['sections'] = Section::where('status', '1')->orderBy('title', 'asc')->get();

        // Query Builder with direct joins
        $query = DB::table('exam_routines')
            ->join('programs', 'exam_routines.program_id', '=', 'programs.id')
            ->leftJoin('faculties', 'programs.faculty_id', '=', 'faculties.id')
            ->leftJoin('sessions', 'exam_routines.session_id', '=', 'sessions.id')
            ->leftJoin('semesters', 'exam_routines.semester_id', '=', 'semesters.id')
            ->leftJoin('sections', 'exam_routines.section_id', '=', 'sections.id')
            ->join('exam_types', 'exam_routines.exam_type_id', '=', 'exam_types.id')
            ->select(
                'exam_routines.*',
                'programs.title as program_title',
                'faculties.title as faculty_title',
                'sessions.title as session_title',
                'semesters.title as semester_title',
                'sections.title as section_title',
                'exam_types.title as exam_type_title'
            )
            ->where('exam_routines.status', '1');

        if ($data['selected_faculty'] != '0') {
            $query->where('programs.faculty_id', $data['selected_faculty']);
        }
        if ($data['selected_program'] != '0') {
            $query->where('exam_routines.program_id', $data['selected_program']);
        }
        if ($data['selected_session'] != '0') {
            $query->where('exam_routines.session_id', $data['selected_session']);
        }
        if ($data['selected_semester'] != '0') {
            $query->where('exam_routines.semester_id', $data['selected_semester']);
        }
        if ($data['selected_section'] != '0') {
            $query->where('exam_routines.section_id', $data['selected_section']);
        }
        if ($data['selected_type'] != '0') {
            $query->where('exam_routines.exam_type_id', $data['selected_type']);
        }

        $data['rows'] = $query->orderBy('exam_routines.date', 'asc')->get();

        return view($this->view . '.index', $data);
    }

    public function report(Request $request)
    {
        $data['title'] = 'Exam Routine Report';
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        // Filter Parameters
        $data['selected_faculty'] = $request->faculty ?? '0';
        $data['selected_type'] = $request->type ?? '0';

        // Filter Data
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['types'] = ExamType::where('status', '1')->orderBy('title', 'asc')->get();

        // Query with joins to get all data directly
        $query = DB::table('exam_routines')
            ->join('programs', 'exam_routines.program_id', '=', 'programs.id')
            ->leftJoin('faculties', 'programs.faculty_id', '=', 'faculties.id')
            ->join('exam_types', 'exam_routines.exam_type_id', '=', 'exam_types.id')
            ->select(
                'exam_routines.*',
                'programs.title as program_name',
                'faculties.title as faculty_name',
                'exam_types.title as exam_type_title'
            )
            ->where('exam_routines.status', '1');

        if ($data['selected_faculty'] != '0') {
            $query->where('programs.faculty_id', $data['selected_faculty']);
        }

        if ($data['selected_type'] != '0') {
            $query->where('exam_routines.exam_type_id', $data['selected_type']);
        }

        $data['reportData'] = $query->get()->map(function ($routine) {
            return [
                'program_id' => $routine->program_id,
                'program_name' => $routine->program_name,
                'faculty_name' => $routine->faculty_name,
                'field_type' => $routine->exam_type_title,
                'start_date' => $routine->date,
                'end_date' => $routine->end_date ?? $routine->date,
            ];
        });

        return view($this->view . '.report', $data);
    }
    public function getPrograms(Request $request)
{
    if (!$request->faculty_id) {
        return response()->json([]);
    }

    $programs = Program::where('faculty_id', $request->faculty_id)
        ->where('status', '1')
        ->orderBy('title', 'asc')
        ->get();

    return response()->json($programs);
}
}