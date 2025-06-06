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
                        <label for="title" class="form-label"><?php echo e(__('field_store')); ?> <span>*</span></label>
                        <input type="text" class="form-control" name="title" id="title" value="<?php echo e(old('title')); ?>" required>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_store')); ?>

                        </div>
                    </div>
                            
                    <div class="form-group">
                        <label for="store_no"><?php echo e(__('field_store_no')); ?> <span>*</span></label>
                        <input type="text" class="form-control" name="store_no" id="store_no" value="<?php echo e(old('store_no')); ?>" required>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_store_no')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone"><?php echo e(__('field_phone')); ?></label>
                        <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e(old('phone')); ?>">

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_phone')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email"><?php echo e(__('field_email')); ?></label>
                        <input type="email" class="form-control" name="email" id="email" value="<?php echo e(old('email')); ?>">

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_email')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address"><?php echo e(__('field_address')); ?></label>
                        <textarea class="form-control" name="address" id="address"><?php echo e(old('address')); ?></textarea>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_address')); ?>

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
    </div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\item-store\create.blade.php ENDPATH**/ ?>