<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>

<style>
    .why-choose-carousel .card {
        min-height: 330px;
        margin-bottom: 20px;
    }
    .owl-carousel .owl-stage {
        display: flex !important;
    }
    .owl-nav {
        display: flex;
        justify-content: space-between;
        position: absolute;
        top: 45%;
        width: 100%;
        padding: 0 15px;
        pointer-events: none;
    }
    .owl-nav span {
        background: #007bff;
        color: #fff;
        border-radius: 50%;
        padding: 5px 10px;
        font-size: 1.5rem;
        pointer-events: all;
        cursor: pointer;
    }
</style>

<!-- Why Choose Us Section -->
<section class="why-choose-us-section py-5 bg-white" id="why-choose-us" aria-labelledby="why-us-heading">
    <div class="container">
        <header class="text-center mb-5" data-aos="fade-up">
            <h2 id="why-us-heading" class="fw-bold">Why Choose Us?</h2>
            <p class="text-muted">A choice that makes the difference in education and career success.</p>
        </header>

        <?php
            $features = [
                ['icon' => 'graduation-cap', 'title' => 'Accredited Programs', 'desc' => 'Our programs are officially certified by examination bodies including KNEC, KASNEB, and City & Guilds.'],
                ['icon' => 'chalkboard-teacher', 'title' => 'Expert Instructors', 'desc' => 'Highly skilled trainers dedicated to delivering quality and career-relevant education.'],
                ['icon' => 'book-open', 'title' => 'Hands-On Training', 'desc' => 'Learn by doing with real-world simulations, projects, and labs.'],
                ['icon' => 'award', 'title' => 'Proven Success', 'desc' => 'Our graduates thrive in both employment and higher learning.'],
            ];
        ?>

        <!-- Desktop Grid Layout -->
        <div class="row g-4 d-none d-md-flex" itemscope itemtype="https://schema.org/ItemList">
            <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-3" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" data-aos="fade-up" data-aos-delay="<?php echo e(100 * $i); ?>">
                    <meta itemprop="position" content="<?php echo e($i + 1); ?>">
                    <div class="card h-100 text-center shadow-sm border-0 p-4">
                        <div class="mb-3">
                            <i class="fas fa-<?php echo e($f['icon']); ?> fa-2x text-primary" aria-hidden="true"></i>
                        </div>
                        <h5 class="fw-bold"><?php echo e($f['title']); ?></h5>
                        <p class="text-muted small"><?php echo e($f['desc']); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Mobile Carousel -->
        <div class="owl-carousel why-choose-carousel d-none d-md-none" itemscope itemtype="https://schema.org/ItemList">
            <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card text-center shadow-sm border-0 p-4 mx-2" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="<?php echo e($i + 1); ?>">
                    <div class="mb-3">
                        <i class="fas fa-<?php echo e($f['icon']); ?> fa-2x text-primary" aria-hidden="true"></i>
                    </div>
                    <h5 class="fw-bold"><?php echo e($f['title']); ?></h5>
                    <p class="text-muted small"><?php echo e($f['desc']); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- Mobile Carousel Init -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.matchMedia("(max-width: 767px)").matches) {
            const carousel = document.querySelector('.why-choose-carousel');
            if (carousel) {
                $(carousel).removeClass('d-none').addClass('d-block');
                $(carousel).owlCarousel({
                    items: 1,
                    loop: true,
                    margin: 20,
                    nav: true,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    smartSpeed: 600,
                    navText: [
                        '<span class="owl-nav-prev">‹</span>',
                        '<span class="owl-nav-next">›</span>'
                    ]
                });
            }
        }
    });
</script>

<?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/web/choose.blade.php ENDPATH**/ ?>