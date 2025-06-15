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
                <a href="<?php echo e(route('home')); ?>" class="b-brand">
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
            <a href="<?php echo e(route('home')); ?>" class="b-brand">
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
            </ul>
            <?php endif; ?>
            <!-- [ Auth Nav ] end -->

        </div>
    </header>
    <!-- [ Header ] end -->


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
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?php echo e(__('error_404_title')); ?></h5>
                                        </div>
                                        <div class="card-block">
                                            <a onclick="history.back()" class="btn btn-info"><?php echo e(__('btn_back')); ?></a>
                                        </div>
                                        <div class="card-block">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                    <!-- End Content-->

                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->


    <?php echo $__env->make('student.layouts.common.footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/errors/404.blade.php ENDPATH**/ ?>