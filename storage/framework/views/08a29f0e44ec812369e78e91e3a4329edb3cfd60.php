<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    
     <title><?php echo e($title); ?></title>
     <?php echo $__env->make('admin.layouts.common.header_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</head>

<body>


    <!-- [ Main Content ] start -->
    <div class="container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    
                    <!-- Start Content-->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row justify-content-center mt-5">
                                <div class="col-lg-6 col-md-8">
                                <form class="needs-validation" novalidate action="<?php echo e(route('verify-purchase')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?php echo e($title); ?></h5>
                                        </div>
                                        <div class="card-block">
                                            <!-- Form Start -->
                                            <div class="form-group">
                                                <label for="purchase_code" class="form-label"><?php echo e(__('Purchase Code')); ?> <span>*</span></label>
                                                <input type="text" class="form-control" name="purchase_code" id="purchase_code" value="<?php echo e(old('purchase_code')); ?>" required>

                                                <div class="invalid-feedback">
                                                  <?php echo e(__('required_field')); ?> <?php echo e(__('Purchase Code')); ?>

                                                </div>
                                            </div>
                                            <!-- Form End -->
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                                        </div>
                                    </div>
                                </form>
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


    <?php echo $__env->make('admin.layouts.common.footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/verify.blade.php ENDPATH**/ ?>