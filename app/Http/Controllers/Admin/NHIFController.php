<?php
// app/Http/Controllers/Admin/NHIFController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NHIFSetting;
use Illuminate\Http\Request;

class NHIFController extends Controller
{
    public function index()
    {
        $data['title'] = 'NHIF Settings';
        $data['nhifSettings'] = NHIFSetting::orderBy('min_amount')->get();
        return view('admin.payroll.nhif_index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|min:0|gte:min_amount',
            'premium' => 'required|numeric|min:0'
        ]);

        NHIFSetting::create($request->all());
        return redirect()->back()->with('success', 'NHIF band added successfully');
    }

    public function update(Request $request, $id)
    {
        $setting = NHIFSetting::findOrFail($id);
        $request->validate([
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|min:0|gte:min_amount',
            'premium' => 'required|numeric|min:0'
        ]);

        $setting->update($request->all());
        return redirect()->back()->with('success', 'NHIF band updated successfully');
    }

    public function destroy($id)
    {
        $setting = NHIFSetting::findOrFail($id);
        $setting->delete();
        return redirect()->back()->with('success', 'NHIF band deleted successfully');
    }
}