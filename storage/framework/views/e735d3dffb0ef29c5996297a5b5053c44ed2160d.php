<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-md-4">
      <?php if(is_file('uploads/'.$path.'/'.$row->photo)): ?>
      <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->photo)); ?>" class="card-img-top img-fluid profile-thumb" alt="<?php echo e(__('field_photo')); ?>" onerror="this.src='<?php echo e(asset('dashboard/images/user/avatar-2.jpg')); ?>';">
      <?php else: ?>
      <img src="<?php echo e(asset('dashboard/images/user/avatar-2.jpg')); ?>" class="card-img-top img-fluid profile-thumb" alt="<?php echo e(__('field_photo')); ?>">
      <?php endif; ?>
      <div class="card-body">
        <h5 class="card-title"><?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></h5>
      </div>
    </div>

    <div class="col-md-4">
        <fieldset class="row gx-2 scheduler-border">
        <p><mark class="text-primary"><?php echo e(__('field_staff_id')); ?>:</mark> <?php echo e($row->staff_id); ?></p><hr/>
        <p><mark class="text-primary"><?php echo e(__('field_email')); ?>:</mark> <?php echo e($row->email); ?></p><hr/>
        <p><mark class="text-primary"><?php echo e(__('field_phone')); ?>:</mark> <?php echo e($row->phone); ?></p><hr/>
        <?php if(field('user_emergency_phone')->status == 1): ?>
        <p><mark class="text-primary"><?php echo e(__('field_emergency_phone')); ?>:</mark> <?php echo e($row->emergency_phone); ?></p><hr/>
        <?php endif; ?>
        
        <?php if(field('user_father_name')->status == 1): ?>
        <p><mark class="text-primary"><?php echo e(__('field_father_name')); ?>:</mark> <?php echo e($row->father_name); ?></p><hr/>
        <?php endif; ?>
        <?php if(field('user_mother_name')->status == 1): ?>
        <p><mark class="text-primary"><?php echo e(__('field_mother_name')); ?>:</mark> <?php echo e($row->mother_name); ?></p><hr/>
        <?php endif; ?>

        <p><mark class="text-primary"><?php echo e(__('field_gender')); ?>:</mark> 
            <?php if( $row->gender == 1 ): ?>
            <?php echo e(__('gender_male')); ?>

            <?php elseif( $row->gender == 2 ): ?>
            <?php echo e(__('gender_female')); ?>

            <?php elseif( $row->gender == 3 ): ?>
            <?php echo e(__('gender_other')); ?>

            <?php endif; ?>
        </p><hr/>

        <p><mark class="text-primary"><?php echo e(__('field_dob')); ?>:</mark> 
            <?php if(isset($setting->date_format)): ?>
            <?php echo e(date($setting->date_format, strtotime($row->dob))); ?>

            <?php else: ?>
            <?php echo e(date("Y-m-d", strtotime($row->dob))); ?>

            <?php endif; ?>
        </p><hr/>

        <?php if(field('user_marital_status')->status == 1): ?>
        <p><mark class="text-primary"><?php echo e(__('field_marital_status')); ?>:</mark> 
            <?php if( $row->marital_status == 1 ): ?>
            <?php echo e(__('marital_status_single')); ?>

            <?php elseif( $row->marital_status == 2 ): ?>
            <?php echo e(__('marital_status_married')); ?>

            <?php elseif( $row->marital_status == 3 ): ?>
            <?php echo e(__('marital_status_widowed')); ?>

            <?php elseif( $row->marital_status == 4 ): ?>
            <?php echo e(__('marital_status_divorced')); ?>

            <?php elseif( $row->marital_status == 5 ): ?>
            <?php echo e(__('marital_status_other')); ?>

            <?php endif; ?>
        </p><hr/>
        <?php endif; ?>

        <?php if(field('user_blood_group')->status == 1): ?>
        <p><mark class="text-primary"><?php echo e(__('field_blood_group')); ?>:</mark> 
            <?php if( $row->blood_group == 1 ): ?>
            <?php echo e(__('A+')); ?>

            <?php elseif( $row->blood_group == 2 ): ?>
            <?php echo e(__('A-')); ?>

            <?php elseif( $row->blood_group == 3 ): ?>
            <?php echo e(__('B+')); ?>

            <?php elseif( $row->blood_group == 4 ): ?>
            <?php echo e(__('B-')); ?>

            <?php elseif( $row->blood_group == 5 ): ?>
            <?php echo e(__('AB+')); ?>

            <?php elseif( $row->blood_group == 6 ): ?>
            <?php echo e(__('AB-')); ?>

            <?php elseif( $row->blood_group == 7 ): ?>
            <?php echo e(__('O+')); ?>

            <?php elseif( $row->blood_group == 8 ): ?>
            <?php echo e(__('O-')); ?>

            <?php endif; ?>
        </p><hr/>
        <?php endif; ?>

        <?php if(field('user_national_id')->status == 1): ?>
        <p><mark class="text-primary"><?php echo e(__('field_national_id')); ?>:</mark> <?php echo e($row->national_id); ?></p><hr/>
        <?php endif; ?>
        <?php if(field('user_passport_no')->status == 1): ?>
        <p><mark class="text-primary"><?php echo e(__('field_passport_no')); ?>:</mark> <?php echo e($row->passport_no); ?></p><hr/>
        <?php endif; ?>
        </fieldset>
    </div>

    <div class="col-md-4">
        <fieldset class="row gx-2 scheduler-border">
        <p><mark class="text-primary"><?php echo e(__('field_department')); ?>:</mark> 
            <?php echo e($row->department->title ?? ''); ?>

        </p><hr/>
        <p><mark class="text-primary"><?php echo e(__('field_designation')); ?>:</mark> 
            <?php echo e($row->designation->title ?? ''); ?>

        </p><hr/>

        <?php if(field('user_joining_date')->status == 1): ?>
        <p><mark class="text-primary"><?php echo e(__('field_joining_date')); ?>:</mark> 
            <?php if(isset($setting->date_format)): ?>
            <?php echo e(date($setting->date_format, strtotime($row->joining_date))); ?>

            <?php else: ?>
            <?php echo e(date("Y-m-d", strtotime($row->joining_date))); ?>

            <?php endif; ?>
        </p><hr/>
        <?php endif; ?>

        <p><mark class="text-primary"><?php echo e(__('field_contract_type')); ?>:</mark> 
            <?php if( $row->contract_type == 1 ): ?>
            <?php echo e(__('contract_type_full_time')); ?>

            <?php elseif( $row->contract_type == 2 ): ?>
            <?php echo e(__('contract_type_part_time')); ?>

            <?php endif; ?>
        </p><hr/>

        <p><mark class="text-primary"><?php echo e(__('field_work_shift')); ?>:</mark> 
            <?php echo e($row->workShift->title ?? ''); ?>

        </p><hr/>

        <p><mark class="text-primary"><?php echo e(__('field_salary_type')); ?>:</mark> 
            <?php if( $row->salary_type == 1 ): ?>
            <?php echo e(__('salary_type_fixed')); ?>

            <?php elseif( $row->salary_type == 2 ): ?>
            <?php echo e(__('salary_type_hourly')); ?>

            <?php endif; ?>
        </p><hr/>
        
        <p><mark class="text-primary"><?php if($row->salary_type == 1): ?> <?php echo e(__('salary_type_fixed')); ?> <?php else: ?> <?php echo e(__('salary_type_hourly')); ?> <?php endif; ?> <?php echo e(__('field_salary')); ?>:</mark>
            <?php echo e(round($row->basic_salary, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?>

        </p><hr/>
        </fieldset>
    </div>
</div>
<!-- [ Main Content ] end --><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/profile/show.blade.php ENDPATH**/ ?>