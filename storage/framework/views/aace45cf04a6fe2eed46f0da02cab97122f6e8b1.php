<?php $__env->startSection('title', $page->title); ?>
<?php $__env->startSection('content'); ?>

    <!-- main-area -->
    <main>

        <!-- breadcrumb-area -->
        <section class="breadcrumb-area d-flex  p-relative align-items-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-12 col-lg-12">
                        <div class="breadcrumb-wrap text-left">
                            <div class="breadcrumb-title">
                                <h2><?php echo e($page->title); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="breadcrumb-wrap2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('navbar_home')); ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo e($page->title); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->
                   
        <!-- Page Detail -->
        <section class="project-detail">
            <div class="container">
                <!-- Upper Box -->
                <?php if(is_file('uploads/page/'.$page->attach)): ?>
                <div class="upper-box">
                    <div class="single-item-carousel owl-carousel owl-theme">
                        <figure class="image"><img src="<?php echo e(asset('uploads/page/'.$page->attach)); ?>" alt="<?php echo e($page->title); ?>"></figure>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Lower Content -->
                <div class="lower-content2">
                    <div class="row">
                        <div class="text-column col-lg-12 col-md-12 col-sm-12">
                            <div class="s-about-content wow fadeInRight" data-animation="fadeInRight" data-delay=".2s">  

                                <h2><?php echo e($page->title); ?></h2>
                                <p><?php echo $page->description; ?></p>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!--End Page Detail -->
       
    </main>
    <!-- main-area-end -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home7/httpurba/public_html/college/resources/views/web/page.blade.php ENDPATH**/ ?>