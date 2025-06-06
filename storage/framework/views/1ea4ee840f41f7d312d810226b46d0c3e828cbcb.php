
<?php $__env->startSection('title', 'Invoice Details'); ?>
<?php $__env->startSection('content'); ?>

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">

                <h3>Invoice #<?php echo e($invoice->invoice_no); ?></h3>

                <p><strong>Student:</strong> <?php echo e($invoice->studentEnroll->student->first_name); ?> <?php echo e($invoice->studentEnroll->student->last_name); ?> (<?php echo e($invoice->studentEnroll->student->student_id); ?>)</p>
                <p><strong>Assign Date:</strong> <?php echo e($invoice->assign_date); ?></p>
                <p><strong>Due Date:</strong> <?php echo e($invoice->due_date); ?></p>
                <p><strong>Payment Status:</strong> <?php echo e($invoice->payment_status); ?></p>
                <p><strong>Total Fee:</strong> Ksh <?php echo e(number_format($invoice->total_fee, 2)); ?></p>
                <p><strong>Amount Paid:</strong> Ksh <?php echo e(number_format($totalPaid, 2)); ?></p>
                <p><strong>Amount Due:</strong> Ksh <?php echo e(number_format($totalDue, 2)); ?></p>

                <h4>Fee Breakdown</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Fee Category</th>
                            <th>Amount</th>
                            <th>Assign Date</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php $__currentLoopData = $invoice->fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($fee->category ? $fee->category->title : 'Category missing'); ?></td>
        <td>Ksh <?php echo e(number_format($fee->fee_amount, 2)); ?></td>
        <td><?php echo e($fee->assign_date); ?></td>
        <td><?php echo e($fee->due_date); ?></td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>

                <a href="<?php echo e(route('fees.invoice')); ?>" class="btn btn-secondary">Back to Invoice List</a>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\fees-student\invoice-show.blade.php ENDPATH**/ ?>