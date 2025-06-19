<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamType;
use App\Models\Semester;
use App\Models\Program;
use App\Models\Faculty;
use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentEnroll;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class ExamDashboardRepoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_exam_result', 1);
        $this->route = 'admin.dashboard-repo';
        $this->view = 'admin.dashboard-repo';
        $this->path = 'dashboard-repo';
        $this->access = 'dashboard-repo';

        $this->middleware('permission:'.$this->access.'-result');
    }

    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        // Filter Parameters
        $data['selected_faculty'] = $request->faculty ?? null;
        $data['selected_program'] = $request->program ?? null;
        $data['selected_semester'] = $request->semester ?? null;

        // Get filter data
        $data['faculties'] = Faculty::where('status', 1)->orderBy('title', 'asc')->get();
        $data['semesters'] = Semester::where('status', 1)->orderBy('id', 'asc')->get();
        $data['grades'] = Grade::where('status', '1')->orderBy('min_mark', 'desc')->get();

        // Get programs based on selected faculty
        if ($data['selected_faculty']) {
            $data['programs'] = Program::where('faculty_id', $data['selected_faculty'])
                ->where('status', 1)
                ->orderBy('title', 'asc')
                ->get();
        } else {
            $data['programs'] = Program::where('status', 1)
                ->orderBy('title', 'asc')
                ->get();
        }

        // Main Query for Dashboard Metrics
        $query = DB::table('exams')
            ->select(
                'exams.*',
                'exam_types.title as exam_type_name',
                'student_enrolls.semester_id',
                'student_enrolls.program_id',
                'programs.faculty_id',
                'students.id as student_id',
                'semesters.title as semester_title',
                'programs.title as program_name',
                'faculties.title as faculty_name',
                'subjects.title as subject_name',
                'subjects.code as subject_code'
            )
            ->leftJoin('exam_types', 'exams.exam_type_id', '=', 'exam_types.id')
            ->leftJoin('student_enrolls', 'exams.student_enroll_id', '=', 'student_enrolls.id')
            ->leftJoin('students', 'student_enrolls.student_id', '=', 'students.id')
            ->leftJoin('semesters', 'student_enrolls.semester_id', '=', 'semesters.id')
            ->leftJoin('programs', 'student_enrolls.program_id', '=', 'programs.id')
            ->leftJoin('faculties', 'programs.faculty_id', '=', 'faculties.id')
            ->leftJoin('subjects', 'exams.subject_id', '=', 'subjects.id');

        // Apply Filters
        if ($data['selected_faculty']) {
            $query->where('programs.faculty_id', $data['selected_faculty']);
        }
        if ($data['selected_program']) {
            $query->where('student_enrolls.program_id', $data['selected_program']);
        }
        if ($data['selected_semester']) {
            $query->where('student_enrolls.semester_id', $data['selected_semester']);
        }

        $exams = $query->get();

        // Get enrolled students without marks - subject-wise
    $data['missing_marks_students'] = [];
    
    // First, get all enrolled students
    $enrolledStudents = StudentEnroll::query()
        ->select(
            'student_enrolls.id as enroll_id',
            'students.id as student_id',
            'students.student_id as roll_no',
            'students.first_name',
            'students.last_name',
            'programs.title as program_name',
            'semesters.title as semester_name'
        )
        ->join('students', 'student_enrolls.student_id', '=', 'students.id')
        ->join('programs', 'student_enrolls.program_id', '=', 'programs.id')
        ->join('semesters', 'student_enrolls.semester_id', '=', 'semesters.id');

    // Apply filters
    if ($data['selected_faculty']) {
        $enrolledStudents->where('programs.faculty_id', $data['selected_faculty']);
    }
    if ($data['selected_program']) {
        $enrolledStudents->where('student_enrolls.program_id', $data['selected_program']);
    }
    if ($data['selected_semester']) {
        $enrolledStudents->where('student_enrolls.semester_id', $data['selected_semester']);
    }

    $enrolledStudents = $enrolledStudents->get();

    // Get all subjects that should have exams (from existing exam records)
    $subjectsWithExams = Exam::query()
        ->select('subjects.id', 'subjects.title', 'subjects.code')
        ->join('subjects', 'exams.subject_id', '=', 'subjects.id')
        ->groupBy('subjects.id', 'subjects.title', 'subjects.code')
        ->get();

    // Now find which students are missing marks
    $missingMarksStudents = collect([]);
    $totalMissingMarks = 0;

    foreach ($enrolledStudents as $enrollment) {
        foreach ($subjectsWithExams as $subject) {
            // Get all exams for this student and subject
            $examsForSubject = Exam::where('student_enroll_id', $enrollment->enroll_id)
                ->where('subject_id', $subject->id)
                ->get();

            // Count missing marks
            $missingCount = $examsForSubject->where('achieve_marks', null)->count();
            $totalMissingMarks += $missingCount;

            // If no exams exist for this subject, or if any exam has null marks
            if ($examsForSubject->isEmpty() || $missingCount > 0) {
                $missingMarksStudents->push([
                    'student_id' => $enrollment->student_id,
                    'roll_no' => $enrollment->roll_no,
                    'first_name' => $enrollment->first_name,
                    'last_name' => $enrollment->last_name,
                    'program_name' => $enrollment->program_name,
                    'semester_name' => $enrollment->semester_name,
                    'subject_name' => $subject->title,
                    'subject_code' => $subject->code,
                    'status' => $examsForSubject->isEmpty() ? 'No Exams' : 'Marks Missing',
                    'missing_count' => $missingCount
                ]);
            }
        }
    }

    $data['missing_marks_students'] = $missingMarksStudents;
    $data['total_missing_marks'] = $totalMissingMarks;
    $data['total_missing_cases'] = $missingMarksStudents->count();

        // 1. Total Exams Done in the Semester
        $data['total_exams'] = $exams->count();

       // 2. Exam Schedule for Calendar - ensures each subject has max 3 exams (units)
