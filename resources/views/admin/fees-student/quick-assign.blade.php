@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<style>
.checkbox-group {
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 4px;
}
.checkbox-item {
    margin-bottom: 8px;
}
.text-danger {
    color: #dc3545;
}
</style>
<style>
    .premium-amount-display {
        background: #f8f9fa;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 15px 20px;
        margin-top: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .amount-content {
        display: flex;
        align-items: center;
    }
    
    .currency-symbol {
        font-size: 1rem;
        font-weight: bold;
        color: #495057;
        margin-right: 5px;
    }
    
    .amount-figure {
        font-size: 1rem;
        font-weight: bold;
        color: #2c3e50;
        letter-spacing: 0.5px;
    }
    
    
    
    /* For dark mode compatibility */
    @media (prefers-color-scheme: dark) {
        .premium-amount-display {
            background: #2d3748;
            border-color: #4a5568;
        }
        
        .currency-symbol, .amount-figure {
            color: #f8f9fa;
        }
        
        
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<style>
    .toast {
        font-size: 14px;
    }
    .toast-success {
        background-color: #51A351;
    }
</style>

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }}</h5>
                    </div>

                    <form class="needs-validation" novalidate action="{{ route($route.'.quick.assign.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-block">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="student">{{ __('field_student_id') }} <span>*</span></label>
                                    <select class="form-control select2" name="students[]" id="student" multiple required>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}" {{ in_array($student->id, old('students', [])) ? 'selected' : '' }}>
                                                {{ $student->student->student_id ?? '' }} - {{ $student->student->first_name ?? '' }} {{ $student->student->last_name ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_student_id') }}</div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="categories">{{ __('field_fees_type') }} <span>*</span></label>
                                    <select class="form-control select2" name="categories[]" id="categories" multiple required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" data-amount="{{ $category->amount }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                                {{ $category->title }} ({{ number_format($category->amount, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_fees_type') }}</div>
                                </div>

                                <div class="form-group col-md-6" id="total-amount-container">
    <label><strong>{{ __('Total Amount') }}:</strong></label>
    <div class="premium-amount-display">
        <div class="amount-content">
            <span class="currency-symbol">Ksh</span>
            <span id="total-amount" class="amount-figure">0.00</span>
        </div>
        <div class="amount-underline"></div>
    </div>
    <input type="hidden" name="total_amount" id="total-amount-input" value="0">
</div>

                                <div class="form-group col-md-6">
                                    <label for="assign_date" class="form-label">{{ __('field_assign') }} {{ __('field_date') }} <span>*</span></label>
                                    <input type="date" class="form-control" name="assign_date" id="assign_date" value="{{ date('Y-m-d') }}" readonly required>
                                    <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_assign') }} {{ __('field_date') }}</div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="due_date" class="form-label">{{ __('field_due_date') }} <span>*</span></label>
                                    <input type="date" class="form-control" name="due_date" id="due_date" value="{{ old('due_date', date('Y-m-d')) }}" required>
                                    <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_due_date') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> {{ __('btn_save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
@if(!empty($invoices) && $invoices->count())
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Latest Invoices</h5>
        <input type="text" id="invoice-search" class="form-control w-50" placeholder="Search by student name or invoice no...">
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="invoice-table">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Student</th>
                    <th>Fee Categories</th>
                    <th>Total Fee</th>
                    <th>Amount Due</th>
                    <th>Assign Date</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                @php
    // Get fees from relationship or direct query
    $fees = $invoice->fees ?? \App\Models\Fee::where('invoice_id', $invoice->id)->get();
    
    // Fallback query if still empty
    if ($fees->isEmpty()) {
        $fees = \App\Models\Fee::where('student_enroll_id', $invoice->student_enroll_id)
            ->where('assign_date', $invoice->assign_date)
            ->where('due_date', $invoice->due_date)
            ->get();
    }

    // Generate HTML for each fee category in separate spans
    $categoryList = $fees->map(function($fee) {
        $categoryTitle = $fee->category->title ?? 'Category #' . $fee->category_id;
        $amount = number_format($fee->category->amount ?? $fee->amount, 2);
        
        return sprintf(
            '<div class="mb-1"><span class="badge badge-info">%s (%s)</span></div>',
            $categoryTitle,
            $amount
        );
    })->implode('');

    if ($fees->isEmpty()) {
        $categoryList = '<span class="text-danger">No fees assigned</span>';
    }
@endphp


                <tr>
                    <td>{{ $invoice->invoice_no }}</td>
                    <td>{{ $invoice->studentEnroll->student->full_name ?? 'N/A' }}</td>
                    <td class="d-flex flex-column">
                        {!! $categoryList !!}
</td>
                    <td>{{ number_format($invoice->total_fee, 2) }}</td>
                    <td>{{ number_format($invoice->amount_due, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($invoice->assign_date)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</td>
                    <td>
                        @if($invoice->payment_status == 'paid')
                            <span class="badge bg-success">Paid</span>
                        @elseif($invoice->payment_status == 'partial')
                            <span class="badge bg-warning">Partial</span>
                        @else
                            <span class="badge bg-danger">Unpaid</span>
                        @endif
                    </td>
                    <td class="text-center">
                   <button class="btn btn-sm btn-info view-invoice-btn" 
            data-invoice-id="{{ $invoice->id }}"
            data-invoice-no="{{ $invoice->invoice_no }}"
            data-student-name="{{ $invoice->studentEnroll->student->full_name ?? 'N/A' }}"
            data-student-id="{{ $invoice->studentEnroll->student->student_id ?? 'N/A' }}"
            data-class="{{ $invoice->studentEnroll->class->name ?? 'N/A' }}"
            data-section="{{ $invoice->studentEnroll->section->name ?? 'N/A' }}"
            data-assign-date="{{ $invoice->assign_date }}"
            data-due-date="{{ $invoice->due_date }}"
            data-total-fee="{{ $invoice->total_fee }}"
            data-amount-paid="{{ $invoice->amount_paid ?? 0 }}"
            data-amount-due="{{ $invoice->amount_due }}"
            data-payment-status="{{ $invoice->payment_status }}"
            data-fee-details='@json($fees->map(function($fee) { 
                return [
                    'category_title' => $fee->category->title ?? 'Category #' . $fee->category_id,
                    'description' => $fee->category->description ?? '',
                    'amount' => $fee->category->amount ?? $fee->amount
                ]; 
            }))'
            data-payments='@json($invoice->payments ?? [])'
            title="View Invoice">
        <i class="fas fa-eye"></i>
    </button>
                
                <button class="btn btn-sm btn-primary payment-btn"
        data-bs-toggle="modal"
        data-bs-target="#paymentModal"
        data-invoice-id="{{ $invoice->id }}"
        data-student-enroll-id="{{ $invoice->student_enroll_id }}"
        data-amount-due="{{ $invoice->amount_due ?? 0 }}">
    <i class="fas fa-money-bill-wave"></i> Pay
</button>
                
                @php
    $currentCategories = $invoice->fees->pluck('category_id')->toArray();
    $feeDetails = $invoice->fee_details ?? [];
@endphp

<button class="btn btn-sm btn-warning edit-invoice-btn"
        data-invoice-id="{{ $invoice->id }}"
        data-student-id="{{ $invoice->student_enroll_id }}"
        data-fee-details="{{ htmlspecialchars(json_encode($feeDetails), ENT_QUOTES, 'UTF-8') }}"
        data-current-categories="{{ htmlspecialchars(json_encode($currentCategories), ENT_QUOTES, 'UTF-8') }}"
        data-assign-date="{{ $invoice->assign_date }}"
        data-due-date="{{ $invoice->due_date }}"
        data-total-amount="{{ $invoice->total_fee }}"
        title="Edit Invoice">
    <i class="fas fa-edit"></i>
</button>
                
                <button class="btn btn-sm btn-secondary print-btn" 
        data-invoice-id="{{ $invoice->id }}"
        data-invoice-no="{{ $invoice->invoice_no }}"
        data-student-name="{{ $invoice->studentEnroll->student->full_name ?? 'N/A' }}"
        data-student-id="{{ $invoice->studentEnroll->student->student_id ?? 'N/A' }}"
        data-class="{{ $invoice->studentEnroll->class->name ?? 'N/A' }}"
        data-section="{{ $invoice->studentEnroll->section->name ?? 'N/A' }}"
        data-assign-date="{{ $invoice->assign_date }}"
        data-due-date="{{ $invoice->due_date }}"
        data-total-fee="{{ $invoice->total_fee }}"
        data-amount-paid="{{ $invoice->amount_paid ?? 0 }}"
        data-amount-due="{{ $invoice->amount_due }}"
        data-payment-status="{{ $invoice->payment_status }}"
        data-fee-details='@json($fees->map(function($fee) { 
            return [
                'category_title' => $fee->category->title ?? 'Category #' . $fee->category_id,
                'description' => $fee->category->description ?? '',
                'amount' => $fee->category->amount ?? $fee->amount
            ]; 
        }))'
        data-payments='@json($invoice->payments ?? [])'
        title="Print Invoice">
    <i class="fas fa-print"></i>
</button>
            </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@php
    // At the top of your view, ensure $allCategories exists
    $allCategories = $allCategories ?? \App\Models\FeesCategory::all();
@endphp
<div class="modal fade" id="editInvoiceModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editInvoiceForm" action="{{ route('invoices.update', ':id') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="edit_invoice_id" name="id">
                    <input type="hidden" id="edit_student_enroll_id" name="student_enroll_id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Assign Date</label>
                                <input type="date" class="form-control" id="edit_assign_date" name="assign_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="edit_due_date" name="due_date" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Available Categories</label>
                        <select id="available_categories" class="form-control select2">
                            <option value="">Select category to add</option>
                            @foreach($allCategories as $category)
                                <option value="{{ $category->id }}" data-amount="{{ $category->amount }}">
                                    {{ $category->title }} ({{ number_format($category->amount, 2) }})
                                </option>
                            @endforeach
                        </select>
                        <button type="button" id="add_category_btn" class="btn btn-sm btn-primary mt-2">Add Category</button>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Selected Categories</label>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="selected_categories">
                                    <!-- Will be populated by JavaScript -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th id="categories_total">0.00</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <input type="hidden" name="fee_categories" id="fee_categories_input">
                    <input type="hidden" name="total_fee" id="total_fee_input">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <form method="POST" action="{{ route('payments.store') }}" id="paymentForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="invoice_id" id="modal_invoice_id">
                <input type="hidden" name="student_enroll_id" id="modal_student_enroll_id">
                <input type="hidden" name="is_installment" id="is_installment" value="0">
                <input type="hidden" id="full-amount-due" value="0">

                <div class="modal-header py-3 bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="paymentModalLabel">
                        <i class="fas fa-credit-card me-2"></i>Quick Manual Payment Receiving
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <!-- Student Information Card -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-user-graduate fa-2x text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold" id="payment-student-name">Student Name</h6>
                                            <div class="d-flex flex-wrap gap-3">
                                                
                                                <small class="text-muted"><i class="fas fa-file-invoice me-1"></i> Invoice ID: <span id="payment-invoice-no">N/A</span></small>
                                                <small class="text-muted"><i class="fas fa-calendar-day me-1"></i> Due Date: <span id="payment-due-date">N/A</span></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="alert alert-success py-1 mb-0">
                                        <strong>Total Due KSH: <span class="fw-bold fs-5" id="modal-total-due"> 0.00</span></strong>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Left Column - Payment Details -->
                        <div class="col-md-6 border-end pe-4">
                            <!-- Payment Type -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Payment Type <span class="text-danger">*</span></label>
                                <div class="d-flex gap-4">
                                    <div class="form-check payment-option">
                                        <input class="form-check-input" type="radio" name="payment_type" id="fullPayment" value="full" checked>
                                        <label class="form-check-label" for="fullPayment">
                                            <i class="fas fa-money-bill-wave me-2"></i> Full Payment
                                        </label>
                                    </div>
                                    <div class="form-check payment-option">
                                        <input class="form-check-input" type="radio" name="payment_type" id="installmentPayment" value="installment">
                                        <label class="form-check-label" for="installmentPayment">
                                            <i class="fas fa-calendar-alt me-2"></i> Installment Payment
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Fee Categories (shown for installment payments) -->
                            <div class="mb-4" id="feeCategoriesContainer" style="display: none;">
                                <label class="form-label fw-bold">Select Fee Categories <span class="text-danger">*</span></label>
                                <div class="checkbox-group border p-2 rounded">
                                    <div id="feeCategoriesList">
                                        <!-- Fee categories will be populated by JavaScript -->
                                    </div>
                                </div>
                                <div class="text-danger small mt-1" id="categories-error" style="display:none;">
                                    <i class="fas fa-exclamation-circle me-1"></i>Select at least one fee category
                                </div>
                            </div>

                            <!-- Amount Section -->
                            <div class="mb-4">
                                <label for="amount" class="form-label fw-bold">Amount to Pay <span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bg-light fw-bold">KES</span>
                                    <input type="number" class="form-control" name="amount" id="amount" min="0.01" step="0.01" required>
                                    <button class="btn btn-outline-secondary" type="button" id="pay-full-btn">Pay Full</button>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">
                                        <i class="fas fa-wallet me-1"></i> Balance: 
                                        <span class="fw-bold">KES <span id="available-balance">0.00</span></span>
                                    </small>
                                    <small class="text-muted">
                                        <i class=""></i>You're About To Pay: 
                                        <span class="fw-bold"><span id="paid-percentage">0</span>%</span>
                                    </small>
                                </div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div id="payment-progress" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Payment Method -->
                        <div class="col-md-6 ps-4">
                            <!-- Payment Method -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Payment Method <span class="text-danger">*</span></label>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="payment-method-option" data-method="mpesa">
                                            <input type="radio" name="payment_method" id="mpesaMethod" value="mpesa" class="d-none" required>
                                            <label for="mpesaMethod" class="border rounded p-3 d-block text-center cursor-pointer">
                                                <i class="fas fa-mobile-alt fa-2x text-success mb-2"></i>
                                                <h6 class="fw-bold mb-1">M-Pesa</h6>
                                                <small class="text-muted">Mobile Money</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="payment-method-option" data-method="bank">
                                            <input type="radio" name="payment_method" id="bankMethod" value="bank" class="d-none">
                                            <label for="bankMethod" class="border rounded p-3 d-block text-center cursor-pointer">
                                                <i class="fas fa-university fa-2x text-primary mb-2"></i>
                                                <h6 class="fw-bold mb-1">Bank Transfer</h6>
                                                <small class="text-muted">Bank Payment</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="payment-method-option" data-method="cash">
                                            <input type="radio" name="payment_method" id="cashMethod" value="cash" class="d-none">
                                            <label for="cashMethod" class="border rounded p-3 d-block text-center cursor-pointer">
                                                <i class="fas fa-money-bill-wave fa-2x text-warning mb-2"></i>
                                                <h6 class="fw-bold mb-1">Cash</h6>
                                                <small class="text-muted">Physical Payment</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
    <div class="payment-method-option" data-method="cheque" id="chequeMethodTrigger">
        <input type="radio" name="payment_method" id="chequeMethod" value="cheque" class="d-none">
        <label for="chequeMethod" class="border rounded p-3 d-block text-center cursor-pointer">
            <i class="fas fa-money-check fa-2x text-info mb-2"></i>
            <h6 class="fw-bold mb-1">Cheque</h6>
            <small class="text-muted">Bank Cheque</small>
        </label>
    </div>
</div>
                                </div>
                            </div>
                            
                            <!-- Dynamic Fields Section -->
                            <div id="dynamicFieldsContainer">
                                <!-- M-Pesa Fields -->
                                <div id="mpesaFields" class="method-fields" style="display: none;">
                                    <div class="mb-3">
                                        <label for="mpesa_number" class="form-label fw-bold">Payer Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="mpesa_number" id="mpesa_number" placeholder="e.g. 254712345678">
                                    </div>
                                    <div class="mb-3">
                                        <label for="mpesa_reference" class="form-label fw-bold">M-Pesa Reference Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reference_number" id="mpesa_reference" placeholder="e.g. M-Pesa Transaction Reference">
                                    </div>
                                </div>
                                
                                <!-- Bank Fields -->
                                <div id="bankFields" class="method-fields" style="display: none;">
                                    <div class="mb-3">
                                        <label for="bank_reference" class="form-label fw-bold">Payment Reference <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reference_number" id="bank_reference" placeholder="e.g. Bank Transaction Reference">
                                    </div>
                                    <div class="mb-3">
                                        <label for="bank_slip" class="form-label fw-bold">Upload Slip (Optional)</label>
                                        <input type="file" class="form-control" name="bank_slip" id="bank_slip">
                                    </div>
                                </div>
                                
                                <!-- Notes -->
                                <div class="mb-3">
                                    <label for="notes" class="form-label fw-bold">Payment Notes (Optional)</label>
                                    <textarea class="form-control" name="notes" id="notes" rows="3" placeholder="Additional payment details"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light py-3">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success px-4" id="submitPayment">
                        <i class="fas fa-paper-plane me-2"></i> Process Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hidden template for fee categories -->
<div id="feeCategoriesTemplate" style="display: none;">
@foreach($invoices as $invoice)
    @php
        // Get fees from relationship or direct query
        $fees = $invoice->fees ?? \App\Models\Fee::where('invoice_id', $invoice->id)->get();
        
        // Fallback query if still empty
        if ($fees->isEmpty()) {
            $fees = \App\Models\Fee::where('student_enroll_id', $invoice->student_enroll_id)
                ->where('assign_date', $invoice->assign_date)
                ->where('due_date', $invoice->due_date)
                ->get();
        }
    @endphp
    <div class="fee-categories" data-invoice-id="{{ $invoice->id }}">
        @foreach($fees as $fee)
            @php
                $categoryTitle = $fee->category->title ?? 'Category #' . $fee->category_id;
                $amount = number_format($fee->category->amount ?? $fee->amount, 2);
                $paidAmount = $fee->paid_amount ?? 0;
                $dueAmount = ($fee->category->amount ?? $fee->amount) - $paidAmount;
                $isPaid = $dueAmount <= 0;
            @endphp
            <div class="form-check mb-2">
                <input class="form-check-input fee-category" 
                       type="checkbox" 
                       name="fee_categories[]" 
                       value="{{ $fee->category_id }}" 
                       id="category_{{ $fee->id }}"
                       data-balance="{{ $dueAmount }}"
                       {{ $isPaid ? 'disabled' : '' }}>
                <label class="form-check-label {{ $isPaid ? 'text-muted' : '' }}" for="category_{{ $fee->id }}">
                    {{ $categoryTitle }} 
                    <small class="text-muted">(Ksh {{ $amount }})</small>
                    @if($isPaid)
                        <span class="badge bg-success ms-2">Paid</span>
                    @else
                        <span class="badge bg-warning text-dark ms-2">Due: Ksh {{ number_format($dueAmount, 2) }}</span>
                    @endif
                </label>
            </div>
        @endforeach
    </div>
@endforeach
</div>

<!-- Cheque Payment Modal (updated version) -->
<div class="modal fade" id="chequeModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header py-3 bg-gradient-info text-white">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-money-check me-2"></i>Cheque Payment Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <!-- Left Column - Student Info -->
                    <div class="col-md-5 border-end pe-4">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <i class="fas fa-user-graduate fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold" id="cheque-student-name">Student Name</h6>
                                        <small class="text-muted"><i class="fas fa-id-card me-1"></i> ID: <span id="cheque-student-id">N/A</span></small>
                                    </div>
                                </div>
                                <div class="alert alert-primary py-2 mb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong>Total Due:</strong>
                                        <span class="fw-bold fs-6">KES <span id="cheque-total-due">0.00</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Cheque Information</h6>
                            </div>
                            <div class="card-body p-3">
                                <ul class="list-unstyled small mb-0">
                                    <li class="mb-2"><i class="fas fa-check-circle text-info me-2"></i> Cheque should be payable to the school</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-info me-2"></i> Must be dated within 3 months</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-info me-2"></i> Amount should match payment</li>
                                    <li><i class="fas fa-check-circle text-info me-2"></i> Clear signature required</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column - Cheque Form -->
                    <div class="col-md-7 ps-4">
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-money-check fa-lg me-3"></i>
                                <div>
                                    <strong>Cheque Payment Processing</strong>
                                    <p class="mb-0 small">Please provide complete cheque details below. Payments may take 3-5 working days to clear.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cheque_number" class="form-label fw-bold">Cheque Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="cheque_number" id="cheque_number" placeholder="e.g. 123456" required>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="cheque_bank" class="form-label fw-bold">Bank Name <span class="text-danger">*</span></label>
                                <select class="form-select" name="cheque_bank" id="cheque_bank" required>
                                    <option value="">Select Bank</option>
                                    <option value="equity">Equity Bank</option>
                                    <option value="kcb">KCB Bank</option>
                                    <option value="coop">Co-operative Bank</option>
                                    <option value="standard">Standard Chartered</option>
                                    <option value="barclays">Absa Bank</option>
                                    <option value="dtb">Diamond Trust Bank</option>
                                    <option value="ncba">NCBA Bank</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="cheque_branch" class="form-label fw-bold">Branch <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="cheque_branch" id="cheque_branch" placeholder="e.g. Nairobi West" required>
                            </div>
                        </div>
                        
                        <div class="row g-3 mt-0">
                            <div class="col-md-6">
                                <label for="cheque_date" class="form-label fw-bold">Cheque Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="cheque_date" id="cheque_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cheque_amount" class="form-label fw-bold">Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">KES</span>
                                    <input type="number" class="form-control" name="cheque_amount" id="cheque_amount" min="0.01" step="0.01" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3 mt-3">
                            <label for="cheque_issuer" class="form-label fw-bold">Issuer Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="cheque_issuer" id="cheque_issuer" placeholder="Name on the cheque" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cheque_image" class="form-label fw-bold">Upload Cheque Copy <small class="text-muted">(Front side, clear image)</small></label>
                            <input type="file" class="form-control" name="cheque_image" id="cheque_image" accept="image/*">
                            <small class="text-muted">Max 2MB (JPEG, PNG, PDF)</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light py-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Cancel
                </button>
                <button type="button" class="btn btn-info px-4" id="confirmChequePayment">
                    <i class="fas fa-check-circle me-2"></i> Confirm Cheque Payment
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Invoice View Modal -->
<div class="modal fade" id="invoiceViewModal" tabindex="-1" aria-labelledby="invoiceViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header with Status Indicator -->
            <div class="modal-header bg-primary text-white position-relative">
                <div class="d-flex align-items-center w-100">
                    <div class="flex-grow-1">
                        <h5 class="modal-title mb-0" id="invoiceViewModalLabel">
                            <i class="fas fa-file-invoice me-2"></i>Invoice Details
                        </h5>
                        <div class="d-flex align-items-center mt-1">
                            <span id="invoiceStatusBadge" class="badge me-2"></span>
                            <small id="invoiceReference" class="text-white-50"></small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body p-4">
                <!-- Summary Section -->
                <div class="row g-4 mb-4">
                    <!-- Institution Info -->
                    <div class="col-md-5">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="height: 50px;" class="me-3">
                            <div>
                                <h4 class="mb-0 fw-bold">{{ config('app.name') }}</h4>
                                <small class="text-muted">Education Management System</small>
                            </div>
                        </div>
                        
                        <!-- Student Card -->
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold d-flex align-items-center">
                                    <i class="fas fa-user-graduate me-2"></i>Student Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <p class="mb-1"><strong>Name:</strong></p>
                                        <p class="mb-1"><strong>Student ID:</strong></p>
                                        <p class="mb-1"><strong>Program:</strong></p>
                                    </div>
                                    <div class="col-6">
                                        <p class="mb-1 text-primary" id="studentName"></p>
                                        <p class="mb-1 text-primary" id="studentId"></p>
                                        <p class="mb-1 text-primary" id="studentProgram"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Invoice Summary -->
                    <div class="col-md-7">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold d-flex align-items-center">
                                    <i class="fas fa-info-circle me-2"></i>Invoice Summary
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label small text-muted mb-0">Invoice Number</label>
                                            <p class="fw-bold text-primary mb-0" id="invoiceNo"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small text-muted mb-0">Issue Date</label>
                                            <p class="fw-bold mb-0" id="invoiceDate"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label small text-muted mb-0">Due Date</label>
                                            <p class="fw-bold mb-0" id="dueDate"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small text-muted mb-0">Status</label>
                                            <p class="fw-bold mb-0"><span class="badge" id="paymentStatus"></span></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Amount Summary -->
                                <div class="border-top pt-3 mt-3">
                                    <div class="row g-2">
                                        <div class="col-4">
                                            <div class="bg-light p-2 rounded text-center">
                                                <small class="text-muted d-block">Total Amount</small>
                                                <strong class="d-block" id="totalAmount"></strong>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="bg-light p-2 rounded text-center">
                                                <small class="text-muted d-block">Amount Paid</small>
                                                <strong class="d-block text-success" id="totalPaid"></strong>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="bg-light p-2 rounded text-center">
                                                <small class="text-muted d-block">Balance Due</small>
                                                <strong class="d-block text-danger" id="totalDue"></strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Fee Breakdown -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="fas fa-list-alt me-2"></i>Fee Breakdown
                        </h6>
                        <button class="btn btn-sm btn-outline-primary" id="expandAllFees">
                            <i class="fas fa-expand me-1"></i> Expand All
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="35%">Fee Category</th>
                                        <th width="20%" class="text-end">Amount</th>
                                        <th width="20%" class="text-end">Paid</th>
                                        <th width="20%" class="text-end">Due</th>
                                    </tr>
                                </thead>
                                <tbody id="feeItems">
                                    <!-- Fee items will be populated here -->
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <th class="text-end" id="feeTotalAmount"></th>
                                        <th class="text-end" id="feeTotalPaid"></th>
                                        <th class="text-end" id="feeTotalDue"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Payment History -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="fas fa-history me-2"></i>Payment History
                        </h6>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="paymentHistoryFilter" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="paymentHistoryFilter">
                                <li><a class="dropdown-item" href="#" data-filter="all">All Payments</a></li>
                                <li><a class="dropdown-item" href="#" data-filter="last30">Last 30 Days</a></li>
                                <li><a class="dropdown-item" href="#" data-filter="this-year">This Year</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="20%">Date</th>
                                        <th width="25%">Transaction ID</th>
                                        <th width="20%">Method</th>
                                        <th width="15%" class="text-end">Amount</th>
                                        <th width="15%">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="paymentHistory">
                                    <!-- Payment history will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Options -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="fas fa-credit-card me-2"></i>Payment Options
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Bank Transfer -->
                            <div class="col-md-6">
                                <div class="border p-3 rounded h-100">
                                    <h6 class="fw-bold d-flex align-items-center mb-3">
                                        <i class="fas fa-university me-2"></i>Bank Transfer
                                    </h6>
                                    <div id="bankDetails" class="mb-3">
                                        <!-- Bank details will be populated here -->
                                    </div>
                                    <button class="btn btn-outline-primary btn-sm w-100" id="copyBankDetails">
                                        <i class="far fa-copy me-1"></i> Copy Bank Details
                                    </button>
                                </div>
                            </div>
                            
                            <!-- M-Pesa Payment -->
                            <div class="col-md-6">
                                <div class="border p-3 rounded h-100">
                                    <h6 class="fw-bold d-flex align-items-center mb-3">
                                        <i class="fas fa-mobile-alt me-2"></i>M-Pesa Payment
                                    </h6>
                                    <div id="mpesaDetails" class="mb-3">
                                        <!-- M-Pesa details will be populated here -->
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-success" id="initiateMpesaPayment">
                                            <i class="fas fa-mobile-alt me-2"></i> Pay via M-Pesa
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" id="showMpesaInstructions">
                                            <i class="fas fa-question-circle me-1"></i> How to Pay
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer bg-light">
                <div class="d-flex justify-content-between w-100">
                    <div>
                        <button type="button" class="btn btn-outline-secondary me-2" id="sendInvoiceBtn">
                            <i class="fas fa-paper-plane me-1"></i> Send to Student
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="downloadInvoiceBtn">
                            <i class="fas fa-download me-1"></i> Download
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Close
                        </button>
                        <button type="button" class="btn btn-primary me-2" id="printInvoiceBtn">
                            <i class="fas fa-print me-1"></i> Print
                        </button>
                        <button type="button" class="btn btn-success" id="makePaymentBtn" style="display: none;">
                            <i class="fas fa-money-bill-wave me-1"></i> Make Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- M-Pesa Instructions Modal -->
<div class="modal fade" id="mpesaInstructionsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">M-Pesa Payment Instructions</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <strong>Follow these steps to complete your payment via M-Pesa:</strong>
                </div>
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item">Go to M-Pesa on your phone</li>
                    <li class="list-group-item">Select "Pay Bill" option</li>
                    <li class="list-group-item">Enter the Paybill number provided above</li>
                    <li class="list-group-item">Enter your invoice number as the account number</li>
                    <li class="list-group-item">Enter the exact amount due</li>
                    <li class="list-group-item">Enter your M-Pesa PIN and confirm</li>
                    <li class="list-group-item">Wait for confirmation message</li>
                </ol>
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Note:</strong> Payments may take up to 5 minutes to reflect in the system.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add this modal HTML at the bottom of your page, before the closing </body> tag -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="invoiceModalLabel">Invoice Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="invoiceModalBody">
                <!-- Invoice content will be loaded here dynamically -->
                <div class="text-center py-5" id="loadingSpinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Loading invoice details...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 <button class="btn btn-sm btn-primary print-btn" 
        data-invoice-id="{{ $invoice->id }}"
        data-invoice-no="{{ $invoice->invoice_no }}"
        data-student-name="{{ $invoice->studentEnroll->student->full_name ?? 'N/A' }}"
        data-student-id="{{ $invoice->studentEnroll->student->student_id ?? 'N/A' }}"
        data-class="{{ $invoice->studentEnroll->class->name ?? 'N/A' }}"
        data-section="{{ $invoice->studentEnroll->section->name ?? 'N/A' }}"
        data-assign-date="{{ $invoice->assign_date }}"
        data-due-date="{{ $invoice->due_date }}"
        data-total-fee="{{ $invoice->total_fee }}"
        data-amount-paid="{{ $invoice->amount_paid ?? 0 }}"
        data-amount-due="{{ $invoice->amount_due }}"
        data-payment-status="{{ $invoice->payment_status }}"
        data-fee-details='@json($fees->map(function($fee) { 
            return [
                'category_title' => $fee->category->title ?? 'Category #' . $fee->category_id,
                'description' => $fee->category->description ?? '',
                'amount' => $fee->category->amount ?? $fee->amount
            ]; 
        }))'
        data-payments='@json($invoice->payments ?? [])'
        title="Print Invoice">
    <i class="fas fa-print"></i> Print Invoice
</button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden div for printing -->
<div id="printableInvoice" style="display:none;"></div>


@else
<div class="alert alert-info mt-3 p-2">
    No invoices found for this student.
</div>
@endif

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #printableInvoice, #printableInvoice * {
            visibility: visible;
        }
        #printableInvoice {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
    }
    
    .invoice-header {
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }
    
    .invoice-table th {
        background-color: #f8f9fa;
    }
    
    .total-row {
        font-weight: bold;
        background-color: #f8f9fa;
    }
