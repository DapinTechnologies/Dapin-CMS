<?php if(isset($callToAction)): ?>
<section class="cta-area position-relative py-5" style="background-color: #444;" aria-labelledby="cta-title" itemscope itemtype="https://schema.org/CreativeWork">
    <meta itemprop="name" content="<?php echo e($callToAction->title); ?>">
    <meta itemprop="description" content="<?php echo e($callToAction->sub_title); ?>">

    <!-- Education Icon Background -->
    <div class="cta-bg-icon" aria-hidden="true">
        <svg viewBox="0 0 64 64" fill="none" class="education-icon-svg">
            <path d="M2 16L32 2L62 16L32 30L2 16Z" stroke="#ffffff20" stroke-width="2"/>
            <path d="M2 24L32 40L62 24" stroke="#ffffff30" stroke-width="2"/>
        </svg>
    </div>

    <div class="container position-relative">
        <div class="row align-items-center justify-content-center text-center text-lg-start">
            <!-- Title & Subtitle -->
            <div class="col-lg-8 mb-4 mb-lg-0" data-aos="fade-up">
                <header class="section-title cta-title">
                    <h2 id="cta-title" itemprop="headline" class="text-white fw-bold display-6"><?php echo e($callToAction->title); ?></h2>
                    <p itemprop="text" class="text-light fs-5 mb-0" style="color: #fff;"><?php echo e($callToAction->sub_title); ?></p>
                </header>
            </div>

            <!-- CTA Button -->
            <div class="col-lg-4 d-flex justify-content-center justify-content-lg-end" data-aos="fade-up" data-aos-delay="150">
                <?php if(isset($callToAction->button_link)): ?>
                <a href="<?php echo e($callToAction->button_link); ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="btn btn-lg fw-bold shadow-sm px-4 py-2 glow-on-hover"
                   itemprop="url"
                   style="background-color: #ff7350; color: #fff; border: none;">
                    <?php echo e($callToAction->button_text); ?> <i class="fas fa-arrow-right ms-2"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Styles -->
<style>
.cta-area {
    overflow: hidden;
    position: relative;
}
.cta-bg-icon {
    position: absolute;
    top: 10%;
    left: 50%;
    transform: translateX(-50%);
    z-index: 0;
    opacity: 0.1;
}
.education-icon-svg {
    width: 160px;
    height: 160px;
}
.cta-area .container {
    position: relative;
    z-index: 2;
}
.glow-on-hover {
    transition: all 0.3s ease-in-out;
}
.glow-on-hover:hover {
    box-shadow: 0 0 16px 3px #f6f5f51a;
    transform: translateY(-2px);
    background-color: #e86240 !important;
    color: #fff !important;
}
@media (max-width: 767.98px) {
    .cta-title h2 {
        font-size: 1.75rem;
    }
    .cta-title p {
        font-size: 1rem;
    }
    .btn {
        width: 100%;
        text-align: center;
    }
}
</style>

<!-- AOS -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        AOS.init({ once: true, offset: 100 });
    });
</script>
<?php endif; ?>
<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/cot.blade.php ENDPATH**/ ?>