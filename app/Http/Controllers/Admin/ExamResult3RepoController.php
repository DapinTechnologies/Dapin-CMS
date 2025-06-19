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
use Illuminate\Support\Facades\DB;

class ExamResult3RepoController extends Controller
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
        $this->route = 'admin.result3-repo';
        $this->view = 'admin.result3-repo';
        $this->path = 'result3-repo';
        $this->access = 'result3-repo';

        $this->middleware('permission:'.$this->access.'-result');
    }

    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        // Get all semesters and grades
        $data['semesters'] = Semester::where('status', 1)->orderBy('id', 'desc')->get();
        $data['grades'] = Grade::where('status', '1')->orderBy('min_mark', 'desc')->get();
        $data['programs'] = Program::where('status', 1)->orderBy('title', 'asc')->get();

        // 1. Get program results data
        $programResults = $this->getProgramResults();
        $data['last_three_results'] = $programResults['last_three_results'];
        $data['current_average'] = $programResults['current_average'];
        $data['historical_average'] = $programResults['historical_average'];
        
        // 2. Get top students data
        $topStudents = $this->getTopStudents();
        $data['top_students'] = $topStudents;
        
        // 3. Prepare data for graphs
        $data['program_performance_data'] = $this->getProgramPerformanceData();
        $data['average_grades_data'] = $this->getAverageGradesData();

        return view($this->view.'.index', $data);
    }

    /**
     * Get program results - last three and averages
     */
    protected function getProgramResults()
    {
        // Get the last three semesters' results
        $lastThreeSemesters = Semester::where('status', 1)
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();

        $lastThreeResults = [];
        $totalAverage = 0;
        $semesterCount = 0;

        foreach ($lastThreeSemesters as $semester) {
            // Calculate average for each semester
            $semesterAvg = DB::table('exams')
                ->select(DB::raw('AVG((achieve_marks / exam_types.marks) * 100) as avg_percentage'))
                ->leftJoin('exam_types', 'exams.exam_type_id', '=', 'exam_types.id')
                ->leftJoin('student_enrolls', 'exams.student_enroll_id', '=', 'student_enrolls.id')
                ->where('student_enrolls.semester_id', $semester->id)
                ->where('exam_types.marks', '>', 0)
                ->first();

            $average = $semesterAvg ? round($semesterAvg->avg_percentage, 2) : 0;
            
            $lastThreeResults[] = [
                'semester' => $semester->title,
                'average' => $average
            ];

            $totalAverage += $average;
            $semesterCount++;
        }

        // Calculate historical average (all semesters)
        $historicalAvg = DB::table('exams')
            ->select(DB::raw('AVG((achieve_marks / exam_types.marks) * 100) as avg_percentage'))
            ->leftJoin('exam_types', 'exams.exam_type_id', '=', 'exam_types.id')
            ->leftJoin('student_enrolls', 'exams.student_enroll_id', '=', 'student_enrolls.id')
            ->where('exam_types.marks', '>', 0)
            ->first();

        return [
            'last_three_results' => $lastThreeResults,
            'current_average' => count($lastThreeResults) > 0 ? $lastThreeResults[0]['average'] : 0,
            'historical_average' => $historicalAvg ? round($historicalAvg->avg_percentage, 2) : 0
        ];
    }

    /**
 * Get top 3 students by total marks (with program)
 */
protected function getTopStudents()
{
    $topStudents = DB::table('students')
        ->select(
            'students.id',
            'students.student_id',
            'students.first_name',
            'students.last_name',
            'programs.title as program', // Using 'title' instead of 'name'
            DB::raw('SUM(exams.achieve_marks) as total_marks'),
            DB::raw('AVG((exams.achieve_marks / exam_types.marks) * 100) as avg_percentage')
        )
        ->leftJoin('student_enrolls', 'students.id', '=', 'student_enrolls.student_id')
        ->leftJoin('exams', 'student_enrolls.id', '=', 'exams.student_enroll_id')
        ->leftJoin('exam_types', 'exams.exam_type_id', '=', 'exam_types.id')
        ->leftJoin('programs', 'student_enrolls.program_id', '=', 'programs.id')
        ->where('exam_types.marks', '>', 0)
        ->groupBy(
            'students.id',
            'students.student_id',
            'students.first_name',
            'students.last_name',
            'programs.title' // Changed to match the SELECT
        )
        ->orderBy('total_marks', 'desc')
        ->limit(3)
        ->get();

    return $topStudents;
}

    /**
     * Get program performance data for graph
     */
    protected function getProgramPerformanceData()
    {
        $performanceData = DB::table('programs')
            ->select(
                'programs.title as program_name',
                DB::raw('AVG((exams.achieve_marks / exam_types.marks) * 100) as avg_percentage')
            )
            ->leftJoin('student_enrolls', 'programs.id', '=', 'student_enrolls.program_id')
            ->leftJoin('exams', 'student_enrolls.id', '=', 'exams.student_enroll_id')
            ->leftJoin('exam_types', 'exams.exam_type_id', '=', 'exam_types.id')
            ->where('exam_types.marks', '>', 0)
            ->groupBy('programs.id', 'programs.title')
            ->orderBy('programs.title')
            ->get();

        $labels = [];
        $data = [];

        foreach ($performanceData as $item) {
            $labels[] = $item->program_name;
            $data[] = round($item->avg_percentage, 2);
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get average grades data for graph
     */
    protected function getAverageGradesData()
    {
        $grades = Grade::where('status', 1)
            ->orderBy('min_mark', 'desc')
            ->get();

        $gradeDistribution = DB::table('exams')
            ->select(
                'grades.title as grade_title',
                DB::raw('COUNT(*) as count')
            )
            ->selectRaw('(exams.achieve_marks / exam_types.marks) * 100 as percentage')
            ->leftJoin('exam_types', 'exams.exam_type_id', '=', 'exam_types.id')
            ->leftJoin('student_enrolls', 'exams.student_enroll_id', '=', 'student_enrolls.id')
            ->crossJoin('grades')
            ->whereRaw('(exams.achieve_marks / exam_types.marks) * 100 BETWEEN grades.min_mark AND grades.max_mark')
            ->where('exam_types.marks', '>', 0)
            ->groupBy('grades.title', 'percentage')
            ->get();

        $labels = [];
        $data = [];

        foreach ($grades as $grade) {
            $count = 0;
            foreach ($gradeDistribution as $dist) {
                if ($dist->grade_title == $grade->title) {
                    $count += $dist->count;
                }
            }
            
            $labels[] = $grade->title;
            $data[] = $count;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}