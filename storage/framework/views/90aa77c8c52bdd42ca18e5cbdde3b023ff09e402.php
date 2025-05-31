
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
    <section class="breadcrumb-area py-5 bg-light border-bottom">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col">
                    <h1 class="display-5 fw-bold"><?php echo e(__('About Us')); ?></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('navbar_home')); ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('About')); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- About Content Section -->
    <section class="py-5">
        <div class="container">
            <?php if($about): ?>
            <div class="row g-5 align-items-center">
                <!-- Left: Text -->
                <div class="col-lg-6">
                    <h2 class="fw-bold"><?php echo e($about->title); ?></h2>
                    <p class="lead text-muted"><?php echo e($about->short_desc); ?></p>
                    <div class="mb-3"><?php echo $about->description; ?></div>
                    <?php if($about->attach): ?>
                        <div class="mt-3">
                            <h6 class="fw-bold">Attached Image:</h6>
                            <img src="<?php echo e(asset('uploads/about/' . $about->attach)); ?>" class="img-fluid rounded shadow-sm" alt="Attachment">
                        </div>
                        <a href="<?php echo e(asset('uploads/about/' . $about->attach)); ?>" class="btn btn-outline-primary mt-3" download>
                            <i class="bi bi-download"></i> <?php echo e($about->button_text ?? 'Download Attachment'); ?>

                        </a>
                    <?php endif; ?>
                </div>

                <!-- Right: YouTube video -->
                <div class="col-lg-6 text-center">
                    <?php if($about->video_id): ?>
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/<?php echo e($about->video_id); ?>" frameborder="0" allowfullscreen></iframe>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Features -->
            <?php if($about->features): ?>
            <div class="mt-5">
                <h3 class="fw-semibold">Features</h3>
                <ul class="list-group list-group-flush">
                    <?php $__currentLoopData = json_decode($about->features, true) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item">
                            <i class="bi bi-check-circle-fill text-success me-2"></i> <?php echo e($feature); ?>

                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- Mission Section -->
            <div class="row mt-5 align-items-center">
                <div class="col-md-6">
                    <h4 class="fw-bold"><?php echo e($about->mission_title); ?></h4>
                    <p class="text-muted"><?php echo e($about->mission_desc); ?></p>
                </div>
                <div class="col-md-6 text-center">
                    <?php if($about->mission_image): ?>
                        <img src="<?php echo e(asset('uploads/about/' . $about->mission_image)); ?>" class="img-fluid rounded" alt="Mission">
                    <?php endif; ?>
                </div>
            </div>

            <!-- Vision Section -->
            <div class="row mt-5 align-items-center flex-md-row-reverse">
                <div class="col-md-6">
                    <h4 class="fw-bold"><?php echo e($about->vision_title); ?></h4>
                    <p class="text-muted"><?php echo e($about->vision_desc); ?></p>
                </div>
                <div class="col-md-6 text-center">
                    <?php if($about->vision_image): ?>
                        <img src="<?php echo e(asset('uploads/about/' . $about->vision_image)); ?>" class="img-fluid rounded" alt="Vision">
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

<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views/web/about.blade.php ENDPATH**/ ?>