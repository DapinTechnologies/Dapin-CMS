<div class="card-block" id="inputFormField">
      <div class="row">
            <div class="form-group col-md-2">
                  <label for="subject"><?php echo e(__('field_subject')); ?> <span>*</span></label>
                  <select class="form-control select2" name="subject[]" id="subject" required>
                        <option value=""><?php echo e(__('select')); ?></option>
                        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($subject->id); ?>" <?php if(old('subject') == $subject->id): ?> selected <?php endif; ?>><?php echo e($subject->code); ?> - <?php echo e($subject->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>

                  <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_subject')); ?>

                  </div>
            </div>
            <div class="form-group col-md-2">
                  <label for="teacher"><?php echo e(__('field_teacher')); ?> <span>*</span></label>
                  <select class="form-control select2" name="teacher[]" id="teacher" required>
                        <option value=""><?php echo e(__('select')); ?></option>
                        <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($teacher->id); ?>" <?php if(old('teacher') == $teacher->id): ?> selected <?php endif; ?>><?php echo e($teacher->staff_id); ?> - <?php echo e($teacher->first_name); ?> <?php echo e($teacher->last_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>

                  <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_teacher')); ?>

                  </div>
            </div>
            <div class="form-group col-md-2">
                  <label for="room"><?php echo e(__('field_room')); ?> <?php echo e(__('field_no')); ?> <span>*</span></label>
                  <select class="form-control select2" name="room[]" id="room" required>
                        <option value=""><?php echo e(__('select')); ?></option>
                        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($room->id); ?>" <?php if(old('room') == $room->id): ?> selected <?php endif; ?>><?php echo e($room->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>

                  <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_room')); ?> <?php echo e(__('field_no')); ?>

                  </div>
            </div>
            <div class="form-group col-md-2">
                  <label for="start_time"><?php echo e(__('field_time')); ?> <?php echo e(__('field_from')); ?> <span>*</span></label>
                  <input type="time" class="form-control time" name="start_time[]" id="start_time" required>

                  <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_time')); ?> <?php echo e(__('field_from')); ?>

                  </div>
            </div>
            <div class="form-group col-md-2">
                  <label for="end_time"><?php echo e(__('field_time')); ?> <?php echo e(__('field_to')); ?> <span>*</span></label>
                  <input type="time" class="form-control time" name="end_time[]" id="end_time" required>

                  <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_time')); ?> <?php echo e(__('field_to')); ?>

                  </div>
            </div>
            <div class="form-group col-md-2">
                  <button id="removeField" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> <?php echo e(__('btn_remove')); ?></button>
            </div>
      </div>
</div><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\class-routine\form_field.blade.php ENDPATH**/ ?>