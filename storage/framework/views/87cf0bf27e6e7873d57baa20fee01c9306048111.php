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
                        <label for="title" class="form-label"><?php echo e(__('field_room')); ?> <?php echo e(__('field_no')); ?> <span>*</span></label>
                        <input type="text" class="form-control" name="title" id="title" value="<?php echo e(old('title')); ?>" required>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_room')); ?> <?php echo e(__('field_no')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="floor" class="form-label"><?php echo e(__('field_floor')); ?></label>
                        <input type="text" class="form-control" name="floor" id="floor" value="<?php echo e(old('floor')); ?>">

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_floor')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="capacity" class="form-label"><?php echo e(__('field_capacity')); ?></label>
                        <input type="text" class="form-control autonumber" name="capacity" id="capacity" value="<?php echo e(old('capacity')); ?>" data-v-max="999999999" data-v-min="0">

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_capacity')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="type" class="form-label"><?php echo e(__('field_type')); ?></label>
                        <input type="text" class="form-control" name="type" id="type" value="<?php echo e(old('type')); ?>">

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_type')); ?>

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
    </div><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/room/create.blade.php ENDPATH**/ ?>