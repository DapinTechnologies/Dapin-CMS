<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubjectMarking;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Session;
use App\Models\Semester;
use App\Models\Section;
use App\Models\Grade;
use App\Models\Subject;
use App\User;
use Auth;

class SubjectRepoController extends Controller
{
    public function __construct()
    {
        $this->title = trans_choice('module_subject_marking', 1);
        $this->route = 'admin.subject-repo';
        $this->view = 'admin.subject-repo';
        $this->path = 'subject-repo';
        $this->access = 'subject-repo';

        $this->middleware('permission:' . $this->access . '-statistics', ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['selected_faculty'] = $faculty = $request->faculty ?? '0';
        $data['selected_program'] = $program = $request->program ?? '0';
        $data['selected_session'] = $session = $request->session ?? '0';
        $data['selected_semester'] = $semester = $request->semester ?? '0';
        $data['selected_section'] = $section = $request->section ?? '0';
        $data['selected_subject'] = $subject = $request->subject ?? '0';

        $data['faculties'] = Faculty::where('status', '1')->orderBy('title')->get();
        $data['grades'] = Grade::where('status', '1')->orderBy('min_mark', 'desc')->get();

        $data['programs'] = ($faculty != '0')
            ? Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title')->get()
            : Program::where('status', '1')->orderBy('title')->get();

        if ($program != '0') {
            $data['sessions'] = Session::whereHas('programs', fn($q) => $q->where('program_id', $program))
                ->where('status', 1)->orderBy('id', 'desc')->get();

            $data['semesters'] = Semester::whereHas('programs', fn($q) => $q->where('program_id', $program))
                ->where('status', 1)->orderBy('id')->get();
        } else {
            $data['sessions'] = Session::where('status', 1)->orderBy('id', 'desc')->get();
            $data['semesters'] = Semester::where('status', 1)->orderBy('id')->get();
        }

        if ($program != '0' && $semester != '0') {
            $data['sections'] = Section::whereHas('semesterPrograms', function ($query) use ($program, $semester) {
                $query->where('program_id', $program)->where('semester_id', $semester);
            })->where('status', 1)->orderBy('title')->get();
        } else {
            $data['sections'] = Section::where('status', 1)->orderBy('title')->get();
        }

        // Get current user (to optionally filter by teacher if not super-admin)
        $teacher_id = Auth::guard('web')->user()->id;
        $isSuperAdmin = User::where('id', $teacher_id)
            ->whereHas('roles', fn($q) => $q->where('slug', 'super-admin'))
            ->exists();

        $subjects = Subject::where('status', '1');
        if ($program != '0') {
            $subjects->whereHas('programs', fn($q) => $q->where('program_id', $program));
        }

        if ($session != '0') {
            $subjects->whereHas('classes', function ($q) use ($session, $teacher_id, $isSuperAdmin) {
                $q->where('session_id', $session);
                if (!$isSuperAdmin) {
                    $q->where('teacher_id', $teacher_id);
                }
            });
        } elseif (!$isSuperAdmin) {
            $subjects->whereHas('classes', fn($q) => $q->where('teacher_id', $teacher_id));
        }

        $data['subjects'] = $subjects->orderBy('code')->get();

        // -------------------------------------------------------
        // Subject-wise Statistics
        // -------------------------------------------------------
        $data['statistics'] = [];
        $grades = $data['grades'];

        $markingsQuery = SubjectMarking::with('subject', 'studentEnroll.student');

        if ($program != '0') {
            $markingsQuery->whereHas('studentEnroll', fn($q) => $q->where('program_id', $program));
        }

        if ($session != '0') {
            $markingsQuery->whereHas('studentEnroll', fn($q) => $q->where('session_id', $session));
        }

        if ($semester != '0') {
            $markingsQuery->whereHas('studentEnroll', fn($q) => $q->where('semester_id', $semester));
        }

        if ($section != '0') {
            $markingsQuery->whereHas('studentEnroll', fn($q) => $q->where('section_id', $section));
        }

        if ($subject != '0') {
            $markingsQuery->where('subject_id', $subject);
        }

        $markings = $markingsQuery->get()->groupBy('subject_id');

       // In the index method, replace the statistics calculation part with this:

foreach ($markings as $subjectId => $subjectMarkings) {
    $subject = $subjectMarkings->first()->subject ?? null;

    $total = count($subjectMarkings);
    $totalMarks = $subjectMarkings->pluck('total_marks');
    $distinction = $merits = $pass = $fail = 0;

    foreach ($totalMarks as $mark) {
        if ($mark >= 80 && $mark <= 100) {
            $distinction++;
        } elseif ($mark >= 70 && $mark <= 79) {
            $merits++;
        } elseif ($mark >= 50 && $mark <= 69) {
            $pass++;
        } else {
            $fail++;
        }
    }

    $data['statistics'][] = [
        'subject' => $subject,
        'total_students' => $total,
        'distinction' => $distinction,
        'merits' => $merits,
        'pass' => $pass,
        'fail' => $fail,
        'highest' => $totalMarks->max(),
        'lowest' => $totalMarks->min(),
        'average' => round($totalMarks->avg(), 2),
        'rows' => $subjectMarkings,
    ];
}
        return view($this->view . '.index', $data);
    }
}
