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
                        
                        <button class="btn btn-secondary btn-sm float-end ms-2"
                                onclick="window.location.href='{{ route('admin.payroll.index') }}'">
                            <i class="fas fa-arrow-right"></i> Go Back
                        </button>
                        <button class="btn btn-primary btn-sm float-end ms-2"
                                onclick="window.location.href='{{ route('admin.payroll.create') }}'">
                            <i class="fas fa-plus"></i> Generate Payroll
                        </button>
                        <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addComponentModal">
                            <i class="fas fa-plus"></i> Add Component
                        </button>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#earnings">Allowances</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#deductions">Deductions</a>
                            </li>
                        </ul>

                        <div class="tab-content mt-3">
                            <!-- Earnings Tab -->
                            <div class="tab-pane fade show active" id="earnings">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Code</th>
                                                <th>Category</th>
                                                <th>Calculation Type</th>
                                                <th>Default Amount</th>
                                                <th>Taxable</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($earnings as $component)
                                            <tr>
                                                <td>{{ $component->name }}</td>
                                                <td><code>{{ $component->code }}</code></td>
                                                <td>{{ ucfirst($component->category) }}</td>
                                                <td>
                                                    <span class="badge bg-info text-capitalize">
                                                        {{ $component->calculation_type }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($component->calculation_type == 'fixed')
                                                        {{ number_format($component->default_amount, 2) }}
                                                    @elseif($component->calculation_type == 'percentage')
                                                        {{ $component->percentage }}%
                                                    @else
                                                        Formula Based
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $component->is_taxable ? 'warning' : 'success' }}">
                                                        {{ $component->is_taxable ? 'Taxable' : 'Non-Taxable' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $component->is_active ? 'success' : 'danger' }}">
                                                        {{ $component->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                                            data-bs-target="#editComponentModal" 
                                                            data-component='@json($component)'>
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('admin.payroll-components.toggle-status', $component->id) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-{{ $component->is_active ? 'warning' : 'success' }}">
                                                            <i class="fas fa-{{ $component->is_active ? 'times' : 'check' }}"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Deductions Tab -->
                            <div class="tab-pane fade" id="deductions">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Code</th>
                                                <th>Category</th>
                                                <th>Calculation Type</th>
                                                <th>Default Amount</th>
                                                <th>Minimum Amount</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($deductions as $component)
                                            <tr>
                                                <td>{{ $component->name }}</td>
                                                <td><code>{{ $component->code }}</code></td>
                                                <td>{{ ucfirst($component->category) }}</td>
                                                <td>
                                                    <span class="badge bg-info text-capitalize">
                                                        {{ $component->calculation_type }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($component->calculation_type == 'fixed')
                                                        {{ number_format($component->default_amount, 2) }}
                                                    @elseif($component->calculation_type == 'percentage')
                                                        {{ $component->percentage }}%
                                                    @else
                                                        Formula Based
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($component->minimum_amount > 0)
                                                        {{ number_format($component->minimum_amount, 2) }}
                                                    @else
                                                        <span class="text-muted">No minimum</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $component->is_active ? 'success' : 'danger' }}">
                                                        {{ $component->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                                            data-bs-target="#editComponentModal" 
                                                            data-component='@json($component)'>
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('admin.payroll-components.toggle-status', $component->id) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-{{ $component->is_active ? 'warning' : 'success' }}">
                                                            <i class="fas fa-{{ $component->is_active ? 'times' : 'check' }}"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Component Modal -->
<div class="modal fade" id="addComponentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.payroll-components.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Payroll Component</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Code *</label>
                                <input type="text" class="form-control" name="code" required>
                                <small class="text-muted">Unique code for the component</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Type *</label>
                                <select class="form-control" name="type" required id="componentType">
                                    <option value="earning">Allowance</option>
                                    <option value="deduction">Deduction</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Category *</label>
                                <input type="text" class="form-control" name="category" required placeholder="e.g., Basic, Housing, Transport">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Calculation Type *</label>
                                <select class="form-control" name="calculation_type" required id="calculationType">
                                    <option value="fixed">Fixed Amount</option>
                                    <option value="percentage">Percentage</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3" id="amount-field">
                                <label class="form-label">Default Amount *</label>
                                <input type="number" class="form-control" name="default_amount" step="0.01" min="0" required>
                            </div>
                            <div class="mb-3 d-none" id="percentage-field">
                                <label class="form-label">Percentage *</label>
                                <input type="number" class="form-control" name="percentage" step="0.01" min="0" max="100">
                                <small class="text-muted">Percentage of basic salary</small>
                            </div>
                            <div class="mb-3 d-none" id="minimum-amount-field">
                                <label class="form-label">Minimum Amount Threshold</label>
                                <input type="number" class="form-control" name="minimum_amount" step="0.01" min="0" value="0">
                                <small class="text-muted">Deduction will only apply when basic salary exceeds this amount</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="is_taxable" value="1" id="is_taxable">
                                <label class="form-check-label" for="is_taxable">
                                    Taxable
                                </label>
                                <small class="text-muted d-block">Check if this component is subject to tax</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                                <label class="form-check-label">
                                    Active
                                </label>
                                <small class="text-muted d-block">Component will be available for use</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Optional description of the component"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Component</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Component Modal -->
<div class="modal fade" id="editComponentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="editComponentForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Payroll Component</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Form content will be populated by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Component</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle calculation fields
    const calculationType = document.getElementById('calculationType');
    const componentType = document.getElementById('componentType');
    const amountField = document.getElementById('amount-field');
    const percentageField = document.getElementById('percentage-field');
    const minimumAmountField = document.getElementById('minimum-amount-field');
    
    function toggleCalculationFields() {
        if (calculationType.value === 'percentage') {
            amountField.classList.add('d-none');
            percentageField.classList.remove('d-none');
            amountField.querySelector('input').removeAttribute('required');
            percentageField.querySelector('input').setAttribute('required', 'required');
        } else {
            amountField.classList.remove('d-none');
            percentageField.classList.add('d-none');
            amountField.querySelector('input').setAttribute('required', 'required');
            percentageField.querySelector('input').removeAttribute('required');
        }
    }
    
    function toggleMinimumAmountField() {
        if (componentType.value === 'deduction') {
            minimumAmountField.classList.remove('d-none');
        } else {
            minimumAmountField.classList.add('d-none');
        }
    }
    
    calculationType.addEventListener('change', toggleCalculationFields);
    componentType.addEventListener('change', toggleMinimumAmountField);
    
    // Initialize on page load
    toggleCalculationFields();
    toggleMinimumAmountField();

    // Edit modal handler
    const editModal = document.getElementById('editComponentModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const component = JSON.parse(button.getAttribute('data-component'));
        const form = document.getElementById('editComponentForm');
        
        form.action = `/admin/payroll-components/${component.id}`;
        
        const modalBody = editModal.querySelector('.modal-body');
        modalBody.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="name" value="${component.name}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Code *</label>
                        <input type="text" class="form-control" name="code" value="${component.code}" required>
                        <small class="text-muted">Unique code for the component</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Type *</label>
                        <select class="form-control" name="type" required id="editComponentType">
                            <option value="earning" ${component.type === 'earning' ? 'selected' : ''}>Allowance</option>
                            <option value="deduction" ${component.type === 'deduction' ? 'selected' : ''}>Deduction</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Category *</label>
                        <input type="text" class="form-control" name="category" value="${component.category}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Calculation Type *</label>
                        <select class="form-control" name="calculation_type" required id="editCalculationType">
                            <option value="fixed" ${component.calculation_type === 'fixed' ? 'selected' : ''}>Fixed Amount</option>
                            <option value="percentage" ${component.calculation_type === 'percentage' ? 'selected' : ''}>Percentage</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3" id="edit-amount-field" style="${component.calculation_type === 'percentage' ? 'display: none;' : ''}">
                        <label class="form-label">Default Amount *</label>
                        <input type="number" class="form-control" name="default_amount" value="${component.default_amount || 0}" step="0.01" min="0" ${component.calculation_type === 'fixed' ? 'required' : ''}>
                    </div>
                    <div class="mb-3" id="edit-percentage-field" style="${component.calculation_type === 'percentage' ? '' : 'display: none;'}">
                        <label class="form-label">Percentage *</label>
                        <input type="number" class="form-control" name="percentage" value="${component.percentage || 0}" step="0.01" min="0" max="100" ${component.calculation_type === 'percentage' ? 'required' : ''}>
                        <small class="text-muted">Percentage of basic salary</small>
                    </div>
                    <div class="mb-3" id="edit-minimum-amount-field" style="${component.type === 'deduction' ? '' : 'display: none;'}">
                        <label class="form-label">Minimum Amount Threshold</label>
                        <input type="number" class="form-control" name="minimum_amount" value="${component.minimum_amount || 0}" step="0.01" min="0">
                        <small class="text-muted">Deduction will only apply when basic salary exceeds this amount</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_taxable" value="1" ${component.is_taxable ? 'checked' : ''}>
                        <label class="form-check-label">
                            Taxable
                        </label>
                        <small class="text-muted d-block">Check if this component is subject to tax</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" ${component.is_active ? 'checked' : ''}>
                        <label class="form-check-label">
                            Active
                        </label>
                        <small class="text-muted d-block">Component will be available for use</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3">${component.description || ''}</textarea>
                    </div>
                </div>
            </div>
        `;

        // Add event listeners for edit modal fields
        const editCalculationType = document.getElementById('editCalculationType');
        const editComponentType = document.getElementById('editComponentType');
        const editAmountField = document.getElementById('edit-amount-field');
        const editPercentageField = document.getElementById('edit-percentage-field');
        const editMinimumAmountField = document.getElementById('edit-minimum-amount-field');

        editCalculationType.addEventListener('change', function() {
            if (this.value === 'percentage') {
                editAmountField.style.display = 'none';
                editPercentageField.style.display = 'block';
                editAmountField.querySelector('input').removeAttribute('required');
                editPercentageField.querySelector('input').setAttribute('required', 'required');
            } else {
                editAmountField.style.display = 'block';
                editPercentageField.style.display = 'none';
                editAmountField.querySelector('input').setAttribute('required', 'required');
                editPercentageField.querySelector('input').removeAttribute('required');
            }
        });

        editComponentType.addEventListener('change', function() {
            if (this.value === 'deduction') {
                editMinimumAmountField.style.display = 'block';
            } else {
                editMinimumAmountField.style.display = 'none';
            }
        });
    });
});
</script>

@endsection