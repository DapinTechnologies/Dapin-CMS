<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reason;
class ReasonController extends Controller
{
    
 public function index()
    {
        $reasons = Reason::all();
        return view('admin.web.reasons.index', compact('reasons'));
    }

    // Show form to create a new reason
    public function create()
    {
        return view('admin.web.reasons.create');
    }

public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
        ]);

        Reason::create($validated);

        return redirect()->route('admin.admin.reasons.index')->with('success', 'Reason added successfully!');
    }

    // Show form to edit an existing reason
    public function edit($id)
    {
        $reason = Reason::findOrFail($id);
        return view('admin.web.reasons.edit', compact('reason'));
    }



  public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
        ]);

        $reason = Reason::findOrFail($id);
        $reason->update($validated);

        return redirect()->route('admin.admin.reasons.index')->with('success', 'Reason updated successfully!');
    }




 public function destroy($id)
    {
        $reason = Reason::findOrFail($id);
        $reason->delete();

        return redirect()->route('admin.admin.reasons.index')->with('success', 'Reason deleted successfully!');
    }










}
