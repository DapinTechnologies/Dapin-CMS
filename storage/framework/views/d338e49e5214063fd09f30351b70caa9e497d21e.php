<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

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

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                    </div>

                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.quick.assign.store')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="card-block">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="student"><?php echo e(__('field_student_id')); ?> <span>*</span></label>
                                    <select class="form-control select2" name="students[]" id="student" multiple required>
                                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($student->id); ?>" <?php echo e(in_array($student->id, old('students', [])) ? 'selected' : ''); ?>>
                                                <?php echo e($student->student->student_id ?? ''); ?> - <?php echo e($student->student->first_name ?? ''); ?> <?php echo e($student->student->last_name ?? ''); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_student_id')); ?></div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="categories"><?php echo e(__('field_fees_type')); ?> <span>*</span></label>
                                    <select class="form-control select2" name="categories[]" id="categories" multiple required>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>" data-amount="<?php echo e($category->amount); ?>" <?php echo e(in_array($category->id, old('categories', [])) ? 'selected' : ''); ?>>
                                                <?php echo e($category->title); ?> (<?php echo e(number_format($category->amount, 2)); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_fees_type')); ?></div>
                                </div>

                                <div class="form-group col-md-6" id="total-amount-container">
                                    <label><strong><?php echo e(__('Total Amount')); ?>:</strong></label>
                                    <div id="total-amount" style="font-size: 1.2rem; font-weight: bold;">0.00</div>
                                    <input type="hidden" name="total_amount" id="total-amount-input" value="0">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="assign_date" class="form-label"><?php echo e(__('field_assign')); ?> <?php echo e(__('field_date')); ?> <span>*</span></label>
                                    <input type="date" class="form-control" name="assign_date" id="assign_date" value="<?php echo e(date('Y-m-d')); ?>" readonly required>
                                    <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_assign')); ?> <?php echo e(__('field_date')); ?></div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="due_date" class="form-label"><?php echo e(__('field_due_date')); ?> <span>*</span></label>
                                    <input type="date" class="form-control" name="due_date" id="due_date" value="<?php echo e(old('due_date', date('Y-m-d'))); ?>" required>
                                    <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_due_date')); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> <?php echo e(__('btn_save')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
<?php if(!empty($invoices) && $invoices->count()): ?>
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
                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
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
                ?>
                <tr>
                    <td><?php echo e($invoice->invoice_no); ?></td>
                    <td><?php echo e($invoice->studentEnroll->student->full_name ?? 'N/A'); ?></td>
                    <td><?php echo e(number_format($invoice->total_fee, 2)); ?></td>
                    <td><?php echo e(number_format($invoice->amount_due, 2)); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($invoice->assign_date)->format('d M Y')); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($invoice->due_date)->format('d M Y')); ?></td>
                    <td>
                        <?php if($invoice->payment_status == 'paid'): ?>
                            <span class="badge bg-success">Paid</span>
                        <?php elseif($invoice->payment_status == 'partial'): ?>
                            <span class="badge bg-warning">Partial</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Unpaid</span>
                        <?php endif; ?>
                    </td>
                    <td class="d-flex gap-1">
                        <a href="<?php echo e(route('invoice.show', $invoice->id)); ?>" class="btn btn-sm btn-info" title="View Invoice">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <button class="btn btn-sm btn-primary payment-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#paymentModal"
                            data-invoice-id="<?php echo e($invoice->id); ?>"
                            data-student-enroll-id="<?php echo e($invoice->student_enroll_id); ?>"
                            data-amount-due="<?php echo e($invoice->amount_due); ?>"
                            data-category-dues='<?php echo json_encode($categoryDues, 15, 512) ?>'>
                            <i class="fas fa-money-bill-wave"></i> Pay
                        </button>
                        
                        <button type="button" class="btn btn-sm btn-secondary print-btn" title="Print" data-id="<?php echo e($invoice->id); ?>">
                            <i class="fas fa-print"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<!-- PAYMENT MODAL -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <form method="POST" action="<?php echo e(route('payments.store')); ?>" id="paymentForm">
                <?php echo csrf_field(); ?>
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
                        <?php if(isset($invoice->categoryDues) && count($invoice->categoryDues) > 0): ?>
                            <select class="form-select form-select-sm select2" name="fee_categories[]" id="fee_categories" multiple="multiple" style="width: 100%;">
                                <?php $__currentLoopData = $invoice->categoryDues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($category['due_amount'] > 0): ?>
                                        <option value="<?php echo e($category['id']); ?>">
                                            <?php echo e($category['title']); ?> - <?php echo e(number_format($category['due_amount'], 2)); ?>

                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        <?php else: ?>
                            <div class="alert alert-info small p-2">No due categories</div>
                        <?php endif; ?>
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
<?php else: ?>
<div class="alert alert-info mt-3 p-2">
    No invoices found for this student.
</div>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>


<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/fees-student/quick-assign.blade.php ENDPATH**/ ?>