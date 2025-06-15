<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamType;
use App\Models\Semester;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Program;
use App\Models\Faculty;
use Illuminate\Support\Facades\DB;

class Exam2ResultRepoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_top_students', 1);
        $this->route = 'admin.result2-repo';
        $this->view = 'admin.result2-repo';
        $this->path = 'result2-repo';
        $this->access = 'result2-repo';

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

        // Get all faculties, programs, semesters and grades
        $data['faculties'] = Faculty::where('status', 1)->orderBy('title', 'asc')->get();
        $data['programs'] = Program::where('status', 1)->orderBy('title', 'asc')->get();
        $data['semesters'] = Semester::where('status', 1)->orderBy('id', 'asc')->get();
        $data['grades'] = Grade::where('status', '1')->orderBy('min_mark', 'desc')->get();

        // Get exam results with necessary relations
        $query = DB::table('exams')
            ->select(
                'exams.*',
                'exam_types.title as exam_type_name',
                'exam_types.marks as exam_type_marks',
                'student_enrolls.semester_id',
                'student_enrolls.student_id',
                'student_enrolls.program_id',
                'students.student_id as student_code',
                'students.first_name',
                'students.last_name',
                'students.photo',
                'semesters.title as semester_title',
                'programs.title as program_name',
                'programs.faculty_id',
                'faculties.title as faculty_name',
                'subjects.title as subject_name',
            )
            ->leftJoin('exam_types', 'exams.exam_type_id', '=', 'exam_types.id')
            ->leftJoin('student_enrolls', 'exams.student_enroll_id', '=', 'student_enrolls.id')
            ->leftJoin('students', 'student_enrolls.student_id', '=', 'students.id')
            ->leftJoin('semesters', 'student_enrolls.semester_id', '=', 'semesters.id')
            ->leftJoin('programs', 'student_enrolls.program_id', '=', 'programs.id')
            ->leftJoin('faculties', 'programs.faculty_id', '=', 'faculties.id')
            ->leftJoin('subjects', 'exams.subject_id', '=', 'subjects.id');

        // Filter by faculty
        if ($data['selected_faculty']) {
            $query->where('programs.faculty_id', $data['selected_faculty']);
        }

        // Filter by program
        if ($data['selected_program']) {
            $query->where('student_enrolls.program_id', $data['selected_program']);
        }

        // Filter by semester
        if ($data['selected_semester']) {
            $query->where('student_enrolls.semester_id', $data['selected_semester']);
        }

        $exams = $query->get();

        // Group results by student and calculate total marks
        $studentResults = [];
        foreach ($exams as $exam) {
            $studentId = $exam->student_id;
            $programId = $exam->program_id;

            if (!isset($studentResults[$studentId])) {
                $studentResults[$studentId] = [
                    'student' => (object)[
                        'id' => $studentId,
                        'student_id' => $exam->student_code,
                        'first_name' => $exam->first_name,
                        'last_name' => $exam->last_name,
                        'photo' => $exam->photo // Include photo in student data
                    ],
                    'program' => (object)[
                        'id' => $programId,
                        'title' => $exam->program_name,
                        'faculty_id' => $exam->faculty_id,
                        'faculty_name' => $exam->faculty_name
                    ],
                    'total_marks' => 0,
                    'exam_count' => 0
                ];
            }

            $studentResults[$studentId]['total_marks'] += $exam->achieve_marks;
            $studentResults[$studentId]['exam_count']++;
        }

        // Group students by program and find top student in each program
        $programWiseStudents = [];
        foreach ($studentResults as $studentId => $studentData) {
            $programId = $studentData['program']->id;

            if (!isset($programWiseStudents[$programId])) {
                $programWiseStudents[$programId] = [
                    'program' => $studentData['program'],
                    'students' => []
                ];
            }

            // Calculate average marks if needed
            $averageMarks = $studentData['exam_count'] > 0 
                ? $studentData['total_marks'] / $studentData['exam_count'] 
                : 0;

            $programWiseStudents[$programId]['students'][$studentId] = [
                'student' => $studentData['student'],
                'total_marks' => $studentData['total_marks'],
                'average_marks' => $averageMarks
            ];
        }

        // Get top student from each program
        $topStudents = [];
        foreach ($programWiseStudents as $programId => $programData) {
            if (!empty($programData['students'])) {
                // Sort students by total marks descending
                uasort($programData['students'], function($a, $b) {
                    return $b['total_marks'] <=> $a['total_marks'];
                });

                // Get the top student
                $topStudent = reset($programData['students']);
                $topStudents[] = [
                    'program' => $programData['program'],
                    'student' => $topStudent['student'],
                    'total_marks' => $topStudent['total_marks']
                ];
            }
        }

        // Sort top students by total marks descending
        usort($topStudents, function($a, $b) {
            return $b['total_marks'] <=> $a['total_marks'];
        });

        $data['rows'] = $topStudents;

        return view($this->view.'.index', $data);
    }

    /**
     * Get student transcript
     */
    public function transcript($id)
    {
        $data['title'] = 'Student Transcript';
        $data['student'] = Student::findOrFail($id);
        
        // Add logic to fetch transcript data for the student
        // ...

        return view($this->view.'.transcript', $data);
    }
}