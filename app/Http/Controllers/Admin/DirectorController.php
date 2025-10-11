<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Director;
use App\Models\Web\AboutUs;
use Illuminate\Support\Facades\Storage;

class DirectorController extends Controller
{
    public function index()
    {
        $director = Director::first(); // Fetch the first director
        return view('admin.director.index', compact('director'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/director'), $filename);
            $imagePath = 'uploads/director/' . $filename;
        }

        Director::create([
            'name' => $request->name,
            'title' => $request->title,
            'message' => $request->message,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.directors.index')->with('success', 'Director message added successfully.');
    }

    public function update(Request $request, $id)
    {
        $director = Director::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($director->image && file_exists(public_path($director->image))) {
                unlink(public_path($director->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/director'), $filename);
            $director->image = 'uploads/director/' . $filename;
        }

        $director->update([
            'name' => $request->name,
            'title' => $request->title,
            'message' => $request->message,
            'image' => $director->image,
        ]);

        return redirect()->route('admin.directors.index')->with('success', 'Director message updated successfully.');
    }

    public function About()
    {
        $about = AboutUs::find(1);
        return view('web.about', compact('about'));
    }
}
