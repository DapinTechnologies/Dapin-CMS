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
                        <h5><?php echo e(__('modal_edit')); ?> <?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                        <a href="<?php echo e(route($route.'.edit', $row->id)); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.update', [$row->id])); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-4">
                            <label for="title" class="form-label"><?php echo e(__('field_title')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="<?php echo e($row->title); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="code"><?php echo e(__('field_code')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="code" id="code" value="<?php echo e($row->code); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_code')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="credit_hour"><?php echo e(__('field_credit_hour')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="credit_hour" id="credit_hour" value="<?php echo e($row->credit_hour); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_credit_hour')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="subject_type"><?php echo e(__('field_subject_type')); ?> <span>*</span></label>
                            <select class="form-control" name="subject_type" id="subject_type" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <option value="1" <?php if( $row->subject_type == 1 ): ?> selected <?php endif; ?>><?php echo e(__('subject_type_compulsory')); ?></option>
                                <option value="0" <?php if( $row->subject_type == 0 ): ?> selected <?php endif; ?>><?php echo e(__('subject_type_optional')); ?></option>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_subject_type')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="class_type"><?php echo e(__('field_class_type')); ?> <span>*</span></label>
                            <select class="form-control" name="class_type" id="class_type" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <option value="1" <?php if( $row->class_type == 1 ): ?> selected <?php endif; ?>><?php echo e(__('class_type_theory')); ?></option>
                                <option value="2" <?php if( $row->class_type == 2 ): ?> selected <?php endif; ?>><?php echo e(__('class_type_practical')); ?></option>
                                <option value="3" <?php if( $row->class_type == 3 ): ?> selected <?php endif; ?>><?php echo e(__('class_type_both')); ?></option>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_class_type')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="status" class="form-label"><?php echo e(__('select_status')); ?></label>
                            <select class="form-control" name="status" id="status">
                                <option value="1" <?php if( $row->status == 1 ): ?> selected <?php endif; ?>><?php echo e(__('status_active')); ?></option>
                                <option value="0" <?php if( $row->status == 0 ): ?> selected <?php endif; ?>><?php echo e(__('status_inactive')); ?></option>
                            </select>
                        </div>

                        <?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group col-md-6 col-lg-4 p-15">
                            <span class="badge badge-primary"><?php echo e($faculty->title); ?></span><br/>

                            <?php $__currentLoopData = $faculty->programs->where('status', 1)->sortBy('title'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <br/>
                            <div class="checkbox d-inline">
                                <input type="checkbox" name="programs[]" id="program-<?php echo e($key); ?>-<?php echo e($index); ?>" value="<?php echo e($program->id); ?>" 
                                <?php $__currentLoopData = $row->programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $selected_program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($selected_program->id == $program->id): ?> checked <?php endif; ?> 
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>>
                                <label for="program-<?php echo e($key); ?>-<?php echo e($index); ?>" class="cr"><?php echo e($program->title); ?></label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_program')); ?>

                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <!-- Form End -->
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/subject/edit.blade.php ENDPATH**/ ?>