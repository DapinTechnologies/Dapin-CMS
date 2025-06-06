<?php $__env->startSection('title', __('navbar_event')); ?>
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
                                <h2><?php echo e(__('navbar_event')); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="breadcrumb-wrap2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('navbar_home')); ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('navbar_event')); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->
                   
        <!-- event-area -->
        <section class="shop-area pt-120 pb-120 p-relative " data-animation="fadeInUp animated" data-delay=".2s">
            <div class="container">
                <div class="row">
                 
                    <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-6  wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                        <div class="event-item mb-30 hover-zoomin">
                            <div class="thumb">
                                <a href="<?php echo e(route('event.single', ['id' => $event->id, 'slug' => $event->slug])); ?>"><img src="<?php echo e(asset('uploads/web-event/'.$event->attach)); ?>" alt="Event"></a>
                            </div>
                            <div class="event-content">                                    
                                <div class="date"><strong><?php echo e(date("d", strtotime($event->date))); ?></strong> <?php echo e(date("M, Y", strtotime($event->date))); ?></div>
                                
                                <h3><a href="<?php echo e(route('event.single', ['id' => $event->id, 'slug' => $event->slug])); ?>"><?php echo e($event->title); ?></a></h3>

                                <p><?php echo str_limit(strip_tags($event->description), 100, ' ...'); ?></p>

                                <div class="time">
                                    <span>
                                    <?php if(isset($setting->time_format)): ?>
                                    <?php echo e(date($setting->time_format, strtotime($event->time))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("h:i A", strtotime($event->time))); ?>

                                    <?php endif; ?>
                                    </span>
                                    <i class="fal fa-long-arrow-right"></i> 
                                    <strong><?php echo e($event->address); ?></strong>
                                </div>
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
                                    <?php echo e($events->appends(Request::only('search'))->links()); ?>

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- event-area-end -->
               
    </main>
    <!-- main-area-end -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\web\event.blade.php ENDPATH**/ ?>