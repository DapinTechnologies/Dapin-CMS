<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\EnrollSubject;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Program;
use App\Models\Section;
use App\Models\Subject;
use App\Models\StudentEnroll;
use App\Models\StudentSubject;
use Toastr;

class StudentSubjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_student_subject', 1);
        $this->route = 'student.subject';
        $this->view = 'student.student-subject'; // Updated to match your directory structure
        $this->path = 'subject';
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

        // Get current student's active enrollment
        $data['enroll'] = StudentEnroll::where('student_id', auth()->id())
                            ->where('status', '1')
                            ->first();
        
        if(isset($data['enroll'])){
            // Get available subjects for the student's program/semester/section
            $enroll_subject = EnrollSubject::where('program_id', $data['enroll']->program_id)
                                ->where('semester_id', $data['enroll']->semester_id)
                                ->where('section_id', $data['enroll']->section_id)
                                ->first();
            
            if(isset($enroll_subject)){
                $data['available_subjects'] = $enroll_subject->subjects()->where('status', '1')->get();
            }
            
            // Get already enrolled subjects
            $data['enrolled_subjects'] = StudentSubject::where('student_enroll_id', $data['enroll']->id)
                                        ->with('subject')
                                        ->get();
        }

        return view($this->view.'.index', $data);
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
            'subjects' => 'required',
            'student_enroll_id' => 'required',
        ]);

        // Get current enrollment
        $enroll = StudentEnroll::findOrFail($request->student_enroll_id);

        // Check if subjects are already registered
        foreach($request->subjects as $subject_id){
            $exist = StudentSubject::where('student_enroll_id', $enroll->id)
                        ->where('subject_id', $subject_id)
                        ->first();
            
            if(!$exist){
                // Insert Data
                $studentSubject = new StudentSubject();
                $studentSubject->student_enroll_id = $enroll->id;
                $studentSubject->subject_id = $subject_id;
                $studentSubject->save();
            }
        }

        Toastr::success(__('msg_enrolled_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete Data
        $studentSubject = StudentSubject::findOrFail($id);
        $studentSubject->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}