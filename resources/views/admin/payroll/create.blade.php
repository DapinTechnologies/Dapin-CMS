@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }}</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route($route.'.store') }}">
                            @csrf
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="payroll_period_id" class="form-label">Payroll Period *</label>
                                    <select class="form-control" name="payroll_period_id" id="payroll_period_id" required>
                                        <option value="">Select Period</option>
                                        @foreach($groupedPeriods as $year => $periods)
                                        <optgroup label="{{ $year }}">
                                            @foreach($periods as $period)
                                            <option value="{{ $period->id }}" {{ $currentPeriod && $currentPeriod->id == $period->id ? 'selected' : '' }}>
                                                {{ $period->name }} ({{ $period->start_date->format('d M Y') }} - {{ $period->end_date->format('d M Y') }})
                                            </option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">
                                        Current period: {{ $currentPeriod ? $currentPeriod->name : 'Not set' }}
                                    </small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Select Employees *</label>
                                    <div class="border p-3" style="max-height: 400px; overflow-y: auto;">
                                        @foreach($employees as $employee)
                                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                                            <div class="form-check flex-grow-1">
                                                <input class="form-check-input" type="checkbox" name="employee_ids[]" value="{{ $employee->id }}" id="emp_{{ $employee->id }}">
                                                <label class="form-check-label" for="emp_{{ $employee->id }}">
                                                    {{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->staff_id }}) - KES {{ number_format($employee->basic_salary, 2) }}
                                                </label>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-primary draft-payroll-btn" 
                                                        data-employee-id="{{ $employee->id }}"
                                                        data-employee-name="{{ $employee->first_name }} {{ $employee->last_name }}"
                                                        data-basic-salary="{{ $employee->basic_salary }}">
                                                    Draft Payroll
                                                </button>
                                               {{-- <button type="button" class="btn btn-sm btn-outline-warning edit-draft-btn" 
                                                        data-employee-id="{{ $employee->id }}"
                                                        data-employee-name="{{ $employee->first_name }} {{ $employee->last_name }}">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger restart-draft-btn" 
                                                        data-employee-id="{{ $employee->id }}"
                                                        data-employee-name="{{ $employee->first_name }} {{ $employee->last_name }}">
                                                    Restart
                                                </button> --}}
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Generate Payroll</button>
                                    <button type="button" class="btn btn-success" onclick="bulkGenerate()">
                                        Bulk Generate for All Active Employees
                                    </button>
                                    <a href="{{ route($route.'.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </form>

                        <form id="bulkForm" method="POST" action="{{ route($route.'.bulk-generate') }}">
                            @csrf
                            <input type="hidden" name="payroll_period_id" id="bulk_period_id">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Draft Payroll Modal -->
<div class="modal fade" id="draftPayrollModal" tabindex="-1" aria-labelledby="draftPayrollModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="draftPayrollModalLabel">Draft Payroll - <span id="employeeName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="draftPayrollForm">
                @csrf
                <input type="hidden" name="user_id" id="draft_user_id">
                <input type="hidden" name="payroll_period_id" id="draft_period_id">
                
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Basic Salary</label>
                            <input type="text" class="form-control" id="display_basic_salary" readonly>
                            <input type="hidden" name="basic_salary" id="basic_salary">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Payroll Period</label>
                            <input type="text" class="form-control" id="display_period" readonly>
                        </div>
                    </div>

                    <!-- Allowances Section -->
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Allowances</h6>
                            <button type="button" class="btn btn-sm btn-success" onclick="addCustomAllowance()">
                                + Add Custom Allowance
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="allowances-section">
                                <!-- Allowances will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>

                    <!-- Deductions Section -->
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Deductions</h6>
                            <button type="button" class="btn btn-sm btn-success" onclick="addCustomDeduction()">
                                + Add Custom Deduction
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="deductions-section">
                                <!-- Deductions will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>

                    <!-- Summary Section -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Payroll Summary</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Gross Earnings:</strong> <span id="summary_gross">KES 0.00</span></p>
                                    <p><strong>Total Deductions:</strong> <span id="summary_deductions">KES 0.00</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Net Pay:</strong> <span id="summary_net" class="fw-bold">KES 0.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Draft</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Template for custom allowance -->
<template id="custom-allowance-template">
    <div class="custom-component mb-2 p-2 border rounded">
        <div class="row">
            <div class="col-md-4">
                <input type="text" class="form-control" name="custom_allowances[][name]" placeholder="Allowance Name" required>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="custom_allowances[][amount]" placeholder="Amount" step="0.01" required>
            </div>
            <div class="col-md-3">
                <select class="form-control" name="custom_allowances[][is_taxable]">
                    <option value="1">Taxable</option>
                    <option value="0">Non-Taxable</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-sm btn-danger" onclick="removeCustomComponent(this)">Remove</button>
            </div>
        </div>
    </div>
