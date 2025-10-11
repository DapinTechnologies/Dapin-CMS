<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeesCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Toastr;

class FeesCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_fees_category', 1);
        $this->route = 'admin.fees-category';
        $this->view = 'admin.fees-category';
        $this->path = 'fees-category';
        $this->access = 'fees-category';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        
        $data['rows'] = FeesCategory::orderBy('title', 'asc')->get();

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404); // Using modal for creation
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Field Validation
        $request->validate([
            'title' => 'required|max:191|unique:fees_categories,title',
            'amount' => 'required|numeric|min:0',
            'fee_type' => 'nullable|in:government,external,both',
        ]);

        // Insert Data
        $feesCategory = new FeesCategory;
        $feesCategory->title = $request->title;
        $feesCategory->slug = Str::slug($request->title, '-');
        $feesCategory->amount = $request->amount;
        $feesCategory->fee_type = $request->fee_type;
        $feesCategory->description = $request->description;
        $feesCategory->status = 1;
        $feesCategory->save();

        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FeesCategory $feesCategory)
    {
        abort(404); // Not implemented
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FeesCategory $feesCategory)
    {
        abort(404); // Using modal for editing
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeesCategory $feesCategory)
    {
        // Field Validation
        $request->validate([
            'title' => 'required|max:191|unique:fees_categories,title,'.$feesCategory->id,
            'amount' => 'required|numeric|min:0',
             'fee_type' => 'nullable|in:government,external,both',
            'status' => 'required|numeric|between:0,1',
        ]);

        // Update Data
        $feesCategory->title = $request->title;
        $feesCategory->slug = Str::slug($request->title, '-');
        $feesCategory->amount = $request->amount;
        $feesCategory->fee_type = $request->fee_type;
        $feesCategory->description = $request->description;
        $feesCategory->status = $request->status;
        $feesCategory->save();

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeesCategory $feesCategory)
    {
        // Delete Data
        $feesCategory->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Assign multiple fees categories
     */
    public function assignMultiple()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        
        $data['categories'] = FeesCategory::where('status', 1)
            ->orderBy('title')
            ->get();

        return view($this->view.'.assign-fee-category', $data);
    }

    /**
     * Store multiple fees categories
     */
    public function storeMultiple(Request $request)
    {
        // Field Validation
        $request->validate([
            'categories' => 'required|array|min:1',
            'amounts' => 'required|array|min:1',
            'amounts.*' => 'required|numeric|min:0',
        ]);

        // Check if counts match
        if (count($request->categories) !== count($request->amounts)) {
            return redirect()->back()
                ->withErrors(['msg' => 'Category count and Amount count must match']);
        }

        // Prepare data for response
        $assignedCategories = [];
        foreach ($request->categories as $index => $categoryId) {
            $category = FeesCategory::findOrFail($categoryId);
            
            $assignedCategories[] = [
                'name' => $category->title,
                'amount' => $request->amounts[$index],
                'type' => $category->fee_type,
            ];
        }

        return redirect()->route($this->route.'.assign-multiple')
            ->with('success', __('msg_updated_successfully'))
            ->with('assignedCategories', $assignedCategories);
    }
}