<?php $__env->startSection('title', __('auth_email')); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="card">
    <div class="card-body text-center">
        <div class="mb-4">
            <i class="feather icon-mail auth-icon"></i>
        </div>
        <h3 class="mb-4"><?php echo e(__('auth_email_title')); ?></h3>

        <?php echo $__env->make('web.student.inc.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Form Start -->
        <form method="POST" action="<?php echo e(route('password.email')); ?>">
        <?php echo csrf_field(); ?> 
            <div class="input-group mb-3">
                <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" placeholder="<?php echo e(__('field_email')); ?>" autofocus>

                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <input type="submit" class="btn btn-primary shadow-2 mb-4" name="submit" value="<?php echo e(__('auth_send_reset_link')); ?>">
        </form>
        <!-- Form End -->

        <?php if(Route::has('login')): ?>
        <p class="mb-0 text-muted">
            <?php echo e(__("auth_already_have_account")); ?> 
            <a href="<?php echo e(route('login')); ?>">
                <?php echo e(__('auth_login')); ?>

            </a>
        </p>
        <?php endif; ?>
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/auth/passwords/email.blade.php ENDPATH**/ ?>