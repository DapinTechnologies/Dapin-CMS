<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
 <head>
 	<!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <?php if(isset($setting)): ?>
    <!-- App Title -->
    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e($setting->meta_title ?? ''); ?></title>

    <meta name="description" content="<?php echo str_limit(strip_tags($setting->meta_description), 160, ' ...'); ?>">
    <meta name="keywords" content="<?php echo strip_tags($setting->meta_keywords); ?>">

    <!-- App favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('/uploads/setting/'.$setting->favicon_path)); ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo e(asset('/uploads/setting/'.$setting->favicon_path)); ?>" type="image/x-icon">
    <?php endif; ?>


    <?php if(empty($setting)): ?>
    <!-- App Title -->
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <?php endif; ?>


    <!-- Social Meta Tags -->
    <link rel="canonical" href="<?php echo e(route('home')); ?>">
    
    <?php echo $__env->yieldContent('social_meta_tags'); ?>


 	<!-- Stylesheets -->
 	<link rel="stylesheet" href="<?php echo e(asset('web/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('web/css/animate.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('web/css/magnific-popup.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('web/fontawesome/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('web/css/dripicons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('web/css/slick.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('web/css/meanmenu.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('web/css/default.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('web/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('web/css/responsive.css')); ?>">


    <?php 
    $version = App\Models\Language::version(); 
    ?>
    <?php if($version->direction == 1): ?>
    <!-- RTL css -->
    <link rel="stylesheet" href="<?php echo e(asset('web/css/rtl.css')); ?>">
    <?php endif; ?>




    <style>
.second-menu .row {
    display: flex;
    align-items: center; /* Align items vertically */
    justify-content: space-between; /* Space out the logo, menu, and button */
}

.main-menu {
    display: flex;
    justify-content: flex-start; /* Align menu to the left */
}

.main-menu ul {
    display: flex;
    align-items: center; /* Ensure items are vertically aligned */
    margin: 0;
    padding: 0;
    list-style: none;
    gap: 10px; /* Space between menu items */
}

.main-menu ul li {
    margin: 0; /* No additional margin needed */
}

.main-menu ul li a {
    display: inline-block;
    white-space: nowrap; /* Prevent text wrapping */
    font-size: 14px; /* Smaller font size */
    padding: 4px 8px; /* Adjust padding for smaller size */
    text-decoration: none; /* Optional: remove underline */
    color: #000; /* Adjust text color as needed */
}

.second-header-btn .btn {
    padding: 6px 12px; /* Adjust button size */
    font-size: 12px; /* Smaller font size for the button */
    margin-left: 10px; /* Space between menu and button */
}
/* Adjust alignment of the Admission button container */
.col-xl-3.col-lg-3.text-right {
    display: flex;
    justify-content: flex-end; /* Align items to the far right */
    align-items: center; /* Ensure vertical alignment */
}

/* Style the Admission button */
.second-header-btn .btn {
    padding: 10px 20px; /* Adjust padding for the button */
    font-size: 14px; /* Slightly larger font for better visibility */
    background-color: #007bff; /* Button background color */
    color: white; /* Button text color */
    border-radius: 4px; /* Optional: rounded corners */
    text-align: center; /* Center-align text */
}
.main-menu ul {
    display: flex;
    align-items: center;
    gap: 20px; /* Increase spacing between menu items */
    margin: 0;
    padding: 0;
    list-style: none;
}

.second-header-btn .btn {
    padding: 8px 16px; /* Adjust button size */
    font-size: 14px; /* Maintain button font size */
    margin-left: 20px; /* Add spacing between the menu and button */
}

.second-menu .row {
    flex-wrap: nowrap; /* Prevent wrapping of header items */
    align-items: center; /* Ensure vertical alignment */
    justify-content: space-between; /* Distribute space evenly */
}

@media (max-width: 991px) {
    .second-menu .row {
        flex-wrap: wrap; /* Allow wrapping on smaller screens */
    }

    .main-menu, .second-header-btn {
        margin-bottom: 10px; /* Add spacing for better visibility */
    }
}



html, body {
    margin: 0 !important;
    padding: 0 !important;
    box-sizing: border-box;
}


</style>

    <style>
/* Add this to remove default body spacing */
body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    color: #fff;
    overflow-x: hidden;
}

/* Ensure header has no top margin */
.header-area {
    margin-top: 0;
}

/* Remove any potential top spacing from slider */
.slider-area {
    margin-top: 0 !important;
    padding-top: 0 !important;
}

.menu-area {
    padding: 10px 0; /* or whatever makes your topbar look good */
    margin: 0;
}



</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        AOS.init({
            once: true,
            duration: 800,
            easing: 'ease-out-quad'
        });
    });
</script>




 </head>

 <body>

<?php echo $__env->make('web.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- header-end -->

 	
    <!-- Content Start -->
    <?php echo $__env->yieldContent('content'); ?>
    <!-- Content End -->


 	<!-- footer -->
    <?php echo $__env->make('web.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  
    <!-- footer-end -->


 	<!-- Script JS -->
 	<script src="<?php echo e(asset('web/js/vendor/modernizr-3.5.0.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/vendor/jquery-3.6.0.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/slick.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/paroller.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/js_isotope.pkgd.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/imagesloaded.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/jquery.waypoints.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/jquery.countdown.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/jquery.counterup.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/jquery.scrollUp.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/jquery.meanmenu.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/parallax-scroll.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/jquery.magnific-popup.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/element-in-view.js')); ?>"></script>
    <script src="<?php echo e(asset('web/js/main.js')); ?>"></script>

 </body>
</html><?php /**PATH /opt/lampp/htdocs/Dapin-CMS/resources/views/web/layouts/master.blade.php ENDPATH**/ ?>