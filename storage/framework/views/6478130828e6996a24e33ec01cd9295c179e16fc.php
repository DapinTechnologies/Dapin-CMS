  <?php if(count($features) > 0): ?>
        <!-- service-area -->
        <section class="service-details-two p-relative">
            <div class="container">
                <div class="row">
                  
                    <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="services-box07 <?php if($key == 1): ?> active <?php endif; ?>">
                            <div class="sr-contner">
                                <div class="icon">
                                    <img src="<?php echo e(asset('web/img/icon/sve-icon4.png')); ?>" alt="icon">
                                </div>
                                <div class="text">
                                    <h5><?php echo e($feature->title); ?></h5>
                                    <p><?php echo $feature->description; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 
                </div>
            </div>
        </section>
        <!-- service-area-end -->
        <?php endif; ?>

</section>
<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/features.blade.php ENDPATH**/ ?>