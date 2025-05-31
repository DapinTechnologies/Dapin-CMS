
<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('page_css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('dashboard/plugins/lightbox2-master/css/lightbox.min.css')); ?>">
<style>
    .list-group-item .heading {
        font-weight: bold;
        color: #333;
    }
    .list-group-item .data {
        margin-left: 10px;
        color: #555;
    }
    .button-row {
        display: flex;
        gap: 10px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->

        <!-- Back Buttons at the top -->
        <div class="mt-3 mb-3 button-row">
            <a href="<?php echo e(route('admin.dashboard.index')); ?>" class="btn btn-secondary"><?php echo e(__('Back to Dashboard')); ?></a>
            <button class="btn btn-secondary" onclick="history.back();"><?php echo e(__('Back')); ?></button>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card user-card user-card-1">
                    <div class="card-body pb-0">
                        <div class="media user-about-block align-items-center mt-0 mb-3">
                            
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="heading"><i class="fas fa-phone-alt m-r-10"></i><?php echo e(__('Phone')); ?> :</span>
                            <span class="data"><?php echo e($message->phone_number); ?></span>
                        </li>
                        <li class="list-group-item">
                            <span class="heading"><i class="fas fa-time-alt m-r-10"></i><?php echo e(__('Time Sent')); ?> :</span>
                            <span class="data"><?php echo e($message->sent_at); ?></span>
                        </li>
                        <li class="list-group-item">
                            <span class="heading"><i class="fas fa-graduati m-r-10"></i><?php echo e(__('Status')); ?> :</span>
                            <span class="data"><?php echo e($message->status); ?></span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-block">
                        <div class="">
                            <div class="row">
                                <div class="col-md-12">
                                    <li class="list-group-item">
                                        <span class="heading"><i class="fa fa-graduation m-r-10"></i><?php echo e(__('Text Message')); ?> :</span>
                                        <span class="data"><?php echo e($message->message); ?></span>
                                    </li>
                                    <?php if(!empty($students)): ?>
                                        <li class="list-group-item">
                                            <span class="heading"><i class="fa fa-users m-r-10"></i><?php echo e(__('Recipients')); ?> :</span>
                                            <ul class="data">
                                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?> - <?php echo e($student->phone); ?></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Back Buttons at the bottom -->
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->

    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
<script src="<?php echo e(asset('dashboard/plugins/lightbox2-master/js/lightbox.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home7/httpurba/public_html/college/resources/views/admin/sms/show.blade.php ENDPATH**/ ?>