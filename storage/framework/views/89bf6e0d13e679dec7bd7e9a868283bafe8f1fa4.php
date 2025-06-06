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
                        <label for="name" class="form-label"><?php echo e(__('field_name')); ?> <span>*</span></label>
                        <input type="text" class="form-control" name="name" id="name" value="<?php echo e($row->name); ?>" required>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_name')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="code"><?php echo e(__('field_code')); ?> <span>*</span></label>
                        <input type="text" class="form-control" name="code" id="code" value="<?php echo e($row->code); ?>" required>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_code')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="direction"><?php echo e(__('field_direction')); ?> <span>*</span></label>
                        <select class="form-control" name="direction" id="direction" required>
                            <option value="0" <?php if( $row->direction == 0 ): ?> selected <?php endif; ?>><?php echo e(__('direction_ltr')); ?></option>
                            <option value="1" <?php if( $row->direction == 1 ): ?> selected <?php endif; ?>><?php echo e(__('direction_rtl')); ?></option>
                        </select>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_direction')); ?>

                        </div>
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
    </div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\language\edit.blade.php ENDPATH**/ ?>