<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdmissionProcessStep;
class AdmissionController extends Controller
{
    
    public function index(){
  $steps = AdmissionProcessStep::all();
     return view('web.admission_process',compact('steps'));
}
}
