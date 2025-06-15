<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamType;
use App\Models\Semester;
use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentEnroll;
use App\Models\Subject;
use App\Models\User;
use App\Models\Faculty;
use App\Models\Program;
use Illuminate\Support\Facades\DB;

class ExamTeacherReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_teacher_performance', 1);
        $this->route = 'admin.teacher-report';
        $this->view = 'admin.teacher-report';
        $this->path = 'teacher-report';
        $this->access = 'teacher-report';

        $this->middleware('permission:'.$this->access.'-view');
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
        $data['selected_teacher'] = $request->teacher ?? null;
        $data['selected_exam_type'] = $request->exam_type ?? null;
        $data['selected_semester'] = $request->semester ?? null;

        // Get filter data
        $data['faculties'] = Faculty::where('status', 1)->orderBy('title', 'asc')->get();
        $data['exam_types'] = ExamType::where('status', 1)->orderBy('title', 'asc')->get();
        $data['semesters'] = Semester::where('status', 1)->orderBy('id', 'asc')->get();
        $data['grades'] = Grade::where('status', '1')->orderBy('min_mark', 'desc')->get();

        // Get programs based on selected faculty
        if (!empty($data['selected_faculty'])) {
            $data['programs'] = Program::where('faculty_id', $data['selected_faculty'])
                ->where('status', 1)
                ->orderBy('title', 'asc')
                ->get();
        }

        // Get teachers (users) for select2 dropdown
        $teachersQuery = User::query();
        
        if ($request->has('teacher_search')) {
            $teachersQuery->where(function($q) use ($request) {
                $q->where('first_name', 'LIKE', '%'.$request->teacher_search.'%')
                  ->orWhere('last_name', 'LIKE', '%'.$request->teacher_search.'%');
            });
        }
        $data['teachers'] = $teachersQuery->orderBy('first_name')->get();

        $query = DB::table('exams')
            ->select(
                'exams.*',
                'exam_types.title as exam_type_name',
                'exam_types.id as exam_type_id',
                'exam_types.marks as exam_type_marks',
                'student_enrolls.semester_id',
                'student_enrolls.program_id',
                'students.id as student_id',
                'students.student_id as student_code',
                'semesters.title as semester_title',
                'subjects.id as subject_id',
                'subjects.title as subject_name',
                'subjects.code as subject_code',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as teacher_names"),
                'users.id as teacher_id',
                'users.first_name as teacher_first_name',
                'users.last_name as teacher_last_name',
                'programs.title as program_title',
                'faculties.title as faculty_title'
            )
            ->leftJoin('exam_types', 'exams.exam_type_id', '=', 'exam_types.id')
            ->leftJoin('student_enrolls', 'exams.student_enroll_id', '=', 'student_enrolls.id')
            ->leftJoin('students', 'student_enrolls.student_id', '=', 'students.id')
            ->leftJoin('semesters', 'student_enrolls.semester_id', '=', 'semesters.id')
            ->leftJoin('subjects', 'exams.subject_id', '=', 'subjects.id')
            ->leftJoin('class_routines', function ($join) {
                $join->on('class_routines.subject_id', '=', 'subjects.id')
                     ->on('class_routines.semester_id', '=', 'student_enrolls.semester_id')
                     ->on('class_routines.section_id', '=', 'student_enrolls.section_id');
            })
            ->leftJoin('users', 'class_routines.teacher_id', '=', 'users.id')
            ->leftJoin('programs', 'student_enrolls.program_id', '=', 'programs.id')
            ->leftJoin('faculties', 'programs.faculty_id', '=', 'faculties.id')
            ->groupBy(
                'exams.id',
                'exam_types.title', 'exam_types.id', 'exam_types.marks',
                'student_enrolls.semester_id', 'student_enrolls.program_id',
                'students.id', 'students.student_id',
                'semesters.title',
                'subjects.id', 'subjects.title', 'subjects.code',
                'users.id', 'users.first_name', 'users.last_name',
                'programs.title', 'faculties.title'
            );

        // Apply filters
        if ($data['selected_faculty']) {
            $query->where('faculties.id', $data['selected_faculty']);
        }
        if ($data['selected_program']) {
            $query->where('programs.id', $data['selected_program']);
        }
        if ($data['selected_teacher']) {
            $query->where('users.id', $data['selected_teacher']);
        }
        if ($data['selected_exam_type']) {
            $query->where('exam_types.id', $data['selected_exam_type']);
        }
        if ($data['selected_semester']) {
            $query->where('student_enrolls.semester_id', $data['selected_semester']);
        }

        $exams = $query->get();

        // Group results by teacher, subject and exam type to calculate pass/fail rates
        $performanceData = [];
        foreach ($exams as $exam) {
            $key = $exam->teacher_id.'_'.$exam->subject_id.'_'.$exam->exam_type_id;

            if (!isset($performanceData[$key])) {
                $performanceData[$key] = [
                    'exam_type' => $exam->exam_type_name,
                    'teacher' => (object)[
                        'id' => $exam->teacher_id,
                        'name' => $exam->teacher_first_name.' '.$exam->teacher_last_name
                    ],
                    'subject' => (object)[
                        'id' => $exam->subject_id,
                        'name' => $exam->subject_name,
                        'code' => $exam->subject_code
                    ],
                    'students' => [],
                    'total_students' => 0,
                    'passed' => 0,
                    'failed' => 0
                ];
            }

            // Track unique students for total count
            if (!in_array($exam->student_id, $performanceData[$key]['students'])) {
                $performanceData[$key]['students'][] = $exam->student_id;
                $performanceData[$key]['total_students']++;
            }

            // Calculate pass/fail for this exam
            $percentage = $exam->exam_type_marks > 0 ? 
                         round(($exam->achieve_marks / $exam->exam_type_marks) * 100, 2) : 0;
            
            if ($percentage >= 50) { // Assuming 50% is passing
                $performanceData[$key]['passed']++;
            } else {
                $performanceData[$key]['failed']++;
            }
        }

        // Prepare final data structure for the view
        $rows = [];
        foreach ($performanceData as $key => $dataItem) {
            $passRate = $dataItem['total_students'] > 0 ? 
                       round(($dataItem['passed'] / $dataItem['total_students']) * 100, 2) : 0;

            $rows[] = [
                'exam_type' => $dataItem['exam_type'],
                'teacher' => $dataItem['teacher'],
                'subject' => $dataItem['subject'],
                'total_students' => $dataItem['total_students'],
                'passed' => $dataItem['passed'],
                'failed' => $dataItem['failed'],
                'pass_rate' => $passRate
            ];
        }

        // Sort by pass rate descending
        usort($rows, function($a, $b) {
            return $b['pass_rate'] <=> $a['pass_rate'];
        });

        $data['rows'] = $rows;

        // Prepare data for the chart
        $chartData = $this->prepareChartData($rows);
        $data['chart_labels'] = $chartData['labels'];
        $data['chart_values'] = $chartData['values'];

        return view($this->view.'.index', $data);
    }

    /**
 * Prepare data for the performance chart
 */
