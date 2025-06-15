<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-md-4">
      <?php if(is_file('uploads/'.$path.'/'.$row->photo)): ?>
      <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->photo)); ?>" class="card-img-top img-fluid profile-thumb" alt="<?php echo e(__('field_photo')); ?>" onerror="this.src='<?php echo e(asset('dashboard/images/user/avatar-2.jpg')); ?>';">
      <?php else: ?>
      <img src="<?php echo e(asset('dashboard/images/user/avatar-2.jpg')); ?>" class="card-img-top img-fluid profile-thumb" alt="<?php echo e(__('field_photo')); ?>">
      <?php endif; ?>

      <?php
        $enroll = \App\Models\Student::enroll($row->id);
      ?>

      <br/><br/>
      <fieldset class="row gx-2 scheduler-border">
        <legend><?php echo e(__('field_academic_information')); ?></legend>
        <p><mark class="text-primary"><?php echo e(__('field_batch')); ?>:</mark> <?php echo e($row->batch->title ?? ''); ?></p><hr/>
        <p><mark class="text-primary"><?php echo e(__('field_program')); ?>:</mark> <?php echo e($row->program->title ?? ''); ?></p><hr/>
        <p><mark class="text-primary"><?php echo e(__('field_session')); ?>:</mark> <?php echo e($enroll->session->title ?? ''); ?></p><hr/>
        <p><mark class="text-primary"><?php echo e(__('field_semester')); ?>:</mark> <?php echo e($enroll->semester->title ?? ''); ?></p><hr/>
        <p><mark class="text-primary"><?php echo e(__('field_section')); ?>:</mark> <?php echo e($enroll->section->title ?? ''); ?></p><hr/>
        <p><mark class="text-primary"><?php echo e(__('field_status')); ?>:</mark> 
        <?php $__currentLoopData = $row->statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="badge badge-primary"><?php echo e($status->title); ?></span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </p><hr/>
        </fieldset>
    </div>

    <div class="col-md-4">
        <fieldset class="row gx-2 scheduler-border">
        <legend><?php echo e(__('tab_profile_info')); ?></legend>
        <p><mark class="text-primary"><?php echo e(__('field_student_id')); ?>:</mark> #<?php echo e($row->student_id); ?></p><hr/>
        <p><mark class="text-primary"><?php echo e(__('field_name')); ?>:</mark> <?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></p><hr/>
        <?php if(field('student_father_name')->status == 1): ?>
        <p><mark class="text-primary"><?php echo e(__('field_father_name')); ?>:</mark> <?php echo e($row->father_name); ?></p><hr/>
        <?php endif; ?>
        <?php if(field('student_mother_name')->status == 1): ?>
        <p><mark class="text-primary"><?php echo e(__('field_mother_name')); ?>:</mark> <?php echo e($row->mother_name); ?></p><hr/>
        <?php endif; ?>

        <p><mark class="text-primary"><?php echo e(__('field_email')); ?>:</mark> <?php echo e($row->email); ?></p><hr/>
        <p><mark class="text-primary"><?php echo e(__('field_phone')); ?>:</mark> <?php echo e($row->phone); ?></p><hr/>

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

        <?php if(field('student_marital_status')->status == 1): ?>
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

        <?php if(field('student_blood_group')->status == 1): ?>
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
    </div>

    <div class="col-md-4">
        <?php if(field('student_address')->status == 1): ?>
        <fieldset class="row gx-2 scheduler-border">
        <legend><?php echo e(__('field_present')); ?> <?php echo e(__('field_address')); ?></legend>
        <p><mark class="text-primary"><?php echo e(__('field_province')); ?>:</mark> <?php echo e($row->presentProvince->title ?? ''); ?></p><hr/>
        <p><mark class="text-primary"><?php echo e(__('field_district')); ?>:</mark> <?php echo e($row->presentDistrict->title ?? ''); ?></p><hr/>
        <p><mark class="text-primary"><?php echo e(__('field_address')); ?>:</mark> <?php echo e($row->present_address); ?></p>
        </fieldset>

        <fieldset class="row gx-2 scheduler-border">
        <legend><?php echo e(__('field_permanent')); ?> <?php echo e(__('field_address')); ?></legend>
        <p><mark class="text-primary"><?php echo e(__('field_province')); ?>:</mark> <?php echo e($row->permanentProvince->title ?? ''); ?></p><hr/>
        <p><mark class="text-primary"><?php echo e(__('field_district')); ?>:</mark> <?php echo e($row->permanentDistrict->title ?? ''); ?></p><hr/>
        <p><mark class="text-primary"><?php echo e(__('field_address')); ?>:</mark> <?php echo e($row->permanent_address); ?></p>
        </fieldset>
        <?php endif; ?>
    </div>
</div>
<!-- [ Main Content ] end --><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/profile/show.blade.php ENDPATH**/ ?>