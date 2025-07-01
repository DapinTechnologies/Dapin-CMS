<!-- HEADER WRAPPER -->
<div id="header-wrapper">

    <!-- TOP HEADER BAR -->
    <div class="header-top d-none d-md-flex align-items-center" id="topbar">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <ul class="d-flex list-unstyled mb-0 align-items-center small-links w-100 justify-content-evenly text-white">
                <?php if(isset($topbarSetting->phone)): ?>
                    <li><i class="fas fa-phone-alt me-1"></i><a href="tel:<?php echo e(str_replace(' ', '', $topbarSetting->phone)); ?>"><?php echo e($topbarSetting->phone); ?></a></li>
                <?php endif; ?>
                <?php if(isset($topbarSetting->email)): ?>
                    <li><i class="fas fa-envelope me-1"></i><a href="mailto:<?php echo e($topbarSetting->email); ?>"><?php echo e($topbarSetting->email); ?></a></li>
                <?php endif; ?>
                <li><i class="fas fa-user-graduate me-1"></i><a href="<?php echo e(route('student.login')); ?>">Student Portal</a></li>
                <li><i class="fas fa-user-tie me-1"></i><a href="<?php echo e(route('login')); ?>">Staff Portal</a></li>
                <li><i class="fas fa-book-reader me-1"></i><a href="#">E-learning</a></li>
                <li><i class="fas fa-book me-1"></i><a href="<?php echo e(route('materialhome')); ?>">Digital Library</a></li>
                <li><i class="fas fa-user-plus me-1"></i><a href="<?php echo e(route('application.index')); ?>">Join Now</a></li>
                <li><i class="fas fa-chalkboard-teacher me-1"></i><a href="#">E-Courses</a></li>
            </ul>
        </div>
    </div>

    <!-- MAIN HEADER -->
    <header class="header-area header-three" id="main-header">
        <div class="menu-area">
            <div class="container">
                <div class="second-menu">
                    <div class="row align-items-center py-1">
                        <div class="col-xl-3 col-lg-3 d-flex align-items-center">
                            <?php if(isset($setting)): ?>
                                <div class="logo" style="max-height: 50px; overflow: hidden;">
                                    <a href="<?php echo e(route('home')); ?>">
                                        <img src="<?php echo e(asset('/uploads/setting/'.$setting->logo_path)); ?>" alt="logo" style="max-height: 40px;">
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-xl-8 col-lg-8">
                            <div class="main-menu text-right text-xl-right">
                                <nav>
                                    <ul class="mb-0">
                                        <li class="<?php echo e(Request::path() == '/' ? 'current' : ''); ?>"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('navbar_home')); ?></a></li>
                                        <li class="<?php echo e(Request::is('course*') ? 'current' : ''); ?>"><a href="<?php echo e(route('course')); ?>"><?php echo e(__('navbar_course')); ?></a></li>
                                        <li class="<?php echo e(Request::is('event*') ? 'current' : ''); ?>"><a href="<?php echo e(route('event')); ?>"><?php echo e(__('navbar_event')); ?></a></li>
                                        <li class="<?php echo e(Request::is('faq*') ? 'current' : ''); ?>"><a href="<?php echo e(route('faq')); ?>"><?php echo e(__('navbar_faqs')); ?></a></li>
                                        <li class="<?php echo e(Request::is('gallery*') ? 'current' : ''); ?>"><a href="<?php echo e(route('gallery')); ?>"><?php echo e(__('navbar_gallery')); ?></a></li>
                                        <li class="<?php echo e(Request::is('news*') ? 'current' : ''); ?>"><a href="<?php echo e(route('news')); ?>"><?php echo e(__('navbar_news')); ?></a></li>
                                        <li class="<?php echo e(Request::is('about*') ? 'current' : ''); ?>"><a href="<?php echo e(route('aboutus')); ?>"><?php echo e(__('About Us')); ?></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mobile-menu"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>

<!-- STYLES -->
<style>
    body {
        padding-top: 90px; /* Adjust as needed */
    }

    .header-top {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1049;
        background-color: #003366;
        color: white;
        font-size: 0.72rem;
        padding: 2px 0;
        height: 24px;
    }

    .header-top a {
        color: #ffffff;
        text-decoration: none;
        font-size: 0.72rem;
    }

    .header-area {
        position: fixed;
        top: 24px; /* Directly below the header-top */
        width: 100%;
        z-index: 1050;
        background-color: #ffffff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .menu-area {
        padding: 4px 0;
    }

    .main-menu ul {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        list-style: none;
        padding: 0;
        margin: 0;
        flex-wrap: wrap;
    }

    .main-menu ul li {
        flex: 1;
        text-align: center;
    }

    .main-menu ul li a {
        padding: 6px 0;
        display: inline-block;
        width: 100%;
        text-transform: uppercase;
        color: #333;
        font-size: 14px;
        text-decoration: none;
    }

    .main-menu ul li a:hover,
    .main-menu ul li.current a {
        color: #4361ee;
        font-weight: 600;
    }

    @media (max-width: 991.98px) {
        .main-menu ul {
            flex-direction: column;
        }

        .main-menu ul li {
            flex: unset;
            width: 100%;
            margin-bottom: 10px;
        }

        body {
            padding-top: 120px;
        }
    }
</style>
<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/layouts/header.blade.php ENDPATH**/ ?>