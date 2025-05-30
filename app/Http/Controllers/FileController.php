<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\File;
use App\Models\User;
use App\Models\Student;
use App\Models\Material;
use App\Models\Category;
use Auth;
use Str;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf;
class FileController extends Controller
{
    public function index(){
        $title = 'Digital Library';
        $access = 'library';
        $rows= 'row';

        $materials = Material::latest()->get();

        $categories = Category::withCount('materials')->get();
        
        return view('admin.files.index', compact('title','access','rows','categories','materials'));
    }
   
public function Catecreate(){
    //dd('Catecreate');
    $categories = Category::all();
    return view('admin.files.addcate',compact('categories'));
}



public function Catestore(Request $request){

//dd($request->all());
    
    $request->validate([
        'name' => 'required|string|max:255',
         ]); 
         $category = new Category(); 
         $category->name = $request->name;
          $category->description = $request->description;
    $category->save();
    return redirect()->route('alldigitalbooks')->with('success', 'Category added successfully.'); 



}

public function CateEdit($id){
    //dd($id);
{ $category = Category::findOrFail($id); 
    $categories = Category::all();
     return view('admin.files.editcate', compact('category', 'categories'));
}

}

public function CateUpdate(Request $request,$id){
   // dd($request->all());
    $request->validate([ 
        'name' => 'required|string|max:255',
     ]);
     $category = Category::findOrFail($id);
      $category->name = $request->name;
       $category->description = $request->description;
     $category->save(); return redirect()->route('alldigitalbooks')->with('success', 'Category updated successfully.');
}

public function destroyCate($id){
    $category = Category::findOrFail($id);
     $category->delete(); 
     return redirect()->route('alldigitalbooks')->with('success', 'Category deleted successfully.');
     }


     public function store(Request $request)
     {
         // Validate the request
         $request->validate([
             'title' => 'required|string|max:255',
             'description' => 'nullable|string',
             'category_id' => 'required|exists:categories,id',
             'type' => 'required|string|in:PDF,Video,Doc,Image',
             'file_path' => 'required|file|mimes:pdf,mp4,jpg,jpeg,png,doc,docx|max:20480', // Max 20MB
             'thumbnail' => 'required|image|mimes:jpg,jpeg,png|max:5120', // Max 5MB
             'author' => 'nullable|string|max:255',
             'publisher' => 'nullable|string|max:255',
             'language' => 'nullable|string|max:255',
             'edition' => 'nullable|string|max:255',
             'isbn' => 'nullable|string|max:255',
             'is_public' => 'nullable|boolean',
             'is_downloadable' => 'nullable|boolean', // Add field for download control
         ]);
     
         $titleSlug = Str::slug($request->title);
         $fileExtension = $request->file('file_path')->getClientOriginalExtension();
         $thumbnailExtension = $request->file('thumbnail')->getClientOriginalExtension();
     
         // Define paths
         $materialsPath = public_path('uploads/materials');
         $thumbnailsPath = public_path('uploads/thumbnails');
     
         // Ensure directories exist
         if (!file_exists($materialsPath)) {
             mkdir($materialsPath, 0777, true);
         }
         if (!file_exists($thumbnailsPath)) {
             mkdir($thumbnailsPath, 0777, true);
         }
     
         // Define file storage locations
         $filePath = "uploads/materials/{$titleSlug}.{$fileExtension}";
         $thumbnailPath = "uploads/thumbnails/{$titleSlug}.{$thumbnailExtension}";
     
         // Move uploaded files to respective directories
         $request->file('file_path')->move($materialsPath, "{$titleSlug}.{$fileExtension}");
         $request->file('thumbnail')->move($thumbnailsPath, "{$titleSlug}.{$thumbnailExtension}");
     
         // Save material details in the database
         $material = new Material();
         $material->title = $request->title;
         $material->description = $request->description;
         $material->category_id = $request->category_id;
         $material->type = $request->type;
         $material->file_path = $filePath; // Save relative path
         $material->thumbnail = $thumbnailPath; // Save relative path
         $material->author = $request->author;
         $material->publisher = $request->publisher;
         $material->language = $request->language;
         $material->edition = $request->edition;
         $material->isbn = $request->isbn;
         $material->is_public = $request->is_public ?? false; // Default to false if not checked
         //$material->is_downloadable = $request->is_downloadable ?? true; // Default to true (downloadable)
         $material->is_downloadable = $request->has('is_downloadable');

         $material->uploaded_by = Auth::id();
         $material->save();
     
         return redirect()->route('alldigitalbooks')->with('success', 'Material added successfully.');
     }
     
