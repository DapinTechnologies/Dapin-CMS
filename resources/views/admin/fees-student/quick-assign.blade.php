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
                                    <div id="total-amount" style="font-size: 1.2rem; font-weight: bold;">0.00</div>
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
                    // Load the fees with their categories and payments for this specific invoice
                    $invoice->load(['fees.category', 'fees.payments']);
                    
                    // Calculate category-wise dues for this invoice
                    $categoryDues = [];
                    foreach ($invoice->fees as $fee) {
                        $categoryId = $fee->category ? $fee->category->id : 0;
                        $paidAmount = $fee->payments->sum('amount');
                        $dueAmount = $fee->amount - $paidAmount;
                        
                        if (!isset($categoryDues[$categoryId])) {
                            $categoryDues[$categoryId] = [
                                'title' => $fee->category ? $fee->category->title : 'Uncategorized',
                                'due_amount' => 0
                            ];
                        }
                        $categoryDues[$categoryId]['due_amount'] += $dueAmount;
                    }
                @endphp
                <tr>
                    <td>{{ $invoice->invoice_no }}</td>
                    <td>{{ $invoice->studentEnroll->student->full_name ?? 'N/A' }}</td>
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
                   <td class="d-flex gap-1">
    <a href="{{ route('invoice.show', $invoice->id) }}" 
   class="btn btn-sm btn-info" 
   title="View Invoice">
    <i class="fas fa-eye"></i>
</a>
    
    <button class="btn btn-sm btn-primary payment-btn"
        data-bs-toggle="modal"
        data-bs-target="#paymentModal"
        data-invoice-id="{{ $invoice->id }}"
        data-student-enroll-id="{{ $invoice->student_enroll_id }}"
        data-amount-due="{{ $invoice->amount_due }}"
        data-category-dues='@json($categoryDues)'>
        <i class="fas fa-money-bill-wave"></i> Pay
    </button>

    
                        

<!-- Edit button with all necessary data -->
<button class="btn btn-sm btn-warning edit-invoice-btn"
    data-invoice-id="{{ $invoice->id }}"
    data-student-id="{{ $invoice->student_enroll_id }}"
    data-fee-details='@json($invoice->feeDetails)'
    data-assign-date="{{ $invoice->assign_date }}"
    data-due-date="{{ $invoice->due_date }}"
    data-total-amount="{{ $invoice->total_fee }}"
    title="Edit Invoice">
    <i class="fas fa-edit"></i> Edit Invoice
</button>

    <!-- Print button -->
    <button type="button" class="btn btn-sm btn-secondary print-btn" title="Print" data-id="{{ $invoice->id }}">
        <i class="fas fa-print"></i>
    </button>
    
    
