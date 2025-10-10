<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\ItemSupplier;
use Illuminate\Http\Request;
use Toastr;
use Auth;
use PDF;

class BillingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_billing', 1);
        $this->route = 'admin.billing';
        $this->view = 'admin.billing';
        $this->path = 'billing';
        $this->access = 'billing';

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
        $data['selected_supplier'] = $request->supplier ?? null;
        $data['selected_status'] = $request->status ?? null;

        $data['suppliers'] = ItemSupplier::where('status', 1)->get();

        $rows = Billing::with('supplier');
        
        if (!empty($request->supplier)) {
            $rows->where('supplier_id', $request->supplier);
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

        $data['suppliers'] = ItemSupplier::where('status', 1)->get();
        $data['billing_no'] = Billing::generateBillingNo();

        return view($this->view.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'billing_no' => 'required|unique:billings,billing_no',
            'supplier_id' => 'required',
            'title' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:date',
        ]);

        // Insert Data
        $billing = new Billing;
        $billing->billing_no = $request->billing_no;
        $billing->supplier_id = $request->supplier_id;
        $billing->title = $request->title;
        $billing->amount = $request->amount;
        $billing->date = $request->date;
        $billing->due_date = $request->due_date;
        $billing->description = $request->description;
        $billing->status = $request->status ?? 1;
        $billing->created_by = Auth::id();
        $billing->save();

        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Billing $billing)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = $billing;

        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Billing $billing)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = $billing;
        $data['suppliers'] = ItemSupplier::where('status', 1)->get();

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Billing $billing)
    {
        $request->validate([
            'billing_no' => 'required|unique:billings,billing_no,'.$billing->id,
            'supplier_id' => 'required',
            'title' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:date',
        ]);

        // Update Data
        $billing->billing_no = $request->billing_no;
        $billing->supplier_id = $request->supplier_id;
        $billing->title = $request->title;
        $billing->amount = $request->amount;
        $billing->date = $request->date;
        $billing->due_date = $request->due_date;
        $billing->description = $request->description;
        $billing->status = $request->status ?? 1;
        $billing->updated_by = Auth::id();
        $billing->save();

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Billing $billing)
    {
        // Check if billing is used in any payable
        if ($billing->payable()->exists()) {
            Toastr::error(__('msg_cannot_delete'), __('msg_error'));
            return redirect()->back();
        }

        $billing->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Print billing
     */
    /**
 * Print billing
 */
public function print(Billing $billing)
{
    $data['title'] = $this->title;
    $data['row'] = $billing;

    return view($this->view.'.print', $data);
}

}