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
                        <label for="number" class="form-label"><?php echo e(__('field_number')); ?> <span>*</span></label>
                        <input type="text" class="form-control" name="number" id="number" value="<?php echo e($row->number); ?>" required>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_number')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="type" class="form-label"><?php echo e(__('field_type')); ?></label>
                        <input type="text" class="form-control" name="type" id="type" value="<?php echo e($row->type); ?>">

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_type')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="route"><?php echo e(__('field_assign')); ?> <?php echo e(__('field_route')); ?> <span>*</span></label><br/>

                        <?php $__currentLoopData = $transportRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $transportRoute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <br/>
                        <div class="checkbox d-inline">
                            <input type="checkbox" name="routes[]" id="route-<?php echo e($key); ?>-<?php echo e($row->id); ?>" value="<?php echo e($transportRoute->id); ?>"

                            <?php $__currentLoopData = $row->transportRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $selected_route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($selected_route->id == $transportRoute->id): ?> checked <?php endif; ?> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            >
                            <label for="route-<?php echo e($key); ?>-<?php echo e($row->id); ?>" class="cr"><?php echo e($transportRoute->title); ?></label>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_route')); ?>

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
    </div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\transport-vehicle\edit.blade.php ENDPATH**/ ?>