</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- EDIT INVOICE MODAL -->
<div class="modal fade" id="editInvoiceModal">
    <div class="modal-dialog">
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

                    <div class="form-group mb-3">
                        <label class="form-label">Assign Date</label>
                        <input type="date" class="form-control" id="edit_assign_date" name="assign_date" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="edit_due_date" name="due_date" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Total Amount</label>
                        <input type="number" class="form-control" id="edit_total_amount" name="total_fee" step="0.01" min="0" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Associated Fee Categories</label>
                        <ul class="list-group" id="invoice-categories-list">
                            <!-- Categories will be inserted here -->
                        </ul>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="update_related_fees" name="update_related_fees">
                        <label class="form-check-label" for="update_related_fees">Update dates for all associated fees</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- PAYMENT MODAL -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <form method="POST" action="{{ route('payments.store') }}" id="paymentForm">
                @csrf
                <input type="hidden" name="invoice_id" id="modal_invoice_id">
                <input type="hidden" name="student_enroll_id" id="modal_student_enroll_id">
                <input type="hidden" name="is_installment" id="is_installment" value="0">
                <input type="hidden" id="full-amount-due" value="0">

                <div class="modal-header py-2">
                    <h5 class="modal-title" id="paymentModalLabel">Make Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-3">
                    <div class="alert alert-info small p-2 mb-2">
                        <strong>Total Due:</strong> KES <span id="modal-total-due">0.00</span>
                    </div>

                    <!-- Payment Type Radio Buttons -->
                    <div class="mb-2">
                        <label class="form-label small">Payment Type <span class="text-danger">*</span></label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_type" id="fullPayment" value="full" checked>
                            <label class="form-check-label small" for="fullPayment">Full</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_type" id="installmentPayment" value="installment">
                            <label class="form-check-label small" for="installmentPayment">Installment</label>
                        </div>
                    </div>

                    <!-- Category Selection Dropdown -->
                    <div class="mb-2" id="feeCategoriesContainer" style="display: none;">
                        <label class="form-label small">Fee Categories <span class="text-danger">*</span></label>
                        @if(isset($invoice->categoryDues) && count($invoice->categoryDues) > 0)
                            <select class="form-select form-select-sm select2" name="fee_categories[]" id="fee_categories" multiple="multiple" style="width: 100%;">
                                @foreach($invoice->categoryDues as $category)
                                    @if($category['due_amount'] > 0)
                                        <option value="{{ $category['id'] }}">
                                            {{ $category['title'] }} - {{ number_format($category['due_amount'], 2) }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        @else
                            <div class="alert alert-info small p-2">No due categories</div>
                        @endif
                        <small class="text-danger small" id="categories-error" style="display:none;">
                            Select at least one fee category
                        </small>
                    </div>

                    <!-- Amount to Pay Input -->
                    <div class="mb-2">
                        <label for="amount" class="form-label small">Amount <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" name="amount" id="amount" min="0.01" step="0.01" required>
                        <small class="text-muted small">Balance: KES <span id="available-balance">0.00</span></small>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="mb-2">
                        <label for="payment_method" class="form-label small">Payment Method <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm" name="payment_method" required id="payment_method">
                            <option value="">-- Select --</option>
                            <option value="mpesa">Mpesa</option>
                            <option value="bank">Bank</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>

                    <!-- Reference Number Input -->
                    <div class="mb-2" id="reference_number_field" style="display:none;">
                        <label for="reference_number" class="form-label small">Reference <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="reference_number" id="reference_number" maxlength="50" required>
                    </div>

                    <!-- Notes Textarea -->
                    <div class="mb-2">
                        <label for="notes" class="form-label small">Notes (optional)</label>
                        <textarea class="form-control form-control-sm" name="notes" id="notes" rows="2"></textarea>
                    </div>
                </div>

                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm" id="submitPayment">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@else
<div class="alert alert-info mt-3 p-2">
    No invoices found for this student.
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Payment modal handling
    $('.payment-btn').on('click', function() {
        const invoiceId = $(this).data('invoice-id');
        const studentEnrollId = $(this).data('student-enroll-id');
        const amountDue = $(this).data('amount-due');
        const categoryDues = $(this).data('category-dues');
        
        // Set basic info
        $('#modal_invoice_id').val(invoiceId);
        $('#modal_student_enroll_id').val(studentEnrollId);
        $('#modal-total-due').text(amountDue.toLocaleString('en-US', {minimumFractionDigits: 2}));
        $('#full-amount-due').val(amountDue);
        $('#amount').val(amountDue).attr('max', amountDue);
        $('#available-balance').text(amountDue.toLocaleString('en-US', {minimumFractionDigits: 2}));
        
        // Clear and populate categories dropdown
        $('#fee_categories').empty();
        $.each(categoryDues, function(categoryId, data) {
            if (data.due_amount > 0) {
                $('#fee_categories').append(
                    $('<option>', {
                        value: categoryId,
                        text: data.title + ' - KES ' + data.due_amount.toLocaleString('en-US', {minimumFractionDigits: 2}),
                        'data-amount': data.due_amount
                    })
                );
            }
        });
        
        // Initialize Select2
        $('#fee_categories').select2({
            placeholder: "Select categories to pay",
            width: '100%'
        });
    });
    
    // Toggle between full and installment payment
    $('input[name="payment_type"]').change(function() {
        if ($(this).val() === 'installment') {
            $('#feeCategoriesContainer').show();
            $('#is_installment').val('1');
        } else {
            $('#feeCategoriesContainer').hide();
            $('#is_installment').val('0');
        }
    });
    
    // Show/hide reference number field based on payment method
    $('#payment_method').change(function() {
        if ($(this).val() === 'mpesa' || $(this).val() === 'bank') {
            $('#reference_number_field').show();
        } else {
            $('#reference_number_field').hide();
        }
    });
    
    // Form validation
    $('#paymentForm').submit(function(e) {
        if ($('#installmentPayment').is(':checked') && $('#fee_categories').val() === null) {
            e.preventDefault();
            $('#categories-error').show();
            return false;
        }
        return true;
    });
});
</script>
@endpush


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

