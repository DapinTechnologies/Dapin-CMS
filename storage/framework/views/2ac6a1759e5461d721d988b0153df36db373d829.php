<?php $__env->startSection('title', __('auth_login')); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="card">
    <div class="card-body text-center">
        <div class="mb-4">
            <i class="feather icon-unlock auth-icon"></i>
        </div>
        <h3 class="mb-4"><?php echo e(__('auth_login_title')); ?></h3>

        <!-- Form Start -->
        <form method="POST" action="<?php echo e(route('login')); ?>">
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
            <div class="input-group mb-4">
                <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password" placeholder="<?php echo e(__('field_password')); ?>">

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
            <div class="form-group text-left">
                <div class="checkbox checkbox-fill d-inline">
                    <input type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>

                    <label class="cr" for="remember">
                        <?php echo e(__('field_remember')); ?>

                    </label>
                </div>
            </div>
            <input type="submit" class="btn btn-primary shadow-2 mb-4" name="submit" value="<?php echo e(__('auth_login')); ?>">
        </form>
        <!-- Form End -->

        <?php if(Route::has('password.request')): ?>
            <p class="mb-2 text-muted">
                <a href="<?php echo e(route('password.request')); ?>">
                    <?php echo e(__('auth_forgot_password')); ?>

                </a>
            </p>
        <?php endif; ?>

        <?php if(Route::has('register')): ?>
        <p class="mb-0 text-muted">
            <?php echo e(__("auth_dont_have_account")); ?> 
            <a href="<?php echo e(route('register')); ?>">
                <?php echo e(__('auth_register')); ?>

            </a>
        </p>
        <?php endif; ?>

        <?php if(isset($setting->copyright_text)): ?>
        <p class="mb-0 text-muted">&copy; <?php echo strip_tags($setting->copyright_text, '<a><b><br>'); ?></p>
        <?php endif; ?>
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/auth/login.blade.php ENDPATH**/ ?>