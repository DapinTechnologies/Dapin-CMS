<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use App\Models\Web\AboutUs;
use App\Models\Web\AboutUsHistory;
use App\Models\Web\AboutUsPartner;
use App\Models\Web\AboutUsAccreditation;

use App\Models\Language;
use Toastr;

class AboutUsController extends Controller
{
    use FileUploader;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title    = trans_choice('module_about_us', 1);
        $this->route    = 'admin.about-us';
        $this->view     = 'admin.web.about-us';
        $this->path     = 'about-us';
        $this->access   = 'about-us';

        $this->middleware('permission:'.$this->access.'-view');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title']  = $this->title;
        $data['route']  = $this->route;
        $data['view']   = $this->view;
        $data['path']   = $this->path;
        $data['access'] = $this->access;

        $data['row'] = AboutUs::where('language_id', Language::version()->id)
                        ->with(['histories', 'partners', 'accreditations'])
                        ->first();

        return view($this->view.'.index', $data);
    }


// Show history management page
public function histories()
{


    $data['title'] = 'Manage History Timeline';
    $data['route'] = 'admin.about-us.histories';
    $data['histories'] = AboutUsHistory::where('about_us_id', $this->getAboutUsId())->get();
   
 return view('admin.web.about-us.histories.index', $data);
}

