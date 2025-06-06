
<?php $__env->startSection('title', 'Invoice Details'); ?>
<?php $__env->startSection('content'); ?>
<style>
    @media print {
        .invoice-actions, .no-print {
            display: none !important;
        }
        
        body {
            background: white !important;
            color: black !important;
        }
        
        .invoice-container {
            box-shadow: none !important;
            border: none !important;
            max-width: 100% !important;
        }
    }
    
    .invoice-actions {
        text-align: center;
        margin-top: 30px;
        padding: 20px 0;
        border-top: 1px solid #eee;
    }
</style>





<?php if($invoice->payment_status == 'pending'): ?>
    <div style="position: absolute; top: 0; left: 0; background-color: #dc3545; color: white; padding: 10px 20px; transform: rotate(-45deg); transform-origin: 0 0; font-weight: bold; z-index: 1000;">PENDING</div>
<?php endif; ?>

<div class="invoice-container">
    <div class="invoice-header">
   <!-- Action Buttons -->
<div class="invoice-actions mt-4 text-center">
   

    <a href="" class="btn btn-secondary ml-2">
        <i class="fas fa-file-pdf"></i> Download PDF
    </a>

   <?php if($invoice->payment_status == 'Pending'): ?>
    <a href="<?php echo e(route('payment.page', ['invoice' => $invoice->id])); ?>" class="btn btn-success ml-2" id="payButton">
        <i class="fas fa-money-bill-wave"></i> Make Payment
    </a>