     public function EditFile($id){
        //dd($id);
        $material = Material::findOrFail($id);
        $categories = Category::all();
        return view('admin.files.editmaterial',compact('material', 'categories'));

     }
     public function MaterialUpdate(Request $request, $id)
     {
         // Validate the request
         $request->validate([
             'title' => 'required|string|max:255',
             'description' => 'nullable|string',
             'category_id' => 'required|exists:categories,id',
             'type' => 'required|string',
             'file_path' => 'nullable|file',
             'thumbnail' => 'nullable|image',
             'author' => 'nullable|string|max:255',
             'publisher' => 'nullable|string|max:255',
             'language' => 'nullable|string|max:255',
             'edition' => 'nullable|string|max:255',
             'isbn' => 'nullable|string|max:255',
             'is_public' => 'nullable|boolean',
             'is_downloadable' => 'nullable|boolean', // Validation for downloadable field
         ]);
     
         $material = Material::findOrFail($id);
     
         // Update fields
         $material->title = $request->title;
         $material->description = $request->description;
         $material->category_id = $request->category_id;
         $material->type = $request->type;
         $material->author = $request->author;
         $material->publisher = $request->publisher;
         $material->language = $request->language;
         $material->edition = $request->edition;
         $material->isbn = $request->isbn;
         $material->is_public = $request->is_public;
        // $material->is_downloadable = $request->is_downloadable ?? true; // Default to true (downloadable)

        $material->is_downloadable = $request->has('is_downloadable');
     
         // Handle file updates
         $titleSlug = Str::slug($request->title);
     
         if ($request->hasFile('file_path')) {
             // Move new file
             $fileExtension = $request->file('file_path')->getClientOriginalExtension();
             $fileName = $titleSlug . '.' . $fileExtension;
             $filePath = "uploads/materials/{$fileName}";
             $request->file('file_path')->move(public_path('uploads/materials'), $fileName);
     
             // Update file path
             $material->file_path = $filePath;
         }
     
         if ($request->hasFile('thumbnail')) {
             // Move new thumbnail
             $thumbnailExtension = $request->file('thumbnail')->getClientOriginalExtension();
             $thumbnailName = $titleSlug . '.' . $thumbnailExtension;
             $thumbnailPath = "uploads/thumbnails/{$thumbnailName}";
             $request->file('thumbnail')->move(public_path('uploads/thumbnails'), $thumbnailName);
     
             // Update thumbnail path
             $material->thumbnail = $thumbnailPath;
         }
     
         // Save updates
         $material->save();
     
         return redirect()->route('alldigitalbooks')->with('success', 'Material updated successfully.');
     }
     
        

public function ShowMaterial($id){
  //  dd($id);
  $material = Material::findOrFail($id);
  return view('admin.files.showmaterial',compact('material'));
}
public function destroy($id){
    //dd($id);

    $material = Material::findOrFail($id);

    // Delete associated files
    if (file_exists(public_path($material->file_path))) {
        unlink(public_path($material->file_path));
    }

    if (file_exists(public_path($material->thumbnail))) {
        unlink(public_path($material->thumbnail));
    }

    // Delete material record
    $material->delete();

    return redirect()->back()->with('success', 'Material deleted successfully.');
}

// public function Home(){
//     //dd('Home');

//     $materials = Material::orderBy('created_at', 'desc')->get();
//     return view('web.file.show', compact('materials'));
// }
       