</style>


@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
  .select2-container--default .select2-selection--multiple {
    border: 1px solid #ced4da;
    padding: 0.375rem 0.75rem;
    min-height: 38px;
  }
  .select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
  }
  .select2-container--default .select2-results__option .category-title {
    margin-right: 10px;
    font-weight: 500;
  }
  .select2-container--default .select2-results__option .category-amount {
    font-size: 0.9em;
    color: #198754;
    font-weight: 500;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #e9ecef;
    border: 1px solid #ced4da;
    color: #495057;
    white-space: nowrap;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-right: 4px;
    margin-top: 4px;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    margin-right: 4px;
    color: #6c757d;
  }
</style>
@endpush



<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Print button functionality
    document.querySelectorAll('.print-btn').forEach(button => {
        button.addEventListener('click', function() {
            const invoiceId = this.getAttribute('data-id');
            
            // First, we need to get the invoice data (similar to the view functionality)
            const btn = $(this);
            const invoiceData = {
                invoice_no: btn.data('invoice-no') || 'INV-001',
                student_name: btn.data('student-name') || 'Student Name',
                student_id: btn.data('student-id') || 'STD-001',
                class: btn.data('class') || 'Class',
                section: btn.data('section') || 'Section',
                assign_date: btn.data('assign-date') || new Date().toISOString(),
                due_date: btn.data('due-date') || new Date().toISOString(),
                total_fee: btn.data('total-fee') || 0,
                amount_paid: btn.data('amount-paid') || 0,
                amount_due: btn.data('amount-due') || 0,
                payment_status: btn.data('payment-status') || 'pending',
                fee_details: btn.data('fee-details') || [],
                payments: btn.data('payments') || []
            };

            // Format the invoice HTML
            const invoiceHtml = formatInvoiceHtml(invoiceData);
            
            // Set the printable content
            document.getElementById('printableInvoice').innerHTML = invoiceHtml;
            
            // Call the print function
            printInvoice();
        });
    });

    // Print function that handles the actual printing
    function printInvoice() {
        const printContent = document.getElementById('printableInvoice').innerHTML;
        const originalContent = document.body.innerHTML;
        
        document.body.innerHTML = printContent;
        window.print();
        
        // Restore the original content after printing
        setTimeout(() => {
            document.body.innerHTML = originalContent;
        }, 500);
    }

    /**
     * Formats invoice data into HTML
     * @param {Object} data - Invoice data object
     * @returns {string} - Formatted HTML string
     */
    function formatInvoiceHtml(data) {
        // Helper functions for formatting
        const formatDate = (dateString) => {
            return new Date(dateString).toLocaleDateString('en-US', {
                year: 'numeric', 
                month: 'short', 
                day: 'numeric'
            });
        };

        const formatCurrency = (amount) => {
            return parseFloat(amount).toLocaleString('en-US', {
                style: 'currency',
                currency: 'Ksh'
            });
        };

        // Main invoice template
        return `
        <div class="invoice-container" style="padding: 20px; font-family: Arial, sans-serif;">
            <!-- Invoice Header Section -->
            <div class="invoice-header d-flex justify-content-between mb-4">
                <div>
                    <h3 class="text-primary">FEES INVOICE</h3>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th class="text-end">Invoice ID:</th>
                            <td>${data.invoice_no}</td>
                        </tr>
                        <tr>
                            <th class="text-end">Issued Date:</th>
                            <td>${formatDate(data.assign_date)}</td>
                        </tr>
                        <tr>
                            <th class="text-end">Due Date:</th>
                            <td>${formatDate(data.due_date)}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Client and Summary Section -->
            <div class="row mb-4">
                <!-- Client Information -->
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="card h-100">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Billed To: </h6>
                        </div>
                        <div class="card-body py-2">
                            <h5>${data.student_name}</h5>
                            <p class="mb-1">Student ID: ${data.student_id}</p>
                           
                        </div>
                    </div>
                </div>
                
                <!-- Payment Summary -->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Payment Summary</h6>
                        </div>
                        <div class="card-body py-2">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge ${data.payment_status === 'paid' ? 'bg-success' : 
                                          data.payment_status === 'partial' ? 'bg-warning' : 'bg-danger'}">
                                            ${data.payment_status.charAt(0).toUpperCase() + data.payment_status.slice(1)}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Amount:</th>
                                    <td>${formatCurrency(data.total_fee)}</td>
                                </tr>
                                
                                <tr class="table-active">
                                    <th>Amount Due:</th>
                                    <td>${formatCurrency(data.amount_due)}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Fee Details Table -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Fee Category Invoiced</th>
                            <th width="20%" class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.fee_details.map((fee, index) => `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${fee.category_title || 'Fee Category'}</td>
                                <td class="text-end">${formatCurrency(fee.amount || 0)}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="2" class="text-end">Total Invoiced:</th>
                            <th class="text-end">${formatCurrency(data.total_fee)}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <!-- Payment History Section (Conditional) -->
            ${data.payments && data.payments.length ? `
            <div class="mb-4">
                <h5 class="mb-3">Payment History of this Invoice</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Payment Date</th>
                                <th>Amount Paid</th>
                                <th>Payment Method</th>
                                <th>Reference Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.payments.map(payment => `
                                <tr>
                                    <td>${formatDate(payment.payment_date || payment.created_at || new Date().toISOString())}</td>
                                    <td>${formatCurrency(payment.amount || 0)}</td>
                                    <td>${payment.payment_method || 'N/A'}</td>
                                    <td>${payment.reference_number || 'N/A'}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
            ` : ''}
            
            <!-- Footer Note -->
            <div class="text-muted small">
                <i class="fas fa-info-circle me-1"></i>
                Invoice generated on ${new Date().toLocaleString()}
            </div>
        </div>
        `;
    }
});
</script>




