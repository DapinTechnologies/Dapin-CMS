<?php $__env->startSection('title', __('navbar_course')); ?>

<?php $__env->startSection('social_meta_tags'); ?>
    <?php if(isset($setting)): ?>
    <meta property="og:type" content="website">
    <meta property='og:site_name' content="<?php echo e($setting->title); ?>"/>
    <meta property='og:title' content="<?php echo e($course->title); ?>"/>
    <meta property='og:description' content="<?php echo str_limit(strip_tags($course->description), 160, ' ...'); ?>"/>
    <meta property='og:url' content="<?php echo e(route('course.single', ['slug' => $course->slug])); ?>"/>
    <meta property='og:image' content="<?php echo e(asset('uploads/course/'.$course->attach)); ?>"/>


    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="<?php echo '@'.str_replace(' ', '', $setting->title); ?>" />
    <meta name="twitter:creator" content="@HiTechParks" />
    <meta name="twitter:url" content="<?php echo e(route('course.single', ['slug' => $course->slug])); ?>" />
    <meta name="twitter:title" content="<?php echo e($course->title); ?>" />
    <meta name="twitter:description" content="<?php echo str_limit(strip_tags($course->description), 160, ' ...'); ?>" />
    <meta name="twitter:image" content="<?php echo e(asset('uploads/course/'.$course->attach)); ?>" />
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
                                <h2><?php echo e(__('navbar_course')); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="breadcrumb-wrap2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('navbar_home')); ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('navbar_course')); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->
        
        <!-- course Detail -->
        <section class="project-detail">
            <div class="container">
                <!-- Lower Content -->
                <div class="lower-content">
                    <div class="row">
                        <div class="text-column col-lg-9 col-md-9 col-sm-12">
                            <h2><?php echo e($course->title); ?></h2>
                            
                            <div class="upper-box">
                                <div class="single-item-carousel owl-carousel owl-theme">
                                    <figure class="image"><img src="<?php echo e(asset('uploads/course/'.$course->attach)); ?>" alt="Course"></figure>
                                </div>
                            </div>
                            <div class="inner-column">
                                <p><?php echo $course->description; ?></p>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <aside class="sidebar-widget info-column">
                                <div class="inner-column3">
                                    <h3><?php echo e(__('sidebar_course')); ?></h3>
                                    
                                    <ul class="project-info clearfix">
                                        <?php if(!empty($course->faculty)): ?>
                                        <li>
                                            <strong><?php echo e(__('field_faculty')); ?>: </strong> 
                                            <span><?php echo e($course->faculty); ?></span>
                                        </li>
                                        <?php endif; ?>
                                        <?php if(!empty($course->semesters)): ?>
                                        <li>
                                            <strong><?php echo e(__('field_total')); ?> <?php echo e(__('field_semester')); ?>: </strong> 
                                            <span><?php echo e($course->semesters); ?></span>
                                        </li>
                                        <?php endif; ?>
                                        <?php if(!empty($course->credits)): ?>
                                        <li>
                                            <strong><?php echo e(__('field_total_credit_hour')); ?>: </strong> 
                                            <span><?php echo e($course->credits); ?></span>
                                        </li>
                                        <?php endif; ?>
                                        <?php if(!empty($course->courses)): ?>
                                        <li>
                                            <strong><?php echo e(__('field_total')); ?> <?php echo e(__('field_subject')); ?>: </strong> 
                                            <span><?php echo e($course->courses); ?></span>
                                        </li>
                                        <?php endif; ?>
                                        <?php if(!empty($course->duration)): ?>
                                        <li>
                                            <strong><?php echo e(__('field_duration')); ?>: </strong> 
                                            <span><?php echo e($course->duration); ?></span>
                                        </li>
                                        <?php endif; ?>
                                        <?php if(!empty($course->fee)): ?>
                                        <li>
                                            <strong><?php echo e(__('field_total')); ?> <?php echo e(__('field_fee')); ?>: </strong> 
                                            <span><?php echo e(round($course->fee, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></span>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End course Detail -->
               
    </main>
    <!-- main-area-end -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\web\course-single.blade.php ENDPATH**/ ?>