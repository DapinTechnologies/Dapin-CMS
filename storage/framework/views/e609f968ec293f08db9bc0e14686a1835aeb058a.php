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
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.quick.assign.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-6">
                            <label for="student"><?php echo e(__('field_student_id')); ?> <span>*</span></label>
                            <select class="form-control select2" name="student" id="student" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($student->id); ?>" <?php if(old('student') == $student->id): ?> selected <?php endif; ?>><?php echo e($student->student->student_id ?? ''); ?> - <?php echo e($student->student->first_name ?? ''); ?> <?php echo e($student->student->last_name ?? ''); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_student_id')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="category"><?php echo e(__('field_fees_type')); ?> <span>*</span></label>
                            <select class="form-control" name="category" id="category" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php if(old('category') == $category->id): ?> selected <?php endif; ?>><?php echo e($category->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_fees_type')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="assign_date" class="form-label"><?php echo e(__('field_assign')); ?> <?php echo e(__('field_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control" name="assign_date" id="assign_date" value="<?php echo e(date('Y-m-d')); ?>" readonly required>

                            <div class="invalid-feedback">
                                <?php echo e(__('required_field')); ?> <?php echo e(__('field_assign')); ?> <?php echo e(__('field_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="due_date" class="form-label"><?php echo e(__('field_due_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="due_date" id="due_date" value="<?php echo e(date('Y-m-d')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_due_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="amount" class="form-label"><?php echo e(__('field_amount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="amount" id="amount" value="<?php echo e(old('amount')); ?>" required>

                            <div class="invalid-feedback">
                                <?php echo e(__('required_field')); ?> <?php echo e(__('field_amount')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label><?php echo e(__('field_amount_type')); ?></label><br/>
                            <div class="radio d-inline">
                                <input type="radio" name="type" id="type_fixed" value="1" <?php if( old('type') == null ): ?> checked <?php elseif( old('type') == 1 ): ?>  checked <?php endif; ?>>
                                <label for="type_fixed" class="cr"><?php echo e(__('amount_type_fixed')); ?></label>
                            </div>
                            <div class="radio d-inline">
                                <input type="radio" name="type" id="type_per_credit" value="2" <?php if( old('type') == 2 ): ?> checked <?php endif; ?>>
                                <label for="type_per_credit" class="cr"><?php echo e(__('amount_type_per_credit')); ?></label>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\fees-student\quick-assign.blade.php ENDPATH**/ ?>