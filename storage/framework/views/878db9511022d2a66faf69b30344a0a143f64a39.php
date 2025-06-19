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


</style>

    




 </head>

 <body>

 	<!-- header -->
    <header class="header-area header-three">  
       <div class="header-top second-header d-none d-md-block">
            <div class="container">
                <div class="row align-items-center">      
                   
                    <div class="col-lg-4 col-md-4 d-none d-lg-block ">
                        <?php if(isset($topbarSetting) && $topbarSetting->social_status == 1): ?>
                        <div class="header-social">
                            <span>
                            <?php if(isset($socialSetting->facebook)): ?>
                            <a href="<?php echo e($socialSetting->facebook); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <?php endif; ?>
                            <?php if(isset($socialSetting->instagram)): ?>
                            <a href="<?php echo e($socialSetting->instagram); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if(isset($socialSetting->twitter)): ?>
                            <a href="<?php echo e($socialSetting->twitter); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                            <?php endif; ?>
                            <?php if(isset($socialSetting->linkedin)): ?>
                            <a href="<?php echo e($socialSetting->linkedin); ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            <?php endif; ?>
                            <?php if(isset($socialSetting->pinterest)): ?>
                            <a href="<?php echo e($socialSetting->pinterest); ?>" target="_blank"><i class="fab fa-pinterest"></i></a>
                            <?php endif; ?>
                            <?php if(isset($socialSetting->youtube)): ?>
                            <a href="<?php echo e($socialSetting->youtube); ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                            <?php endif; ?>
                           </span>                    
                           <!--  /social media icon redux -->                               
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-lg-8 col-md-8 d-none d-lg-block text-right">
                        <div class="header-cta">
                            <ul>
                               <?php if(isset($topbarSetting->phone)): ?>
                               <li>
                                  <div class="call-box">
                                     <div class="icon">
                                        <img src="<?php echo e(asset('web/img/icon/phone-call.png')); ?>" alt="img">
                                     </div>
                                     <div class="text">
                                        <strong><a href="tel:<?php echo e(str_replace(' ', '', $topbarSetting->phone ?? '')); ?>"><?php echo e($topbarSetting->phone ?? ''); ?></a></strong>
                                     </div>
                                  </div>
                               </li>
                               <?php endif; ?>
                               <?php if(isset($topbarSetting->email)): ?>
                               <li>
                                  <div class="call-box">
                                     <div class="icon">
                                        <img src="<?php echo e(asset('web/img/icon/mailing.png')); ?>" alt="img">
                                     </div>
                                     <div class="text">
                                        <strong><a href="mailto:<?php echo e($topbarSetting->email ?? ''); ?>"><?php echo e($topbarSetting->email ?? ''); ?></a></strong>
                                     </div>
                                  </div>
                               </li>
                               <?php endif; ?>
                            </ul>
                        </div>                        
                    </div>
                    
                </div>
            </div>
        </div>    


        <div id="header-sticky" class="menu-area">
            <div class="container">
                <div class="second-menu">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-3">
                            <?php if(isset($setting)): ?>
                            <div class="logo">
                                <a href="<?php echo e(route('home')); ?>"><img src="<?php echo e(asset('/uploads/setting/'.$setting->logo_path)); ?>" alt="logo"></a>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-xl-8 col-lg-8">
                            <div class="main-menu text-right text-xl-right">
                                <nav id="mobile-menu">
                                    <ul>
                                        <li class="<?php echo e(Request::path() == '/' ? 'current' : ''); ?>"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('navbar_home')); ?></a></li>
                                        <li class="<?php echo e(Request::is('course*') ? 'current' : ''); ?>"><a href="<?php echo e(route('course')); ?>"><?php echo e(__('navbar_course')); ?></a></li>
                                        <li class="<?php echo e(Request::is('event*') ? 'current' : ''); ?>"><a href="<?php echo e(route('event')); ?>"><?php echo e(__('navbar_event')); ?></a></li>
                                        <li class="<?php echo e(Request::is('faq*') ? 'current' : ''); ?>"><a href="<?php echo e(route('faq')); ?>"><?php echo e(__('navbar_faqs')); ?></a></li>
                                        <li class="<?php echo e(Request::is('gallery*') ? 'current' : ''); ?>"><a href="<?php echo e(route('gallery')); ?>"><?php echo e(__('navbar_gallery')); ?></a></li>
                                        <li class="<?php echo e(Request::is('news*') ? 'current' : ''); ?>"><a href="<?php echo e(route('news')); ?>"><?php echo e(__('navbar_news')); ?></a></li>
                                 
                                        

                                        <li class="<?php echo e(Request::is('materials*') ? 'current' : ''); ?>">
                                            <a href="<?php echo e(route('materialhome')); ?>"><?php echo e(__('Digital Library')); ?></a>
                                        </li>
                                        
                                        <li class="<?php echo e(Request::is('about*') ? 'current' : ''); ?>">
                                            <a href="#"><?php echo e(__('About Us')); ?></a>
                                        </li>
                                        
                                        
                                    </ul>
                                </nav>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 text-right d-none d-lg-block text-right text-xl-right">
                            <?php 
                            $application = App\Models\ApplicationSetting::status(); 
                            ?>
                            <?php if(isset($application)): ?>
                            <div class="login">
                                <ul>
                                    <li>
                                        <div class="second-header-btn">
                                           <a href="<?php echo e(route('application.index')); ?>" target="_blank" class="btn"><?php echo e(__('navbar_admission')); ?></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="col-12">
                            <div class="mobile-menu"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->

 	
    <!-- Content Start -->
    <?php echo $__env->yieldContent('content'); ?>
    <!-- Content End -->


 	<!-- footer -->
    <footer class="footer-bg footer-p pt-90" style="background-color: #125875;">
        <div class="footer-top pb-70">
            <div class="container">
                <div class="row justify-content-between">
                    
                    <div class="col-xl-4 col-lg-4 col-sm-12">
                        <div class="footer-widget mb-30">
                            <div class="f-widget-title">
                                <h2><?php echo e(__('footer_socials')); ?></h2>
                            </div>
                            <div class="footer-social mt-10">                                    
                                <?php if(isset($socialSetting->facebook)): ?>
                                <a href="<?php echo e($socialSetting->facebook); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <?php endif; ?>
                                <?php if(isset($socialSetting->instagram)): ?>
                                <a href="<?php echo e($socialSetting->instagram); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                                <?php endif; ?>
                                <?php if(isset($socialSetting->twitter)): ?>
                                <a href="<?php echo e($socialSetting->twitter); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                                <?php endif; ?>
                                <?php if(isset($socialSetting->linkedin)): ?>
                                <a href="<?php echo e($socialSetting->linkedin); ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                <?php endif; ?>
                                <?php if(isset($socialSetting->pinterest)): ?>
                                <a href="<?php echo e($socialSetting->pinterest); ?>" target="_blank"><i class="fab fa-pinterest"></i></a>
                                <?php endif; ?>
                                <?php if(isset($socialSetting->youtube)): ?>
                                <a href="<?php echo e($socialSetting->youtube); ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                                <?php endif; ?>
                            </div>    
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="footer-widget mb-30">
                            <div class="f-widget-title">
                                <h2><?php echo e(__('footer_links')); ?></h2>
                            </div>
                            <div class="footer-link">
                                <ul>
                                    <?php if(Route::has('student.login')): ?>
                                    <li><a href="<?php echo e(route('student.login')); ?>" target="_blank"><?php echo e(__('field_student')); ?> <?php echo e(__('field_login')); ?></a></li>
                                    <?php endif; ?>
                                    <?php if(Route::has('login')): ?>
                                    <li><a href="<?php echo e(route('login')); ?>" target="_blank"><?php echo e(__('field_staff')); ?> <?php echo e(__('field_login')); ?></a></li>
                                    <?php endif; ?>

                                    <?php 
                                    $application = App\Models\ApplicationSetting::status(); 
                                    ?>
                                    <?php if(isset($application)): ?>
                                    <li><a href="<?php echo e(route('application.index')); ?>" target="_blank"><?php echo e(__('navbar_admission')); ?></a></li>
                                    <?php endif; ?>

                                    <?php $__currentLoopData = $footer_pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $footer_page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e(route('page.single', ['slug' => $footer_page->slug])); ?>"><?php echo e($footer_page->title); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="footer-widget mb-30">
                            <div class="f-widget-title">
                                <h2><?php echo e(__('footer_contact')); ?></h2>
                            </div>
                            <div class="f-contact">
                                <ul>
                                    <?php if(isset($topbarSetting->phone)): ?>
                                    <li>
                                        <i class="icon fal fa-phone"></i>
                                        <span><a href="tel:<?php echo e(str_replace(' ', '', $topbarSetting->phone ?? '')); ?>"><?php echo e($topbarSetting->phone ?? ''); ?></a></span>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(isset($topbarSetting->email)): ?>
                                    <li>
                                        <i class="icon fal fa-envelope"></i>
                                        <span><a href="mailto:<?php echo e($topbarSetting->email ?? ''); ?>"><?php echo e($topbarSetting->email ?? ''); ?></a></span>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(isset($topbarSetting->address)): ?>
                                    <li>
                                        <i class="icon fal fa-map-marker-check"></i>
                                        <span><?php echo e($topbarSetting->address ?? ''); ?></span>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>


        <div class="copyright-wrap">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="dropdown">
                          <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo e($version->name); ?>

                          </a>

                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <?php $__currentLoopData = $user_languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a class="dropdown-item" href="<?php echo e(route('version', $user_language->code)); ?>"><?php echo e($user_language->name); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12 text-center">          
                        
                    </div>
                    <div class="col-lg-4 col-md-4 col-12 text-center text-md-right">
                        <?php if(isset($setting->copyright_text)): ?>
                        &copy; <?php echo strip_tags($setting->copyright_text, '<a><b><i><u><strong>'); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
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
</html><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/web/layouts/master.blade.php ENDPATH**/ ?>