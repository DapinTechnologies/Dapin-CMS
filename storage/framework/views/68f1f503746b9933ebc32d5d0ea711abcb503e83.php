
<?php $__env->startSection('title', 'Assigned Fees History'); ?>
<?php $__env->startSection('content'); ?>

<h4>Assigned Fees History</h4>
<a href="<?php echo e(route('admin.fees-summary')); ?>" class="btn btn-info mb-3">View School Fees Summary</a>

<?php $__currentLoopData = $studentEnrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $student = $enroll->student;
        $fees = $enroll->fees;

        $totalAssigned = $fees->sum('fee_amount');
        $totalPaid = $fees->where('status', 1)->sum('fee_amount');
        $totalDue = $fees->where('status', 0)->sum('fee_amount');
    ?>

    <div class="card mb-4">
        <div class="card-header">
            <strong>
                <?php echo e($student->student_id); ?> - <?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?>

            </strong>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Amount (Ksh)</th>
                        <th>Assigned Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($fee->category->title ?? 'N/A'); ?></td>
                            <td><?php echo e(number_format($fee->fee_amount, 2)); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($fee->assign_date)->format('d-M-Y')); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($fee->due_date)->format('d-M-Y')); ?></td>
                            <td>
                                <?php if($fee->status == 0): ?>
                                    <span class="badge badge-warning">Pending</span>
                                <?php elseif($fee->status == 1): ?>
                                    <span class="badge badge-success">Paid</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Unknown</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total Assigned</th>
                        <th><?php echo e(number_format($totalAssigned, 2)); ?></th>
                        <th colspan="3"></th>
                    </tr>
                    <tr>
                        <th>Total Paid</th>
                        <th><?php echo e(number_format($totalPaid, 2)); ?></th>
                        <th colspan="3"></th>
                    </tr>
                    <tr>
                        <th>Total Due</th>
                        <th><?php echo e(number_format($totalDue, 2)); ?></th>
                        <th colspan="3"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views/admin/fees-student/assigned-fees-history.blade.php ENDPATH**/ ?>