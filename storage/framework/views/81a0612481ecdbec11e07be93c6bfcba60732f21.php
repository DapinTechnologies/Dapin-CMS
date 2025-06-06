<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(__('modal_add')); ?> <?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                        <a href="<?php echo e(route($route.'.create')); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-4">
                            <label for="title" class="form-label"><?php echo e(__('field_supplier')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="<?php echo e(old('title')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_supplier')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="phone"><?php echo e(__('field_phone')); ?></label>
                            <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e(old('phone')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_phone')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="email"><?php echo e(__('field_email')); ?></label>
                            <input type="email" class="form-control" name="email" id="email" value="<?php echo e(old('email')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_email')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="address"><?php echo e(__('field_address')); ?></label>
                            <input type="text" class="form-control" name="address" id="address" value="<?php echo e(old('address')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_address')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="contact_person" class="form-label"><?php echo e(__('field_contact_person')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="contact_person" id="contact_person" value="<?php echo e(old('contact_person')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_contact_person')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="designation" class="form-label"><?php echo e(__('field_designation')); ?></label>
                            <input type="text" class="form-control" name="designation" id="designation" value="<?php echo e(old('designation')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_designation')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="contact_person_phone"><?php echo e(__('field_contact_person')); ?> <?php echo e(__('field_phone')); ?></label>
                            <input type="text" class="form-control" name="contact_person_phone" id="contact_person_phone" value="<?php echo e(old('contact_person_phone')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_contact_person')); ?> <?php echo e(__('field_phone')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="contact_person_email"><?php echo e(__('field_contact_person')); ?> <?php echo e(__('field_email')); ?></label>
                            <input type="email" class="form-control" name="contact_person_email" id="contact_person_email" value="<?php echo e(old('contact_person_email')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_contact_person')); ?> <?php echo e(__('field_email')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="description" class="form-label"><?php echo e(__('field_description')); ?></label>
                            <textarea class="form-control" name="description" id="description"><?php echo e(old('description')); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_description')); ?>

                            </div>
                        </div>
                        <!-- Form End -->
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_save')); ?></button>
                    </div>
                    </form>
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\item-supplier\create.blade.php ENDPATH**/ ?>