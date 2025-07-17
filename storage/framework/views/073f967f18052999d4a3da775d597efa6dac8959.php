
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
    <!-- Hero Section -->
    <section class="breadcrumb-area py-5 bg-dark-blue text-white">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-12">
                    <h1 class="display-4 fw-bold mb-4"><?php echo e(__('About NIBS Technical College')); ?></h1>
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
            <!-- Dynamic Content Section -->
            <div class="row g-5 align-items-center">
                <!-- Left: Text Content -->
                <div class="col-lg-6 order-lg-1 order-2">
                    <h2 class="fw-bold mb-4 text-dark-blue"><?php echo e($about->title); ?></h2>
                    <p class="lead text-muted mb-4"><?php echo e($about->short_desc); ?></p>
                    <div class="mb-4 text-gray-700"><?php echo $about->description; ?></div>
                </div>

                <!-- Right: Media Content (Image + Video) -->
                <div class="col-lg-6 order-lg-2 order-1">
                    <?php if($about->attach): ?>
                        <div class="text-center mb-4">
                            <img src="<?php echo e(asset('uploads/about-us/'.$about->attach)); ?>" 
                                 alt="<?php echo e($about->title); ?>" 
                                 class="img-fluid rounded w-100 shadow-lg mb-4"
                                 style="max-height: 400px; object-fit: cover;">
                        </div>
                    <?php endif; ?>
                    
                    <?php if($about->video_id): ?>
                        <div class="ratio ratio-16x9 shadow-lg rounded-lg overflow-hidden">
                            <iframe src="https://www.youtube.com/embed/<?php echo e($about->video_id); ?>" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen 
                                    class="rounded-lg">
                            </iframe>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Features Section -->
            <?php if($about->features): ?>
            <div class="mt-5 pt-4">
                <h3 class="fw-semibold mb-4 text-dark-blue">Our Key Features</h3>
                <div class="row g-4">
                    <?php $__currentLoopData = json_decode($about->features, true) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6">
                            <div class="feature-card p-4 rounded-lg bg-light border-start border-4 border-dark-blue h-100">
                                <i class="bi bi-check-circle-fill text-dark-blue me-2"></i> 
                                <span class="text-dark"><?php echo e($feature); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
            <?php endif; ?>

            <!-- Vision & Mission Section -->
            <div class="row mb-5 mt-5">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="icon-box bg-light-blue text-dark-blue mb-3">
                                <i class="bi bi-eye-fill fs-2"></i>
                            </div>
                            <h3 class="text-dark">Vision Statement</h3>
                            <p class="lead text-dark">To be a dynamic center of excellence in the delivery of high-quality, relevant industry-based training and education.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="icon-box bg-light-green text-dark-blue mb-3">
                                <i class="bi bi-bullseye fs-2"></i>
                            </div>
                            <h3 class="text-dark">Our Motto</h3>
                            <p class="lead text-dark">"Developing Character, Skills & Competence."</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Founder's Message -->
            <div class="row my-5 py-4 align-items-center">
                <div class="col-lg-5">
                    <img src="<?php echo e(asset('assets/images/founder.jpg')); ?>" alt="Founder Lizzie Wanyoike" class="img-fluid rounded shadow-lg w-100">
                </div>
                <div class="col-lg-7 mt-4 mt-lg-0">
                    <h2 class="text-dark mb-4">Founder's Message</h2>
                    <div class="message-content">
                        <p class="text-dark">Welcome to the world of possibilities at NIBS Technical College! Your interest in joining our exceptional institution is truly appreciated. Get ready to embark on an exciting journey towards academic excellence fused with dynamic courses that redefine leadership.</p>
                        
                        <p class="text-dark">With a remarkable 24-year legacy, NIBS Technical College has been at the forefront of delivering top-notch technical education and training. We offer a diverse range of courses, from Artisan and Craft Certificates to Diplomas and Advanced Diplomas, all designed to equip you not only with theoretical knowledge but also hands-on practical expertise essential for your success.</p>
                        
                        <p class="text-dark">Rest assured, our commitment to quality is unwavering. Endorsed by the Ministry of Education and authorized by the Technical and Vocational Education and Training Authority (TVETA), we guarantee a superior education and practical training that aligns with industry standards.</p>
                        
                        <div class="signature mt-4">
                            <p class="mb-1 fw-bold text-dark">Lizzie Wanyoike,</p>
                            <p class="text-muted">Principal</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Timeline -->
            <div class="row my-5 py-4">
                <div class="col-12">
                    <h2 class="text-dark mb-5 text-center">Our History</h2>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-year">1999</div>
                            <div class="timeline-content">
                                <h4>Establishment</h4>
                                <p class="text-dark">Incorporated on 19th March 1999 under the Companies Act (Cap 486), as Nairobi Institute of Business Studies (NIBS) as a private tertiary college mandated to offer market driven courses. We commenced operations in June 1999 with a total of 25 students pursuing Secretarial and Business courses in the Agriculture House Building, along Moi Avenue in Nairobi CBD.</p>
                            </div>
                        </div>
                        <!-- Additional Timeline Items -->
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Ensure all text is black */
    .text-dark, .lead, .text-muted, .timeline-content p, .message-content p, .feature-card span, .text-dark-blue {
        color: black !important; /* Set text color to black */
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/about.blade.php ENDPATH**/ ?>