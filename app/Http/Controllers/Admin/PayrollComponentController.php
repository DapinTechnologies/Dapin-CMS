<?php
// app/Http/Controllers/Admin/PayrollComponentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayrollComponent;
use App\Models\EmployeePayrollPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollComponentController extends Controller
{
    public function __construct()
    {
        $this->title = 'Payroll Components';
        $this->route = 'admin.payroll-components';
        $this->view = 'admin.payroll.components';
    }

    public function index()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        
        $data['earnings'] = PayrollComponent::where('type', 'earning')
            ->where('is_active', true)
            ->get();
            
        $data['deductions'] = PayrollComponent::where('type', 'deduction')
            ->where('is_active', true)
            ->get();
        
        return view('admin.payroll.components_index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payroll_components',
            'type' => 'required|in:earning,deduction',
            'category' => 'required|string|max:100',
            'calculation_type' => 'required|in:fixed,percentage',
            'default_amount' => 'nullable|numeric|min:0',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'minimum_amount' => 'nullable|numeric|min:0',
            'is_taxable' => 'boolean',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:500'
        ]);

        // Validate based on calculation type
        if ($request->calculation_type === 'fixed' && !$request->default_amount) {
            return redirect()->back()->with('error', 'Default amount is required for fixed calculation type.');
        }

        if ($request->calculation_type === 'percentage' && !$request->percentage) {
            return redirect()->back()->with('error', 'Percentage is required for percentage calculation type.');
        }

        try {
            DB::beginTransaction();

            $component = PayrollComponent::create([
                'name' => $request->name,
                'code' => strtoupper($request->code),
                'type' => $request->type,
                'category' => $request->category,
                'calculation_type' => $request->calculation_type,
                'default_amount' => $request->default_amount ?? 0,
                'percentage' => $request->percentage ?? 0,
                'minimum_amount' => $request->minimum_amount ?? 0,
                'is_taxable' => $request->is_taxable ?? false,
                'is_active' => $request->is_active ?? true,
                'description' => $request->description,
            ]);

            DB::commit();

            return redirect()->route('admin.payroll-components.index')
                ->with('success', 'Payroll component created successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating payroll component: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $component = PayrollComponent::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payroll_components,code,'.$id,
            'type' => 'required|in:earning,deduction',
            'category' => 'required|string|max:100',
            'calculation_type' => 'required|in:fixed,percentage',
            'default_amount' => 'nullable|numeric|min:0',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'minimum_amount' => 'nullable|numeric|min:0',
            'is_taxable' => 'boolean',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:500'
        ]);

        // Validate based on calculation type
        if ($request->calculation_type === 'fixed' && !$request->default_amount) {
            return redirect()->back()->with('error', 'Default amount is required for fixed calculation type.');
        }

        if ($request->calculation_type === 'percentage' && !$request->percentage) {
            return redirect()->back()->with('error', 'Percentage is required for percentage calculation type.');
        }

        try {
            DB::beginTransaction();

            // Check if component is being deactivated and has active preferences
            if (!$request->is_active && $component->is_active) {
                $activePreferences = EmployeePayrollPreference::where('component_id', $id)
                    ->where('is_active', true)
                    ->count();
                    
                if ($activePreferences > 0) {
                    return redirect()->back()->with('warning', 
                        "Cannot deactivate component. There are {$activePreferences} active employee preferences using this component. Please update employee preferences first.");
                }
            }

            $component->update([
                'name' => $request->name,
                'code' => strtoupper($request->code),
                'type' => $request->type,
                'category' => $request->category,
                'calculation_type' => $request->calculation_type,
                'default_amount' => $request->default_amount ?? 0,
                'percentage' => $request->percentage ?? 0,
                'minimum_amount' => $request->minimum_amount ?? 0,
                'is_taxable' => $request->is_taxable ?? false,
                'is_active' => $request->is_active ?? true,
                'description' => $request->description,
            ]);

            DB::commit();

            return redirect()->route('admin.payroll-components.index')
                ->with('success', 'Payroll component updated successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating payroll component: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $component = PayrollComponent::findOrFail($id);
        
        try {
            DB::beginTransaction();

            if (!$component->is_active) {
                // Activating component
                $component->update(['is_active' => true]);
                $status = 'activated';
            } else {
                // Deactivating component - check for active preferences
                $activePreferences = EmployeePayrollPreference::where('component_id', $id)
                    ->where('is_active', true)
                    ->count();
                    
                if ($activePreferences > 0) {
                    return redirect()->back()->with('warning', 
                        "Cannot deactivate component. There are {$activePreferences} active employee preferences using this component. Please update employee preferences first.");
                }
                
                $component->update(['is_active' => false]);
                $status = 'deactivated';
            }

            DB::commit();

            return redirect()->back()->with('success', "Component {$status} successfully");
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating component status: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $component = PayrollComponent::findOrFail($id);
        
        try {
            DB::beginTransaction();

            // Check if component has any preferences
            $preferencesCount = EmployeePayrollPreference::where('component_id', $id)->count();
            if ($preferencesCount > 0) {
                return redirect()->back()->with('warning', 
                    "Cannot delete component. There are {$preferencesCount} employee preferences using this component. Please delete preferences first.");
            }

            $component->delete();

            DB::commit();

            return redirect()->route('admin.payroll-components.index')
                ->with('success', 'Payroll component deleted successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error deleting payroll component: ' . $e->getMessage());
        }
    }
}