<script>
    /**
     * Invoice Viewer Script
     * Handles the display of invoice details in a modal
     * Features: Loading states, data formatting, responsive layout
     */
    
    // Document ready handler for invoice viewing
    $(document).on('click', '.view-invoice-btn', function() {
        const btn = $(this);
        const modal = $('#invoiceModal');
        
        // Show loading state on button
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        
        // Initialize modal with loading state
        $('#invoiceModalBody').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading invoice details...</p>
            </div>
        `);
        
        // Extract invoice data from button attributes
        const invoiceData = {
            invoice_no: btn.data('invoice-no'),
            student_name: btn.data('student-name'),
            student_id: btn.data('student-id'),
            class: btn.data('class'),
            section: btn.data('section'),
            assign_date: btn.data('assign-date'),
            due_date: btn.data('due-date'),
            total_fee: btn.data('total-fee'),
            amount_paid: btn.data('amount-paid'),
            amount_due: btn.data('amount-due'),
            payment_status: btn.data('payment-status'),
            fee_details: btn.data('fee-details'),
            payments: btn.data('payments')
        };

        // Set modal title with invoice info
        $('#invoiceModalLabel').html(`
            
        `);

        // Show modal
        new bootstrap.Modal(modal.get(0)).show();
        
        // Simulate AJAX delay (remove in production)
        setTimeout(() => {
            // Format and display invoice
            const invoiceHtml = formatInvoiceHtml(invoiceData);
            $('#invoiceModalBody').html(invoiceHtml);
            $('#printableInvoice').html(invoiceHtml);
            
            // Reset button state
            btn.prop('disabled', false).html('<i class="fas fa-eye"></i>');
        }, 800); // Simulate network delay
    });

/**
     * Prints the invoice
     */
    function printInvoice() {
        const printContent = document.getElementById('printableInvoice').innerHTML;
        const originalContent = document.body.innerHTML;
        
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        
        
    }



    /**
     * Formats invoice data into HTML
     * @param {Object} data - Invoice data object
     * @returns {string} - Formatted HTML string
     */
    function formatInvoiceHtml(data) {
        // Helper functions for formatting
        const formatDate = (dateString) => {
            return new Date(dateString).toLocaleDateString('en-US', {
                year: 'numeric', 
                month: 'short', 
                day: 'numeric'
            });
        };

        const formatCurrency = (amount) => {
            return parseFloat(amount).toLocaleString('en-US', {
                style: 'currency',
                currency: 'Ksh'
            });
        };

        // Main invoice template
        return `
        <div class="invoice-container">
            <!-- Invoice Header Section -->
            <div class="invoice-header d-flex justify-content-between mb-4">
                <div>
                    <h3 class="text-primary">FEES INVOICE</h3>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th class="text-end">Invoice ID:</th>
                            <td>${data.invoice_no}</td>
                        </tr>
                        <tr>
                            <th class="text-end">Issued Date:</th>
                            <td>${formatDate(data.assign_date)}</td>
                        </tr>
                        <tr>
                            <th class="text-end">Due Date:</th>
                            <td>${formatDate(data.due_date)}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Client and Summary Section -->
            <div class="row mb-4">
                <!-- Client Information -->
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="card h-100">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Billed To: </h6>
                        </div>
                        <div class="card-body py-2">
                            <h5>${data.student_name}</h5>
                            <p class="mb-1">Student ID: ${data.student_id}</p>
                           
                        </div>
                    </div>
                </div>
                
                <!-- Payment Summary -->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Payment Summary</h6>
                        </div>
                        <div class="card-body py-2">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge ${data.payment_status === 'paid' ? 'bg-success' : 
                                          data.payment_status === 'partial' ? 'bg-warning' : 'bg-danger'}">
                                            ${data.payment_status.charAt(0).toUpperCase() + data.payment_status.slice(1)}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Amount:</th>
                                    <td>${formatCurrency(data.total_fee)}</td>
                                </tr>
                                
                                <tr class="table-active">
                                    <th>Amount Due:</th>
                                    <td>${formatCurrency(data.amount_due)}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Fee Details Table -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Fee Category Invoiced</th>
                            <th width="20%" class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.fee_details.map((fee, index) => `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${fee.category_title}</td>
                                <td class="text-end">${formatCurrency(fee.amount)}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="2" class="text-end">Total Invoiced:</th>
                            <th class="text-end">${formatCurrency(data.total_fee)}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <!-- Payment History Section (Conditional) -->
            ${data.payments && data.payments.length ? `
            <div class="mb-4">
                <h5 class="mb-3">Payment History of this Invoice</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Payment Date</th>
                                <th>Amount Paid</th>
                                <th>Payment Method</th>
                                <th>Reference Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.payments.map(payment => `
                                <tr>
                                    <td>${formatDate(payment.payment_date || payment.created_at)}</td>
                                    <td>${formatCurrency(payment.amount)}</td>
                                    <td>${payment.payment_method || 'N/A'}</td>
                                    <td>${payment.reference_number || 'N/A'}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
            ` : ''}
            
            <!-- Footer Note -->
            <div class="text-muted small no-print">
                <i class="fas fa-info-circle me-1"></i>
                Invoice generated on ${new Date().toLocaleString()}
            </div>
        </div>
        `;
    }
</script>

<script>
$(document).ready(function() {
    // Store student names for lookup
    const studentNames = {};
    @foreach($students as $student)
        studentNames[{{ $student->id }}] = '{{ $student->student->first_name }} {{ $student->student->last_name }}';
    @endforeach

    // Edit button click handler
    $(document).on('click', '.edit-btn', function() {
        const invoiceId = $(this).data('invoice-id');
        const studentId = $(this).data('student-id');
        const feeDetails = $(this).data('fee-details');
        const assignDate = $(this).data('assign-date');
        const dueDate = $(this).data('due-date');
        const totalAmount = $(this).data('total-amount');
        
        // Get student name
        const studentName = studentNames[studentId] || 'Selected Student';
        
        // Show toast with student name
        toastr.success(`Loading invoice data for: <strong>${studentName}</strong>`, 'Editing Invoice', {
            timeOut: 3000,
            extendedTimeOut: 1000,
            progressBar: true,
            closeButton: true,
            positionClass: 'toast-top-center',
            onHidden: function() {
                // After toast disappears, scroll to form
                $('html, body').animate({
                    scrollTop: $('#quick-assign-form').offset().top - 20
                }, 500);
            }
        });
        
        // Set form values
        $('#invoice_id').val(invoiceId);
        $('#student').val([studentId]).trigger('change');
        $('#assign_date').val(assignDate);
        $('#due_date').val(dueDate);
        
        // Clear and repopulate categories with amounts
        $('#categories').val(null).trigger('change');
        
        // Prepare categories with amounts for selection
        $('#categories option').each(function() {
            const categoryId = $(this).val();
            const feeDetail = feeDetails.find(f => f.category_id == categoryId);
            
            if (feeDetail) {
                $(this).prop('selected', true);
                // Update the amount display
                $(this).text(
                    $(this).data('original-text') + 
                    ' (Original: ' + feeDetail.amount.toFixed(2) + 
                    ', Paid: ' + feeDetail.paid_amount.toFixed(2) + 
                    ', Due: ' + feeDetail.due_amount.toFixed(2) + ')'
                );
            }
        });
        
        $('#categories').trigger('change');
        
        // Update total amount display
        $('#total-amount').text(totalAmount.toFixed(2));
        $('#total-amount-input').val(totalAmount);
        
        // Change form to edit mode
        $('.card-header h5').text('Edit Fee Assignment - ' + studentName);
        $('.btn-success').html('<i class="fas fa-save"></i> Update');
        $('#cancel-edit').show();
    });
    
    // Cancel edit button
    $('#cancel-edit').click(function() {
        resetForm();
        toastr.info('Edit mode canceled', '', {
            timeOut: 2000,
            positionClass: 'toast-top-center'
        });
    });
    
    function resetForm() {
        $('#invoice_id').val('');
        $('#student').val(null).trigger('change');
        
        // Reset categories display
        $('#categories option').each(function() {
            if ($(this).data('original-text')) {
                $(this).text($(this).data('original-text'));
            }
        });
        
        $('#categories').val(null).trigger('change');
        $('#assign_date').val('{{ date('Y-m-d') }}');
        $('#due_date').val('{{ date('Y-m-d', strtotime('+30 days')) }}');
        $('#total-amount').text('0.00');
        $('#total-amount-input').val('0');
        $('.card-header h5').text('{{ $title }}');
        $('.btn-success').html('<i class="fas fa-check"></i> {{ __("btn_save") }}');
        $('#cancel-edit').hide();
    }
    
    // Initialize original text for category options
    $('#categories option').each(function() {
        $(this).data('original-text', $(this).text());
    });
});
</script>
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000"
    };
</script>
    
<script>
$(document).ready(function() {
    let selectedCategories = [];
    let categoriesTotal = 0;

    $('.edit-invoice-btn').click(function() {
        // Reset state
        selectedCategories = [];
        categoriesTotal = 0;
        $('#selected_categories').empty();
        $('#categories_total').text('0.00');
        $('#available_categories').val('').trigger('change');

        // Get invoice data
        const invoiceId = $(this).data('invoice-id');
        const studentId = $(this).data('student-id');
        const assignDate = $(this).data('assign-date');
        const dueDate = $(this).data('due-date');
        const totalAmount = $(this).data('total-amount');
        const currentCategories = $(this).data('current-categories');
        const feeDetails = $(this).data('fee-details');

        // Update form
        $('#edit_invoice_id').val(invoiceId);
        $('#edit_student_enroll_id').val(studentId);
        $('#edit_assign_date').val(assignDate);
        $('#edit_due_date').val(dueDate);
        $('#total_fee_input').val(totalAmount);
        $('#categories_total').text(parseFloat(totalAmount).toFixed(2));

        // Initialize Select2
        if (!$('#available_categories').hasClass("select2-hidden-accessible")) {
            $('#available_categories').select2({
                placeholder: "Select a category to add",
                allowClear: true
            });
        }

        // Load current categories if they exist
        if (currentCategories && currentCategories.length > 0) {
            currentCategories.forEach(catId => {
                const categoryOption = $('#available_categories option[value="' + catId + '"]');
                if (categoryOption.length > 0) {
                    addCategoryToSelection(
                        catId,
                        categoryOption.text(),
                        categoryOption.data('amount')
                    );
                }
            });
        }

        // Show modal
        $('#editInvoiceModal').modal('show');
    });

    // Add category button click handler
    $('#add_category_btn').click(function() {
        const categorySelect = $('#available_categories');
        const selectedOption = categorySelect.find('option:selected');
        
        if (selectedOption.val()) {
            // Check if category already added
            if (!selectedCategories.includes(selectedOption.val())) {
                addCategoryToSelection(
                    selectedOption.val(),
                    selectedOption.text(),
                    selectedOption.data('amount')
                );
                categorySelect.val('').trigger('change');
            } else {
                alert('This category is already added');
            }
        }
    });

    // Function to add a category to the selection
    function addCategoryToSelection(id, name, amount) {
        selectedCategories.push(id);
        categoriesTotal += parseFloat(amount);
        
        $('#selected_categories').append(`
            <tr data-category-id="${id}">
                <td>${name}</td>
                <td>${parseFloat(amount).toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-category-btn">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);
        
        updateTotals();
    }

    // Remove category button handler
    $(document).on('click', '.remove-category-btn', function() {
        const row = $(this).closest('tr');
        const categoryId = row.data('category-id');
        const amount = parseFloat(row.find('td:eq(1)').text());
        
        // Remove from selected categories
        selectedCategories = selectedCategories.filter(id => id != categoryId);
        categoriesTotal -= amount;
        
        // Remove row
        row.remove();
        updateTotals();
    });

    // Update totals and hidden inputs
    function updateTotals() {
        $('#categories_total').text(categoriesTotal.toFixed(2));
        $('#total_fee_input').val(categoriesTotal.toFixed(2));
        $('#fee_categories_input').val(JSON.stringify(selectedCategories));
    }
});
</script>
<script>
$(document).ready(function() {
    // Initialize all modals
    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));

    // Payment button click handler
    $(document).on('click', '.payment-btn', function() {
        const invoiceId = $(this).data('invoice-id');
        const studentEnrollId = $(this).data('student-enroll-id');
        const amountDue = parseFloat($(this).data('amount-due')) || 0;
        
        // Get student info from the table row
        const row = $(this).closest('tr');
        const studentName = row.find('td:nth-child(2)').text();
        const studentId = row.find('td:nth-child(2)').text().match(/ID: (\w+)/)?.[1] || 'N/A';
        const invoiceNo = row.find('td:nth-child(1)').text();
        const dueDate = row.find('td:nth-child(7)').text();
        
        // Set basic info in modal
        $('#modal_invoice_id').val(invoiceId);
        $('#modal_student_enroll_id').val(studentEnrollId);
        $('#modal-total-due').text(amountDue.toLocaleString('en-US', {minimumFractionDigits: 2}));
        $('#full-amount-due').val(amountDue);
        $('#amount').val(amountDue.toFixed(2)).attr('max', amountDue);
        $('#available-balance').text(amountDue.toLocaleString('en-US', {minimumFractionDigits: 2}));
        
        // Set student info
        $('#payment-student-name').text(studentName);
        $('#payment-student-id').text(studentId);
        $('#payment-invoice-no').text(invoiceNo);
        $('#payment-due-date').text(dueDate);
        
        // Reset form
        $('#paymentForm')[0].reset();
        $('#feeCategoriesContainer').hide();
        $('#is_installment').val('0');
        $('#fullPayment').prop('checked', true);
        $('.payment-method-option').removeClass('active-method');
        $('.method-fields').hide();
        
        // Load fee categories from template
        loadFeeCategories(invoiceId);
        
        updatePaymentProgress(amountDue, amountDue);
        
        // Show modal
        paymentModal.show();
    });

    // Function to load fee categories from template
    function loadFeeCategories(invoiceId) {
        // Find the template for this invoice
        const template = $(`#feeCategoriesTemplate .fee-categories[data-invoice-id="${invoiceId}"]`).html();
        
        if (template) {
            $('#feeCategoriesList').html(template);
        } else {
            $('#feeCategoriesList').html('<div class="alert alert-warning py-2 mb-0">No fee categories found for this invoice</div>');
        }
    }

    // Payment type toggle
    $('input[name="payment_type"]').change(function() {
        if ($(this).val() === 'installment') {
            $('#feeCategoriesContainer').show();
            $('#is_installment').val('1');
            
            // Validate at least one category is selected
            if ($('.fee-category:checked:not(:disabled)').length === 0) {
                $('#categories-error').show();
            } else {
                $('#categories-error').hide();
            }
        } else {
            $('#feeCategoriesContainer').hide();
            $('#is_installment').val('0');
            $('#amount').val($('#full-amount-due').val());
            $('#categories-error').hide();
        }
    });

    // Category selection handler
    $(document).on('change', '.fee-category', function() {
        if ($('input[name="payment_type"]:checked').val() === 'installment') {
            const selectedCategories = $('.fee-category:checked:not(:disabled)');
            
            if (selectedCategories.length === 0) {
                $('#categories-error').show();
            } else {
                $('#categories-error').hide();
                
                // Calculate total amount for selected categories
                let totalAmount = 0;
                selectedCategories.each(function() {
                    totalAmount += parseFloat($(this).data('balance'));
                });
                
                $('#amount').val(totalAmount.toFixed(2)).attr('max', totalAmount);
                updatePaymentProgress(totalAmount, parseFloat($('#full-amount-due').val()));
            }
        }
    });

    // Pay full amount button
    $('#pay-full-btn').click(function() {
        $('#amount').val($('#full-amount-due').val());
        updatePaymentProgress(parseFloat($('#full-amount-due').val()), parseFloat($('#full-amount-due').val()));
    });

    // Amount validation
    $('#amount').on('input', function() {
        const maxAmount = parseFloat($('#full-amount-due').val()) || 0;
        let enteredAmount = parseFloat($(this).val()) || 0;
        
        if (enteredAmount > maxAmount) {
            enteredAmount = maxAmount;
            $(this).val(enteredAmount.toFixed(2));
        }
        
        updatePaymentProgress(enteredAmount, maxAmount);
    });

    // Payment method selection
    $('.payment-method-option').click(function() {
        const method = $(this).data('method');
        $('.payment-method-option').removeClass('active-method');
        $(this).addClass('active-method');
        $('#' + method + 'Method').prop('checked', true);
        
        // Hide all method fields
        $('.method-fields').hide();
        
        // Show fields for the selected method
        $('#' + method + 'Fields').show();
    });

    // Form validation before submission
    $('#paymentForm').submit(function(e) {
        e.preventDefault();
        
        // Validate payment type
        if ($('#installmentPayment').is(':checked') && $('.fee-category:checked:not(:disabled)').length === 0) {
            $('#categories-error').show();
            toastr.error('Please select at least one fee category for installment payment');
            return false;
        }
        
        // Validate amount
        const amount = parseFloat($('#amount').val()) || 0;
        if (amount <= 0) {
            toastr.error('Please enter a valid payment amount');
            return false;
        }
        
        // Validate payment method
        if (!$('input[name="payment_method"]:checked').val()) {
            toastr.error('Please select a payment method');
            return false;
        }

        
        
        // If all validations pass, submit the form
        $('#submitPayment').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Processing...');
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
    if (response.success) {
        toastr.success(response.message);
        if (response.redirect_url) {
            // Open receipt in new tab
            const receiptWindow = window.open(response.redirect_url, '_blank');
            
            // Focus on the new window (optional)
            if (receiptWindow) {
                receiptWindow.focus();
            }
            
            // Reload current page after a small delay (300ms)
            setTimeout(() => {
                window.location.reload();
            }, 300);
        } else {
            paymentModal.hide();
            window.location.reload();
        }
    } else {
        toastr.error(response.message);
        $('#submitPayment').prop('disabled', false).html('<i class="fas fa-paper-plane me-2"></i> Process Payment');
    }
},
            error: function(xhr) {
                const errorMessage = xhr.responseJSON?.message || 'Payment processing failed';
                toastr.error(errorMessage);
                $('#submitPayment').prop('disabled', false).html('<i class="fas fa-paper-plane me-2"></i> Process Payment');
            }
        });
    });

    // Helper function to update payment progress
    function updatePaymentProgress(paidAmount, totalAmount) {
        const percentage = totalAmount > 0 ? Math.min(100, (paidAmount / totalAmount) * 100) : 0;
        $('#paid-percentage').text(Math.round(percentage));
        $('#payment-progress').css('width', percentage + '%');
    }
});
// Add this to your existing script
$(document).ready(function() {
    const chequeModal = new bootstrap.Modal(document.getElementById('chequeModal'));
    
    // When cheque method is selected in payment modal
    $('#chequeMethodTrigger').click(function() {
        // Set student info in cheque modal
        $('#cheque-student-name').text($('#payment-student-name').text());
        $('#cheque-student-id').text($('#payment-student-id').text());
        $('#cheque-total-due').text($('#modal-total-due').text());
        $('#cheque_amount').val($('#amount').val());
        
        // Show cheque modal
        chequeModal.show();
    });
    
    // Confirm cheque payment button
    $('#confirmChequePayment').click(function() {
        // Validate form
        let isValid = true;
        $('#chequeModal [required]').each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            toastr.error('Please fill all required fields');
            return;
        }
        
        // Validate cheque date is not in the past
        const chequeDate = new Date($('#cheque_date').val());
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (chequeDate < today) {
            toastr.error('Cheque date cannot be in the past');
            $('#cheque_date').addClass('is-invalid');
            return;
        }
        
        // Validate amount matches
        const paymentAmount = parseFloat($('#amount').val());
        const chequeAmount = parseFloat($('#cheque_amount').val());
        
        if (chequeAmount !== paymentAmount) {
            toastr.error('Cheque amount must match the payment amount');
            $('#cheque_amount').addClass('is-invalid');
            return;
        }
        
        // If validation passes
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Processing...');
        
        // Here you would typically submit the form or collect the data
        // For now, we'll just close the modals and show a success message
        setTimeout(function() {
            chequeModal.hide();
            paymentModal.hide();
            toastr.success('Cheque payment submitted successfully');
            // In a real implementation, you would submit the form here
            // $('#paymentForm').submit();
        }, 1500);
    });
});
</script>
<style>
.payment-method-option {
    transition: all 0.2s ease;
    cursor: pointer;
}