$data['exam_routines'] = $exams
    ->groupBy('subject_code') // Group by subject (or 'subject_id')
    ->flatMap(function ($subjectExams) {
        return $subjectExams
            ->take(3) // Limit to 3 exams (units) per subject
            ->map(function ($exam) {
                return [
                    'title' => $exam->subject_name . ' (' . $exam->subject_code . ')',
                    'start' => $exam->date,
                    'description' => 'Exam Type: ' . $exam->exam_type_name
                ];
            });
    })
    ->values(); // Reset array keys

        // Find the lowest passing grade
        $passingGrade = Grade::where('status', 1)
            ->orderBy('min_mark', 'asc')
            ->first();

        // Prepare program-wise statistics
$programStats = [];
$totalStudents = 0;
$totalPassingStudents = 0;

// Group exams by program
$programGroups = $exams->groupBy('program_id');

foreach ($programGroups as $programId => $programExams) {
    $programName = $programExams->first()->program_name;
    $programStudents = $programExams->groupBy('student_id');
    $programStudentCount = $programStudents->count();
    $totalStudents += $programStudentCount;

    // Calculate CAT1, CAT2, and Mock averages
    $cat1Avg = $programExams->where('exam_type_name', 'CAT 1')->avg('achieve_marks') ?? 0;
    $cat2Avg = $programExams->where('exam_type_name', 'CAT 2')->avg('achieve_marks') ?? 0;
    $mockAvg = $programExams->where('exam_type_name', 'Mock Exam')->avg('achieve_marks') ?? 0;

    // Calculate passing students for this program
    $programPassingStudents = 0;
    foreach ($programStudents as $studentExams) {
        $totalMarks = $studentExams->sum('achieve_marks');
        $maxMarks = $studentExams->sum('exam_type_marks');
        $percentage = $maxMarks > 0 ? ($totalMarks / $maxMarks) * 100 : 0;

        if ($passingGrade && $percentage >= $passingGrade->min_mark) {
            $programPassingStudents++;
            $totalPassingStudents++;
        }
    }

    // Calculate pass_rate as the average of CAT1, CAT2, and Mock Exam averages
    $passRate = ($cat1Avg + $cat2Avg + $mockAvg) ;
    $passRate = round($passRate, 2);

    $programStats[] = [
        'program_name' => $programName,
        'cat1_avg' => round($cat1Avg, 2),
        'cat2_avg' => round($cat2Avg, 2),
        'mock_avg' => round($mockAvg, 2),
        'passed_students' => $programPassingStudents,
        'total_students' => $programStudentCount,
        'pass_rate' => $passRate
    ];
}

// Calculate overall pass rate as the average of all program pass rates
$overallPassRate = count($programStats) > 0 ? round(array_sum(array_column($programStats, 'pass_rate')) / count($programStats), 2) : 0;
        $data['program_stats'] = $programStats;
        $data['total_passing_students'] = $totalPassingStudents;
        $data['total_students'] = $totalStudents;
        $data['overall_pass_rate'] = $overallPassRate;

        $pendingGradingQuery = StudentEnroll::query()
            ->select('student_enrolls.*', 'students.student_id', 'students.first_name', 'students.last_name')
            ->join('students', 'student_enrolls.student_id', '=', 'students.id');

        if ($data['selected_faculty']) {
            $pendingGradingQuery->join('programs', 'student_enrolls.program_id', '=', 'programs.id')
                ->where('programs.faculty_id', $data['selected_faculty']);
        }
        if ($data['selected_program']) {
            $pendingGradingQuery->where('student_enrolls.program_id', $data['selected_program']);
        }
        if ($data['selected_semester']) {
            $pendingGradingQuery->where('student_enrolls.semester_id', $data['selected_semester']);
        }

        $enrolledStudents = $pendingGradingQuery->get();

        $data['pending_grading'] = [];
        foreach ($enrolledStudents as $enrollment) {
            $examsTaken = Exam::where('student_enroll_id', $enrollment->id)->count();
            // Get subjects count differently (assuming they're in a pivot table)
        }

        // In your index method, after calculating $programStats
$data['chart_programs'] = array_column($programStats, 'program_name');
$data['chart_pass_rates'] = array_column($programStats, 'pass_rate');



// Or alternatively, calculate directly from program stats:
 $data['chart_fail_rates'] = array_map(function($program) {
    $passRate = $program['pass_rate'] ?? 0;
    $passRate = max(0, min(100, $passRate));
     return 100 - $passRate;
 }, $programStats);


        return view($this->view.'.index', $data);
    }

    /**
     * Get programs based on faculty (AJAX)
     */
    public function getPrograms(Request $request)
    {
        $faculty_id = $request->faculty_id;

        $programs = Program::where('faculty_id', $faculty_id)
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get();

        return response()->json($programs);
    }
}