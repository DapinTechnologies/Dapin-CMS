<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdmissionProcessStep;
class AdmissionProcessController extends Controller
{
        public function process()
    {
        // Get all admission process steps
        $steps = AdmissionProcessStep::orderBy('id', 'asc')->get();

        // If no steps exist in database, use default data
        if ($steps->isEmpty()) {
            $steps = $this->getDefaultSteps();
        }
        //dd('Admission');

        return view('web.admission_process', compact('steps'));
    }

}