.payment-method-option:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.payment-method-option.active-method label {
    border: 2px solid #0d6efd !important;
    background-color: rgba(13, 110, 253, 0.05);
}

.method-fields {
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 5px;
    margin-top: 15px;
}

/* Ensure all form controls are properly styled and visible */
.payment-details-modal .form-control {
    height: auto;
    padding: 0.5rem 0.75rem;
    font-size: 1rem;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    background-color: #fff;
}

.payment-details-modal .form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.payment-details-modal .form-label {
    margin-bottom: 0.5rem;
    font-weight: 500;
}

/* Make sure modals are properly positioned and visible */
.payment-details-modal {
    z-index: 1060 !important;
}

/* Fix for modal backdrop issue */
.modal-backdrop {
    z-index: 1050 !important;
}

/* Ensure all input fields are enabled */
.payment-details-modal input:not([type="radio"]):not([type="checkbox"]),
.payment-details-modal select,
.payment-details-modal textarea {
    background-color: white !important;
    color: #212529 !important;
    opacity: 1 !important;
}

/* Add these styles to your existing CSS */
/* Premium Student Info Card */
.card.student-info-card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    position: relative;
}

.card.student-info-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(to bottom, #4e54c8, #8f94fb);
}

.card.student-info-card .card-body {
    padding: 1.5rem;
}

