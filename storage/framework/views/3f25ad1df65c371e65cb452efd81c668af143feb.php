<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    
     <?php echo $__env->make('student.layouts.common.header_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</head>

<body>

    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar active-lightblue title-lightblue navbar-lightblue brand-lightblue navbar-image-4 menu-item-icon-style2 <?php echo e(\Cookie::get('sidebar')); ?>">
        <div class="navbar-wrapper">
            <div class="navbar-brand header-logo">
                <?php if(isset($setting)): ?>
                <?php if(is_file('uploads/setting/'.$setting->logo_path)): ?>
                <a href="<?php echo e(route('student.dashboard.index')); ?>" class="b-brand">
                    <img src="<?php echo e(asset('uploads/setting/'.$setting->logo_path)); ?>" alt="logo">
                </a>
                <?php endif; ?>
                <?php endif; ?>
                <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
            </div>


            <?php if(Request::is('student*')): ?>
            <!--- Sidemenu -->
            <?php echo $__env->make('student.layouts.inc.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- End Sidebar -->
            <?php endif; ?>

        </div>
    </nav>
    <!-- [ navigation menu ] end -->


    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg navbar-light headerpos-fixed header-lightblue">
        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
            <?php if(isset($setting)): ?>
            <?php if(is_file('uploads/setting/'.$setting->logo_path)): ?>
            <a href="<?php echo e(route('student.dashboard.index')); ?>" class="b-brand">
                <div class="b-bg">
                    <img src="<?php echo e(asset('uploads/setting/'.$setting->logo_path)); ?>" alt="logo" height="20">
                </div>
            </a>
            <?php endif; ?>
            <?php endif; ?>
        </div>
        <a class="mobile-menu" id="mobile-header" href="#!">
            <i class="feather icon-more-horizontal"></i>
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li><a href="#!" class="full-screen" onclick="javascript:toggleFullScreen()"><i class="feather icon-maximize"></i></a></li>
                <li>
                    <h4 class="topbar-title"><?php echo e($setting->title); ?></h4>
                </li>
            </ul>

            <!-- [ Auth Nav ] start -->
            <?php if(auth()->guard()->check()): ?>
            <ul class="navbar-nav ms-auto">
                <!-- Language -->
                <li>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <?php 
                            $version = App\Models\Language::version(); 
                            ?>
                            <i class="fas fa-language"></i> <?php echo e($version->name); ?>

                        </a>
                        <div class="dropdown-menu dropdown-menu-right notification">
                            <div class="noti-head">
                                <h6 class="d-inline-block m-b-0"><?php echo e(trans_choice('module_language', 2)); ?></h6>
                            </div>
                            <ul class="noti-body">
                                <?php $__currentLoopData = $user_languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="notification <?php if(\Session()->get('locale') == $user_language->code): ?> active <?php endif; ?>">
                                    <a class="language" href="<?php echo e(route('version', $user_language->code)); ?>"><?php echo e($user_language->name); ?></a>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- Notification -->
                <li>
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="icon feather icon-bell">
                            <?php if(isset(Auth::guard('student')->user()->unreadNotifications)): ?>
                            <?php if(Auth::guard('student')->user()->unreadNotifications->count() > 0): ?>
                            <span class="notification-active"></span>
                            <?php endif; ?>
                            <?php endif; ?>
                            </i>
                        </a>
                        <?php if(isset(Auth::guard('student')->user()->unreadNotifications)): ?>
                        <div class="dropdown-menu dropdown-menu-right notification">
                            <div class="noti-head">
                                <h6 class="d-inline-block m-b-0"><?php echo e(trans_choice('module_notification', 2)); ?></h6>
                            </div>
                            <ul class="noti-body">
                                <?php $__empty_1 = true; $__currentLoopData = Auth::guard('student')->user()->unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php if($key < 10): ?>
                                <?php
                                    $notification_link = 'student.dashboard.index';
                                    $notification_type = '';
                                    if($notification->data['type'] == 'content') {
                                    $notification_link = 'student.download.show';
                                    $notification_type = trans_choice('module_content', 1);
                                    }
                                    elseif( $notification->data['type'] == 'notice') {
                                    $notification_link = 'student.notice.show';
                                    $notification_type = trans_choice('module_notice', 1);
                                    }
                                    elseif($notification->data['type'] == 'assignment'){
                                    $notification_link = 'student.assignment.index';
                                    $notification_type = trans_choice('module_assignment', 1);
                                    }
                                ?>
                                <li class="notification">
                                    <?php if($notification->data['type'] == 'assignment'): ?>
                                    <a class="media" href="<?php echo e(route($notification_link)); ?>">
                                    <?php else: ?>
                                    <a class="media" href="<?php echo e(route($notification_link, $notification->data['id'])); ?>">
                                    <?php endif; ?>
                                        <div class="media-body">
                                            <p><strong><?php echo e($notification->data['title']); ?></strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i><?php echo e($notification->created_at->diffForHumans()); ?></span></p>
                                            <p><i class="fas fa-arrow-circle-right"></i> <?php echo e($notification_type); ?></p>
                                        </div>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li class="notification"><?php echo e(__('status_no_notification')); ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </li>

                <!-- Profile -->
                <li>
                    <div class="dropdown drp-user">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="far fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-notification">
                            <div class="pro-head">
                                <img src="<?php echo e(asset('uploads/student/'.Auth::user()->photo)); ?>" class="img-radius" alt="User Profile" <?php if(Auth::user()->gender == 1): ?> onerror="this.src='<?php echo e(asset('dashboard/images/user/avatar-2.jpg')); ?>';" <?php else: ?>  onerror="this.src='<?php echo e(asset('dashboard/images/user/avatar-1.jpg')); ?>';" <?php endif; ?>>
                                <span><?php echo e(Auth::user()->first_name); ?> <?php echo e(Auth::user()->last_name); ?></span>

                                <a href="javascript:void(0);" class="dud-logout" href="<?php echo e(route('student.logout')); ?>"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    
                                    <i class="feather icon-log-out"></i>
                                </a>

                                <form id="logout-form" action="<?php echo e(route('student.logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                </form>

                            </div>
                            <ul class="pro-body">
                                <li><a href="<?php echo e(route('student.profile.index')); ?>" class="dropdown-item"><i class="feather icon-user"></i> <?php echo e(trans_choice('module_profile', 2)); ?></a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
            <?php endif; ?>
            <!-- [ Auth Nav ] end -->

        </div>
    </header>
    <!-- [ Header ] end -->


    <!-- [ chat user list ] start -->
    <section class="header-user-list">
        <div class="h-list-header">
            <div class="input-group">
                <input type="text" id="search-friends" class="form-control" placeholder="Search Friend . . .">
            </div>
        </div>
        <div class="h-list-body">
            <a href="#!" class="h-close-text"><i class="feather icon-chevrons-right"></i></a>
            <div class="main-friend-cont scroll-div">
                <div class="main-friend-list">

                </div>
            </div>
        </div>
    </section>
    <!-- [ chat user list ] end -->

    <!-- [ chat message ] start -->
    <section class="header-chat">
        <div class="h-list-header">
            <h6></h6>
            <a href="#!" class="h-back-user-list"><i class="feather icon-chevron-left"></i></a>
        </div>
        <div class="h-list-body">
            <div class="main-chat-cont scroll-div">
                <div class="main-friend-chat">
                    <div class="media chat-messages">
                        
                        <div class="media-body chat-menu-content">
                            
                        </div>
                    </div>
                    <div class="media chat-messages">
                        <div class="media-body chat-menu-reply">
                            
                        </div>
                    </div>
                    <div class="media chat-messages">
                        
                        <div class="media-body chat-menu-content">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- [ chat message ] end -->


    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    
                    <!-- start page title -->
                    <!-- Include page breadcrumb -->
                    <?php echo $__env->make('student.layouts.inc.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!-- end page title -->
                    

                    <!-- Start Content-->
                    <?php echo $__env->yieldContent('content'); ?>
                    <!-- End Content-->

                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->


    <?php echo $__env->make('student.layouts.common.footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/layouts/master.blade.php ENDPATH**/ ?>