 public function ViewHome($id){
//    // dd($id);
    $material = Material::findOrFail($id);
    return view('web.file.book', compact('material'));
 }
public function Home(Request $request)
{
    $query = $request->input('query');

    if ($query) {
        $materials = Material::where('title', 'like', '%' . $query . '%')
            ->orWhere('author', 'like', '%' . $query . '%')
            ->orderBy('created_at', 'desc')
            ->get();
    } else {
        $materials = Material::orderBy('created_at', 'desc')->get();
    }

    return view('web.file.show', compact('materials', 'query'));
}




// public function download($id){
//     $material = Material::findOrFail($id);

//     $filePath = public_path('uploads/materials/' . $material->file_path);

//     if (!file_exists($filePath)) {
//         return abort(404, 'File not found.');
//     }

//     // Force the file to be downloaded
//     return response()->download($filePath, $material->title);

// }
public function downloadFile($id)
{
    $user = auth()->guard('student')->user();

    if (!$user) {
        return redirect()->route('student.login')->with('error', 'Please log in to download this file.');
    }

    $material = Material::findOrFail($id);

    // Only allow private files to authenticated users
    if (!$material->is_public && !$user) {
        return abort(403, 'Unauthorized access.');
    }

    $filePath = public_path('uploads/materials/' . $material->file_path);

    if (!file_exists($filePath)) {
        return abort(404, 'File not found.');
    }

    return response()->download($filePath, $material->title);
}


// public function StudentDigitalHome(Request $request){
//     //dd('StudentDigitalHome');
//     $query = Material::whereNull('is_public');

//         // If a search term is provided
//         if ($request->has('search') && !empty($request->search)) {
//             $search = $request->search;
//             $query->where(function ($q) use ($search) {
//                 $q->where('title', 'LIKE', "%{$search}%")
//                   ->orWhere('author', 'LIKE', "%{$search}%")
//                   ->orWhere('publisher', 'LIKE', "%{$search}%")
//                   ->orWhere('language', 'LIKE', "%{$search}%");
//             });
//         }

//         $materials = $query->orderBy('created_at', 'desc')->get();


// //dd($materials);







public function AllDigitalBook()
{
    // Fetch all materials ordered by creation date
    $materials = Material::orderBy('created_at', 'desc')->get();

  //dd($materials);
    return view('student.digital.index', compact('materials'));
}



public function searchdigitalbook(Request $request)
{
    $query = $request->input('query');

    $materials = Material::when($query, function ($queryBuilder) use ($query) {
        $queryBuilder->where('title', 'like', "%$query%")
            ->orWhere('author', 'like', "%$query%")
            ->orWhere('publisher', 'like', "%$query%");
    })->get();

    return view('student.digital.index', compact('materials'));
}




public function viewdigitalSingle($id){
    //dd($id);

    $material = Material::findOrFail($id);
    //dd($material);
    return view('student.digital.view', compact('material'));

}
public function download($id)
{
    $material = Material::findOrFail($id);

    if (!$material->is_public) {
        abort(403, 'You do not have access to download this material.');
    }

    $filePath = $material->file_path;

    if (!Storage::exists($filePath)) {
        abort(404, 'File not found.');
    }

    return response()->download(storage_path("app/{$filePath}"), $material->title . '.' . pathinfo($filePath, PATHINFO_EXTENSION));
}
public function create()
{
    return view('web.file.materials.create');
}


public function storefile(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'file' => 'required|mimes:pdf|max:2048',
    ]);

    $file = $request->file('file');
    $fileName = time() . '-' . $file->getClientOriginalName();
    $filePath = $file->storeAs('public/uploads/pdfs', $fileName);

    // Store material in database
    $material = Material::create([
        'title' => $request->input('title'),
        'type' => 'PDF',
        'file_path' => $filePath,
        'category_id' => $request->input('category_id'),
    ]);

    // Convert PDF to images
    $outputDir = storage_path('app/public/uploads/pdf_images/' . pathinfo($fileName, PATHINFO_FILENAME));
    if (!file_exists($outputDir)) {
        mkdir($outputDir, 0755, true);
    }

    $pdf = new Pdf(storage_path('app/' . $filePath));
    $pdf->saveAllPagesAsImages($outputDir);

    return redirect()->route('materials.index')->with('success', 'Material uploaded and processed successfully!');
}

public function allpdfs()
{
    $materials = Material::where('type', 'PDF')->get();
    return view('web.file.materials.index', compact('materials'));
}

public function allpdfshow($id)
{
    $material = Material::findOrFail($id);
    $imageDir = storage_path('app/public/pdf_images/' . pathinfo($material->file_path, PATHINFO_FILENAME));
    $images = file_exists($imageDir) ? array_map('basename', glob($imageDir . '/*.jpg')) : [];

    return view('materials.show', compact('material', 'images'));
}



}