</template>

<!-- Template for custom deduction -->
<template id="custom-deduction-template">
    <div class="custom-component mb-2 p-2 border rounded">
        <div class="row">
            <div class="col-md-4">
                <input type="text" class="form-control" name="custom_deductions[][name]" placeholder="Deduction Name" required>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="custom_deductions[][amount]" placeholder="Amount" step="0.01" required>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="custom_deductions[][minimum_amount]" placeholder="Min Amount" step="0.01">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-sm btn-danger" onclick="removeCustomComponent(this)">Remove</button>
            </div>
        </div>
    </div>
</template>

<script>
// Payroll components data from backend
const payrollComponents = @json($payrollComponents);

function bulkGenerate() {
    const periodId = document.querySelector('[name="payroll_period_id"]').value;
    if (!periodId) {
        alert('Please select a payroll period first');
        return;
    }
    
    if (confirm('Generate payroll for ALL active employees?')) {
        document.getElementById('bulk_period_id').value = periodId;
        document.getElementById('bulkForm').submit();
    }
}

// Draft Payroll functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize draft payroll buttons
    document.querySelectorAll('.draft-payroll-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const employeeId = this.dataset.employeeId;
            const employeeName = this.dataset.employeeName;
            const basicSalary = this.dataset.basicSalary;
            const periodId = document.getElementById('payroll_period_id').value;
            const periodText = document.getElementById('payroll_period_id').selectedOptions[0]?.text;
            
            if (!periodId) {
                alert('Please select a payroll period first');
                return;
            }
            
            openDraftModal(employeeId, employeeName, basicSalary, periodId, periodText, false);
        });
    });
    
    // Edit draft buttons
    document.querySelectorAll('.edit-draft-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const employeeId = this.dataset.employeeId;
            const employeeName = this.dataset.employeeName;
            const periodId = document.getElementById('payroll_period_id').value;
            const periodText = document.getElementById('payroll_period_id').selectedOptions[0]?.text;
            
            if (!periodId) {
                alert('Please select a payroll period first');
                return;
            }
            
            // Load existing draft data
            loadDraftForEditing(employeeId, periodId, employeeName, periodText);
        });
    });
    
    // Restart draft buttons
    document.querySelectorAll('.restart-draft-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const employeeId = this.dataset.employeeId;
            const employeeName = this.dataset.employeeName;
            const periodId = document.getElementById('payroll_period_id').value;
            
            if (!periodId) {
                alert('Please select a payroll period first');
                return;
            }
            
            if (confirm(`Are you sure you want to restart the payroll draft for ${employeeName}? This will delete all saved information.`)) {
                restartDraft(employeeId, periodId);
            }
        });
    });
});

function openDraftModal(employeeId, employeeName, basicSalary, periodId, periodText, isEdit = false) {
    document.getElementById('employeeName').textContent = employeeName;
    document.getElementById('draft_user_id').value = employeeId;
    document.getElementById('draft_period_id').value = periodId;
    document.getElementById('display_basic_salary').value = 'KES ' + parseFloat(basicSalary).toLocaleString('en-US', {minimumFractionDigits: 2});
    document.getElementById('basic_salary').value = basicSalary;
    document.getElementById('display_period').value = periodText;
    
    // Clear previous data unless editing
    if (!isEdit) {
        clearDraftForm();
    }
    
    // Populate components
    populateComponents();
    
    // Calculate initial summary
    calculateSummary();
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('draftPayrollModal'));
    modal.show();
}

function clearDraftForm() {
    // Clear all checkboxes
    document.querySelectorAll('.component-checkbox').forEach(checkbox => {
        checkbox.checked = false;
        const details = checkbox.parentNode.querySelector('.component-details');
        if (details) details.style.display = 'none';
    });
    
    // Clear custom components
    document.querySelectorAll('.custom-component').forEach(component => {
        component.remove();
    });
    
    // Clear input values in component details
    document.querySelectorAll('.component-details input').forEach(input => {
        input.value = '';
    });
}

