<!-- CSS & Libraries -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.core.min.css">

<style>
    .course-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        padding: 20px;
        background: #ffffff;
        border: 1px solid #e3e3e3;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        min-height: 360px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }

    .course-card h3 {
        font-size: 1.1rem;
        color: #212529;
        margin-bottom: 10px;
    }

    .course-card p {
        font-size: 0.95rem;
        margin-bottom: 6px;
        color: #444;
    }

    .course-card i {
        color: #007bff;
        margin-right: 8px;
    }

    .course-fee {
        color: #007bff;
        font-weight: 600;
    }

    @media (max-width: 576px) {
        .course-card {
            margin-bottom: 1rem;
        }
    }

    @media (min-width: 769px) {
        .course-card {
            min-height: 280px;
            padding: 15px 20px;
        }

        .course-card h3 {
            font-size: 1rem;
            margin-bottom: 8px;
        }

        .course-card p {
            font-size: 0.9rem;
            margin-bottom: 4px;
        }
    }

    /* Mobile-specific center alignment fix */
    .courses-glide .glide__slide {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0 10px;
        width: 100%;
        box-sizing: border-box;
        text-align: center;
    }

    @media (max-width: 768px) {
        .courses-glide .course-card {
            max-width: 95%;
            margin: 0 auto;
        }
    }

    .courses-glide .glide__bullets {
        display: flex;
        justify-content: center;
        margin-top: 15px;
        gap: 8px;
    }

    .courses-glide .glide__bullet {
        width: 10px;
        height: 10px;
        background: rgba(0,0,0,0.3);
        border-radius: 50%;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .courses-glide .glide__bullet--active {
        background: #007bff;
        transform: scale(1.2);
    }

    .courses-glide .glide__arrows {
        display: flex;
        justify-content: space-between;
        position: absolute;
        top: 40%;
        left: 0;
        right: 0;
        padding: 0 15px;
        z-index: 10;
    }

    .courses-glide .glide__arrow {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #fff;
        border: none;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        color: #007bff;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s ease;
    }

    .courses-glide .glide__arrow:hover {
        background: #007bff;
        color: #fff;
    }
</style>


<?php
    use App\Models\Course;
    $courses = Course::where('status', 1)->orderBy('faculty')->get();
?>

<section class="container py-5" aria-labelledby="courses-heading">
    <h2 id="courses-heading" class="text-center mb-4">Our Courses</h2>

    <!-- Desktop Grid -->
    <div class="row g-4 d-none d-md-flex" id="course-list">
        <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-lg-4 col-md-6 col-sm-12" data-aos="fade-up" data-aos-duration="800">
                <article class="course-card">
                    <a href="<?php echo e(route('course.single', ['slug' => $course->slug])); ?>" class="text-decoration-none text-dark d-block">
                        <h3><?php echo e($course->title); ?></h3>
                        <p><i class="fas fa-building"></i><strong> Department:</strong> <?php echo e($course->faculty); ?></p>
                        <p><i class="fas fa-clock"></i><strong> Duration:</strong> <?php echo e($course->duration); ?></p>
                        <p class="course-fee"><i class="fas fa-money-bill-wave"></i><strong> Fee:</strong> KSH <?php echo e(number_format($course->fee, 2)); ?></p>
                        <div class="course-extra mt-2">
                            <p><strong>Description:</strong> <?php echo Str::limit($course->description, 150); ?></p>
                            <?php if($course->award): ?><p><strong>Award:</strong> <?php echo e($course->award); ?></p><?php endif; ?>
                            <?php if($course->semesters): ?><p><strong>Semesters:</strong> <?php echo e($course->semesters); ?></p><?php endif; ?>
                        </div>
                    </a>
                </article>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center">No courses available.</p>
        <?php endif; ?>
    </div>

    <!-- Mobile Carousel -->
    <div class="glide courses-glide d-md-none mt-4 position-relative">
        <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
                <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="glide__slide">
                        <article class="course-card">
                            <a href="<?php echo e(route('course.single', ['slug' => $course->slug])); ?>" class="text-decoration-none text-dark d-block">
                                <h3><?php echo e($course->title); ?></h3>
                                <p><i class="fas fa-building"></i><strong> Department:</strong> <?php echo e($course->faculty); ?></p>
                                <p><i class="fas fa-clock"></i><strong> Duration:</strong> <?php echo e($course->duration); ?></p>
                                <p class="course-fee"><i class="fas fa-money-bill-wave"></i><strong> Fee:</strong> KSH <?php echo e(number_format($course->fee, 2)); ?></p>
                                <div class="course-extra mt-2">
                                    <p><strong>Description:</strong> <?php echo Str::limit($course->description, 150); ?></p>
                                    <?php if($course->award): ?><p><strong>Award:</strong> <?php echo e($course->award); ?></p><?php endif; ?>
                                    <?php if($course->semesters): ?><p><strong>Semesters:</strong> <?php echo e($course->semesters); ?></p><?php endif; ?>
                                </div>
                            </a>
                        </article>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="glide__slide">
                        <p class="text-center">No courses available.</p>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Arrows -->
        <div class="glide__arrows" data-glide-el="controls">
            <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fas fa-chevron-left"></i></button>
            <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fas fa-chevron-right"></i></button>
        </div>

        <!-- Bullets -->
        <div class="glide__bullets" data-glide-el="controls[nav]">
            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button class="glide__bullet" data-glide-dir="=<?php echo e($index); ?>"></button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/glide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.innerWidth <= 768 && document.querySelector('.courses-glide')) {
            new Glide('.courses-glide', {
                type: 'carousel',
                perView: 1,
                gap: 20,
                autoplay: 4000,
                hoverpause: true,
                animationDuration: 600
            }).mount();
        }
    });
</script>

<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/coursehead.blade.php ENDPATH**/ ?>