.student-info-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.25rem;
}

.student-avatar {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-right: 1.25rem;
}

.student-info-text h4 {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.student-info-text p {
    color: #7f8c8d;
    margin-bottom: 0;
    font-size: 0.9rem;
}

.student-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 0.75rem;
}

.student-meta-item {
    display: flex;
    align-items: center;
    font-size: 0.85rem;
}

.student-meta-item i {
    margin-right: 0.5rem;
    color: #4e54c8;
}

/* Premium Due Amount Display */
.due-amount-display {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 8px;
    padding: 1.25rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    margin-bottom: 1.5rem;
}

.due-amount-display h5 {
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.due-amount-display h5 i {
    margin-right: 0.75rem;
}

.due-amount-display .amount {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.due-amount-display .due-date {
    font-size: 0.9rem;
    opacity: 0.9;
}

/* Enhanced Progress Bar */
.payment-progress-container {
    margin-bottom: 1.5rem;
}

.payment-progress-container .progress {
    height: 8px;
    border-radius: 4px;
    background-color: #e9ecef;
}

.payment-progress-container .progress-bar {
    border-radius: 4px;
    background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
    transition: width 0.6s ease;
}

.payment-progress-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
}

.payment-progress-info .label {
    font-weight: 600;
    color: #2c3e50;
}

.payment-progress-info .percentage {
    font-weight: 700;
    color: #4e54c8;
}

/* Enhanced Payment Method Cards */
.payment-method-card {
    border: none;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    cursor: pointer;
    height: 100%;
}

.payment-method-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.payment-method-card.active {
    border: 2px solid #4e54c8;
    background-color: rgba(78, 84, 200, 0.05);
}

.payment-method-card .card-body {
    padding: 1.5rem;
    text-align: center;
}

.payment-method-card i {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.payment-method-card .method-name {
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.payment-method-card .method-description {
    font-size: 0.8rem;
    color: #7f8c8d;
}

/* M-Pesa specific */
.method-mpesa {
    background: linear-gradient(135deg, #ffffff 0%, #e6f7ee 100%);
}

.method-mpesa i {
    color: #00b300;
}

/* Bank specific */
.method-bank {
    background: linear-gradient(135deg, #ffffff 0%, #e6f0f7 100%);
}

.method-bank i {
    color: #0066cc;
}

/* Cash specific */
.method-cash {
    background: linear-gradient(135deg, #ffffff 0%, #fff9e6 100%);
}

.method-cash i {
    color: #ff9900;
}

/* Cheque specific */
.method-cheque {
    background: linear-gradient(135deg, #ffffff 0%, #e6f7f7 100%);
}

.method-cheque i {
    color: #009999;
}
</style>
<script>
$(document).ready(function() {
    const invoiceShowRoute = typeof route !== 'undefined' && route('fees.get-invoice-data') 
        ? route('fees.get-invoice-data') 
        : '/admin/fees/get-invoice-data';
    
    // Initialize the modal
    const invoiceModal = new bootstrap.Modal(document.getElementById('invoiceViewModal'));
    
    // Handle view button click
    $(document).on('click', '.view-invoice-btn', function() {
        const invoiceId = $(this).data('invoice-id');
        
        // Show loading state
        $('#invoiceViewModal .modal-body').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading invoice details...</p>
            </div>
        `);
        
        // Fetch invoice data via AJAX
        $.ajax({
            url: invoiceShowRoute,
            type: 'GET',
            data: { id: invoiceId }, // Send the ID as a query parameter
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    populateInvoiceData(response);
                } else {
                    showError(response.message);
                }
                invoiceModal.show();
            },
            error: function(xhr) {
                showError('Failed to load invoice details. Please try again.');
                invoiceModal.show();
            }
        });
    });
    
    // Rest of your existing code remains the same...
    // Function to populate invoice data
    function populateInvoiceData(data) {
        const invoice = data.invoice;
        const student = data.student;
        const program = data.program;
        const payments = data.payments;
        const paymentSummary = data.paymentSummary;
        const bankDetails = data.bankDetails;
        const mpesaSettings = data.mpesaSettings;
        const feeCategories = invoice.fee_categories || [];
        const feeDetails = invoice.fee_details || [];
        
        // Student information
        $('#studentName').text(student.full_name);
        $('#studentId').text(student.student_id);
        $('#studentProgram').text(program.name);
        
        // Invoice information
        $('#invoiceNo').text(invoice.invoice_no);
        $('#invoiceDate').text(formatDate(invoice.assign_date));
        $('#dueDate').text(formatDate(invoice.due_date));
        
        // Payment status with appropriate badge color
        const statusBadge = $('#paymentStatus');
        const statusText = paymentSummary.payment_status.charAt(0).toUpperCase() + 
                         paymentSummary.payment_status.slice(1);
        statusBadge.text(statusText);
        
        if (paymentSummary.payment_status === 'paid') {
            statusBadge.addClass('bg-success');
        } else if (paymentSummary.payment_status === 'partial') {
            statusBadge.addClass('bg-warning text-dark');
        } else {
            statusBadge.addClass('bg-danger');
        }
        
        // Fee items
        let feeItemsHtml = '';
        feeCategories.forEach((category, index) => {
            const feeAmount = feeDetails[category.id] || 0;
            feeItemsHtml += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${category.title}</td>
                    <td class="text-end">${parseFloat(feeAmount).toFixed(2)}</td>
                    <td class="text-end">0.00</td> <!-- Paid amount would need calculation -->
                    <td class="text-end">${parseFloat(feeAmount).toFixed(2)}</td>
                </tr>
            `;
        });
        
        $('#feeItems').html(feeItemsHtml);
        $('#totalAmount').text(paymentSummary.total_amount.toFixed(2));
        $('#totalPaid').text(paymentSummary.total_paid.toFixed(2));
        $('#totalDue').text(paymentSummary.total_due.toFixed(2));
        
        // Payment history
        let paymentHistoryHtml = '';
        
        if (payments.length > 0) {
            payments.forEach((payment, index) => {
                paymentHistoryHtml += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${formatDate(payment.payment_date)}</td>
                        <td>${payment.transaction_id || payment.reference_number || 'N/A'}</td>
                        <td>${payment.payment_method}</td>
                        <td class="text-end">${parseFloat(payment.amount).toFixed(2)}</td>
                        <td><span class="badge bg-success">${payment.status}</span></td>
                    </tr>
                `;
            });
        } else {
            paymentHistoryHtml = `
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No payment history found</td>
                </tr>
            `;
        }
        
        $('#paymentHistory').html(paymentHistoryHtml);
        
        // Payment instructions
        if (bankDetails) {
            $('#bankDetails').html(`
                <p class="mb-1"><strong>Bank Name:</strong> ${bankDetails.bank_name}</p>
                <p class="mb-1"><strong>Account Name:</strong> ${bankDetails.account_name}</p>
                <p class="mb-1"><strong>Account Number:</strong> ${bankDetails.account_number}</p>
                <p class="mb-1"><strong>Branch:</strong> ${bankDetails.branch}</p>
                <p class="mb-1"><strong>Reference:</strong> ${invoice.invoice_no}</p>
            `);
        } else {
            $('#bankDetails').html('<p class="text-muted">No bank details available</p>');
        }
        
        if (mpesaSettings) {
            $('#mpesaDetails').html(`
                <p class="mb-1"><strong>Paybill:</strong> ${mpesaSettings.paybill_number}</p>
                <p class="mb-1"><strong>Account Number:</strong> ${invoice.invoice_no}</p>
                <p class="mb-1"><strong>Amount:</strong> KES ${paymentSummary.total_due.toFixed(2)}</p>
            `);
        } else {
            $('#mpesaDetails').html('<p class="text-muted">No M-Pesa details available</p>');
        }
        
        // Show/hide make payment button based on due amount
        if (paymentSummary.total_due > 0) {
            $('#makePaymentBtn').show().attr('data-invoice-id', invoice.id);
        } else {
            $('#makePaymentBtn').hide();
        }
    }
    
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleDateString();
    }
    
    function showError(message) {
        $('#invoiceViewModal .modal-body').html(`
            <div class="text-center py-5">
                <i class="fas fa-exclamation-circle fa-3x text-danger mb-3"></i>
                <p class="text-danger">${message}</p>
                <button class="btn btn-sm btn-primary" onclick="location.reload()">Reload</button>
            </div>
        `);
    }
    
    // Print invoice button
    $('#printInvoiceBtn').click(function() {
        const printContent = $('#invoiceViewModal .modal-content').html();
        const originalContent = $('body').html();
        
        $('body').html(printContent);
        window.print();
        $('body').html(originalContent);
    });
    
    // Make payment button
    $('#makePaymentBtn').click(function() {
        const invoiceId = $(this).data('invoice-id');
        alert('Redirect to payment page for invoice ID: ' + invoiceId);
    });
    
    // M-Pesa payment function
    $('#initiateMpesaPayment').click(function() {
        const invoiceId = $('#makePaymentBtn').data('invoice-id');
        const amount = parseFloat($('#totalDue').text());
        
        if (!invoiceId || isNaN(amount)) {
            alert('Invalid invoice or amount');
            return;
        }
        
        // Show loading state
        $(this).html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Processing...
        `).prop('disabled', true);
        
        // Simulate M-Pesa payment request
        setTimeout(function() {
            alert(`M-Pesa payment initiated for invoice ${invoiceId} with amount KES ${amount.toFixed(2)}`);
            
            // Reset button
            $('#initiateMpesaPayment').html(`
                <i class="fas fa-mobile-alt me-2"></i> Pay via M-Pesa
            `).prop('disabled', false);
        }, 2000);
    });
});
</script>

<script>
$(document).ready(function() {
    // Initialize select2
    $('.select2').select2();
    
    // Calculate total amount when categories are selected
    $('#categories').on('change', function() {
        let total = 0;
        $(this).find('option:selected').each(function() {
            total += parseFloat($(this).data('amount')) || 0;
        });
        $('#total-amount').text(total.toFixed(2));
        $('#total-amount-input').val(total.toFixed(2));
    });
});
</script>
<script>
    @include('admin.report.script')
</script>
@endsection

