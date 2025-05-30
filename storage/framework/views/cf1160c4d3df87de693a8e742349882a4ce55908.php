<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('page_css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('dashboard/plugins/lightbox2-master/css/lightbox.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-3">
                <div class="card user-card user-card-1">
                    <div class="card-body pb-0">
                        <div class="media user-about-block align-items-center mt-0 mb-3">
                            <div class="position-relative d-inline-block">
                                <?php if(is_file('uploads/'.$path.'/'.$row->photo)): ?>
                                <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->photo)); ?>" class="img-radius img-fluid wid-80" alt="<?php echo e(__('field_photo')); ?>" onerror="this.src='<?php echo e(asset('dashboard/images/user/avatar-2.jpg')); ?>';">
                                <?php else: ?>
                                <img src="<?php echo e(asset('dashboard/images/user/avatar-2.jpg')); ?>" class="img-radius img-fluid wid-80" alt="<?php echo e(__('field_photo')); ?>">
                                <?php endif; ?>
                                <div class="certificated-badge">
                                    <i class="fas fa-certificate text-primary bg-icon"></i>
                                    <i class="fas fa-check front-icon text-white"></i>
                                </div>
                            </div>
                            <div class="media-body ms-3">
                                <h6 class="mb-1"><?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></h6>
                                <?php if(isset($row->registration_no)): ?>
                                <p class="mb-0 text-muted">#<?php echo e($row->registration_no); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="far fa-envelope m-r-10"></i><?php echo e(__('field_email')); ?> : </span>
                            <span class="float-end"><?php echo e($row->email); ?></span>
                        </li>
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="fas fa-phone-alt m-r-10"></i><?php echo e(__('field_phone')); ?> : </span>
                            <span class="float-end"><?php echo e($row->phone); ?></span>
                        </li>
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="fas fa-graduation-cap m-r-10"></i><?php echo e(__('field_program')); ?> : </span>
                            <span class="float-end"><?php echo e($row->program->title ?? ''); ?></span>
                        </li>
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="far fa-calendar-alt m-r-10"></i><?php echo e(__('field_apply_date')); ?> : </span>
                            <span class="float-end">
                                <?php if(isset($setting->date_format)): ?>
                                <?php echo e(date($setting->date_format, strtotime($row->apply_date))); ?>

                                <?php else: ?>
                                <?php echo e(date("Y-m-d", strtotime($row->apply_date))); ?>

                                <?php endif; ?>
                            </span>
                        </li>
                        <li class="list-group-item border-bottom-0">
                            <span class="f-w-500"><i class="far fa-question-circle m-r-10"></i><?php echo e(__('field_status')); ?> : </span>
                            <span class="float-end">
                                <?php if( $row->status == 1 ): ?>
                                <span class="badge badge-pill badge-primary"><?php echo e(__('status_pending')); ?></span>
                                <?php elseif( $row->status == 2 ): ?>
                                <span class="badge badge-pill badge-success"><?php echo e(__('status_approved')); ?></span>
                                <?php else: ?>
                                <span class="badge badge-pill badge-danger"><?php echo e(__('status_rejected')); ?></span>
                                <?php endif; ?>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            
            <div class="col-md-9">
                <div class="card">
                    <div class="card-block">
                        <div class="">
                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset class="row gx-2 scheduler-border">
                                    <?php if(field('application_father_name')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_father_name')); ?>:</mark> <?php echo e($row->father_name); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('application_father_occupation')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_father_occupation')); ?>:</mark> <?php echo e($row->father_occupation); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('application_mother_name')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_mother_name')); ?>:</mark> <?php echo e($row->mother_name); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('application_mother_occupation')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_mother_occupation')); ?>:</mark> <?php echo e($row->mother_occupation); ?></p><hr/>
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

                                    <?php if(field('application_emergency_phone')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_emergency_phone')); ?>:</mark> <?php echo e($row->emergency_phone); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('application_religion')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_religion')); ?>:</mark> <?php echo e($row->religion); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('application_caste')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_caste')); ?>:</mark> <?php echo e($row->caste); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('application_mother_tongue')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_mother_tongue')); ?>:</mark> <?php echo e($row->mother_tongue); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('application_nationality')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_nationality')); ?>:</mark> <?php echo e($row->nationality); ?></p><hr/>
                                    <?php endif; ?>

                                    <?php if(field('application_marital_status')->status == 1): ?>
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

                                    <?php if(field('application_blood_group')->status == 1): ?>
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
                                    </fieldset>
                                    <?php endif; ?>

                                    <?php if(field('application_signature')->status == 1): ?>
                                    <fieldset class="row gx-2 scheduler-border">
                                        <?php if(is_file('uploads/'.$path.'/'.$row->signature)): ?>
                                        <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->signature)); ?>" data-lightbox="gallery">
                                            <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->signature)); ?>" class="img-fluid field-image">
                                        </a>
                                        <?php endif; ?>
                                    </fieldset>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4">
                                    <?php if(field('application_national_id')->status == 1 || field('application_passport_no')->status == 1): ?>
                                    <fieldset class="row gx-2 scheduler-border">
                                    <?php if(field('application_national_id')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_national_id')); ?>:</mark> <?php echo e($row->national_id); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('application_passport_no')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_passport_no')); ?>:</mark> <?php echo e($row->passport_no); ?></p>
                                    <?php endif; ?>
                                    </fieldset>
                                    <?php endif; ?>

                                    <?php if(field('application_address')->status == 1): ?>
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
                                <div class="col-md-4">
                                    <?php if(field('application_school_info')->status == 1): ?>
                                    <fieldset class="row gx-2 scheduler-border">
                                    <legend><?php echo e(__('field_school_information')); ?></legend>
                                    <p><mark class="text-primary"><?php echo e(__('field_school_name')); ?>:</mark> <?php echo e($row->school_name); ?></p><hr/>
                                    <p><mark class="text-primary"><?php echo e(__('field_exam_id')); ?>:</mark> <?php echo e($row->school_exam_id); ?></p><hr/>
                                    <p><mark class="text-primary"><?php echo e(__('field_graduation_year')); ?>:</mark> <?php echo e($row->school_graduation_year); ?></p><hr/>
                                    <p><mark class="text-primary"><?php echo e(__('field_graduation_point')); ?>:</mark> <?php echo e($row->school_graduation_point); ?></p><hr/>
                                    </fieldset>
                                    <?php endif; ?>
                                    
                                    <?php if(field('application_collage_info')->status == 1): ?>
                                    <fieldset class="row gx-2 scheduler-border">
                                    <legend><?php echo e(__('field_college_information')); ?></legend>
                                    <p><mark class="text-primary"><?php echo e(__('field_collage_name')); ?>:</mark> <?php echo e($row->collage_name); ?></p><hr/>
                                    <p><mark class="text-primary"><?php echo e(__('field_exam_id')); ?>:</mark> <?php echo e($row->collage_exam_id); ?></p><hr/>
                                    <p><mark class="text-primary"><?php echo e(__('field_graduation_year')); ?>:</mark> <?php echo e($row->collage_graduation_year); ?></p><hr/>
                                    <p><mark class="text-primary"><?php echo e(__('field_graduation_point')); ?>:</mark> <?php echo e($row->collage_graduation_point); ?></p><hr/>
                                    </fieldset>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php if(field('application_school_transcript')->status == 1): ?>
            <div class="col-md-3">
                <?php if(is_file('uploads/'.$path.'/'.$row->school_transcript)): ?>
                <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->school_transcript)); ?>" data-lightbox="gallery">
                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->school_transcript)); ?>" class="img-fluid">
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if(field('application_school_certificate')->status == 1): ?>
            <div class="col-md-3">
                <?php if(is_file('uploads/'.$path.'/'.$row->school_certificate)): ?>
                <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->school_certificate)); ?>" data-lightbox="gallery">
                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->school_certificate)); ?>" class="img-fluid">
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if(field('application_collage_transcript')->status == 1): ?>
            <div class="col-md-3">
                <?php if(is_file('uploads/'.$path.'/'.$row->collage_transcript)): ?>
                <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->collage_transcript)); ?>" data-lightbox="gallery">
                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->collage_transcript)); ?>" class="img-fluid">
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if(field('application_collage_certificate')->status == 1): ?>
            <div class="col-md-3">
                <?php if(is_file('uploads/'.$path.'/'.$row->collage_certificate)): ?>
                <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->collage_certificate)); ?>" data-lightbox="gallery">
                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->collage_certificate)); ?>" class="img-fluid">
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
<script src="<?php echo e(asset('dashboard/plugins/lightbox2-master/js/lightbox.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\application\show.blade.php ENDPATH**/ ?>