function loadDraftForEditing(employeeId, periodId, employeeName, periodText) {
    fetch(`/admin/payroll/draft/${employeeId}/${periodId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const draft = data.draft;
                openDraftModal(employeeId, employeeName, draft.basic_salary, periodId, periodText, true);
                
                // Populate the form with draft data after a short delay to ensure modal is ready
                setTimeout(() => {
                    populateDraftData(draft);
                }, 500);
            } else {
                alert('No draft found for this employee and period. Please create a draft first.');
            }
        })
        .catch(error => {
            console.error('Error loading draft:', error);
            alert('Error loading draft data');
        });
}

function populateDraftData(draft) {
    // Clear form first
    clearDraftForm();
    
    // Populate selected components
    if (draft.selected_components) {
        draft.selected_components.forEach(component => {
            const checkbox = document.querySelector(`.component-checkbox[value="${component.component_id}"]`);
            if (checkbox) {
                checkbox.checked = true;
                const details = checkbox.parentNode.querySelector('.component-details');
                if (details) {
                    details.style.display = 'block';
                    
                    // Populate input fields based on calculation type
                    if (component.calculation_type === 'percentage') {
                        const input = details.querySelector('input[name$="[percentage]"]');
                        if (input && component.input_data && component.input_data.percentage) {
                            input.value = component.input_data.percentage;
                        }
                    } else if (component.calculation_type === 'fixed') {
                        const input = details.querySelector('input[name$="[amount]"]');
                        if (input && component.input_data && component.input_data.amount) {
                            input.value = component.input_data.amount;
                        }
                    }
                }
            }
        });
    }
    
    // Populate custom allowances
    if (draft.custom_allowances) {
        draft.custom_allowances.forEach(allowance => {
            addCustomAllowance();
            const allowanceSection = document.getElementById('allowances-section');
            const lastAllowance = allowanceSection.querySelector('.custom-component:last-child');
            if (lastAllowance) {
                lastAllowance.querySelector('input[name^="custom_allowances"][name$="[name]"]').value = allowance.name || '';
                lastAllowance.querySelector('input[name^="custom_allowances"][name$="[amount]"]').value = allowance.amount || '';
                if (allowance.is_taxable !== undefined) {
                    lastAllowance.querySelector('select[name^="custom_allowances"][name$="[is_taxable]"]').value = allowance.is_taxable ? '1' : '0';
                }
            }
        });
    }
    
    // Populate custom deductions
    if (draft.custom_deductions) {
        draft.custom_deductions.forEach(deduction => {
            addCustomDeduction();
            const deductionSection = document.getElementById('deductions-section');
            const lastDeduction = deductionSection.querySelector('.custom-component:last-child');
            if (lastDeduction) {
                lastDeduction.querySelector('input[name^="custom_deductions"][name$="[name]"]').value = deduction.name || '';
                lastDeduction.querySelector('input[name^="custom_deductions"][name$="[amount]"]').value = deduction.amount || '';
                if (deduction.minimum_amount !== undefined) {
                    lastDeduction.querySelector('input[name^="custom_deductions"][name$="[minimum_amount]"]').value = deduction.minimum_amount || '';
                }
            }
        });
    }
    
    // Recalculate summary
    calculateSummary();
}

function restartDraft(employeeId, periodId) {
    fetch(`/admin/payroll/draft/${employeeId}/${periodId}/restart`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Payroll draft restarted successfully');
            // Optionally reload the page or update UI
            location.reload();
        } else {
            alert('Error restarting draft: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error restarting draft:', error);
        alert('Error restarting draft');
    });
}

function populateComponents() {
    const allowancesSection = document.getElementById('allowances-section');
    const deductionsSection = document.getElementById('deductions-section');
    
    allowancesSection.innerHTML = '';
    deductionsSection.innerHTML = '';
    
    payrollComponents.forEach(component => {
        const section = component.type === 'earning' ? allowancesSection : deductionsSection;
        const isStatutory = component.is_statutory ? ' (Statutory)' : '';
        
        const componentHtml = `
            <div class="form-check mb-2">
                <input class="form-check-input component-checkbox" type="checkbox" 
                       value="${component.id}" 
                       id="comp_${component.id}"
                       data-type="${component.type}"
                       data-calculation-type="${component.calculation_type}"
                       data-default-amount="${component.default_amount || 0}"
                       data-percentage="${component.percentage || 0}"
                       data-minimum-amount="${component.minimum_amount || 0}"
                       onchange="toggleComponentDetails(this)">
                <label class="form-check-label" for="comp_${component.id}">
                    ${component.name}${isStatutory}
                </label>
                <div class="component-details mt-1" style="display: none;">
                    ${getComponentInputFields(component)}
                </div>
            </div>
        `;
        
        section.innerHTML += componentHtml;
    });
}

function getComponentInputFields(component) {
    switch(component.calculation_type) {
        case 'percentage':
            return `
                <div class="row">
                    <div class="col-md-6">
                        <input type="number" class="form-control form-control-sm" 
                               name="components[${component.id}][percentage]" 
                               placeholder="Percentage" 
                               step="0.01" 
                               onchange="calculateSummary()">
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Default: ${component.percentage}%</small>
                    </div>
                </div>
            `;
        case 'fixed':
            return `
                <div class="row">
                    <div class="col-md-6">
                        <input type="number" class="form-control form-control-sm" 
                               name="components[${component.id}][amount]" 
                               placeholder="Amount" 
                               step="0.01"
                               value="${component.default_amount || 0}"
                               onchange="calculateSummary()">
                    </div>
                </div>
            `;
        default:
            return '';
    }
}

function toggleComponentDetails(checkbox) {
    const details = checkbox.parentNode.querySelector('.component-details');
    details.style.display = checkbox.checked ? 'block' : 'none';
    calculateSummary();
}

function addCustomAllowance() {
    const template = document.getElementById('custom-allowance-template');
    const clone = template.content.cloneNode(true);
    document.getElementById('allowances-section').appendChild(clone);
}

function addCustomDeduction() {
    const template = document.getElementById('custom-deduction-template');
    const clone = template.content.cloneNode(true);
    document.getElementById('deductions-section').appendChild(clone);
}

function removeCustomComponent(button) {
    button.closest('.custom-component').remove();
    calculateSummary();
}

function calculateSummary() {
    const basicSalary = parseFloat(document.getElementById('basic_salary').value) || 0;
    let totalAllowances = 0;
    let totalDeductions = 0;
    
    // Calculate selected components
    document.querySelectorAll('.component-checkbox:checked').forEach(checkbox => {
        const type = checkbox.dataset.type;
        const calculationType = checkbox.dataset.calculationType;
        const details = checkbox.parentNode.querySelector('.component-details');
        
        if (details) {
            const input = details.querySelector('input');
            if (input) {
                const value = parseFloat(input.value) || 0;
                
                if (type === 'earning') {
                    if (calculationType === 'percentage') {
                        totalAllowances += basicSalary * (value / 100);
                    } else {
                        totalAllowances += value;
                    }
                } else {
                    if (calculationType === 'percentage') {
                        totalDeductions += basicSalary * (value / 100);
                    } else {
                        totalDeductions += value;
                    }
                }
            }
        }
    });
    
    // Calculate custom allowances
    document.querySelectorAll('input[name^="custom_allowances"]').forEach(input => {
        if (input.name.includes('[amount]') && input.value) {
            totalAllowances += parseFloat(input.value) || 0;
        }
    });
    
    // Calculate custom deductions
    document.querySelectorAll('input[name^="custom_deductions"]').forEach(input => {
        if (input.name.includes('[amount]') && input.value) {
            totalDeductions += parseFloat(input.value) || 0;
        }
    });
    
    const grossEarnings = basicSalary + totalAllowances;
    const netPay = grossEarnings - totalDeductions;
    
    document.getElementById('summary_gross').textContent = 'KES ' + grossEarnings.toLocaleString('en-US', {minimumFractionDigits: 2});
    document.getElementById('summary_deductions').textContent = 'KES ' + totalDeductions.toLocaleString('en-US', {minimumFractionDigits: 2});
    document.getElementById('summary_net').textContent = 'KES ' + netPay.toLocaleString('en-US', {minimumFractionDigits: 2});
}

// Save draft form submission
document.getElementById('draftPayrollForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Fix for custom allowances/deductions - ensure name field is present
    const formData = new FormData(this);
    
    // Validate custom fields
    const customAllowances = document.querySelectorAll('input[name^="custom_allowances"][name$="[name]"]');
    const customDeductions = document.querySelectorAll('input[name^="custom_deductions"][name$="[name]"]');
    
    for (let allowance of customAllowances) {
        if (!allowance.value.trim()) {
            alert('Please provide a name for all custom allowances');
            allowance.focus();
            return;
        }
    }
    
    for (let deduction of customDeductions) {
        if (!deduction.value.trim()) {
            alert('Please provide a name for all custom deductions');
            deduction.focus();
            return;
        }
    }
    
    fetch('{{ route("admin.payroll.draft.save") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Payroll draft saved successfully!');
            bootstrap.Modal.getInstance(document.getElementById('draftPayrollModal')).hide();
            location.reload(); // Reload to update buttons
        } else {
            alert('Error saving draft: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving draft: ' + error.message);
    });
});

// Recalculate summary when any input changes
document.addEventListener('input', function(e) {
    if (e.target.matches('input[type="number"]')) {
        calculateSummary();
    }
});
</script>
@endsection