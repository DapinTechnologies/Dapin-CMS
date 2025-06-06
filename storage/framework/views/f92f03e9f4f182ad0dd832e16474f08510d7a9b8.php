<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('btn_update')); ?> <?php echo e($title); ?></h5>
                        </div>
                        <div class="card-block">
                          <div class="row">
                            <!-- Form Start -->
                            <input name="id" type="hidden" value="<?php echo e((isset($row->id))?$row->id:-1); ?>">

                            <div class="form-group col-md-6">
                                <label for="driver" class="form-label"><?php echo e(__('field_mail_driver')); ?> <span>*</span></label>
                                <select class="form-control" name="driver" id="driver" required>
                                    <option value="smtp" <?php if(isset($row->driver)): ?> <?php if($row->driver == 'smtp'): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e(__('SMTP')); ?></option>
                                    <option value="sendmail"<?php if(isset($row->driver)): ?>  <?php if($row->driver == 'sendmail'): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e(__('SendMail')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mail_driver')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="host" class="form-label"><?php echo e(__('field_mail_host')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="host" id="host" value="<?php echo e(isset($row->host)?$row->host:''); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mail_host')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="port" class="form-label"><?php echo e(__('field_mail_port')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="port" id="port" value="<?php echo e(isset($row->port)?$row->port:''); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mail_port')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="username" class="form-label"><?php echo e(__('field_mail_username')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="username" id="username" value="<?php echo e(isset($row->username)?$row->username:''); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mail_username')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="password" class="form-label"><?php echo e(__('field_mail_password')); ?> <span>*</span></label>
                                <input type="password" class="form-control" name="password" id="password" value="<?php echo e(isset($row->password)?$row->password:''); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mail_password')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="encryption" class="form-label"><?php echo e(__('field_mail_encryption')); ?> <span>*</span></label>

                                <select class="form-control" name="encryption" id="encryption" required>
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="ssl" <?php if(isset($row->encryption)): ?> <?php if($row->encryption == 'ssl'): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e(__('SSL')); ?></option>
                                    <option value="tls"<?php if(isset($row->encryption)): ?>  <?php if($row->encryption == 'tls'): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e(__('TLS')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mail_encryption')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="sender_email" class="form-label"><?php echo e(__('field_mail_sender_email')); ?> <span>*</span></label>
                                <input type="email" class="form-control" name="sender_email" id="sender_email" value="<?php echo e(isset($row->sender_email)?$row->sender_email:''); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mail_sender_email')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="sender_name" class="form-label"><?php echo e(__('field_mail_sender_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="sender_name" id="sender_name" value="<?php echo e(isset($row->sender_name)?$row->sender_name:''); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mail_sender_name')); ?>

                                </div>
                            </div>

                            
                            <!-- Form End -->
                          </div>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\mail-setting\index.blade.php ENDPATH**/ ?>