<?php $__env->startSection('title', __('navbar_faqs')); ?>
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
                                <h2><?php echo e(__('navbar_faqs')); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="breadcrumb-wrap2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('navbar_home')); ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('navbar_faqs')); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <!-- faq-area -->
        <section class="event event03 pt-150 pb-120 p-relative fix">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12  wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                       <div class="faq-wrap pl-30 wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                            <div class="accordion" id="accordionExample">

                                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="card">
                                    <div class="card-header" id="heading-<?php echo e($key); ?>">
                                        <h2 class="mb-0">
                                            <button class="faq-btn <?php if($key != 0): ?> collapsed <?php endif; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo e($key); ?>">
                                                <?php echo e($faq->title); ?>

                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapse-<?php echo e($key); ?>" class="collapse <?php if($key == 0): ?> show <?php endif; ?>" data-bs-parent="#accordionExample">
                                        <div class="card-body">
                                            <?php echo $faq->description; ?>

                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                        </div>  
                    </div>           
                </div>
            </div>
        </section>
        <!-- faq-area -->
               
    </main>
    <!-- main-area-end -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home7/httpurba/public_html/college/resources/views/web/faq.blade.php ENDPATH**/ ?>