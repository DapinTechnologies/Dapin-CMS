    <!-- Edit modal content -->
    <div id="changePasswordModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form class="needs-validation" novalidate action="<?php echo e(route($route.'-password-change')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><?php echo e(__('change_password')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Form Start -->
                    <input type="hidden" name="staff_id" value="<?php echo e($row->id); ?>">

                    <div class="form-group">
                        <label for="password" class="form-label"><?php echo e(__('field_password')); ?> <span>*</span></label>
                        <input type="password" class="form-control" name="password" id="password" value="" required autocomplete="new-password">

                        <div class="invalid-feedback">
                            <?php echo e(__('required_field')); ?> <?php echo e(__('field_password')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="form-label"><?php echo e(__('field_confirm_password')); ?> <span>*</span></label>
                        <input type="password" class="form-control" name="password_confirmation" id="password-confirm" value="" required autocomplete="new-password">

                        <div class="invalid-feedback">
                            <?php echo e(__('required_field')); ?> <?php echo e(__('field_confirm_password')); ?>

                        </div>
                    </div>
                    <!-- Form End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_change')); ?></button>
                </div>

              </form>
            </div>
        </div>
    </div><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/user/password-change.blade.php ENDPATH**/ ?>