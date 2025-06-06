<?php $__env->startSection('title', __('navbar_news')); ?>
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
                                <h2><?php echo e(__('navbar_news')); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="breadcrumb-wrap2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('navbar_home')); ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('navbar_news')); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->
        
        <!-- blog-area -->
        <section class="blog-area p-relative fix pt-120 pb-120">
            <div class="container">
                <div class="row">

                    <?php $__currentLoopData = $newses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-post2 hover-zoomin mb-30 wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                            <div class="blog-thumb2">
                                <a href="<?php echo e(route('news.single', ['id' => $news->id, 'slug' => $news->slug])); ?>"><img src="<?php echo e(asset('uploads/news/'.$news->attach)); ?>" alt="News"></a>

                                <div class="date-home">
                                    <i class="fal fa-calendar-alt"></i> 
                                    <?php echo e(date("d F, Y", strtotime($news->date))); ?>

                                </div>
                            </div>                    
                            <div class="blog-content2">
                                <h4><a href="<?php echo e(route('news.single', ['id' => $news->id, 'slug' => $news->slug])); ?>"><?php echo e($news->title); ?></a></h4> 

                                <p><?php echo str_limit(strip_tags($news->description), 120, ' ...'); ?></p>

                                <div class="blog-btn"><a href="<?php echo e(route('news.single', ['id' => $news->id, 'slug' => $news->slug])); ?>"><?php echo e(__('btn_read_more')); ?> <i class="fal fa-long-arrow-right"></i></a></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="pagination-wrap mt-20 text-center">
                            <nav>
                                <ul class="pagination">
                                    <?php echo e($newses->appends(Request::only('search'))->links()); ?>

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- blog-area-end -->

    </main>
    <!-- main-area-end -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\web\news.blade.php ENDPATH**/ ?>