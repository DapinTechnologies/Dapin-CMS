
<?php $__env->startSection('title', 'Fees Invoice'); ?>
<?php $__env->startSection('content'); ?>

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <h3>Fees Invoice</h3>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Student Name</th>
                            <th>Student ID</th>
                            <th>Total Fee</th>
                            <th>Amount Paid</th>
                            <th>Amount Due</th>
                            <th>Payment Status</th>
                            <th>Assign Date</th>
                            <th>Due Date</th>
                            <th>Action</th>  <!-- New column -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item['invoice']->invoice_no); ?></td>
                                <td><?php echo e($item['student']->first_name); ?> <?php echo e($item['student']->last_name); ?></td>
                                <td><?php echo e($item['student']->student_id); ?></td>
                                <td>Ksh <?php echo e(number_format($item['total_fee_amount'], 2)); ?></td>
                                <td>Ksh <?php echo e(number_format($item['total_paid'], 2)); ?></td>
                                <td>Ksh <?php echo e(number_format($item['total_due'], 2)); ?></td>
                                <td><?php echo e($item['payment_status']); ?></td>
                                <td><?php echo e($item['invoice']->assign_date); ?></td>
                                <td><?php echo e($item['invoice']->due_date); ?></td>
                                <td>
                                    <a href="<?php echo e(route('fees.invoice.show', $item['invoice']->id)); ?>" class="btn btn-sm btn-primary" title="View Invoice">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\fees-student\invoice.blade.php ENDPATH**/ ?>