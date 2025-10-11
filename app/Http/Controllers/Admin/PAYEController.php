<?php
// app/Http/Controllers/Admin/PAYEController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PAYESetting;
use Illuminate\Http\Request;

class PAYEController extends Controller
{
    public function index()
    {
        $data['title'] = 'PAYE Tax Bands';
        $data['payeSettings'] = PAYESetting::orderBy('order')->get();
        return view('admin.payroll.paye_index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|min:0',
            'rate' => 'required|numeric|min:0|max:100',
            'order' => 'required|integer'
        ]);

        PAYESetting::create($request->all());
        return redirect()->back()->with('success', 'PAYE band added successfully');
    }

    public function update(Request $request, $id)
    {
        $setting = PAYESetting::findOrFail($id);
        $request->validate([
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|min:0',
            'rate' => 'required|numeric|min:0|max:100',
            'order' => 'required|integer'
        ]);

        $setting->update($request->all());
        return redirect()->back()->with('success', 'PAYE band updated successfully');
    }
}