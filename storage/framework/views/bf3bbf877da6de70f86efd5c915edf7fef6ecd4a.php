<?php $__env->startSection('title', __('auth_reset')); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="card">
   <div class="card-body text-center">
        <div class="mb-4">
            <i class="feather icon-lock auth-icon"></i>
        </div>
        <h5 class="mb-4"><?php echo e(__('auth_reset_title')); ?></h5>

        <!-- Form Start -->
        <form method="POST" action="<?php echo e(route($passwordUpdateRoute)); ?>">
        <?php echo csrf_field(); ?>

          <input type="hidden" name="token" value="<?php echo e($token); ?>">

          <div class="input-group mb-3">
            <input id="email" type="hidden" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e($email ?? old('email')); ?>" required autocomplete="email" placeholder="<?php echo e(__('field_email')); ?>" autofocus>

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
          <div class="input-group mb-3">
            <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="new-password" placeholder="<?php echo e(__('field_password')); ?>">

            <?php $__errorArgs = ['password'];
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
          <div class="input-group mb-4">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="<?php echo e(__('field_confirm_password')); ?>">
          </div>
          <input type="submit" class="btn btn-primary shadow-2 mb-4" name="submit" value="<?php echo e(__('auth_reset')); ?>">
        </form>
        <!-- Form End -->

        <?php if(Route::has('student.login')): ?>
        <p class="mb-0 text-muted">
          <?php echo e(__("auth_already_have_account")); ?> 
          <a href="<?php echo e(route('student.login')); ?>">
              <?php echo e(__('auth_login')); ?>

          </a>
        </p>
        <?php endif; ?>
   </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\web\student\passwords\reset.blade.php ENDPATH**/ ?>