<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    // Show the statistics page
    public function index()
    {
        $statistics = Statistic::all();
        return view('admin.statistics.index', compact('statistics'));
    }

    // Show form to create a new statistic
    public function create()
    {
        return view('admin.statistics.create');
    }

    // Store a new statistic
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'count' => 'required|integer',
            'icon' => 'required|string|max:255',
        'icon_color' => 'required|string|in:primary,success,warning,danger,secondary'
        ]);

        Statistic::create($request->all());

        return redirect()->route('admin.statistics.index')->with('success', 'Statistic added successfully');
    }

    // Show form to edit an existing statistic
    public function edit($id)
    {
        $statistic = Statistic::findOrFail($id);
        return view('admin.statistics.edit', compact('statistic'));
    }

    // Update an existing statistic
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'count' => 'required|integer',
               'icon' => 'required|string|max:255',
        'icon_color' => 'required|string|in:primary,success,warning,danger,secondary'
        ]);

        $statistic = Statistic::findOrFail($id);
        $statistic->update($request->all());

        return redirect()->route('admin.statistics.index')->with('success', 'Statistic updated successfully');
    }

    // Delete a statistic
    public function destroy($id)
    {
        $statistic = Statistic::findOrFail($id);
        $statistic->delete();

        return redirect()->route('admin.statistics.index')->with('success', 'Statistic deleted successfully');
    }
}
