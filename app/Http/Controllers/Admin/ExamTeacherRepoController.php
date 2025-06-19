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

class ExamTeacherRepoController extends Controller
{
    public function __construct()
    {
        $this->title = trans_choice('module_exam_routine', 1);
        $this->route = 'admin.exam-teacher-repo';
        $this->view = 'admin.exam-teacher-repo';
        $this->path = 'exam-teacher-repo';
        $this->access = 'exam-teacher-repo';

        $this->middleware('permission:' . $this->access . '-view|' . $this->access . '-create|' . $this->access . '-edit|' . $this->access . '-delete|' . $this->access . '-print', ['only' => ['index', 'show', 'report', 'teacherSearch']]);
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
        $data['selected_teacher'] = $request->teacher_id ?? '0';

        // Filter Data
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['types'] = ExamType::where('status', '1')->orderBy('title', 'asc')->get();
        $data['sessions'] = Session::where('status', '1')->orderBy('id', 'desc')->get();
        $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();
        $data['semesters'] = Semester::where('status', '1')->orderBy('id', 'asc')->get();
        $data['sections'] = Section::where('status', '1')->orderBy('title', 'asc')->get();
        $data['teachers'] = User::where('status', '1')
                              ->where('id')
                              ->orderBy('first_name')
                              ->orderBy('last_name')
                              ->get();

        // Query Builder with Eloquent relationships
        $query = ExamRoutine::with([
                'program.faculty',
                'session',
                'semester',
                'section',
               
                'users', // Teachers relationship
                'rooms'  // Classrooms relationship
            ])
            ->where('status', '1');

        // Apply filters
        if ($data['selected_faculty'] != '0') {
            $query->whereHas('program', function($q) use ($data) {
                $q->where('faculty_id', $data['selected_faculty']);
            });
        }
        if ($data['selected_program'] != '0') {
            $query->where('program_id', $data['selected_program']);
        }
        if ($data['selected_session'] != '0') {
            $query->where('session_id', $data['selected_session']);
        }
        if ($data['selected_semester'] != '0') {
            $query->where('semester_id', $data['selected_semester']);
        }
        if ($data['selected_section'] != '0') {
            $query->where('section_id', $data['selected_section']);
        }
        if ($data['selected_type'] != '0') {
            $query->where('exam_type_id', $data['selected_type']);
        }
        if ($data['selected_teacher'] != '0') {
            $query->whereHas('users', function($q) use ($data) {
                $q->where('user_id', $data['selected_teacher']);
            });
        }

        $data['rows'] = $query->orderBy('date', 'asc')->get();

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

        // Query using Eloquent relationships
        $query = ExamRoutine::with(['program.faculty', 'examType'])
            ->where('status', '1');

        if ($data['selected_faculty'] != '0') {
            $query->whereHas('program', function($q) use ($data) {
                $q->where('faculty_id', $data['selected_faculty']);
            });
        }

        if ($data['selected_type'] != '0') {
            $query->where('exam_type_id', $data['selected_type']);
        }

        $data['reportData'] = $query->get()->map(function ($routine) {
            return [
                'program_id' => $routine->program_id,
                'program_name' => $routine->program->title,
                'faculty_name' => $routine->program->faculty->title ?? '',
                 'field_type' => ExamType::find($routine->exam_type_id)->title ?? '', // ✅ Updated
                'field_type' => $routine->examType->title,
                'start_date' => $routine->date,
                'end_date' => $routine->end_date ?? $routine->date,
            ];
        });

        return view($this->view . '.report', $data);
    }

