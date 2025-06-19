<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamType;
use App\Models\Semester;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class ExamResultRepoController extends Controller
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
        $this->route = 'admin.result-repo';
        $this->view = 'admin.result-repo';
        $this->path = 'result-repo';
        $this->access = 'result-repo';

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
        $data['student_search'] = $request->student_search ?? '';
        $data['selected_semester'] = $request->semester ?? null;

        // Get all semesters and grades
        $data['semesters'] = Semester::where('status', 1)->orderBy('id', 'asc')->get();
        $data['grades'] = Grade::where('status', '1')->orderBy('min_mark', 'desc')->get();

        // Get students for select2 dropdown
        $studentsQuery = Student::query();
        if ($request->has('q')) {
            $search = $request->q;
            $studentsQuery->where(function($q) use ($search) {
                $q->where('student_id', 'LIKE', '%'.$search.'%')
                  ->orWhere('first_name', 'LIKE', '%'.$search.'%')
                  ->orWhere('last_name', 'LIKE', '%'.$search.'%');
            });
        }
        $data['students'] = $studentsQuery->orderBy('student_id')->get();

        // Get exam results with exam types joined directly
        $query = DB::table('exams')
            ->select(
                'exams.*',
                'exam_types.title as exam_type_name',
                'exam_types.marks as exam_type_marks',
                'student_enrolls.semester_id',
                'student_enrolls.section_id',
                'students.student_id',
                'students.first_name',
                'students.last_name',
                'semesters.title as semester_title',
                'sections.title as section_name',
                'subjects.title as subject_name',
            )
            ->leftJoin('exam_types', 'exams.exam_type_id', '=', 'exam_types.id')
            ->leftJoin('student_enrolls', 'exams.student_enroll_id', '=', 'student_enrolls.id')
            ->leftJoin('students', 'student_enrolls.student_id', '=', 'students.id')
            ->leftJoin('semesters', 'student_enrolls.semester_id', '=', 'semesters.id')
            ->leftJoin('sections', 'student_enrolls.section_id', '=', 'sections.id')
            ->leftJoin('subjects', 'exams.subject_id', '=', 'subjects.id');

        // Filter by semester
        if ($data['selected_semester']) {
            $query->where('student_enrolls.semester_id', $data['selected_semester']);
        }

        // Filter by student (changed from search term to exact match)
        if ($data['student_search'] && $data['student_search'] != '0') {
            $query->where('students.id', $data['student_search']);
        }

        $exams = $query->get();

        // Group results by student and subject
        $groupedResults = [];
        foreach ($exams as $exam) {
            $studentEnrollId = $exam->student_enroll_id;
            $subjectId = $exam->subject_id;

            if (!isset($groupedResults[$studentEnrollId])) {
                $groupedResults[$studentEnrollId] = [];
            }

            if (!isset($groupedResults[$studentEnrollId][$subjectId])) {
                $groupedResults[$studentEnrollId][$subjectId] = [
                    'student' => (object)[
                        'student_id' => $exam->student_id,
                        'name' => $exam->first_name.' '.$exam->last_name
                    ],
                    'semester' => (object)[
                        'title' => $exam->semester_title
                    ],
                    'section' => (object)[
                        'name' => $exam->section_name
                    ],
                    'subject' => (object)[
                        'name' => $exam->subject_name
                    ],
                    'exams' => []
                ];
            }

            $groupedResults[$studentEnrollId][$subjectId]['exams'][] = [
                'exam_type_name' => $exam->exam_type_name,
                'achieve_marks' => $exam->achieve_marks,
                'exam_type_marks' => $exam->exam_type_marks
            ];
        }

        // Calculate totals and percentages
        foreach ($groupedResults as &$student) {
            foreach ($student as &$subject) {
                $totalMarks = 0;
                $maxMarks = 0;
                
                foreach ($subject['exams'] as $exam) {
                    $totalMarks += $exam['achieve_marks'];
                    $maxMarks += $exam['exam_type_marks'];
                }
                
                $subject['total_marks'] = $totalMarks;
                $subject['percentage'] = $maxMarks > 0 ? round(($totalMarks / $maxMarks) * 100, 2) : 0;
                
                // Find grade
                $subject['grade'] = 'N/A';
                foreach ($data['grades'] as $grade) {
                    if ($subject['percentage'] >= $grade->min_mark && $subject['percentage'] <= $grade->max_mark) {
                        $subject['grade'] = $grade->name;
                        break;
                    }
                }
            }
        }

        $data['rows'] = $groupedResults;

        return view($this->view.'.index', $data);
    }

    /**
     * Get students for select2 dropdown (AJAX)
     */
    public function getStudents(Request $request)
    {
        $search = $request->q;

        $query = Student::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('student_id', 'LIKE', '%'.$search.'%')
                  ->orWhere('first_name', 'LIKE', '%'.$search.'%')
                  ->orWhere('last_name', 'LIKE', '%'.$search.'%');
            });
        }

        $students = $query->select('id', 'student_id', 'first_name', 'last_name')
                         ->orderBy('student_id')
                         ->limit(50)
                         ->get();

        $formattedStudents = [];
        foreach ($students as $student) {
            $formattedStudents[] = [
                'id' => $student->id,
                'text' => $student->student_id.' - '.$student->first_name.' '.$student->last_name
            ];
        }

        return response()->json($formattedStudents);
    }
}