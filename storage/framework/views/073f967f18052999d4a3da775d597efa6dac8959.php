
<?php $__env->startSection('title', __('About Us')); ?>

<?php $__env->startSection('social_meta_tags'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <?php if(isset($setting)): ?>
        <meta property="og:type" content="website">
        <meta property='og:site_name' content="<?php echo e($setting->title); ?>"/>
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="<?php echo '@'.str_replace(' ', '', $setting->title); ?>" />
        <meta name="twitter:creator" content="@HiTechParks" />
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<main>
    <!-- Hero Section with Dark Blue Breadcrumb -->
    <section class="breadcrumb-area py-5 bg-dark-blue text-white">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-12">
                    <h1 class="display-4 fw-bold mb-4"><?php echo e(__('About Us')); ?></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>" class="text-white-70"><?php echo e(__('navbar_home')); ?></a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page"><?php echo e(__('About')); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- About Content Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <?php if($about): ?>
            <div class="row g-5 align-items-center">
                <!-- Left: Text -->
                <div class="col-lg-6 order-lg-1 order-2">
                    <h2 class="fw-bold mb-4 text-dark-blue"><?php echo e($about->title); ?></h2>
                    <p class="lead text-muted mb-4"><?php echo e($about->short_desc); ?></p>
                    <div class="mb-4 text-gray-700"><?php echo $about->description; ?></div>
                    <?php if($about->attach): ?>
                        <div class="mt-4">
                            <h6 class="fw-bold text-dark-blue mb-3">Attached Image:</h6>
                            <img src="<?php echo e(asset('uploads/about/' . $about->attach)); ?>" class="img-fluid rounded-lg shadow" alt="Attachment">
                        </div>
                        <a href="<?php echo e(asset('uploads/about/' . $about->attach)); ?>" class="btn btn-primary mt-3" download>
                            <i class="bi bi-download me-2"></i> <?php echo e($about->button_text ?? 'Download Attachment'); ?>

                        </a>
                    <?php endif; ?>
                </div>

                <!-- Right: YouTube video -->
                <div class="col-lg-6 order-lg-2 order-1 text-center">
                    <?php if($about->video_id): ?>
                        <div class="ratio ratio-16x9 shadow-lg rounded-lg overflow-hidden">
                            <iframe src="https://www.youtube.com/embed/<?php echo e($about->video_id); ?>" frameborder="0" allowfullscreen class="rounded-lg"></iframe>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Features -->
            <?php if($about->features): ?>
            <div class="mt-5 pt-4">
                <h3 class="fw-semibold mb-4 text-dark-blue">Our Key Features</h3>
                <div class="row g-4">
                    <?php $__currentLoopData = json_decode($about->features, true) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6">
                            <div class="feature-card p-4 rounded-lg bg-light border-start border-4 border-dark-blue">
                                <i class="bi bi-check-circle-fill text-dark-blue me-2"></i> 
                                <span class="text-dark"><?php echo e($feature); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Mission Section -->
            <div class="row mt-5 pt-5 align-items-center">
                <div class="col-md-6">
                    <div class="pe-lg-4">
                        <h4 class="fw-bold text-dark-blue mb-4"><?php echo e($about->mission_title); ?></h4>
                        <p class="text-muted"><?php echo e($about->mission_desc); ?></p>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <?php if($about->mission_image): ?>
                        <img src="<?php echo e(asset('uploads/about/' . $about->mission_image)); ?>" class="img-fluid rounded-lg shadow" alt="Mission">
                    <?php endif; ?>
                </div>
            </div>

            <!-- Vision Section -->
            <div class="row mt-5 pt-5 align-items-center">
                <div class="col-md-6 order-md-2">
                    <div class="ps-lg-4">
                        <h4 class="fw-bold text-dark-blue mb-4"><?php echo e($about->vision_title); ?></h4>
                        <p class="text-muted"><?php echo e($about->vision_desc); ?></p>
                    </div>
                </div>
                <div class="col-md-6 text-center order-md-1">
                    <?php if($about->vision_image): ?>
                        <img src="<?php echo e(asset('uploads/about/' . $about->vision_image)); ?>" class="img-fluid rounded-lg shadow" alt="Vision">
                    <?php endif; ?>
                </div>
            </div>

            <?php else: ?>
                <div class="alert alert-warning mt-5">
                    <?php echo e(__('No about us content available.')); ?>

                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php $__env->stopSection(); ?>

<style>
/* Modern Color Theme with Dark Blue */
:root {
    --dark-blue: #0a2463;  /* Rich dark blue */
    --primary-color: #4361ee;
    --secondary-color: #3f37c9;
    --accent-color: #4cc9f0;
    --dark-color: #14213d;
    --light-color: #f8f9fa;
    --text-color: #495057;
    --text-light: #6c757d;
}

/* Base Styles */
body {
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    line-height: 1.6;
    color: var(--text-color);
    overflow-x: hidden;
}

h1, h2, h3, h4, h5, h6 {
    font-family: 'Jost', sans-serif;
    color: var(--dark-blue);
    font-weight: 600;
    line-height: 1.3;
}

p {
    margin-bottom: 1.2rem;
    line-height: 1.8;
}

/* Hero Section with Dark Blue */
.bg-dark-blue {
    background-color: var(--dark-blue);
    background: linear-gradient(135deg, var(--dark-blue), #1e3b8a);
    position: relative;
    overflow: hidden;
}

.bg-dark-blue::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd' opacity='0.1'%3E%3Cg fill='%23ffffff' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.text-white-70 {
    color: rgba(255, 255, 255, 0.7) !important;
}

.text-white-70:hover {
    color: white !important;
}

.display-4 {
    font-size: 2.5rem;
    letter-spacing: -0.5px;
}

/* Buttons */
.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: var(--dark-blue);
    border-color: var(--dark-blue);
}

.btn-primary:hover {
    background-color: #1a3a8a;
    border-color: #1a3a8a;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(10, 36, 99, 0.3);
}

/* Cards & Boxes */
.feature-card {
    transition: all 0.3s ease;
    height: 100%;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    background-color: white !important;
}

/* Images & Media */
.img-fluid {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    transition: transform 0.3s ease;
}

.img-fluid:hover {
    transform: scale(1.02);
}

.rounded-lg {
    border-radius: 12px;
}

.shadow {
    box-shadow: 0 5px 15px rgba(0,0,0,0.08) !important;
}

/* Text Colors */
.text-dark {
    color: var(--dark-color) !important;
}

.text-dark-blue {
    color: var(--dark-blue) !important;
}

.text-muted {
    color: var(--text-light) !important;
}

.text-gray-700 {
    color: #4a5568;
}

/* Spacing */
.mt-5 {
    margin-top: 3rem !important;
}

.pt-5 {
    padding-top: 3rem !important;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .display-4 {
        font-size: 2.2rem;
    }
}

@media (max-width: 768px) {
    .breadcrumb-area {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }
    
    .display-4 {
        font-size: 2rem;
    }
    
    .feature-card {
        padding: 1.5rem;
    }
    
    .col-md-6, .col-lg-6 {
        margin-bottom: 2rem;
    }
    
    .order-md-1, .order-lg-1 {
        order: 1;
    }
    
    .order-md-2, .order-lg-2 {
        order: 2;
    }
}

@media (max-width: 576px) {
    .display-4 {
        font-size: 1.8rem;
    }
    
    .btn {
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
    }
}
</style>
<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/about.blade.php ENDPATH**/ ?>