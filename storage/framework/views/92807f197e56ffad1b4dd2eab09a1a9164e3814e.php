<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<style>
.select2-container--default .select2-results__options {
    max-height: 200px;
    overflow-y: auto;
}
.select2-container--default .select2-selection--multiple {
    min-height: 38px;
    padding: 6px;
    overflow: hidden;
    box-sizing: border-box;
    white-space: normal;
}
.select2-container {
    width: 100% !important;
}
.select2-selection__choice {
    white-space: normal !important;
    word-break: break-word !important;
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
                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->title); ?> (<?php echo e(number_format($category->amount, 2)); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_fees_type')); ?></div>
                                </div>

                                <div class="form-group col-md-6" id="total-amount-container" style="display:none;">
                                    <label><strong>Total Amount:</strong></label>
                                    <div id="total-amount" style="font-size: 1.2rem; font-weight: bold;">0.00</div>
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
                            <tr>
                                <td><?php echo e($invoice->invoice_no); ?></td>
                                <td><?php echo e($invoice->studentEnroll->student->full_name ?? 'N/A'); ?></td>
                                <td><?php echo e(number_format($invoice->total_fee, 2)); ?></td>
                                <td><?php echo e(number_format($invoice->amount_due, 2)); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($invoice->assign_date)->format('d M Y')); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($invoice->due_date)->format('d M Y')); ?></td>
                                <td>
                                    <?php if($invoice->status == 'paid'): ?>
                                        <span class="badge bg-success">Paid</span>
                                    <?php elseif($invoice->status == 'partial'): ?>
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
                                            data-fee-categories="<?php echo e(json_encode($invoice->feeCategories)); ?>">
                                        <i class="fas fa-money-bill-wave"></i> Pay
                                    </button>
                                    <button type="button" class="btn btn-sm btn-secondary" title="Print" data-toggle="modal" data-target="#printModal" data-id="<?php echo e($invoice->id); ?>">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="<?php echo e(route('payments.store')); ?>" id="paymentForm">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="invoice_id" id="modal_invoice_id">
        <input type="hidden" name="student_enroll_id" id="modal_student_enroll_id">

        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalLabel">Make a Payment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Fee Categories Display -->
          <div class="mb-3">
            <label class="form-label">Fee Categories</label>
            <div id="fee-categories-list" class="border p-2" style="max-height: 150px; overflow-y: auto;">
              <!-- Categories will be populated here -->
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Payment Type</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="payment_type" id="fullPayment" value="full" checked>
              <label class="form-check-label" for="fullPayment">Full Payment</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="payment_type" id="installmentPayment" value="installment">
              <label class="form-check-label" for="installmentPayment">Installment Payment</label>
            </div>
          </div>

          <div class="mb-3" id="feeCategoriesContainer" style="display: none;">
            <label for="fee_categories" class="form-label">Select Fee Categories</label>
            <select class="form-select select2" name="fee_categories[]" id="fee_categories" multiple>
              <!-- Options will be populated via JavaScript -->
            </select>
          </div>

          <div class="mb-3">
            <label for="amount" class="form-label">Amount to Pay</label>
            <input type="number" class="form-control" name="amount" id="amount" 
                   min="0.01" step="0.01" required>
            <small class="text-muted">Amount due: <span id="amount-due-display">0.00</span></small>
            <div class="invalid-feedback">Please enter a valid amount.</div>
          </div>

          <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select class="form-select" name="payment_method" required id="payment_method">
              <option value="">-- Select --</option>
              <option value="mpesa">Mpesa</option>
              <option value="bank">Bank</option>
              <option value="cash">Cash</option>
            </select>
            <div class="invalid-feedback">Please select a payment method.</div>
          </div>

          <div class="mb-3" id="reference_number_field" style="display:none;">
            <label for="reference_number" class="form-label">Reference Number</label>
            <input type="text" class="form-control" name="reference_number" id="reference_number" maxlength="50">
            <div class="invalid-feedback">Please enter a reference number.</div>
          </div>

          <div class="mb-3">
            <label for="notes" class="form-label">Notes (optional)</label>
            <textarea class="form-control" name="notes" id="notes" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Submit Payment</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Print Modal -->
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="printModalLabel">Print Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Placeholder for print preview -->
        <p>Invoice preview for printing will load here...</p>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    // Initialize Select2 for student and category dropdowns
    $('#student').select2({ placeholder: 'Select student(s)', width: '100%' });
    $('#categories').select2({ placeholder: 'Select one or more fee categories', width: '100%' });
    
    // Initialize Select2 for fee categories in modal (will be reinitialized when modal opens)
    $('#fee_categories').select2({
        placeholder: "Select categories to pay",
        width: '100%'
    });

    // Calculate and display total amount when categories are selected
    function updateTotalAmount() {
        let total = 0;
        $('#categories option:selected').each(function () {
            let match = $(this).text().match(/\(([\d,\.]+)\)/);
            if (match && match[1]) {
                total += parseFloat(match[1].replace(/,/g, '')) || 0;
            }
        });
        if (total > 0) {
            $('#total-amount-container').show();
            $('#total-amount').text(total.toFixed(2));
        } else {
            $('#total-amount-container').hide();
            $('#total-amount').text('0.00');
        }
    }

    $('#categories').on('change', updateTotalAmount);
    updateTotalAmount();

    // Search functionality for invoices table
    $('#invoice-search').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $('#invoice-table tbody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Payment modal handling
    $('.payment-btn').click(function() {
        const invoiceId = $(this).data('invoice-id');
        const studentEnrollId = $(this).data('student-enroll-id');
        const amountDue = $(this).data('amount-due');
        const feeCategories = $(this).data('fee-categories');
        
        // Set form values
        $('#modal_invoice_id').val(invoiceId);
        $('#modal_student_enroll_id').val(studentEnrollId);
        $('#amount').val(amountDue).attr('max', amountDue);
        $('#amount-due-display').text(amountDue.toFixed(2));
        
        // Populate fee categories list
        const categoriesList = $('#fee-categories-list');
        categoriesList.empty();
        
        if (feeCategories && feeCategories.length > 0) {
            feeCategories.forEach(category => {
                categoriesList.append(`
                    <div class="d-flex justify-content-between mb-2">
                        <span>${category.title}</span>
                        <span class="text-end">${category.pivot.amount.toFixed(2)}</span>
                    </div>
                `);
            });
        } else {
            categoriesList.append('<p>No fee categories assigned</p>');
        }
        
        // Clear and repopulate fee categories for the select dropdown
        $('#fee_categories').empty();
        $.each(feeCategories, function(index, category) {
            $('#fee_categories').append(
                $('<option></option>').val(category.id).text(category.title + ' (' + category.pivot.amount.toFixed(2) + ')')
            );
        });
        
        // Reinitialize Select2
        $('#fee_categories').select2({
            placeholder: "Select categories to pay",
            width: '100%'
        });
    });

    // Payment type toggle
    $('input[name="payment_type"]').change(function() {
        $('#feeCategoriesContainer').toggle($(this).val() === 'installment');
    });

    // Payment method reference field toggle
    $('#payment_method').change(function() {
        const selected = $(this).val();
        $('#reference_number_field').toggle(selected === 'mpesa' || selected === 'bank');
        if (selected === 'mpesa' || selected === 'bank') {
            $('#reference_number').prop('required', true);
        } else {
            $('#reference_number').prop('required', false);
        }
    });

    // Form validation
    $('#paymentForm').submit(function(e) {
        let isValid = true;
        
        // Validate amount
        const amount = parseFloat($('#amount').val());
        const maxAmount = parseFloat($('#amount').attr('max'));
        if (isNaN(amount) || amount <= 0 || amount > maxAmount) {
            $('#amount').addClass('is-invalid');
            isValid = false;
        } else {
            $('#amount').removeClass('is-invalid');
        }
        
        // Validate payment method
        if ($('#payment_method').val() === '') {
            $('#payment_method').addClass('is-invalid');
            isValid = false;
        } else {
            $('#payment_method').removeClass('is-invalid');
        }
        
        // Validate reference number if required
        if (($('#payment_method').val() === 'mpesa' || $('#payment_method').val() === 'bank') && 
            $('#reference_number').val().trim() === '') {
            $('#reference_number').addClass('is-invalid');
            isValid = false;
        } else {
            $('#reference_number').removeClass('is-invalid');
        }
        
        if (!isValid) {
            e.preventDefault();
            return false;
        }
        
        return true;
    });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views/admin/fees-student/quick-assign.blade.php ENDPATH**/ ?>