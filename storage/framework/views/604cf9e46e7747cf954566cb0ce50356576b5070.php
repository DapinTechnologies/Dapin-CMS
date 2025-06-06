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
                        <label for="student"><?php echo e(__('field_student_id')); ?> <span>*</span></label>
                        <input type="text" class="form-control" name="student" id="student" value="<?php echo e($row->student->student_id); ?>" readonly required>

                        <div class="invalid-feedback">
                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_student_id')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="transfer_id"><?php echo e(__('field_transfer_id')); ?> <span>*</span></label>
                        <input type="text" class="form-control autonumber" name="transfer_id" id="transfer_id" value="<?php echo e($row->transfer_id); ?>" required>

                        <div class="invalid-feedback">
                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_transfer_id')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="university_name"><?php echo e(__('field_university_name')); ?> <span>*</span></label>
                        <input type="text" class="form-control" name="university_name" id="university_name" value="<?php echo e($row->university_name); ?>" required>

                        <div class="invalid-feedback">
                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_university_name')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="date"><?php echo e(__('field_date')); ?> <span>*</span></label>
                        <input type="date" class="form-control date" name="date" id="date" value="<?php echo e($row->date); ?>" required>

                        <div class="invalid-feedback">
                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_date')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="note"><?php echo e(__('field_note')); ?></label>
                        <textarea class="form-control" name="note" id="note"><?php echo e($row->note); ?></textarea>

                        <div class="invalid-feedback">
                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_note')); ?>

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
    </div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\student-transfer-out\edit.blade.php ENDPATH**/ ?>