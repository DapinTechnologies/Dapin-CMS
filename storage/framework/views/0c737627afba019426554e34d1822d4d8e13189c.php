<?php $__env->startSection('title', __('auth_verify')); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="card">
    <div class="card-body text-center">
        <div class="mb-4">
            <i class="feather icon-mail auth-icon"></i>
        </div>
        <h3 class="mb-4"><?php echo e(__('auth_verify_title')); ?></h3>
        
        <?php echo $__env->make('web.student.inc.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <p class="mb-0 text-muted">
            <?php echo e(__('auth_check_your_email')); ?>

        </p>
        <p class="mb-0 text-muted">
            <?php echo e(__('auth_not_receive_email')); ?>, <a href="<?php echo e(route('verification.resend')); ?>"><?php echo e(__('auth_send_another_request')); ?></a>
        </p>
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\auth\verify.blade.php ENDPATH**/ ?>