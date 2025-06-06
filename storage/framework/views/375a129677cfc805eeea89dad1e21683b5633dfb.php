    <!-- Add modal content -->
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><?php echo e(__('modal_add')); ?> <?php echo e($title); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Form Start -->
                    <div class="form-group">
                        <label for="name" class="form-label"><?php echo e(__('field_name')); ?> <span>*</span></label>
                        <input type="text" class="form-control" name="name" id="name" value="<?php echo e(old('name')); ?>" required>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_name')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="type"><?php echo e(__('field_type')); ?> <span>*</span></label>
                        <select class="form-control" name="type" id="type" required>
                            <option value=""><?php echo e(__('select')); ?></option>
                            <option value="1" <?php if( old('type') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('hostel_type_boys')); ?></option>
                            <option value="2" <?php if( old('type') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('hostel_type_girls')); ?></option>
                            <option value="3" <?php if( old('type') == 3 ): ?> selected <?php endif; ?>><?php echo e(__('hostel_type_staff')); ?></option>
                            <option value="4" <?php if( old('type') == 4 ): ?> selected <?php endif; ?>><?php echo e(__('hostel_type_combine')); ?></option>
                        </select>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_type')); ?>

                        </div>
                    </div>
                            
                    <div class="form-group">
                        <label for="capacity"><?php echo e(__('field_capacity')); ?> <span>*</span></label>
                        <input type="text" class="form-control" name="capacity" id="capacity" value="<?php echo e(old('capacity')); ?>" required>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_capacity')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address"><?php echo e(__('field_address')); ?></label>
                        <textarea class="form-control" name="address" id="address"><?php echo e(old('address')); ?></textarea>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_address')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="note"><?php echo e(__('field_note')); ?></label>
                        <textarea class="form-control" name="note" id="note"><?php echo e(old('note')); ?></textarea>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_note')); ?>

                        </div>
                    </div>
                    <!-- Form End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_save')); ?></button>
                </div>

              </form>
            </div>
        </div>
    </div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\hostel\create.blade.php ENDPATH**/ ?>