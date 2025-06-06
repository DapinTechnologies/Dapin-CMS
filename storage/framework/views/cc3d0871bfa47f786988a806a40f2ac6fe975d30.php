

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h3>Payment Successful</h3>
        <p>Fee: <?php echo e($fee->category->name); ?></p>
        <p>Amount Paid: KES <?php echo e(number_format($fee->paid_amount, 2)); ?></p>
        <p>Remaining Balance: KES <?php echo e(number_format($fee->remaining_balance, 2)); ?></p>
        <a href="<?php echo e(route('fees.index')); ?>" class="btn btn-primary">Back to Fees</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\payment.blade.php ENDPATH**/ ?>