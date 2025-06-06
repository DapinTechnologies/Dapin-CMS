<!-- Edit modal content -->
<div id="lostModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="lostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form class="needs-validation" novalidate action="<?php echo e(route($route.'.penalty', $row->id)); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                
                <div class="modal-header">
                    <h5 class="modal-title" id="lostModalLabel"><?php echo e($title); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Form Start -->
                    <div class="form-group">
                        <label for="penalty" class="form-label"><?php echo e(__('field_penalty')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                        <input type="text" class="form-control autonumber" name="penalty" id="penalty" value="<?php echo e(old('penalty')); ?>" required>

                        <div class="invalid-feedback">
                            <?php echo e(__('required_field')); ?> <?php echo e(__('field_penalty')); ?>

                        </div>
                    </div>
                    <!-- Form End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-minus"></i> <?php echo e(__('btn_lost')); ?></button>
                </div>

            </form>
        </div>
    </div>
</div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\issue-return\lost.blade.php ENDPATH**/ ?>