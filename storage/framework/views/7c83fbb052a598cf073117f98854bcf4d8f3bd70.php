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
                            <label for="type"><?php echo e(__('field_type')); ?> <span>*</span></label>
                            <select class="form-control" name="type" id="type" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type->id); ?>" <?php if(old('type') == $type->id): ?> selected <?php endif; ?>><?php echo e($type->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_type')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="user"><?php echo e(__('field_assigned')); ?></label>
                            <select class="form-control select2" name="user" id="user">
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>" <?php if(old('user') == $user->id): ?> selected <?php endif; ?>><?php echo e($user->staff_id); ?> - <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_assigned')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name"><?php echo e(__('field_name')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="<?php echo e(old('name')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_name')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="father_name"><?php echo e(__('field_father_name')); ?></label>
                            <input type="text" class="form-control" name="father_name" id="father_name" value="<?php echo e(old('father_name')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_father_name')); ?>

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
                            <label for="purpose"><?php echo e(__('field_purpose')); ?></label>
                            <input type="text" class="form-control" name="purpose" id="purpose" value="<?php echo e(old('purpose')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_purpose')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="persons"><?php echo e(__('field_persons')); ?> <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="persons" id="persons" value="<?php echo e(old('persons') != null ? old('persons') : '1'); ?>" required data-v-max="9999" data-v-min="0">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_persons')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="date"><?php echo e(__('field_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="date" id="date" value="<?php echo e(date('Y-m-d')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="in_time"><?php echo e(__('field_in_time')); ?> <span>*</span></label>
                            <input type="time" class="form-control time" name="in_time" id="in_time" value="<?php echo e(old('in_time')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_in_time')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="out_time"><?php echo e(__('field_out_time')); ?></label>
                            <input type="time" class="form-control time" name="out_time" id="out_time" value="<?php echo e(old('out_time')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_out_time')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="id_no"><?php echo e(__('field_id_no')); ?></label>
                            <input type="text" class="form-control" name="id_no" id="id_no" value="<?php echo e(old('id_no')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_id_no')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="attach"><?php echo e(__('field_attach')); ?></label>
                            <input type="file" class="form-control" name="attach" id="attach" value="<?php echo e(old('attach')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_attach')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="note"><?php echo e(__('field_note')); ?></label>
                            <textarea  class="form-control" name="note" id="note"><?php echo e(old('note')); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_note')); ?>

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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\meeting\create.blade.php ENDPATH**/ ?>