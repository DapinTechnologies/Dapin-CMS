<?php $__env->startSection('title', __('navbar_news')); ?>

<?php $__env->startSection('social_meta_tags'); ?>
    <?php if(isset($setting)): ?>
    <meta property="og:type" content="website">
    <meta property='og:site_name' content="<?php echo e($setting->title); ?>"/>
    <meta property='og:title' content="<?php echo e($news->title); ?>"/>
    <meta property='og:description' content="<?php echo str_limit(strip_tags($news->description), 160, ' ...'); ?>"/>
    <meta property='og:url' content="<?php echo e(route('news.single', ['id' => $news->id, 'slug' => $news->slug])); ?>"/>
    <meta property='og:image' content="<?php echo e(asset('uploads/news/'.$news->attach)); ?>"/>


    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="<?php echo '@'.str_replace(' ', '', $setting->title); ?>" />
    <meta name="twitter:creator" content="@HiTechParks" />
    <meta name="twitter:url" content="<?php echo e(route('news.single', ['id' => $news->id, 'slug' => $news->slug])); ?>" />
    <meta name="twitter:title" content="<?php echo e($news->title); ?>" />
    <meta name="twitter:description" content="<?php echo str_limit(strip_tags($news->description), 160, ' ...'); ?>" />
    <meta name="twitter:image" content="<?php echo e(asset('uploads/news/'.$news->attach)); ?>" />
    <?php endif; ?>
<?php $__env->stopSection(); ?>

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
          
        <!-- inner-blog -->
        <section class="inner-blog b-details-p pt-120 pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="blog-details-wrap">
                            <div class="details__content pb-30">
                                <h2><?php echo e($news->title); ?></h2>

                                <div class="meta-info">
                                    <ul>
                                        <li><i class="fal fa-calendar-alt"></i> 
                                            <?php echo e(date("d F, Y", strtotime($news->date))); ?>

                                        </li>
                                    </ul>
                                </div>

                                <div class="details__content-img">
                                    <img src="<?php echo e(asset('uploads/news/'.$news->attach)); ?>" alt="News">
                                </div>

                                <p><?php echo $news->description; ?></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- inner-blog-end -->
     
    </main>
    <!-- main-area-end -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\web\news-single.blade.php ENDPATH**/ ?>