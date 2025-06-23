

<!-- Examination Bodies Section -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.core.min.css" rel="stylesheet">

<section class="exam-bodies-section py-5" style="background: #f1f3f5;" aria-labelledby="exam-bodies-heading">
    <div class="container">
        <header class="text-center mb-5" data-aos="fade-up" data-aos-duration="800">
            <h2 id="exam-bodies-heading" class="fw-bold h2">Accredited Examination Bodies in Kenya</h2>
            <p class="text-muted">Our institution is officially recognized and accredited by top national and international examination authorities.</p>
        </header>

        <div id="examBodiesCarousel" class="glide exam-bodies-glide">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides text-center">
                    <!-- KNEC -->
                    <li class="glide__slide" itemscope itemtype="https://schema.org/Organization" data-aos="fade-right" data-aos-delay="100" data-aos-duration="800">
                        <div class="exam-body-card p-4 shadow-sm bg-white rounded" itemprop="department">
                            <img src="<?php echo e(asset('uploads/logos/knec.jpg')); ?>" alt="KNEC Logo" style="height: 60px;" class="mb-3" itemprop="logo">
                            <h3 class="h5" itemprop="name">KNEC</h3>
                            <p class="text-muted small" itemprop="description">Kenya National Examinations Council - the national assessment body in Kenya.</p>
                        </div>
                    </li>

                    <!-- KASNEB -->
                    <li class="glide__slide" itemscope itemtype="https://schema.org/Organization" data-aos="fade-up" data-aos-delay="200" data-aos-duration="800">
                        <div class="exam-body-card p-4 shadow-sm bg-white rounded" itemprop="department">
                            <img src="<?php echo e(asset('uploads/logos/kasneb.png')); ?>" alt="KASNEB Logo" style="height: 60px;" class="mb-3" itemprop="logo">
                            <h3 class="h5" itemprop="name">KASNEB</h3>
                            <p class="text-muted small" itemprop="description">Kenya Accountants and Secretaries National Examinations Board - a professional certification body in Kenya.</p>
                        </div>
                    </li>

                    <!-- City & Guilds -->
                    <li class="glide__slide" itemscope itemtype="https://schema.org/Organization" data-aos="fade-left" data-aos-delay="300" data-aos-duration="800">
                        <div class="exam-body-card p-4 shadow-sm bg-white rounded" itemprop="department">
                            <img src="<?php echo e(asset('uploads/logos/city.png')); ?>" alt="City and Guilds Logo" style="height: 60px;" class="mb-3" itemprop="logo">
                            <h3 class="h5" itemprop="name">City & Guilds</h3>
                            <p class="text-muted small" itemprop="description">City & Guilds - a globally recognized vocational education and certification authority.</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Arrows only visible on mobile -->
            <div class="glide__arrows d-md-none" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fas fa-chevron-left"></i></button>
                <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>
</section>

<style>
.exam-body-card {
    transition: all 0.3s ease;
}
.exam-body-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}
.exam-bodies-glide .glide__slide {
    padding: 0 12px;
}

@media (max-width: 768px) {
    .exam-bodies-glide {
        position: relative;
        padding: 0 20px;
    }

    .exam-bodies-glide .glide__arrows {
        display: flex;
        justify-content: space-between;
        position: absolute;
        top: 40%;
        left: 0;
        right: 0;
        padding: 0 10px;
        pointer-events: none;
    }

    .exam-bodies-glide .glide__arrow {
        width: 36px;
        height: 36px;
        background: #fff;
        border: none;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        font-size: 1rem;
        color: #007bff;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: auto;
    }

    .exam-bodies-glide .glide__arrow:hover {
        background: #007bff;
        color: #fff;
    }
}
</style>

<!-- JS Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/glide.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Glide('#examBodiesCarousel', {
            type: 'carousel',
            perView: 3,
            gap: 24,
            breakpoints: {
                992: { perView: 2 },
                768: { perView: 1 }
            }
        }).mount();

        AOS.init({ once: true });
    });
</script>
<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/exams.blade.php ENDPATH**/ ?>