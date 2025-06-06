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
                                <td class="d-flex gap-1">
                                    <a href="<?php echo e(route('invoice.show', $invoice->id)); ?>" class="btn btn-sm btn-info" title="View Invoice">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                   <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
    Make Payment
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

<!-- Pay Modal -->
<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="<?php echo e(route('payments.store', $invoice->id)); ?>">
      <?php echo csrf_field(); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalLabel">Make a Payment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="invoice_id" value="<?php echo e($invoice->id); ?>">
          <input type="hidden" name="student_enroll_id" value="<?php echo e($invoice->student_enroll_id); ?>">

          <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" class="form-control" name="amount" min="0.01" step="0.01" required>
          </div>

          <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select class="form-select" name="payment_method" required id="payment_method">
              <option value="">-- Select --</option>
              <option value="mpesa">Mpesa</option>
              <option value="bank">Bank</option>
              <option value="cash">Cash</option>
            </select>
          </div>

          <div class="mb-3" id="reference_number_field" style="display:none;">
            <label for="reference_number" class="form-label">Reference Number</label>
            <input type="text" class="form-control" name="reference_number" maxlength="50">
          </div>

          <div class="mb-3">
           <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="is_installment" value="true" id="installmentYes">
  <label class="form-check-label" for="installmentYes">Yes</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="is_installment" value="false" id="installmentNo" checked>
  <label class="form-check-label" for="installmentNo">No</label>
</div>

          </div>

          <div class="mb-3">
            <label for="notes" class="form-label">Notes (optional)</label>
            <textarea class="form-control" name="notes" rows="2"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Submit Payment</button>
        </div>
      </div>
    </form>
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
<script>
$(document).ready(function () {
    $('#student').select2({ placeholder: 'Select student(s)', width: '100%' });
    $('#categories').select2({ placeholder: 'Select one or more fee categories', width: '100%' });

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

    $('#invoice-search').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $('#invoice-table tbody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Optional: Attach event listeners to load modal content
    $('#payModal, #printModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var invoiceId = button.data('id');
        // You could use AJAX to load content here using invoiceId
        console.log("Modal triggered for Invoice ID:", invoiceId);
    });
});
</script>
<script>
document.getElementById('payment_method').addEventListener('change', function () {
    const refField = document.getElementById('reference_number_field');
    const selected = this.value;
    if (selected === 'mpesa' || selected === 'bank') {
        refField.style.display = 'block';
    } else {
        refField.style.display = 'none';
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\fees-student\quick-assign.blade.php ENDPATH**/ ?>