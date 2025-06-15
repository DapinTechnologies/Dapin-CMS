<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        
         <?php echo $__env->make('admin.layouts.common.header_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

         <style type="text/css" media="screen">
             h3 {
                font-size: 18px;
             }
             .auth-logo {
                position: absolute;
                left: 40px;
                top: 10px;
                overflow: hidden;
             }
             .auth-logo img {
                max-height: 100px;
                max-width: 100px;
             }

             @media screen and (max-width: 767px) {
                .auth-logo img {
                    max-height: 70px;
                }
             }
         </style>

    </head>
    <body>

        <div class="auth-wrapper">

            <?php if(isset($setting)): ?>
            <?php if(is_file('uploads/setting/'.$setting->logo_path)): ?>
            <a href="#" class="auth-logo">
                <img src="<?php echo e(asset('uploads/setting/'.$setting->logo_path)); ?>" alt="logo">
            </a>
            <?php endif; ?>
            <?php endif; ?>
            
            <div class="auth-content">
                <div class="auth-bg">
                    <span class="r"></span>
                    <span class="r s"></span>
                    <span class="r s"></span>
                    <span class="r"></span>
                </div>

                <!-- Start Content-->
                <?php echo $__env->yieldContent('content'); ?>
                <!-- End Content-->
                
            </div>
        </div>

        <?php echo $__env->make('admin.layouts.common.footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>
</html><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/auth/layouts/master.blade.php ENDPATH**/ ?>