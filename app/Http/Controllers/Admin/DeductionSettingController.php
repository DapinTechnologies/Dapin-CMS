<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeductionSetting;
use Toastr;

class DeductionSettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_deduction_setting', 1);
        $this->route = 'admin.deduction-setting';
        $this->view = 'admin.deduction-setting';
        $this->path = 'deduction-setting';
        $this->access = 'deduction-setting';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
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
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        
        $data['rows'] = DeductionSetting::orderBy('name', 'asc')->get();

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
            'name' => 'required|string|max:191|unique:deduction_settings,name',
            'type' => 'required|string|in:fixed,rate,tiered',
            'fixed_amount' => 'nullable|numeric|required_if:type,fixed',
            'rate' => 'nullable|numeric|required_if:type,rate',
            'min_salary' => 'nullable|numeric|required_if:type,rate',
            'max_salary' => 'nullable|numeric',
            'min_amount' => 'nullable|numeric|required_if:type,tiered',
            'max_amount' => 'nullable|numeric|required_if:type,tiered',
            'percentage' => 'nullable|numeric|required_if:type,tiered',
            'max_no_deduction_amount' => 'nullable|numeric',
            'description' => 'nullable|string'
        ]);

        // Insert Data
        $deductionSetting = new DeductionSetting;
        $deductionSetting->name = $request->name;
        $deductionSetting->type = $request->type;
        $deductionSetting->fixed_amount = $request->fixed_amount;
        $deductionSetting->rate = $request->rate;
        $deductionSetting->min_salary = $request->min_salary;
        $deductionSetting->max_salary = $request->max_salary;
        $deductionSetting->min_amount = $request->min_amount;
        $deductionSetting->max_amount = $request->max_amount;
        $deductionSetting->percentage = $request->percentage;
        $deductionSetting->max_no_deduction_amount = $request->max_no_deduction_amount;
        $deductionSetting->is_statutory = $request->is_statutory ?? 1;
        $deductionSetting->description = $request->description;
        $deductionSetting->save();

        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeductionSetting  $deductionSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeductionSetting $deductionSetting)
    {
        // Field Validation
        $request->validate([
            'name' => 'required|string|max:191|unique:deduction_settings,name,'.$deductionSetting->id,
            'type' => 'required|string|in:fixed,rate,tiered',
            'fixed_amount' => 'nullable|numeric|required_if:type,fixed',
            'rate' => 'nullable|numeric|required_if:type,rate',
            'min_salary' => 'nullable|numeric|required_if:type,rate',
            'max_salary' => 'nullable|numeric',
            'min_amount' => 'nullable|numeric|required_if:type,tiered',
            'max_amount' => 'nullable|numeric|required_if:type,tiered',
            'percentage' => 'nullable|numeric|required_if:type,tiered',
            'max_no_deduction_amount' => 'nullable|numeric',
            'description' => 'nullable|string'
        ]);

        // Update Data
        $deductionSetting->name = $request->name;
        $deductionSetting->type = $request->type;
        $deductionSetting->fixed_amount = $request->fixed_amount;
        $deductionSetting->rate = $request->rate;
        $deductionSetting->min_salary = $request->min_salary;
        $deductionSetting->max_salary = $request->max_salary;
        $deductionSetting->min_amount = $request->min_amount;
        $deductionSetting->max_amount = $request->max_amount;
        $deductionSetting->percentage = $request->percentage;
        $deductionSetting->max_no_deduction_amount = $request->max_no_deduction_amount;
        $deductionSetting->is_statutory = $request->is_statutory ?? 1;
        $deductionSetting->status = $request->status;
        $deductionSetting->description = $request->description;
        $deductionSetting->save();

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeductionSetting  $deductionSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeductionSetting $deductionSetting)
    {
        //Delete Data
        $deductionSetting->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}