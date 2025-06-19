<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use App\Models\Director;
use App\Models\Web\AboutUs; // ✅ CORRECT

 use Illuminate\Support\Facades\Storage;
class DirectorController extends Controller
{
    
    public function index()
    {
        $director = Director::first(); // Fetch only one director (not an array)
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
            // Generate a unique filename
            $filename = time().'_'.$image->getClientOriginalName();
    
            // Move the file to the public/uploads/director directory
            $image->move(public_path('uploads/director'), $filename);
    
            // Set the path relative to public
            $imagePath = 'uploads/director/' . $filename;
        }
    
        // Store the director details in the database
        Director::create([
            'name' => $request->name,
            'title' => $request->title,
            'message' => $request->message,
            'image' => $imagePath, // Save the image path
        ]);
    
        return redirect()->route('directors.index')->with('success', 'Director message added successfully.');
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
        // Delete the old image from public if it exists
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

    return redirect()->route('directors.index')->with('success', 'Director message updated successfully.');
}

public function About(){
    //dd('About');
   $about = \App\Models\Web\AboutUs::find(1);

    return view('web.about',compact('about'));
}





}