    public function teacherSearch(Request $request)
    {
        $data['title'] = 'Teacher Exam Routine Search';
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        // Maintain filter parameters
        $data['selected_faculty'] = $request->faculty ?? '0';
        $data['selected_program'] = $request->program ?? '0';
        $data['selected_session'] = $request->session ?? '0';
        $data['selected_semester'] = $request->semester ?? '0';
        $data['selected_section'] = $request->section ?? '0';
        $data['selected_type'] = $request->type ?? '0';
        $data['selected_teacher'] = $request->teacher_id ?? '0';

        // Teacher search parameters
        $teacher_name = $request->teacher_name;
        $teacher_last_name = $request->teacher_last_name;
        $exam_date = $request->exam_date;

        // Filter Data
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['types'] = ExamType::where('status', '1')->orderBy('title', 'asc')->get();
        $data['sessions'] = Session::where('status', '1')->orderBy('id', 'desc')->get();
        $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();
        $data['semesters'] = Semester::where('status', '1')->orderBy('id', 'asc')->get();
        $data['sections'] = Section::where('status', '1')->orderBy('title', 'asc')->get();
        $data['teachers'] = User::where('status', '1')
                              ->where('user_type', 'teacher')
                              ->orderBy('first_name')
                              ->orderBy('last_name')
                              ->get();

        // Base query with relationships
        $query = ExamRoutine::with([
                'program.faculty',
                'session',
                'semester',
                'section',
                'subject',
               
                'users', // Teachers
                'rooms'  // Classrooms
            ])
            ->where('status', '1');

        // Apply original filters
        if ($data['selected_faculty'] != '0') {
            $query->whereHas('program', function($q) use ($data) {
                $q->where('faculty_id', $data['selected_faculty']);
            });
        }
        if ($data['selected_program'] != '0') {
            $query->where('program_id', $data['selected_program']);
        }
        if ($data['selected_session'] != '0') {
            $query->where('session_id', $data['selected_session']);
        }
        if ($data['selected_semester'] != '0') {
            $query->where('semester_id', $data['selected_semester']);
        }
        if ($data['selected_section'] != '0') {
            $query->where('section_id', $data['selected_section']);
        }
        if ($data['selected_type'] != '0') {
            $query->where('exam_type_id', $data['selected_type']);
        }
        if ($data['selected_teacher'] != '0') {
            $query->whereHas('users', function($q) use ($data) {
                $q->where('user_id', $data['selected_teacher']);
            });
        }

        // Apply teacher search filters using the many-to-many relationship
        if (!empty($teacher_name) || !empty($teacher_last_name)) {
            $query->whereHas('users', function($q) use ($teacher_name, $teacher_last_name) {
                if (!empty($teacher_name)) {
                    $q->where('first_name', 'like', '%' . $teacher_name . '%');
                }
                if (!empty($teacher_last_name)) {
                    $q->where('last_name', 'like', '%' . $teacher_last_name . '%');
                }
            });
        }
        if (!empty($exam_date)) {
            $query->whereDate('date', $exam_date);
        }

        $data['rows'] = $query->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get()
            ->map(function ($routine) {
                return [
                    'id' => $routine->id,
                    'date' => $routine->date,
                    'start_time' => $routine->start_time,
                    'end_time' => $routine->end_time,
                    'program_title' => $routine->program->title ?? '',
                    'faculty_title' => $routine->program->faculty->title ?? '',
                    'session_title' => $routine->session->title ?? '',
                    'semester_title' => $routine->semester->title ?? '',
                    'section_title' => $routine->section->title ?? '',
                      'exam_type_title' => ExamType::find($routine->exam_type_id)->title ?? '', // ✅ Updated
                    'subject_title' => $routine->subject->title ?? '',
                    'subject_code' => $routine->subject->code ?? '',
                    'teacher_first_name' => $routine->users->first()->first_name ?? '',
                    'teacher_last_name' => $routine->users->first()->last_name ?? '',
                    'room_no' => $routine->rooms->first()->room_no ?? '',
                    'teacher_full_name' => $routine->users->first() ? 
                        $routine->users->first()->first_name . ' ' . $routine->users->first()->last_name : '',
                    'all_teachers' => $routine->users->map(function($user) {
                        return $user->first_name . ' ' . $user->last_name;
                    })->implode(', '),
                    'all_rooms' => $routine->rooms->pluck('room_no')->implode(', ')
                ];
            });

        $data['show_all'] = (!empty($teacher_name) || !empty($teacher_last_name)) && empty($exam_date);

        return view($this->view . '.index', $data);
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