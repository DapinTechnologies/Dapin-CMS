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
                        <label for="category"><?php echo e(__('field_category')); ?> <span>*</span></label>
                        <select class="form-control" name="category" id="category" required>
                            <option value=""><?php echo e(__('select')); ?></option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php if( $category->id == $row->category_id ): ?> selected <?php endif; ?>><?php echo e($category->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_category')); ?>

                        </div>
                    </div>
                            
                    <div class="form-group">
                        <label for="unit"><?php echo e(__('field_unit')); ?></label>
                        <input type="text" class="form-control" name="unit" id="unit" value="<?php echo e($row->unit); ?>">

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_unit')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description"><?php echo e(__('field_description')); ?></label>
                        <textarea class="form-control" name="description" id="description"><?php echo e($row->description); ?></textarea>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_description')); ?>

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
    </div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\item\edit.blade.php ENDPATH**/ ?>