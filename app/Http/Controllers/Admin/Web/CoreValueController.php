<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;

use App\Models\CoreValue;
use Illuminate\Http\Request;

class CoreValueController extends Controller
{
    // Show all core values
    public function index()
    {
        $values = CoreValue::all();
        return view('admin.web.about-us.core-values.index', compact('values'));
    }

    // Show form to create a new core value
    public function create()
    {
        return view('admin.web.about-us.core-values.create');
    }

    // Store a new core value in the database
    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        CoreValue::create($request->all());

        return redirect()->route('admin.core-values.index')->with('success', 'Core value added successfully');
    }

    // Show form to edit a core value
    public function edit($id)
    {
        $value = CoreValue::findOrFail($id);
        return view('admin.web.about-us.core-values.edit', compact('value'));
    }

    // Update a core value
    public function update(Request $request, $id)
    {
        $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $value = CoreValue::findOrFail($id);
        $value->update($request->all());

        return redirect()->route('admin.core-values.index')->with('success', 'Core value updated successfully');
    }

    // Delete a core value
    public function destroy($id)
    {
        $value = CoreValue::findOrFail($id);
        $value->delete();

        return redirect()->route('admin.core-values.index')->with('success', 'Core value deleted successfully');
    }
}