// Save history items
public function saveHistories(Request $request)
{
    $validated = $request->validate([
        'year' => 'required|numeric|digits:4',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'order' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $history = new AboutUsHistory();
    
    if ($request->hasFile('image')) {
        $imageName = time().'_'.$request->image->getClientOriginalName();
        $request->image->move(public_path('uploads/about-us/history'), $imageName);
        $history->image = $imageName;
    }
    
    $history->fill($request->only(['year', 'title', 'description', 'order']));
    $history->about_us_id = 1;
    $history->save();

   return redirect()->route('admin.histories.index')
    ->with('success', 'History item added successfully');

}

public function edit($id)
{
    $history = AboutUsHistory::findOrFail($id);
    return view('admin.web.about-us.histories.edit', compact('history'));
}


public function update(Request $request, $id)
{
    // Validate the incoming request
    $validated = $request->validate([
        'year' => 'required|numeric|digits:4',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'order' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Find the history item by ID
    $history = AboutUsHistory::findOrFail($id);

    // Handle image removal
    if ($request->has('remove_image') && $history->image) {
        $oldImagePath = public_path('uploads/about-us/history/'.$history->image);
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
        $history->image = null;
    }

    // Handle new image upload
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($history->image) {
            $oldImagePath = public_path('uploads/about-us/history/'.$history->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Store the new image
        $imageName = time().'_'.$request->image->getClientOriginalName();
        $request->image->move(public_path('uploads/about-us/history'), $imageName);
        $history->image = $imageName;
    }

    // Update the fields
    $history->year = $request->year;
    $history->title = $request->title;
    $history->description = $request->description;
    $history->order = $request->order;
    $history->save();

    // Redirect back with success message
    return redirect()->route('admin.histories.index')->with('success', 'History item updated successfully');
}


// Delete history item
public function destroy($id)
{
    $history = AboutUsHistory::findOrFail($id);

    // Delete associated image if it exists
    if ($history->image) {
        $imagePath = public_path('uploads/about-us/history/'.$history->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $history->delete();

    return redirect()->back()->with('success', 'History item deleted successfully');
}

// Helper method to get about_us_id
protected function getAboutUsId()
{
    return AboutUs::where('language_id', Language::version()->id)->first()->id;
}

// Similar methods for partners and accreditations...
public function partners()
{
    $partners = AboutUsPartner::all();  // Fetch all partners
    return view('admin.web.about-us.partners.index', compact('partners'));
}


public function createPartner()
{
    return view('admin.web.about-us.partners.create');
}
public function storePartner(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
          'url' => 'required',
    ]);

    $partner = new AboutUsPartner();
    $partner->name = $request->name;
    $partner->description = $request->description;
  $partner->url = $request->url;
    // Handle logo upload if a logo is provided
    if ($request->hasFile('logo')) {
        $imageName = time().'_'.$request->logo->getClientOriginalName();
        $request->logo->move(public_path('uploads/about-us/partners'), $imageName);
        $partner->logo = $imageName;
    }

    $partner->save();

    return redirect()->route('admin.admin.about-us.partners')
        ->with('success', 'Partner added successfully');
}

public function editPartner($id)
{
    $partner = AboutUsPartner::findOrFail($id);  // Find the partner by ID
    return view('admin.web.about-us.partners.edit', compact('partner'));
}

public function updatePartner(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $partner = AboutUsPartner::findOrFail($id);

    $partner->name = $request->name;
    $partner->description = $request->description;

    // Handle logo upload if a new logo is provided
    if ($request->hasFile('logo')) {
        // Delete the old logo if exists
        if ($partner->logo) {
            $oldImagePath = public_path('uploads/about-us/partners/'.$partner->logo);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Store the new logo
        $imageName = time().'_'.$request->logo->getClientOriginalName();
        $request->logo->move(public_path('uploads/about-us/partners'), $imageName);
        $partner->logo = $imageName;
    }

    $partner->save();

    return redirect()->route('admin.admin.about-us.partners')
        ->with('success', 'Partner updated successfully');
}

public function destroyPartner($id)
{
    $partner = AboutUsPartner::findOrFail($id);

    // Delete associated logo if it exists
    if ($partner->logo) {
        $imagePath = public_path('uploads/about-us/partners/'.$partner->logo);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $partner->delete();

    return redirect()->route('admin.admin.about-us.partners')
        ->with('success', 'Partner deleted successfully');
}

public function accreditations()
{
    $accreditations = AboutUsAccreditation::all();  // Fetch all accreditations
    return view('admin.web.about-us.accreditations.index', compact('accreditations'));
}
public function createAccreditation()
{
    return view('admin.web.about-us.accreditations.create');
}
public function storeAccreditation(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $accreditation = new AboutUsAccreditation();
    $accreditation->name = $request->name;
    $accreditation->description = $request->description;

    // Handle logo upload if a logo is provided
    if ($request->hasFile('logo')) {
        $imageName = time().'_'.$request->logo->getClientOriginalName();
        $request->logo->move(public_path('uploads/about-us/accreditations'), $imageName);
        $accreditation->logo = $imageName;
    }

    $accreditation->save();

    return redirect()->route('admin.admin.about-us.accreditations')
        ->with('success', 'Accreditation added successfully');
}

public function editAccreditation($id)
{
    $accreditation = AboutUsAccreditation::findOrFail($id);  // Find the accreditation by ID
    return view('admin.web.about-us.accreditations.edit', compact('accreditation'));
}

public function updateAccreditation(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $accreditation = AboutUsAccreditation::findOrFail($id);
    $accreditation->name = $request->name;
    $accreditation->description = $request->description;

    // Handle logo upload if a new logo is provided
    if ($request->hasFile('logo')) {
        // Delete the old logo if exists
        if ($accreditation->logo) {
            $oldImagePath = public_path('uploads/about-us/accreditations/'.$accreditation->logo);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Store the new logo
        $imageName = time().'_'.$request->logo->getClientOriginalName();
        $request->logo->move(public_path('uploads/about-us/accreditations'), $imageName);
        $accreditation->logo = $imageName;
    }

    $accreditation->save();

    return redirect()->route('admin.admin.about-us.accreditations')
        ->with('success', 'Accreditation updated successfully');
}
public function destroyAccreditation($id)
{
    $accreditation = AboutUsAccreditation::findOrFail($id);

    // Delete associated logo if it exists
    if ($accreditation->logo) {
        $imagePath = public_path('uploads/about-us/accreditations/'.$accreditation->logo);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $accreditation->delete();

    return redirect()->route('admin.admin.about-us.accreditations')
        ->with('success', 'Accreditation deleted successfully');
}


























    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Log::info('Request Data:', $request->all());
    //dd($request->all()); // Temporary - remove after debugging
        // Field Validation
        $request->validate([
            'label' => 'required',
            'title' => 'required',
            'description' => 'required',
            'attach' => 'nullable|image',
            'histories.*.year' => 'required_if:histories.*.title,!=,null',
            'histories.*.title' => 'required_if:histories.*.year,!=,null',
            'partners.*.name' => 'required_if:partners.*.logo,!=,null',
            'accreditations.*.name' => 'required_if:accreditations.*.logo,!=,null',
        ]);

        $id = $request->id;

        // -1 means no data row found
        if($id == -1){
            // Insert Data
            $aboutUs = new AboutUs;
            $aboutUs->language_id = Language::version()->id;
            $aboutUs->label = $request->label;
            $aboutUs->title = $request->title;
            $aboutUs->short_desc = $request->short_desc;
            $aboutUs->description = $request->description;
            $aboutUs->button_text = $request->button_text;
            $aboutUs->video_id = $request->video_id;
            $aboutUs->attach = $this->uploadImage($request, 'attach', $this->path, null, 800);
            $aboutUs->vision_title = $request->vision_title;
            $aboutUs->vision_desc = $request->vision_desc;
            $aboutUs->mission_title = $request->mission_title;
            $aboutUs->mission_desc = $request->mission_desc;
            $aboutUs->save();

            $id = $aboutUs->id;
        }
        else{
            // Update Data
            $aboutUs = AboutUs::find($id);
            $aboutUs->label = $request->label;
            $aboutUs->title = $request->title;
            $aboutUs->short_desc = $request->short_desc;
            $aboutUs->description = $request->description;
            $aboutUs->button_text = $request->button_text;
            $aboutUs->video_id = $request->video_id;
            $aboutUs->attach = $this->updateImage($request, 'attach', $this->path, null, 800, $aboutUs, 'attach');
            $aboutUs->vision_title = $request->vision_title;
            $aboutUs->vision_desc = $request->vision_desc;
            $aboutUs->mission_title = $request->mission_title;
            $aboutUs->mission_desc = $request->mission_desc;
            $aboutUs->save();
        }

        // Save Histories
        $this->saveHistories($id, $request->histories ?? []);

        // Save Partners
        $this->savePartners($id, $request->partners ?? []);

        // Save Accreditations
        $this->saveAccreditations($id, $request->accreditations ?? []);

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }




}