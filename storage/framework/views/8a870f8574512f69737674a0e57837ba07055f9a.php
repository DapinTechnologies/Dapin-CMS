        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="robots" content="noindex" />
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <?php if(isset($setting)): ?>
        <!-- App Title -->
        <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e($setting->meta_title ?? ''); ?></title>

        <meta name="description" content="<?php echo str_limit(strip_tags($setting->meta_description), 160, ' ...'); ?>">
        <meta name="keywords" content="<?php echo strip_tags($setting->meta_keywords); ?>">

        <?php if(is_file('uploads/setting/'.$setting->favicon_path)): ?>
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo e(asset('uploads/setting/'.$setting->favicon_path)); ?>" type="image/x-icon">
        <?php endif; ?>
        <?php endif; ?>

        <?php if(empty($setting)): ?>
        <!-- App Title -->
        <title><?php echo $__env->yieldContent('title'); ?></title>
        <?php endif; ?>

        <!-- fontawesome icon -->
        <link rel="stylesheet" href="<?php echo e(asset('dashboard/fonts/fontawesome/css/fontawesome-all.min.css')); ?>">
        <!-- data tables css -->
        <link rel="stylesheet" href="<?php echo e(asset('dashboard/plugins/data-tables/css/datatables.min.css')); ?>">
        <!-- material datetimepicker css -->
        <link rel="stylesheet" href="<?php echo e(asset('dashboard/plugins/material-datetimepicker/css/bootstrap-material-datetimepicker.css')); ?>">
        <!-- toastr css -->
        <link rel="stylesheet" href="<?php echo e(asset('dashboard/plugins/toastr/css/toastr.min.css')); ?>">

        
        <!-- page css -->
        <?php echo $__env->yieldContent('page_css'); ?>


        <!-- vendor css -->
        <link rel="stylesheet" href="<?php echo e(asset('dashboard/css/style.css')); ?>">

        <?php 
        $version = App\Models\Language::version(); 
        ?>
        <?php if($version->direction == 1): ?>
        <!-- RTL css -->
        <link rel="stylesheet" class="rtl-css" href="<?php echo e(asset('dashboard/css/layouts/rtl.css')); ?>">
        <?php endif; ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/layouts/common/header_script.blade.php ENDPATH**/ ?>