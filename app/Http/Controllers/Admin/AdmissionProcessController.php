<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdmissionProcessStep;
class AdmissionProcessController extends Controller
{
    
public function index()
    {
        $steps = AdmissionProcessStep::all();
        return view('admin.admission.index', compact('steps'));
    }


  public function create()
    {
        return view('admin.admission.create');
    }

 public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|array',
        ]);

        AdmissionProcessStep::create([
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => json_encode($request->requirements),
        ]);

        return redirect()->route('admin.admission.process.index')->with('success', 'Process Step Created!');
    }

public function edit($id)
    {
        $step = AdmissionProcessStep::findOrFail($id);
        return view('admin.admission.edit', compact('step'));
    }

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'requirements' => 'required|array',
    ]);

    $step = AdmissionProcessStep::findOrFail($id);
    $step->update([
        'title' => $request->title,
        'description' => $request->description,
        'requirements' => json_encode($request->requirements),
    ]);

    return redirect()->route('admin.admission.process.index')->with('success', 'Process Step Updated!');
}


   public function destroy($id)
    {
        $step = AdmissionProcessStep::findOrFail($id);
        $step->delete();

        return redirect()->route('admin.admission.process.index')->with('success', 'Process Step Deleted!');
    }






}
