<?php if(isset($about)): ?>
<!-- About Us Section -->
<section class="about-area about-p p-relative fix parallax-section" style="padding-top: 60px; padding-bottom: 120px;">
    <div class="parallax-bg"></div>

    <div class="animations-02" data-aos="zoom-in">
        <img src="<?php echo e(asset('web/img/bg/an-img-02.png')); ?>" alt="Decorative background for About section" class="img-fluid">
    </div>

    <div class="container position-relative">
        <div class="row justify-content-center align-items-center g-5">

            <div class="col-lg-6 col-md-12" data-aos="fade-right">
                <figure class="s-about-img p-relative rounded overflow-hidden shadow-sm">
                    <img src="<?php echo e(asset('uploads/about-us/'.$about->attach)); ?>" alt="<?php echo e($about->title); ?>" class="img-fluid rounded w-100">
                </figure>
            </div>

            <div class="col-lg-6 col-md-12" data-aos="fade-left">
                <article class="about-content s-about-content ps-lg-4">
                    <header class="about-title second-title pb-3" data-aos="fade-up">
                        <h1 class="text-primary fw-semibold mb-2 h5">
                            <i class="fal fa-graduation-cap me-2"></i><?php echo e($about->label); ?>

                        </h1>
                        <h2 class="fw-bold display-6 mb-3"><?php echo e($about->title); ?></h2>
                    </header>

                    <div class="about-description mb-4 text-dark fs-5 lh-base" data-aos="fade-up" data-aos-delay="100">
                        <?php echo strip_tags($about->description, '<a><b><i><u><strong>'); ?>

                    </div>

                    <?php if($about->mission_title || $about->vision_title): ?>
                    <div class="bg-white rounded shadow-sm p-4" itemscope itemtype="https://schema.org/Organization" data-aos="fade-up" data-aos-delay="200">
                        <?php if(isset($about->mission_title)): ?>
                        <div class="mb-3">
                            <h3 class="text-dark fw-bold mb-2" itemprop="mission"><?php echo e($about->mission_title); ?></h3>
                            <p class="mb-0 text-muted"><?php echo strip_tags($about->mission_desc, '<a><b><i><u><strong>'); ?></p>
                        </div>
                        <?php endif; ?>

                        <?php if(isset($about->vision_title)): ?>
                        <hr>
                        <div class="mt-3">
                            <h3 class="text-dark fw-bold mb-2" itemprop="vision"><?php echo e($about->vision_title); ?></h3>
                            <p class="mb-0 text-muted"><?php echo strip_tags($about->vision_desc, '<a><b><i><u><strong>'); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </article>
            </div>

        </div>
    </div>
</section>
<!-- End About Us Section -->
<?php endif; ?>

<!-- Styles -->
<style>
.parallax-section {
    position: relative;
    overflow: hidden;
    background-color: #eff7ff;
}

.parallax-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 140%;
    background-image: url('<?php echo e(asset('web/img/bg/parallax-bg.jpg')); ?>');
    background-size: cover;
    background-attachment: fixed;
    background-position: center;
    opacity: 0.15;
    z-index: 0;
}

.parallax-section .container {
    position: relative;
    z-index: 1;
}
@media (max-width: 767.98px) {
    /* Reduce bottom margin of feature services */
    .service-details-two {
        margin-bottom: 10px !important;
        padding-bottom: 10px !important;
    }

    /* Reduce top padding of About Us section */
    .about-area {
        padding-top: 30px !important;
    }
}

</style>
<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/abouthead.blade.php ENDPATH**/ ?>