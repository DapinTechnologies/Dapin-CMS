<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-md-8">
        <div class="card-header">
          <h5><?php echo e(__('change_password')); ?></h5>
        </div>
        <div class="card-body">
          <!-- Form Start -->
          <form class="needs-validation" novalidate action="<?php echo e(route($route.'.changepass')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right"><?php echo e(__('field_old_password')); ?> <span>*</span></label>

                <div class="col-md-8">
                    <input id="old_password" type="password" class="form-control <?php $__errorArgs = ['old_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="old_password" required autocomplete="old_password" required>

                    <div class="invalid-feedback">
                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_old_password')); ?>

                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="new-password" class="col-md-4 col-form-label text-md-right"><?php echo e(__('field_new_password')); ?> <span>*</span></label>

                <div class="col-md-8">
                    <input id="new-password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="new-password" required>

                    <div class="invalid-feedback">
                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_new_password')); ?>

                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right"><?php echo e(__('field_confirm_password')); ?> <span>*</span></label>

                <div class="col-md-8">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" required>

                    <div class="invalid-feedback">
                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_confirm_password')); ?>

                    </div>
                </div> 
            </div>

            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_change')); ?></button>
                </div>
            </div>

          </form>
          <!-- Form End -->
        </div>
    </div>
</div>
<!-- [ Main Content ] end --><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/profile/account.blade.php ENDPATH**/ ?>