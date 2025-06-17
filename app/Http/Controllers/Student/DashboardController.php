<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentAssignment;
use App\Models\StudentEnroll;
use App\Models\ClassRoutine;
use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Event;
use App\Models\Notice;
use Carbon\Carbon;
use Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_dashboard', 1);
        $this->route = 'student.dashboard';
        $this->view = 'student';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        $student_id = Auth::guard('student')->user()->id;
        $current_session = Session::where('status', '1')->where('current', '1')->first();

        // Initialize enrollment data
        $session_id = null;
        $program_id = null;
        $semester_id = null;
        $section_id = null;

        if(isset($current_session)){
            $enroll = StudentEnroll::where('student_id', $student_id)
                            ->where('session_id', $current_session->id)
                            ->where('status', '1')
                            ->first();

            if(isset($enroll)){
                $session_id = $enroll->session_id;
                $semester_id = $enroll->semester_id;
                $program_id = $enroll->program_id;
                $section_id = $enroll->section_id;
            }
        }

        // Assignments
        if(isset($enroll)){
            $assignments = StudentAssignment::with('studentEnroll')->whereHas('studentEnroll', function ($query) use ($student_id, $session_id, $semester_id){
                $query->where('student_id', $student_id);
                $query->where('session_id', $session_id);
                $query->where('semester_id', $semester_id);
            });
            $assignments->with('assignment')->whereHas('assignment', function ($query){
                $query->where('start_date', '<=', Carbon::today());
            });

            $data['assignments'] = $assignments->orderBy('id', 'desc')->limit(10)->get();
        }

        // Events
        $data['events'] = Event::where('status', '1')->orderBy('id', 'asc')->get();
        $data['latest_events'] = Event::where('status', '1')
                                ->where('end_date', '>=', Carbon::today())
                                ->orderBy('start_date', 'asc')
                                ->limit(10)
                                ->get();

        // Notices
        $data['latest_notices'] = Notice::where('status', '1')
                                    ->where('date', '<=', Carbon::today())
                                    ->orderBy('date', 'desc')
                                    ->limit(5)
                                    ->get();

        // Today's Classes (using ClassRoutine model)
        if(isset($enroll)){
            // Get current day (1=Saturday, 2=Sunday, etc.)
            $currentDay = Carbon::now()->dayOfWeek + 2;
            if($currentDay > 7) $currentDay = 1;
            
            $data['today_classes'] = ClassRoutine::with(['subject', 'teacher', 'room'])
                ->where('status', '1')
                ->where('session_id', $session_id)
                ->where('program_id', $program_id)
                ->where('semester_id', $semester_id)
               
                ->where('section_id', $section_id)
                ->where('day', $currentDay)
                ->orderBy('start_time', 'asc')
                ->get();
        } else {
            $data['today_classes'] = collect(); // Empty collection if no enrollment
        }

        return view($this->view.'.index', $data);
    }
}
