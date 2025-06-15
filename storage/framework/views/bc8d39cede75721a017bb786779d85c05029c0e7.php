<?php $__env->startSection('title', 'Dapin SMS Setup'); ?>
<?php $__env->startSection('content'); ?>

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-md-12 col-lg-10">
                <form class="needs-validation" novalidate action="<?php echo e(route('sms.store')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Dapin SMS API Configuration')); ?></h5>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <input name="id" type="hidden" value="<?php echo e($smsConfig->id ?? -1); ?>">

                                <div class="container">
                                    <div class="form-group">
                                        <label for="sms_api_url"><?php echo e(__('SMS API URL')); ?> <span>*</span></label>
                                        <input type="text" class="form-control" name="sms_api_url" id="sms_api_url" 
                                               value="<?php echo e($smsConfig->api_url ?? 'https://smsportal.dapintechnologies.com/sms/v3/sendmultiple'); ?>" required>
                                        <div class="invalid-feedback">
                                            <?php echo e(__('required_field')); ?> <?php echo e(__('SMS API URL')); ?>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sms_api_key"><?php echo e(__('SMS API Key')); ?> <span>*</span></label>
                                        <input type="text" class="form-control" name="sms_api_key" id="sms_api_key" 
                                               value="<?php echo e($smsConfig->api_key ?? '9v4CNdzEQOyehbr3P2ns5ltwfTVYRiSp0cI6uo1DZG8jBFqMm7xWXaLkUAKgHJ'); ?>" required>
                                        <div class="invalid-feedback">
                                            <?php echo e(__('required_field')); ?> <?php echo e(__('SMS API Key')); ?>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sms_service_id"><?php echo e(__('SMS Service ID')); ?> <span>*</span></label>
                                        <input type="text" class="form-control" name="sms_service_id" id="sms_service_id" 
                                               value="<?php echo e($smsConfig->sms_service_id ?? '0'); ?>" required>
                                        <div class="invalid-feedback">
                                            <?php echo e(__('required_field')); ?> <?php echo e(__('SMS Service ID')); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('Save')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/sms-setting/index.blade.php ENDPATH**/ ?>