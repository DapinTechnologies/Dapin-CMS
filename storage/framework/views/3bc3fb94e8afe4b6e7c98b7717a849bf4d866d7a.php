<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-md-12">
        <form class="needs-validation" novalidate action="<?php echo e(route($route.'.update', [$row->id])); ?>" method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
            <!-- Form Start -->
            <div class="row">
            <div class="form-group col-md-4">
                <label for="first_name"><?php echo e(__('field_first_name')); ?> <span>*</span></label>
                <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo e($row->first_name); ?>" required>

                <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_first_name')); ?>

                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="last_name"><?php echo e(__('field_last_name')); ?> <span>*</span></label>
                <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo e($row->last_name); ?>" required>

                <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_last_name')); ?>

                </div>
            </div>

            <?php if(field('user_father_name')->status == 1): ?>
            <div class="form-group col-md-4">
                <label for="father_name"><?php echo e(__('field_father_name')); ?></label>
                <input type="text" class="form-control" name="father_name" id="father_name" value="<?php echo e($row->father_name); ?>">

                <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_father_name')); ?>

                </div>
            </div>
            <?php endif; ?>

            <?php if(field('user_mother_name')->status == 1): ?>
            <div class="form-group col-md-4">
                <label for="mother_name"><?php echo e(__('field_mother_name')); ?></label>
                <input type="text" class="form-control" name="mother_name" id="mother_name" value="<?php echo e($row->mother_name); ?>">

                <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mother_name')); ?>

                </div>
            </div>
            <?php endif; ?>

            <div class="form-group col-md-4">
                <label for="gender"><?php echo e(__('field_gender')); ?> <span>*</span></label>
                <select class="form-control" name="gender" id="gender" required>
                    <option value=""><?php echo e(__('select')); ?></option>
                    <option value="1" <?php if( $row->gender == 1 ): ?> selected <?php endif; ?>><?php echo e(__('gender_male')); ?></option>
                    <option value="2" <?php if( $row->gender == 2 ): ?> selected <?php endif; ?>><?php echo e(__('gender_female')); ?></option>
                    <option value="3" <?php if( $row->gender == 3 ): ?> selected <?php endif; ?>><?php echo e(__('gender_other')); ?></option>
                </select>

                <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_gender')); ?>

                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="dob"><?php echo e(__('field_dob')); ?> <span>*</span></label>
                <input type="date" class="form-control date" name="dob" id="dob" value="<?php echo e($row->dob); ?>" required>

                <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_dob')); ?>

                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="phone"><?php echo e(__('field_phone')); ?> <span>*</span></label>
                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e($row->phone); ?>" required>

                <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_phone')); ?>

                </div>
            </div>

            <?php if(field('user_emergency_phone')->status == 1): ?>
            <div class="form-group col-md-4">
                <label for="emergency_phone"><?php echo e(__('field_emergency_phone')); ?></label>
                <input type="text" class="form-control" name="emergency_phone" id="emergency_phone" value="<?php echo e($row->emergency_phone); ?>">

                <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_emergency_phone')); ?>

                </div>
            </div>
            <?php endif; ?>

            <?php if(field('user_marital_status')->status == 1): ?>
            <div class="form-group col-md-4">
                <label for="marital_status"><?php echo e(__('field_marital_status')); ?></label>
                <select class="form-control" name="marital_status" id="marital_status">
                    <option value=""><?php echo e(__('select')); ?></option>
                    <option value="1" <?php if( $row->marital_status == 1 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_single')); ?></option>
                    <option value="2" <?php if( $row->marital_status == 2 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_married')); ?></option>
                    <option value="3" <?php if( $row->marital_status == 3 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_widowed')); ?></option>
                    <option value="4" <?php if( $row->marital_status == 4 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_divorced')); ?></option>
                    <option value="5" <?php if( $row->marital_status == 5 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_other')); ?></option>
                </select>

                <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_marital_status')); ?>

                </div>
            </div>
            <?php endif; ?>

            <?php if(field('user_blood_group')->status == 1): ?>
            <div class="form-group col-md-4">
                <label for="blood_group"><?php echo e(__('field_blood_group')); ?></label>
                <select class="form-control" name="blood_group" id="blood_group">
                    <option value=""><?php echo e(__('select')); ?></option>
                    <option value="1" <?php if( $row->blood_group == 1 ): ?> selected <?php endif; ?>><?php echo e(__('A+')); ?></option>
                    <option value="2" <?php if( $row->blood_group == 2 ): ?> selected <?php endif; ?>><?php echo e(__('A-')); ?></option>
                    <option value="3" <?php if( $row->blood_group == 3 ): ?> selected <?php endif; ?>><?php echo e(__('B+')); ?></option>
                    <option value="4" <?php if( $row->blood_group == 4 ): ?> selected <?php endif; ?>><?php echo e(__('B-')); ?></option>
                    <option value="5" <?php if( $row->blood_group == 5 ): ?> selected <?php endif; ?>><?php echo e(__('AB+')); ?></option>
                    <option value="6" <?php if( $row->blood_group == 6 ): ?> selected <?php endif; ?>><?php echo e(__('AB-')); ?></option>
                    <option value="7" <?php if( $row->blood_group == 7 ): ?> selected <?php endif; ?>><?php echo e(__('O+')); ?></option>
                    <option value="8" <?php if( $row->blood_group == 8 ): ?> selected <?php endif; ?>><?php echo e(__('O-')); ?></option>
                </select>

                <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_blood_group')); ?>

                </div>
            </div>
            <?php endif; ?>

            <div class="form-group col-md-8">
                <label for="photo"><?php echo e(__('field_photo')); ?>: <span><?php echo e(__('image_size', ['height' => 300, 'width' => 300])); ?></span></label>
                <input type="file" class="form-control" name="photo" id="photo" value="<?php echo e(old('photo')); ?>">

                <div class="invalid-feedback">
                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_photo')); ?>

                </div>
            </div>

            <div class="form-group col-md-12">
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
            </div>
            <div class="clearfix"></div>
            </div>
            <!-- Form End -->
        </form>
    </div>
</div>
<!-- [ Main Content ] end --><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/profile/edit.blade.php ENDPATH**/ ?>