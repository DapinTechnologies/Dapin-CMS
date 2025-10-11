<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;
use App\Models\FeesCategory;
use App\Models\Student;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Setting;
use Auth;

class FeesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_fees_report', 1);
        $this->route = 'student.fees';
        $this->view = 'student.fees';
        $this->path = 'fees';
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

    // Get authenticated student
    $data['user'] = $user = Auth::guard('student')->user();
    $data['setting'] = Setting::first();

    // Get filter options
    $data['sessions'] = StudentEnroll::where('student_id', $user->id)
        ->with('session')
        ->groupBy('session_id')
        ->get();

    $data['semesters'] = StudentEnroll::where('student_id', $user->id)
        ->with('semester')
        ->groupBy('semester_id')
        ->get();

    $data['categories'] = FeesCategory::where('status', '1')
        ->orderBy('title', 'asc')
        ->get();

    // Set selected filters
    $data['selected_session'] = $session = $request->session ?? '0';
    $data['selected_semester'] = $semester = $request->semester ?? '0';
    $data['selected_category'] = $category = $request->category ?? '0';

    // Get invoices with related data
    $invoices = Invoice::with([
            'studentEnroll.session',
            'studentEnroll.semester',
            'studentEnroll.student',
            'fees.category',
            'payments' => function($query) {
                $query->where('status', 'completed');
            }
        ])
        ->whereHas('studentEnroll', function ($query) use ($user, $session, $semester) {
            $query->where('student_id', $user->id);
            if ($session != '0') {
                $query->where('session_id', $session);
            }
            if ($semester != '0') {
                $query->where('semester_id', $semester);
            }
        });

    // Filter by category if selected
    if ($category != '0') {
        $invoices->whereHas('fees', function($query) use ($category) {
            $query->where('category_id', $category);
        });
    }

    $data['invoices'] = $invoices->orderBy('assign_date', 'desc')->get();

    return view($this->view.'.index', $data);
}

    /**
     * Display payment form for specific fee.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pay($id)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $user = Auth::guard('student')->user()->id;

        // Get fee with validation
        $fee = Fee::where('id', $id)
            ->with('studentEnroll')
            ->whereHas('studentEnroll', function ($query) use ($user) {
                $query->where('student_id', $user);
            })
            ->where('status', '<', '1')
            ->firstOrFail();

        $data['row'] = $fee;
        $data['setting'] = Setting::first();

        return view($this->view.'.pay', $data);
    }
}