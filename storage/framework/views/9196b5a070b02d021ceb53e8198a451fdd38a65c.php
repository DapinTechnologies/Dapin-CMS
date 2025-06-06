    <!-- Edit modal content -->
    <div id="editModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form class="needs-validation" novalidate action="<?php echo e(route($route.'.update', $row->id)); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><?php echo e(__('modal_edit')); ?> <?php echo e($title); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Form Start -->
                    <div class="form-group">
                        <label for="min_amount" class="form-label"><?php echo e(__('field_min_amount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                        <input type="text" class="form-control" name="min_amount" id="min_amount" value="<?php echo e(round($row->min_amount, 2)); ?>" required>

                        <div class="invalid-feedback">
                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_min_amount')); ?> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="max_amount" class="form-label"><?php echo e(__('field_max_amount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                        <input type="text" class="form-control" name="max_amount" id="max_amount" value="<?php echo e(round($row->max_amount, 2)); ?>" required>

                        <div class="invalid-feedback">
                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_max_amount')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="percentange" class="form-label"><?php echo e(__('field_percentage')); ?> (%) <span>*</span></label>
                        <input type="text" class="form-control" name="percentange" id="percentange" value="<?php echo e(round($row->percentange, 2)); ?>" required>

                        <div class="invalid-feedback">
                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_percentage')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="max_no_taxable_amount" class="form-label"><?php echo e(__('field_max_no_taxable_amount')); ?> (<?php echo $setting->currency_symbol; ?>)</label>
                        <input type="text" class="form-control" name="max_no_taxable_amount" id="max_no_taxable_amount" value="<?php echo e(round($row->max_no_taxable_amount, 2)); ?>">

                        <div class="invalid-feedback">
                        <?php echo e(__('field_max_no_taxable_amount')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label"><?php echo e(__('select_status')); ?></label>
                        <select class="form-control" name="status" id="status">
                            <option value="1" <?php if( $row->status == 1 ): ?> selected <?php endif; ?>><?php echo e(__('status_active')); ?></option>
                            <option value="0" <?php if( $row->status == 0 ): ?> selected <?php endif; ?>><?php echo e(__('status_inactive')); ?></option>
                        </select>
                    </div>
                    <!-- Form End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                </div>

              </form>
            </div>
        </div>
    </div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\tax-setting\edit.blade.php ENDPATH**/ ?>