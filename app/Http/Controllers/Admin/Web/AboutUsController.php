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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Log::info('Request Data:', $request->all());
dd($request->all()); // Temporary - remove after debugging
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

    /**
     * Save History Items
     */
    protected function saveHistories($aboutUsId, $histories)
    {
     
        $existingIds = [];
        
        foreach ($histories as $history) {
            if (!empty($history['year']) && !empty($history['title'])) {
                $data = [
                    'about_us_id' => $aboutUsId,
                    'year' => $history['year'],
                    'title' => $history['title'],
                    'description' => $history['description'] ?? null,
                ];

                if (isset($history['id']) && !empty($history['id'])) {
                    // Update existing
                    $record = AboutUsHistory::find($history['id']);
                    if ($record) {
                        // Handle image upload
                        if (isset($history['image'])) {
                            $data['image'] = $this->updateImage(
                                new Request(['image' => $history['image']]), 
                                'image', 
                                $this->path.'/history', 
                                null, 
                                null, 
                                $record, 
                                'image'
                            );
                        }
                        
                        $record->update($data);
                        $existingIds[] = $record->id;
                    }
                } else {
                    // Create new
                    $record = new AboutUsHistory($data);
                    
                    // Handle image upload
                    if (isset($history['image'])) {
                        $record->image = $this->uploadImage(
                            new Request(['image' => $history['image']]), 
                            'image', 
                            $this->path.'/history'
                        );
                    }
                    
                    $record->save();
                    $existingIds[] = $record->id;
                }
            }
        }

        // Delete removed items
        AboutUsHistory::where('about_us_id', $aboutUsId)
            ->whereNotIn('id', $existingIds)
            ->delete();
    }

    /**
     * Save Partner Items
     */
    protected function savePartners($aboutUsId, $partners)
    {
        $existingIds = [];
        
        foreach ($partners as $partner) {
            if (!empty($partner['name'])) {
                $data = [
                    'about_us_id' => $aboutUsId,
                    'name' => $partner['name'],
                    'url' => $partner['url'] ?? null,
                ];

                if (isset($partner['id']) && !empty($partner['id'])) {
                    // Update existing
                    $record = AboutUsPartner::find($partner['id']);
                    if ($record) {
                        // Handle logo upload
                        if (isset($partner['logo'])) {
                            $data['logo'] = $this->updateImage(
                                new Request(['logo' => $partner['logo']]), 
                                'logo', 
                                $this->path.'/partners', 
                                null, 
                                null, 
                                $record, 
                                'logo'
                            );
                        }
                        
                        $record->update($data);
                        $existingIds[] = $record->id;
                    }
                } else {
                    // Create new
                    $record = new AboutUsPartner($data);
                    
                    // Handle logo upload
                    if (isset($partner['logo'])) {
                        $record->logo = $this->uploadImage(
                            new Request(['logo' => $partner['logo']]), 
                            'logo', 
                            $this->path.'/partners'
                        );
                    }
                    
                    $record->save();
                    $existingIds[] = $record->id;
                }
            }
        }

        // Delete removed items
        AboutUsPartner::where('about_us_id', $aboutUsId)
            ->whereNotIn('id', $existingIds)
            ->delete();
    }

    /**
     * Save Accreditation Items
     */
    protected function saveAccreditations($aboutUsId, $accreditations)
    {
        $existingIds = [];
        
        foreach ($accreditations as $accreditation) {
            if (!empty($accreditation['name'])) {
                $data = [
                    'about_us_id' => $aboutUsId,
                    'name' => $accreditation['name'],
                    'description' => $accreditation['description'] ?? null,
                ];

                if (isset($accreditation['id']) && !empty($accreditation['id'])) {
                    // Update existing
                    $record = AboutUsAccreditation::find($accreditation['id']);
                    if ($record) {
                        // Handle logo upload
                        if (isset($accreditation['logo'])) {
                            $data['logo'] = $this->updateImage(
                                new Request(['logo' => $accreditation['logo']]), 
                                'logo', 
                                $this->path.'/accreditations', 
                                null, 
                                null, 
                                $record, 
                                'logo'
                            );
                        }
                        
                        $record->update($data);
                        $existingIds[] = $record->id;
                    }
                } else {
                    // Create new
                    $record = new AboutUsAccreditation($data);
                    
                    // Handle logo upload
                    if (isset($accreditation['logo'])) {
                        $record->logo = $this->uploadImage(
                            new Request(['logo' => $accreditation['logo']]), 
                            'logo', 
                            $this->path.'/accreditations'
                        );
                    }
                    
                    $record->save();
                    $existingIds[] = $record->id;
                }
            }
        }

        // Delete removed items
        AboutUsAccreditation::where('about_us_id', $aboutUsId)
            ->whereNotIn('id', $existingIds)
            ->delete();
    }


}