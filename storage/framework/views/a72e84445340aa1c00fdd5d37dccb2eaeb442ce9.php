<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('page_css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('dashboard/plugins/lightbox2-master/css/lightbox.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php
    use App\Models\County;
    use App\Models\SubCounty;

    $counties = County::all();
    $subCounties = SubCounty::all(); // Ensure this references the correct table

    

?>


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
                                        <legend><?php echo e(__('field_present')); ?> <?php echo e(__('field_address')); ?></legend>
                                        <p><mark class="text-primary">County:</mark> <?php echo e($row->county->CountyName ?? 'N/A'); ?></p><hr/>
                                        <p><mark class="text-primary">Sub County:</mark> <?php echo e($row->subcounty->SubCountyName  ?? ''); ?></p><hr/>
                                        
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <?php if(!empty($row->school_name)): ?>
                                        <fieldset class="row gx-2 scheduler-border">
                                            <legend><?php echo e(__('field_school_information')); ?></legend>
                                            <p><mark class="text-primary"><?php echo e(__('field_school_name')); ?>:</mark> <?php echo e($row->school_name); ?></p><hr/>
                                            <p><mark class="text-primary"><?php echo e(__('field_exam_id')); ?>:</mark> <?php echo e($row->school_exam_id); ?></p><hr/>
                                        </fieldset>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Section -->
        <div class="row">
            <?php if(is_file('uploads/'.$path.'/'.$row->school_transcript)): ?>
                <div class="col-md-3">
                    <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->school_transcript)); ?>" data-lightbox="gallery">
                        <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->school_transcript)); ?>" class="img-fluid">
                    </a>
                </div>
            <?php endif; ?>
            <?php if(is_file('uploads/'.$path.'/'.$row->school_certificate)): ?>
                <div class="col-md-3">
                    <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->school_certificate)); ?>" data-lightbox="gallery">
                        <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->school_certificate)); ?>" class="img-fluid">
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- End Content -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
<script src="<?php echo e(asset('dashboard/plugins/lightbox2-master/js/lightbox.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\application\show.blade.php ENDPATH**/ ?>