<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($row->title); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>
                    </div>
                    <div class="card-block">
                    <!-- Details View Start -->
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_notice_no')); ?>:</mark> #<?php echo e($row->notice_no); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_category')); ?>:</mark> <?php echo e($row->category->title ?? ''); ?></p><hr/>
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_publish_date')); ?>:</mark> 
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <?php if(is_file('uploads/'.$path.'/'.$row->attach)): ?>
                                <mark class="text-primary"><?php echo e(__('field_attach')); ?>:</mark>
                                <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->attach)); ?>" class="btn btn-icon btn-dark btn-sm" download><i class="fas fa-download"></i></a>
                                <?php endif; ?>

                                <?php if(isset($row->url)): ?>
                                <mark class="text-primary"><?php echo e(__('field_source_url')); ?>:</mark>
                                <a href="<?php echo e(url($row->url)); ?>" class="btn btn-icon btn-dark btn-sm" target="_blank"><i class="fas fa-link"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><mark class="text-primary"><?php echo e(__('field_description')); ?>:</mark> <?php echo $row->description; ?></p><hr/>

                                <?php if(is_file('uploads/'.$path.'/'.$row->attach)): ?>
                                <div class="ratio ratio-16x9">
                                  <iframe src="https://docs.google.com/gview?embedded=true&url=<?php echo e(asset('uploads/'.$path.'/'.$row->attach)); ?>" allowfullscreen></iframe>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Details View End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/notice/show.blade.php ENDPATH**/ ?>