@push('scripts')
<script>
$(document).ready(function() {
  // Initialize Select2 when modal is shown
  $('#paymentModal').on('shown.bs.modal', function () {
    $('#fee_categories').select2({
      placeholder: "Select fee categories",
      allowClear: true,
      dropdownParent: $('#paymentModal'),
      templateResult: formatCategory,
      templateSelection: formatCategorySelection,
      width: '100%'
    }).on('change', updateDueAmount);
  });

  // Custom formatting for dropdown options
  function formatCategory(category) {
    if (!category.id) return category.text;
    var $option = $(category.element);
    var title = $option.data('title');
    var amount = $option.data('amount');
    var $container = $(
      '<div class="d-flex justify-content-between align-items-center">' +
        '<span class="category-title">' + title + '</span>' +
        '<span class="category-amount">KES ' + parseFloat(amount).toFixed(2) + '</span>' +
      '</div>'
    );
    return $container;
  }

  // Custom formatting for selected options
  function formatCategorySelection(category) {
    if (!category.id) return category.text;
    var $option = $(category.element);
    return $option.data('title') + ' (KES ' + parseFloat($option.data('amount')).toFixed(2) + ')';
  }

  // Calculate and update due amount based on selected categories
  function updateDueAmount() {
    var totalDue = 0;
    var selectedCategories = $('#fee_categories option:selected');
    
    if (selectedCategories.length > 0) {
      selectedCategories.each(function() {
        totalDue += parseFloat($(this).data('amount')) || 0;
      });
      $('#categories-error').hide();
    } else {
      $('#categories-error').show();
    }
    
    $('#modal-total-due').text(totalDue.toFixed(2));
    $('#available-balance').text(totalDue.toFixed(2));
    $('#amount').attr('max', totalDue.toFixed(2));
    
    // Reset amount input if it exceeds the new max
    var currentAmount = parseFloat($('#amount').val());
    if (currentAmount > totalDue) {
      $('#amount').val(totalDue.toFixed(2));
    }
  }

  // Handle payment type change
  $('input[name="payment_type"]').change(function() {
    if ($(this).val() === 'installment') {
      $('#feeCategoriesContainer').show();
      $('#is_installment').val(1);
      $('#fee_categories').val(null).trigger('change');
    } else {
      $('#feeCategoriesContainer').hide();
      $('#is_installment').val(0);
      var fullAmount = parseFloat($('#full-amount-due').val()) || 0;
      $('#modal-total-due').text(fullAmount.toFixed(2));
      $('#available-balance').text(fullAmount.toFixed(2));
      $('#amount').attr('max', fullAmount.toFixed(2));
      $('#amount').val(fullAmount.toFixed(2));
    }
  });

  // Handle payment method change
  $('#payment_method').change(function() {
    if ($(this).val() === 'mpesa' || $(this).val() === 'bank') {
      $('#reference_number_field').show();
      $('#reference_number').prop('required', true);
    } else {
      $('#reference_number_field').hide();
      $('#reference_number').prop('required', false);
    }
  });

  // Form validation
  $('#paymentForm').submit(function(e) {
    if ($('#installmentPayment').is(':checked') && $('#fee_categories').val() === null) {
      e.preventDefault();
      $('#categories-error').show();
      $('html, body').animate({
        scrollTop: $('#feeCategoriesContainer').offset().top - 20
      }, 500);
    }
  });
});
</script>
@endpush

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

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

    // Payment button click handler
    $('.payment-btn').click(function() {
        const amountDue = parseFloat($(this).data('amount-due')) || 0;
        const invoiceId = $(this).data('invoice-id');
        const studentEnrollId = $(this).data('student-enroll-id');
        const feeCategoriesData = $(this).data('fee-categories') || [];

        // Set modal fields
        $('#modal_invoice_id').val(invoiceId);
        $('#modal_student_enroll_id').val(studentEnrollId);
        $('#modal-total-due').text(amountDue.toFixed(2));
        $('#amount').val(amountDue.toFixed(2));
        $('#available-balance').text(amountDue.toFixed(2));

        // Populate fee categories checkboxes
        const checkboxesContainer = $('#fee-categories-checkboxes');
        checkboxesContainer.empty();
        
        feeCategoriesData.forEach(cat => {
            const paid = parseFloat(cat.paid) || 0;
            const amount = parseFloat(cat.amount) || 0;
            const balance = parseFloat(cat.balance) || 0;
            
            const checkboxId = `fee_category_${cat.id}`;
            const isDisabled = balance <= 0;
            
            checkboxesContainer.append(`
                <div class="checkbox-item form-check">
                    <input class="form-check-input fee-category" type="checkbox" 
                           id="${checkboxId}" name="fee_categories[]" 
                           value="${cat.id}" data-balance="${balance}"
                           ${isDisabled ? 'disabled' : ''}>
                    <label class="form-check-label" for="${checkboxId}">
                        ${cat.title} (Balance: ${balance.toFixed(2)})
                        ${isDisabled ? ' - Fully Paid' : ''}
                    </label>
                </div>
            `);
        });

        // Reset payment type to full payment
        $('#fullPayment').prop('checked', true);
        $('#feeCategoriesContainer').hide();
        $('#is_installment').val(0);
        $('#categories-error').hide();
    });

    // Handle payment type change
    $('input[name="payment_type"]').change(function() {
        const isInstallment = $(this).val() === 'installment';
        $('#is_installment').val(isInstallment ? 1 : 0);
        $('#feeCategoriesContainer').toggle(isInstallment);
        $('#categories-error').hide();

        if (!isInstallment) {
            $('#amount').val($('#modal-total-due').text());
        } else {
            updateAmountFromSelectedCategories();
        }
    });

    // Update amount when categories are selected
    $(document).on('change', '.fee-category', function() {
        updateAmountFromSelectedCategories();
    });

    function updateAmountFromSelectedCategories() {
        let total = 0;
        $('.fee-category:checked').each(function() {
            total += parseFloat($(this).data('balance')) || 0;
        });
        
        // If no categories selected, use total balance
        if ($('.fee-category:checked').length === 0) {
            total = parseFloat($('#modal-total-due').text()) || 0;
        }
        
        $('#amount').val(total.toFixed(2));
        $('#available-balance').text(total.toFixed(2));
    }

    // Payment method change handler
    $('#payment_method').change(function() {
        const method = $(this).val();
        $('#reference_number_field').toggle(method === 'mpesa' || method === 'bank');
        $('#reference_number').prop('required', method === 'mpesa' || method === 'bank');
    });

    // Amount validation
    $('#amount').on('input', function() {
        const maxAmount = parseFloat($('#available-balance').text()) || 0;
        const enteredAmount = parseFloat($(this).val()) || 0;

        if (enteredAmount > maxAmount) {
            $(this).val(maxAmount.toFixed(2));
        }
    });

    // Form submission handler
    $('#paymentForm').submit(function(e) {
        e.preventDefault();
        
        const isInstallment = $('input[name="payment_type"]:checked').val() === 'installment';
        const hasCategories = $('.fee-category:checked').length > 0;
        
        if (isInstallment && !hasCategories) {
            $('#categories-error').show();
            $('#fee-categories-checkboxes').css('border', '1px solid #dc3545');
            return false;
        }

        // Submit form via AJAX
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success && response.redirect_url) {
                    // Open receipt in new tab
                    window.open(response.redirect_url, '_blank');
                    
                    // Close modal if needed
                    $('#paymentModal').modal('hide');
                    
                    // Optionally reload the page or update UI
                    window.location.reload();
                }
            },
            error: function(xhr) {
                // Handle errors
                alert('Payment failed: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    });

    // Invoice search functionality
    $('#invoice-search').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('#invoice-table tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>

<script>
$('.edit-fee-btn').click(function() {
    const invoiceId = $(this).data('invoice-id');
    const studentEnrollId = $(this).data('student-enroll-id');
    
    // Show loading state
    $('#feeEditBody').html('<tr><td colspan="5" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading fee details...</td></tr>');
    
    // Set the IDs in the form
    $('#edit_invoice_id').val(invoiceId);
    $('#edit_student_enroll_id').val(studentEnrollId);
    
    // Make AJAX call to get fee details
    $.ajax({
        url: "{{ route('fees.get') }}",
        method: "GET",
        data: {
            invoice_id: invoiceId,
            student_enroll_id: studentEnrollId
        },
        success: function(response) {
            if (response.success && response.fees.length) {
                let html = '';
                
                response.fees.forEach(fee => {
                    html += `
                        <tr>
                            <td>
                                ${fee.category_title}
                                <input type="hidden" name="fee_ids[]" value="${fee.id}">
                            </td>
                            <td>${fee.original_amount}</td>
                            <td>${fee.paid_amount}</td>
                            <td>${fee.balance}</td>
                            <td>
                                <input type="number" class="form-control form-control-sm" 
                                       name="new_amounts[]" value="${fee.original_amount_raw}" 
                                       min="${fee.paid_amount_raw}" step="0.01" required>
                                <small class="text-muted">Min: ${fee.paid_amount} (paid)</small>
                            </td>
                        </tr>
                    `;
                });
                
                $('#feeEditBody').html(html);
                $('#editFeeModal').modal('show');
            } else {
                $('#feeEditBody').html('<tr><td colspan="5" class="text-center text-danger">No fee details found</td></tr>');
            }
        },
        error: function(xhr) {
            let errorMsg = 'Error loading fee details';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            $('#feeEditBody').html(`<tr><td colspan="5" class="text-center text-danger">${errorMsg}</td></tr>`);
        }
    });
});


$('#editFeeForm').submit(function(e) {
    e.preventDefault();
    
    // Show loading state on submit button
    const submitBtn = $(this).find('button[type="submit"]');
    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
    
    $.ajax({
        url: $(this).attr('action'),
        method: "POST",
        data: $(this).serialize(),
        success: function(response) {
            if (response.success) {
                // Show success message
                toastr.success('Fees updated successfully');
                // Close the modal
                $('#editFeeModal').modal('hide');
                // Refresh the page to see changes
                setTimeout(() => window.location.reload(), 1000);
            } else {
                toastr.error('Error: ' + response.message);
                submitBtn.prop('disabled', false).html('Save Changes');
            }
        },
        error: function(xhr) {
            let errorMsg = 'Error updating fees';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            toastr.error(errorMsg);
            submitBtn.prop('disabled', false).html('Save Changes');
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Print button functionality
    document.querySelectorAll('.print-btn').forEach(button => {
        button.addEventListener('click', function() {
            const invoiceId = this.getAttribute('data-id');
            
            // Open print dialog for the invoice
            printInvoice(invoiceId);
        });
    });

    function printInvoice(invoiceId) {
        // Option 1: Print the current page (simple approach)
        window.print();
        
        // Option 2: Open a print-optimized version (better approach)
        // window.open(`/invoices/${invoiceId}/print`, '_blank');
    }
});
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
    $('.edit-invoice-btn').click(function() {
        // Get all data attributes
        const invoiceId = $(this).data('invoice-id');
        const studentId = $(this).data('student-id');
        const assignDate = $(this).data('assign-date');
        const dueDate = $(this).data('due-date');
        const totalAmount = $(this).data('total-amount');
        const feeDetails = $(this).data('fee-details');

        // Set form values
        $('#edit_invoice_id').val(invoiceId);
        $('#edit_student_enroll_id').val(studentId);
        $('#edit_assign_date').val(assignDate);
        $('#edit_due_date').val(dueDate);
        $('#edit_total_amount').val(totalAmount);

        // Populate fee categories list
        let categoriesHtml = '';
        if (feeDetails && feeDetails.length > 0) {
            feeDetails.forEach(fee => {
                categoriesHtml += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        ${fee.category_title}
                        <span class="badge bg-primary rounded-pill">${fee.amount}</span>
                    </li>
                `;
            });
        } else {
            categoriesHtml = '<li class="list-group-item text-muted">No fee categories assigned</li>';
        }
        $('#invoice-categories-list').html(categoriesHtml);

        // Show the modal
        $('#editInvoiceModal').modal('show');
    });
});
</script>
@endsection