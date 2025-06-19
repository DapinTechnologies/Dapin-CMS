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
                        <label for="title" class="form-label"><?php echo e(__('field_title')); ?> <span>*</span></label>
                        <input type="text" class="form-control" name="title" id="title" value="<?php echo e($row->title); ?>" required>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="start_date" class="form-label"><?php echo e(__('field_start_date')); ?> <span>*</span></label>
                        <input type="date" class="form-control date" name="start_date" id="start_date" value="<?php echo e($row->start_date); ?>" required>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_start_date')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="program"><?php echo e(__('field_assign')); ?> <?php echo e(__('field_program')); ?> <span>*</span></label><br/>

                        <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <br/>
                        <div class="checkbox d-inline">
                            <input type="checkbox" name="programs[]" id="program-<?php echo e($key); ?>-<?php echo e($row->id); ?>" value="<?php echo e($program->id); ?>"

                            <?php $__currentLoopData = $row->programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $selected_program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($selected_program->id == $program->id): ?> checked <?php endif; ?> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            >
                            <label for="program-<?php echo e($key); ?>-<?php echo e($row->id); ?>" class="cr"><?php echo e($program->title); ?></label>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_program')); ?>

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
    </div><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/batch/edit.blade.php ENDPATH**/ ?>