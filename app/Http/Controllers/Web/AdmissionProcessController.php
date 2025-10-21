<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdmissionProcessStep;

class AdmissionProcessController extends Controller
{
    /**
     * Display the admission process page for public
     */
    public function process()
    {
        // Get all admission process steps
        $steps = AdmissionProcessStep::orderBy('id', 'asc')->get();

        // If no steps exist in database, use default data
        if ($steps->isEmpty()) {
            $steps = $this->getDefaultSteps();
        }

        return view('web.admission_process', compact('steps'));
    }

    /**
     * Display a listing of the resource (Admin)
     */
    public function index()
    {
        $steps = AdmissionProcessStep::orderBy('id', 'asc')->get();
        return view('admin.admission.index', compact('steps'));
    }

    /**
     * Show the form for creating a new resource (Admin)
     */
    public function create()
    {
        return view('admin.admission.create');
    }

    /**
     * Store a newly created resource (Admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|array',
            'requirements.*' => 'required|string|max:255'
        ]);

        AdmissionProcessStep::create([
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => json_encode($request->requirements),
        ]);

        return redirect()->route('admin.admission.process.index')->with('success', 'Admission process step created successfully!');
    }

    /**
     * Display the specified resource (Admin)
     */
    public function show($id)
    {
        $step = AdmissionProcessStep::findOrFail($id);
        return view('admin.admission.show', compact('step'));
    }

    /**
     * Show the form for editing the specified resource (Admin)
     */
    public function edit($id)
    {
        $step = AdmissionProcessStep::findOrFail($id);
        return view('admin.admission.edit', compact('step'));
    }

    /**
     * Update the specified resource (Admin)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|array',
            'requirements.*' => 'required|string|max:255'
        ]);

        $step = AdmissionProcessStep::findOrFail($id);
        $step->update([
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => json_encode($request->requirements),
        ]);

        return redirect()->route('admin.admission.process.index')->with('success', 'Admission process step updated successfully!');
    }

    /**
     * Remove the specified resource (Admin)
     */
    public function destroy($id)
    {
        $step = AdmissionProcessStep::findOrFail($id);
        $step->delete();

        return redirect()->route('admin.admission.process.index')->with('success', 'Admission process step deleted successfully!');
    }

    /**
     * Update the status of specified resource (Admin)
     */
    public function status(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|boolean'
        ]);

        $step = AdmissionProcessStep::findOrFail($id);
        $step->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    /**
     * Update the order of steps (Admin)
     */
public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'requirements' => 'required|string', // Change from array to string
    ]);

    $step = AdmissionProcessStep::findOrFail($id);
    
    // Convert textarea input to array
    $requirements = array_filter(
        array_map('trim', explode("\n", $request->requirements)),
        function($item) {
            return !empty($item);
        }
    );
    
    $step->update([
        'title' => $request->title,
        'description' => $request->description,
        'requirements' => json_encode($requirements),
    ]);

    return redirect()->route('admin.admission.process.index')->with('success', 'Admission process step updated successfully!');
}

    /**
     * Default steps if no data in database
     */
    private function getDefaultSteps()
    {
        return collect([
            (object)[
                'title' => 'Step 1: Online Application',
                'description' => 'Complete our online application form with your personal and academic details.',
                'requirements' => json_encode(['Fill online form', 'Upload documents', 'Pay application fee']),
                'order' => 1
            ],
            (object)[
                'title' => 'Step 2: Document Submission', 
                'description' => 'Submit all required academic documents and identification proofs.',
                'requirements' => json_encode(['Academic transcripts', 'ID copy', 'Passport photos']),
                'order' => 2
            ],
            (object)[
                'title' => 'Step 3: Interview & Admission',
                'description' => 'Attend the admission interview and receive your admission letter.',
                'requirements' => json_encode(['Schedule interview', 'Meet requirements', 'Receive offer']),
                'order' => 3
            ]
        ]);
    }
}