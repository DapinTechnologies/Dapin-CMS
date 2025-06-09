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
                                            <option value="<?php echo e($category->id); ?>" <?php echo e(in_array($category->id, old('categories', [])) ? 'selected' : ''); ?>>
                                                <?php echo e($category->title); ?> (<?php echo e(number_format($category->amount, 2)); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_fees_type')); ?></div>
                                </div>

                                <div class="form-group col-md-6" id="total-amount-container">
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

                                    <?php
                                        $invoice->loadMissing(['fees.feePayments', 'fees.category']);
                                        $feeCategoriesData = $invoice->fees->map(function($fee) {
                                            $paid = $fee->feePayments ? $fee->feePayments->sum('amount') : 0;
                                            return [
                                                'id' => optional($fee->category)->id ?? 0,
                                                'title' => optional($fee->category)->title ?? 'Unknown',
                                                'amount' => $fee->amount,
                                                'paid' => $paid,
                                                'balance' => $fee->amount - $paid,
                                            ];
                                        });
                                    ?>

                                    <button class="btn btn-sm btn-primary payment-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#paymentModal"
                                        data-invoice-id="<?php echo e($invoice->id); ?>"
                                        data-student-enroll-id="<?php echo e($invoice->student_enroll_id); ?>"
                                        data-amount-due="<?php echo e($invoice->amount_due); ?>"
                                        data-fee-categories='<?php echo json_encode($feeCategoriesData, 15, 512) ?>'>
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

<!-- PAYMENT MODAL -->
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
          <div class="alert alert-info mb-3">
            <strong>Total Amount Due:</strong> <span id="modal-total-due">0.00</span>
          </div>
          
          <div id="fee-categories-list" class="mb-3"></div>

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
            <select class="form-select select2" name="fee_categories[]" id="fee_categories" multiple></select>
          </div>

          <div class="mb-3">
            <label for="amount" class="form-label">Amount to Pay <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="amount" id="amount" min="0.01" step="0.01" required>
            <small class="text-muted">Available balance: <span id="available-balance">0.00</span></small>
            <div class="invalid-feedback">Please enter a valid amount.</div>
          </div>

          <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
            <select class="form-select" name="payment_method" required id="payment_method">
              <option value="">-- Select --</option>
              <option value="mpesa">Mpesa</option>
              <option value="bank">Bank</option>
              <option value="cash">Cash</option>
            </select>
            <div class="invalid-feedback">Please select a payment method.</div>
          </div>

          <div class="mb-3" id="reference_number_field" style="display:none;">
            <label for="reference_number" class="form-label">Reference Number <span class="text-danger">*</span></label>
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
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="printModalLabel">Print Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
        <div id="print-content" class="p-4">
          <!-- Invoice content will be loaded here -->
          <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <p>Loading invoice details...</p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="print-invoice-btn">
          <i class="fas fa-print"></i> Print
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Print Styles (hidden from normal view) -->
<style type="text/css" media="print">
  @page {
    size: auto;
    margin: 0mm;
  }
  body {
    padding: 20px;
    font-size: 12px;
  }
  .no-print, .modal-header, .modal-footer {
    display: none !important;
  }
  .invoice-header, .invoice-body, .invoice-footer {
    width: 100%;
    margin: 0;
    padding: 0;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  table, th, td {
    border: 1px solid #ddd;
  }
</style>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

  
$(document).ready(function() {
  // Initialize Select2
  $('.select2').select2();
  
  let currentFeeCategories = [];
  let totalAmountDue = 0;

  // Payment button click handler
  $('.payment-btn').click(function() {
    const invoiceId = $(this).data('invoice-id');
    const studentEnrollId = $(this).data('student-enroll-id');
    const amountDue = parseFloat($(this).data('amount-due')) || 0;
    currentFeeCategories = $(this).data('fee-categories') || [];
    totalAmountDue = amountDue;

    // Set modal fields
    $('#modal_invoice_id').val(invoiceId);
    $('#modal_student_enroll_id').val(studentEnrollId);
    $('#modal-total-due').text(amountDue.toFixed(2));
    $('#available-balance').text(amountDue.toFixed(2));
    
    // Set initial amount to full balance
    $('#amount').val(amountDue.toFixed(2));
    $('#amount').attr({
      'max': amountDue,
      'min': 0.01
    });

    // Populate fee categories list
    const summary = $('#fee-categories-list');
    summary.empty();
    $('#fee_categories').empty().trigger('change');

    let totalBalance = 0;
    
    currentFeeCategories.forEach(cat => {
      const paid = parseFloat(cat.paid) || 0;
      const amount = parseFloat(cat.amount) || 0;
      const balance = parseFloat(cat.balance) || 0;
      totalBalance += balance;

      summary.append(`
        <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
          <span><strong>${cat.title}</strong></span>
          <span class="text-end">
            <span class="badge bg-light text-dark">Total: ${amount.toFixed(2)}</span>
            <span class="badge bg-success">Paid: ${paid.toFixed(2)}</span>
            <span class="badge bg-primary">Balance: ${balance.toFixed(2)}</span>
          </span>
        </div>
      `);

      const option = new Option(
        balance <= 0 
          ? `${cat.title} - Fully Paid` 
          : `${cat.title} - Balance: ${balance.toFixed(2)}`,
        cat.id,
        false,
        false
      );

      if (balance <= 0) $(option).prop('disabled', true);
      $('#fee_categories').append(option);
    });

    $('#fee_categories').select2({
      placeholder: "Select categories to pay",
      width: '100%'
    });

    // Reset payment type to full payment
    $('#fullPayment').prop('checked', true);
    $('#feeCategoriesContainer').hide();
  });

  // Payment type toggle
  $('input[name="payment_type"]').change(function() {
    const isInstallment = $(this).val() === 'installment';
    $('#feeCategoriesContainer').toggle(isInstallment);

    if (!isInstallment) {
      // For full payment, set amount to total balance
      $('#amount').val(totalAmountDue.toFixed(2));
      $('#available-balance').text(totalAmountDue.toFixed(2));
    } else {
      // For installment, trigger category selection change
      $('#fee_categories').trigger('change');
    }
  });

  // Fee category selection change handler
  $('#fee_categories').on('change', function() {
    const selectedIds = $(this).val() || [];
    let total = 0;

    currentFeeCategories.forEach(cat => {
      if (selectedIds.includes(cat.id.toString())) {
        total += parseFloat(cat.balance) || 0;
      }
    });

    $('#amount').val(total.toFixed(2));
    $('#available-balance').text(total.toFixed(2));
  });

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

  // Print modal handler
  $('#printModal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);
    const invoiceId = button.data('id');
    const modal = $(this);
    
    // Load invoice content via AJAX
    $.get(`/invoice/${invoiceId}/print`, function(data) {
      modal.find('#print-content').html(data);
    }).fail(function() {
      modal.find('#print-content').html('<div class="alert alert-danger">Failed to load invoice details</div>');
    });
  });

  // Print button handler
  $('#print-invoice-btn').click(function() {
    window.print();
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


<!-- ... existing code ... -->

<!-- Print Styles (hidden from normal view) -->
<style type="text/css" media="print">
  @page {
    size: auto;
    margin: 0mm;
  }
  body {
    padding: 20px;
    font-size: 12px;
  }
  .no-print, .modal-header, .modal-footer {
    display: none !important;
  }
  .invoice-header, .invoice-body, .invoice-footer {
    width: 100%;
    margin: 0;
    padding: 0;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  table, th, td {
    border: 1px solid #ddd;
  }
  
  /* Add receipt specific styles */
  .receipt-container {
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
  }
  .receipt-container h3 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
  }
  .receipt-container table {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
  }
  .receipt-container th {
    background-color: #f5f5f5;
    text-align: left;
    padding: 8px;
  }
  .receipt-container td {
    padding: 8px;
    border-bottom: 1px solid #ddd;
  }
</style>
<style>
.receipt-container {
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    padding: 30px;
    margin: 20px auto;
}
.receipt-container h3 {
    color: #2c3e50;
    border-bottom: 2px solid #3498db;
    padding-bottom: 10px;
}
.receipt-container p {
    margin-bottom: 5px;
}
.receipt-container .total-amount {
    font-size: 1.2em;
    font-weight: bold;
    color: #27ae60;
}
.receipt-container table {
    margin: 20px 0;
}
</style>
<!-- Receipt Template -->
<?php if(session('print_receipt')): ?>
    <div class="receipt-container" id="receipt-to-print">
        <h3>Payment Receipt</h3>
        <p>Receipt No: <?php echo e(session('receipt_data.receipt_no')); ?></p>
        <p>Transaction ID: <?php echo e(session('receipt_data.transaction_id')); ?></p>
        <p>Date: <?php echo e(session('receipt_data.date')); ?></p>
        <p>Student: <?php echo e(session('receipt_data.student_name')); ?> (ID: <?php echo e(session('receipt_data.student_id')); ?>)</p>
        
        <?php if(session('receipt_data.is_installment')): ?>
            <p>Installment #<?php echo e(session('receipt_data.installment_number')); ?></p>
        <?php endif; ?>
        
        <h4>Payment Details:</h4>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = session('receipt_data.items'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item['category']); ?></td>
                        <td><?php echo e($item['amount']); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        
        <p><strong>Total Paid:</strong> <?php echo e(session('receipt_data.amount_paid')); ?></p>
        <p><strong>Remaining Balance:</strong> <?php echo e(session('receipt_data.remaining_balance')); ?></p>
        <p>Payment Method: <?php echo e(session('receipt_data.payment_method')); ?></p>
        <?php if(session('receipt_data.reference_number')): ?>
            <p>Reference: <?php echo e(session('receipt_data.reference_number')); ?></p>
        <?php endif; ?>
    </div>
    
    <script>
        window.onload = function() {
            // Auto-print the receipt
            window.print();
            
            // Optional: Close after printing
            setTimeout(function() {
                window.close();
            }, 1000);
        };
    </script>
<?php endif; ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views/admin/fees-student/quick-assign.blade.php ENDPATH**/ ?>