<!-- FIXED: Feature Services Section (limited to 3) -->
<section class="service-details-two" style="position: relative; z-index: 1;">
    <div class="container">
        <div class="row">
            <?php $__currentLoopData = $features->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="services-box07 <?php if($key == 1): ?> active <?php endif; ?> h-100">
                    <div class="sr-contner">
                        <div class="icon mb-3 text-center">
                            <img src="<?php echo e(asset('web/img/icon/sve-icon4.png')); ?>" alt="<?php echo e($feature->title); ?> icon" loading="lazy">
                        </div>
                        <div class="text text-center px-3">
                            <h5 class="fw-semibold"><?php echo e($feature->title); ?></h5>
                            <p><?php echo $feature->description; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php /**PATH /opt/lampp/htdocs/Dapin-CMS/resources/views/web/features.blade.php ENDPATH**/ ?>