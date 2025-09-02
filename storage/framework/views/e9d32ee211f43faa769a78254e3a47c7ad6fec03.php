<!-- AOS & Font Awesome CSS -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
</style>

<?php
    use App\Models\Course;
    $courses = Course::where('status', 1)->orderBy('faculty')->get();
?>

<section class="container py-5" aria-labelledby="courses-heading">
    <h2 id="courses-heading" class="text-center mb-4">Our Courses</h2>

    <div class="row g-4" id="course-list">
        <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-lg-4 col-md-6 col-sm-12" data-aos="fade-up" data-aos-duration="800">
                <article class="course-card" itemscope itemtype="https://schema.org/Course">
                    <a href="<?php echo e(route('course.single', ['slug' => $course->slug])); ?>" class="text-decoration-none text-dark d-block" itemprop="url">
                        <h3 itemprop="name"><?php echo e($course->title); ?></h3>
                        <p><i class="fas fa-building"></i><strong>Department:</strong> <span itemprop="provider"><?php echo e($course->faculty); ?></span></p>
                        <p><i class="fas fa-clock"></i><strong>Duration:</strong> <?php echo e($course->duration); ?></p>
                        <p class="course-fee"><i class="fas fa-money-bill-wave"></i><strong>Fee:</strong> KSH <?php echo e(number_format($course->fee, 2)); ?></p>

                        <div class="course-extra mt-2" itemprop="description">
                            <p><strong>Description:</strong> <?php echo Str::limit($course->description, 150); ?></p>
                            <?php if($course->award): ?>
                                <p><strong>Award:</strong> <?php echo e($course->award); ?></p>
                            <?php endif; ?>
                            <?php if($course->semesters): ?>
                                <p><strong>Semesters:</strong> <?php echo e($course->semesters); ?></p>
                            <?php endif; ?>
                        </div>
                    </a>
                </article>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center">No courses available.</p>
        <?php endif; ?>
    </div>
</section>

<!-- AOS Script -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        AOS.init({ once: true });
    });
</script>
<?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/web/coursehead.blade.php ENDPATH**/ ?>