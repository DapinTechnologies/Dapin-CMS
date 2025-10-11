<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReceivableInvoice;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Toastr;
use Auth;

class ReceivableInvoiceController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_receivable_invoice', 1);
        $this->route = 'admin.receivable-invoice';
        $this->view = 'admin.receivable-invoice';
        $this->path = 'receivable-invoice';
        $this->access = 'receivable-invoice';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        // Search Filter
        $data['selected_payer_type'] = $request->payer_type ?? null;
        $data['selected_status'] = $request->status ?? null;

        $rows = ReceivableInvoice::with(['student', 'staff', 'createdBy']);
        
        if (!empty($request->payer_type)) {
            $rows->where('payer_type', $request->payer_type);
        }
        
        if (isset($request->status) && $request->status != '') {
            $rows->where('status', $request->status);
        }

        $data['rows'] = $rows->orderBy('id', 'desc')->get();

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        $data['students'] = Student::where('status', 1)->get();
        $data['staff'] = User::where('status', 1)->where('is_admin', 0)->get();
        $data['invoice_no'] = ReceivableInvoice::generateInvoiceNo();

        return view($this->view.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'invoice_no' => 'required|unique:receivable_invoices,invoice_no',
        'payer_type' => 'required|in:student,staff,outsider',
        'payer_id' => 'required_if:payer_type,student,staff',
        'payer_name' => 'required_if:payer_type,outsider',
        'title' => 'required',
        'amount' => 'required|numeric|min:0',
        'date' => 'required|date',
        'due_date' => 'nullable|date|after_or_equal:date',
    ]);

    // Determine payer_id based on payer_type
    $payerId = null;
    if ($request->payer_type === 'student') {
        $payerId = $request->payer_id_student ?? $request->payer_id;
    } elseif ($request->payer_type === 'staff') {
        $payerId = $request->payer_id_staff ?? $request->payer_id;
    }

    // Insert Data
    $invoice = new ReceivableInvoice;
    $invoice->invoice_no = $request->invoice_no;
    $invoice->payer_type = $request->payer_type;
    
    if ($request->payer_type === 'outsider') {
        $invoice->payer_name = $request->payer_name;
        $invoice->payer_email = $request->payer_email;
        $invoice->payer_phone = $request->payer_phone;
    } else {
        $invoice->payer_id = $payerId;
    }
    
    $invoice->title = $request->title;
    $invoice->amount = $request->amount;
    $invoice->date = $request->date;
    $invoice->due_date = $request->due_date;
    $invoice->description = $request->description;
    $invoice->status = $request->status ?? 1;
    $invoice->created_by = Auth::id();
    $invoice->save();

    Toastr::success(__('msg_created_successfully'), __('msg_success'));

    return redirect()->route($this->route.'.index');
}

    /**
     * Display the specified resource.
     */
    public function show(ReceivableInvoice $receivableInvoice)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = $receivableInvoice;

        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReceivableInvoice $receivableInvoice)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = $receivableInvoice;
        $data['students'] = Student::where('status', 1)->get();
        $data['staff'] = User::where('status', 1)->where('is_admin', 0)->get();

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReceivableInvoice $receivableInvoice)
    {
        $request->validate([
            'invoice_no' => 'required|unique:receivable_invoices,invoice_no,'.$receivableInvoice->id,
            'payer_type' => 'required|in:student,staff,outsider',
            'payer_id' => 'required_if:payer_type,student,staff',
            'payer_name' => 'required_if:payer_type,outsider',
            'title' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:date',
        ]);

        // Update Data
        $receivableInvoice->invoice_no = $request->invoice_no;
        $receivableInvoice->payer_type = $request->payer_type;
        
        if ($request->payer_type === 'outsider') {
            $receivableInvoice->payer_id = null;
            $receivableInvoice->payer_name = $request->payer_name;
            $receivableInvoice->payer_email = $request->payer_email;
            $receivableInvoice->payer_phone = $request->payer_phone;
        } else {
            $receivableInvoice->payer_id = $request->payer_id;
            $receivableInvoice->payer_name = null;
            $receivableInvoice->payer_email = null;
            $receivableInvoice->payer_phone = null;
        }
        
        $receivableInvoice->title = $request->title;
        $receivableInvoice->amount = $request->amount;
        $receivableInvoice->date = $request->date;
        $receivableInvoice->due_date = $request->due_date;
        $receivableInvoice->description = $request->description;
        $receivableInvoice->status = $request->status ?? 1;
        $receivableInvoice->updated_by = Auth::id();
        $receivableInvoice->save();

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReceivableInvoice $receivableInvoice)
    {
        // Check if invoice is used in any receivable
        if ($receivableInvoice->receivable()->exists()) {
            Toastr::error(__('msg_cannot_delete'), __('msg_error'));
            return redirect()->back();
        }

        $receivableInvoice->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Print invoice
     */
    public function print(ReceivableInvoice $receivableInvoice)
    {
        $data['title'] = $this->title;
        $data['row'] = $receivableInvoice;

        return view($this->view.'.print', $data);
    }

    /**
     * Get students for dropdown
     */
    public function getStudents()
    {
        $students = Student::where('status', 1)
            ->select('id', 'first_name', 'last_name', 'student_id', 'email', 'phone')
            ->get()
            ->map(function($student) {
                return [
                    'id' => $student->id,
                    'text' => $student->student_id . ' - ' . $student->first_name . ' ' . $student->last_name,
                    'email' => $student->email,
                    'phone' => $student->phone
                ];
            });

        return response()->json($students);
    }

    /**
     * Get staff for dropdown
     */
    public function getStaff()
    {
        $staff = User::where('status', 1)
            ->where('is_admin', 0)
            ->select('id', 'first_name', 'last_name', 'staff_id', 'email', 'phone')
            ->get()
            ->map(function($staff) {
                return [
                    'id' => $staff->id,
                    'text' => $staff->staff_id . ' - ' . $staff->first_name . ' ' . $staff->last_name,
                    'email' => $staff->email,
                    'phone' => $staff->phone
                ];
            });

        return response()->json($staff);
    }
}