<?php endif; ?>
</div>
        <div class="logo">
            <img src="<?php echo e(asset('path/to/your/logo.png')); ?>" alt="Institution Logo" width="150">
        </div>
        <div class="invoice-info">
            <h2>INVOICE</h2>
            <p>Invoice No: <strong><?php echo e($invoice->invoice_no); ?></strong></p>
            <p>Date: <strong><?php echo e(\Carbon\Carbon::parse($invoice->assign_date)->format('d M Y')); ?></strong></p>
            <p>Due Date: <strong><?php echo e(\Carbon\Carbon::parse($invoice->due_date)->format('d M Y')); ?></strong></p>
        </div>
    </div>

    <div class="student-info">
        <div class="row">
            <div class="col-md-6">
                <h4>Student Information</h4>
                <p><strong>Student ID:</strong> <?php echo e($invoice->studentEnroll->student->student_id ?? 'N/A'); ?></p>
                <p><strong>Name:</strong> <?php echo e($invoice->studentEnroll->student->full_name ?? 'N/A'); ?></p>
                <p><strong>Program:</strong> <?php echo e($invoice->studentEnroll->program->title ?? 'N/A'); ?></p>
                <p><strong>Phone:</strong> <?php echo e($invoice->studentEnroll->student->phone ?? 'N/A'); ?></p>
            </div>
            <div class="col-md-6">
                <h4>Payment Status</h4>
                <p><strong>Status:</strong> 
                    <span class="badge <?php echo e($invoice->payment_status == 'paid' ? 'badge-success' : 'badge-danger'); ?>">
                        <?php echo e(ucfirst($invoice->payment_status)); ?>

                    </span>
                </p>
                <p><strong>Outstanding Fee:</strong> <?php echo e(number_format($invoice->amount_due, 2)); ?></p>
            </div>
        </div>
    </div>

    <div class="fee-details">
        <h4>Fee Breakdown</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fee Type</th>
                    <th>Amount</th>
                    <th>Assign Date</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1; ?>
             <?php $__currentLoopData = $invoice->fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($counter++); ?></td>
        <td>
            
            <?php echo e($fee->category->title ?? 'Tuition Fee'); ?>

            
            
            
        </td>
        <td><?php echo e(number_format($fee->fee_amount, 2)); ?></td>
        <td><?php echo e(\Carbon\Carbon::parse($fee->assign_date)->format('d M Y')); ?></td>
        <td><?php echo e(\Carbon\Carbon::parse($fee->due_date)->format('d M Y')); ?></td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <?php if($invoice->fees->isEmpty()): ?>
                <tr>
                    <td>1</td>
                    <td>Tuition Fee</td>
                    <td><?php echo e(number_format($invoice->total_fee, 2)); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($invoice->assign_date)->format('d M Y')); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($invoice->due_date)->format('d M Y')); ?></td>
                </tr>
                <?php endif; ?>
                
                <?php if($invoice->fees->sum('fine_amount') > 0): ?>
                <tr>
                    <td><?php echo e($counter++); ?></td>
                    <td>Late Fees</td>
                    <td><?php echo e(number_format($invoice->fees->sum('fine_amount'), 2)); ?></td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                <?php endif; ?>
                
                <?php if($invoice->fees->sum('discount_amount') > 0): ?>
                <tr>
                    <td><?php echo e($counter++); ?></td>
                    <td>Discounts</td>
                    <td>-<?php echo e(number_format($invoice->fees->sum('discount_amount'), 2)); ?></td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="payment-summary">
        <div class="row">
            <div class="col-md-6 offset-md-6">
                <table class="table">
                    <tr>
                        <th>Subtotal:</th>
                        <td><?php echo e(number_format($invoice->fees->sum('fee_amount') > 0 ? $invoice->fees->sum('fee_amount') : $invoice->total_fee, 2)); ?></td>
                    </tr>
                    <?php if($invoice->fees->sum('fine_amount') > 0): ?>
                    <tr>
                        <th>Late Fees:</th>
                        <td><?php echo e(number_format($invoice->fees->sum('fine_amount'), 2)); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if($invoice->fees->sum('discount_amount') > 0): ?>
                    <tr>
                        <th>Discounts:</th>
                        <td>-<?php echo e(number_format($invoice->fees->sum('discount_amount'), 2)); ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr class="total-row">
                        <th>Total Due:</th>
                        <td><?php echo e(number_format($invoice->total_fee, 2)); ?></td>
                    </tr>
                    <tr>
                        <th>Amount Collected:</th>
                        <td><?php echo e(number_format($invoice->amount_paid, 2)); ?></td>
                    </tr>
                    <tr class="balance-row">
                        <th>Balance:</th>
                        <td><?php echo e(number_format($invoice->amount_due, 2)); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="invoice-footer">
        <div class="notes">
            <h5>Notes:</h5>
            <p>Please make payment by the due date to avoid late fees. For any discrepancies, contact the accounts office within 7 days.</p>
        </div>
        <div class="payment-method">
            <h5>Payment Methods:</h5>
            <div class="bank-details">
                <p><strong>Bank Transfer:</strong></p>
                <p>Bank Name: <?php echo e($bankDetails->bank_name ?? 'Kenya Commercial Bank (KCB)'); ?></p>
                <p>Account Name: Your Institution Name</p>
                <p>Account No: <?php echo e($bankDetails->bank_account ?? '12968644'); ?></p>
                <p>Branch: <?php echo e($bankDetails->bank_branch ?? 'Kirinyanga'); ?></p>
            </div>
            <div class="mpesa-details">
                <p><strong>M-Pesa:</strong></p>
                <p>Paybill: 123456</p>
                <p>Account No: Student ID (<?php echo e($invoice->studentEnroll->student->student_id ?? 'N/A'); ?>)</p>
            </div>
        </div>
    </div>
</div>

<style>
    .invoice-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
        position: relative;
        overflow: hidden;
    }
    .invoice-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
        padding-bottom: 20px;
    }
    .student-info {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    .fee-details {
        margin-bottom: 20px;
    }
    .fee-details table {
        width: 100%;
    }
    .payment-summary {
        margin-bottom: 20px;
    }
    .payment-summary table {
        width: 100%;
    }
    .total-row {
        font-weight: bold;
        border-top: 2px solid #333;
    }
    .balance-row {
        font-weight: bold;
        border-top: 2px solid #333;
        border-bottom: 2px solid #333;
    }
    .invoice-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    .notes, .payment-method {
        width: 48%;
    }
    .badge-success {
        background-color: #28a745;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
    }
    .badge-danger {
        background-color: #dc3545;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
    }
    .bank-details, .mpesa-details {
        margin-top: 10px;
    }
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views/admin/fees-student/invoice-details.blade.php ENDPATH**/ ?>