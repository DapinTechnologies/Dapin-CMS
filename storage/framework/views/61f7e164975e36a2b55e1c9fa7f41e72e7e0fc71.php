<style>
    /* Animation for moving letters */
/* Animation for moving letters */
.moving-letters span {
    display: inline-block;
    opacity: 0;
    transform: translateX(100%); /* Start off-screen to the right */
    animation: moveLetters 1s forwards;
    animation-timing-function: ease-out;
}

/* Delay the animation for each letter */
.moving-letters span:nth-child(1) { animation-delay: 0.1s; }
.moving-letters span:nth-child(2) { animation-delay: 0.2s; }
.moving-letters span:nth-child(3) { animation-delay: 0.3s; }
.moving-letters span:nth-child(4) { animation-delay: 0.4s; }
.moving-letters span:nth-child(5) { animation-delay: 0.5s; }
/* Continue with nth-child selectors for more letters */

@keyframes moveLetters {
    0% {
        opacity: 0;
        transform: translateX(100%); /* Letters start from the far right */
    }
    100% {
        opacity: 1;
        transform: translateX(0); /* Letters end at their original position */
    }
}

</style>

<section id="home" class="slider-area fix p-relative">
    <div class="slider-active" style="background: #141b22;">
        <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="single-slider slider-bg" style="background-image: url(<?php echo e(asset('uploads/slider/'.$slider->attach)); ?>); background-size: cover;">
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-7">
                        <div class="slider-content s-slider-content mt-130">
                            <!-- Wrap each letter in a span tag -->
                            <h2 class="moving-letters">
                                <?php $__currentLoopData = str_split($slider->title); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span><?php echo e($letter); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </h2>
                            <p data-animation="fadeInUp" data-delay=".6s"><?php echo strip_tags($slider->sub_title, '<b><u><i><br>'); ?></p>
                            
                            <?php if(isset($slider->button_link)): ?>
                            <div class="slider-btn mt-30">     
                                <a href="<?php echo e($slider->button_link); ?>" target="_blank" class="btn ss-btn mr-15" data-animation="fadeInLeft" data-delay=".4s"><?php echo e($slider->button_text); ?> <i class="fal fa-long-arrow-right"></i></a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 p-relative">
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>
<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/slider.blade.php ENDPATH**/ ?>