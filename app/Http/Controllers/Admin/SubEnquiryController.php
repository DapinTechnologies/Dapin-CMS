<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubEnquiry;
use Illuminate\Http\Request;


class SubEnquiryController extends Controller
{
    public function index()
    {
        $enquiries = SubEnquiry::latest()->paginate(20);
        return view('admin.subenquiries.index', compact('enquiries'));
    }

    public function show($id)
    {
        $entry = SubEnquiry::findOrFail($id);
        return view('admin.subenquiries.show', compact('entry'));
    }

    public function destroy($id)
    {
        SubEnquiry::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Entry deleted successfully.');
    }
}

