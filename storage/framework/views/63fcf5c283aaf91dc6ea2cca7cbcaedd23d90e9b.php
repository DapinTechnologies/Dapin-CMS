<!-- header -->
    <header class="header-area header-three">  
      <?php echo $__env->make('web.layouts.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
    </header><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/layouts/header.blade.php ENDPATH**/ ?>