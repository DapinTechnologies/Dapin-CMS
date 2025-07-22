
<?php $__env->startSection('title', __('navbar_gallery')); ?>
<?php $__env->startSection('content'); ?>

<!-- main-area -->
<main>
    
    <!-- breadcrumb-area -->
    <section class="breadcrumb-area d-flex p-relative align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-12 col-lg-12">
                    <div class="breadcrumb-wrap text-left">
                        <div class="breadcrumb-title">
                            <h2><?php echo e(__('navbar_gallery')); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="breadcrumb-wrap2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('navbar_home')); ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('navbar_gallery')); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- gallery-area -->
    <section id="work" class="pt-150 pb-105">
        <div class="container">                  
            <div class="portfolio">
                <div class="grid col3 wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">

                    <?php $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="grid-item">
                        <a class="popup-image" href="<?php echo e(asset('uploads/gallery/'.$gallery->attach)); ?>">
                            <figure class="gallery-image">
                                <img src="<?php echo e(asset('uploads/gallery/'.$gallery->attach)); ?>" alt="<?php echo e($gallery->title ?? ''); ?>" class="img-fluid gallery-img"> 
                            </figure>
                        </a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
        </div>
    </section>
    <!-- gallery-area-end -->
          
</main>
<!-- main-area-end -->

<?php $__env->stopSection(); ?>

<style>
    /* Ensure all images have the same size and modern styling */
.gallery-img {
    width: 100%;
    height: auto;
    object-fit: cover; /* Ensures the image covers the area while maintaining its aspect ratio */
    border-radius: 10px; /* Adds rounded corners for a modern feel */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adds a soft shadow for a modern look */
}

/* Responsive Grid Layout */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Makes the grid responsive */
    gap: 15px;
}

.grid-item {
    position: relative;
    overflow: hidden;
}

.popup-image {
    display: block;
    width: 100%;
    height: 100%;
}

.grid-item figure {
    margin: 0;
}

</style>
<style>
/* Responsive Grid Layout */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 15px;
}

/* Container for each image */
.grid-item {
    position: relative;
    overflow: hidden;
    height: 220px; /* Fixed height for all image containers */
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Image inside container */
.gallery-img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures consistent cropping */
    display: block;
    border-radius: 10px;
    transition: transform 0.3s ease-in-out;
}

/* Optional: zoom effect on hover */
.grid-item:hover .gallery-img {
    transform: scale(1.05);
}
</style>

<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/gallery.blade.php ENDPATH**/ ?>