protected function prepareChartData($rows)
{
    // Group data by exam type and calculate average marks
    $examTypes = [];
    
    foreach ($rows as $row) {
        $type = $row['exam_type'] ?? 'N/A';
        
        if (!isset($examTypes[$type])) {
            $examTypes[$type] = [
                'count' => 0,
                'total_marks' => 0
            ];
        }
        
        // Calculate average marks for this row (assuming pass_rate is percentage)
        $marks = $row['pass_rate'] ?? 0;
        
        $examTypes[$type]['count']++;
        $examTypes[$type]['total_marks'] += $marks;
    }
    
    // Prepare labels and values for chart
    $labels = [];
    $values = [];
    
    foreach ($examTypes as $type => $data) {
        $labels[] = $type;
        $values[] = $data['count'] > 0 ? round($data['total_marks'] / $data['count']) : 0;
    }
    
    return [
        'labels' => $labels,
        'values' => $values
    ];
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

    /**
     * Get teachers for select2 dropdown (AJAX)
     */
    public function getTeachers(Request $request)
    {
        $search = $request->q;

        $query = User::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'LIKE', '%'.$search.'%')
                  ->orWhere('last_name', 'LIKE', '%'.$search.'%');
            });
        }

        $teachers = $query->select('id', DB::raw("CONCAT(first_name, ' ', last_name) AS text"))
                         ->orderBy('first_name')
                         ->limit(50)
                         ->get();

        return response()->json($teachers);
    }

    
}