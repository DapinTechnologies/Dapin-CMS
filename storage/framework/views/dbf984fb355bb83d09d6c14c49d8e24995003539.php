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
                        <h5><?php echo e(__('modal_add')); ?> / <?php echo e(__('modal_edit')); ?> <?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.create')); ?>">
                            <div class="row gx-2">
                                <?php echo $__env->make('common.inc.common_search_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-3">
                                    <label for="type"><?php echo e(__('field_type')); ?> <span>*</span></label>
                                    <select class="form-control" name="type" id="type" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->id); ?>" <?php if( $selected_type == $type->id): ?> selected <?php endif; ?>><?php echo e($type->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                    <?php echo e(__('required_field')); ?> <?php echo e(__('field_type')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_filter')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <?php if(isset($rows)): ?>
                    <div class="card-block">
                        
                        <?php if(isset($rows)): ?>
                        <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <form class="needs-validation mt-5" novalidate action="<?php echo e(route($route.'.update', $row->id)); ?>" method="post" id="fields" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                            <div class="row">

                                <?php echo $__env->make('admin.exam-routine.form_edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <input type="text" name="program" value="<?php echo e($selected_program); ?>" hidden>
                                <input type="text" name="session" value="<?php echo e($selected_session); ?>" hidden>
                                <input type="text" name="semester" value="<?php echo e($selected_semester); ?>" hidden>
                                <input type="text" name="section" value="<?php echo e($selected_section); ?>" hidden>
                                <input type="text" name="type" value="<?php echo e($selected_type); ?>" hidden>

                                <div class="form-group col-6 col-md-3">
                                    <button type="submit" class="btn btn-success btn-filter"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                                </div>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-delete')): ?>
                                <div class="form-group col-6 col-md-3">
                                    <button type="button" class="btn btn-danger btn-filter" data-bs-toggle="modal" data-bs-target="#deleteModal-<?php echo e($row->id); ?>">
                                        <i class="fas fa-trash-alt"></i> <?php echo e(__('btn_remove')); ?>

                                    </button>
                                </div>
                                <?php endif; ?>

                            </div>
                        </form>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-delete')): ?>
                        <!-- Include Delete modal -->
                        <?php echo $__env->make('admin.layouts.inc.delete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                        <form action="<?php echo e(route($route.'.store')); ?>" class="needs-validation mt-5 btn-submit" novalidate method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            
                            <?php echo $__env->make('admin.exam-routine.form_field', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            <input type="text" name="program" value="<?php echo e($selected_program); ?>" hidden>
                            <input type="text" name="session" value="<?php echo e($selected_session); ?>" hidden>
                            <input type="text" name="semester" value="<?php echo e($selected_semester); ?>" hidden>
                            <input type="text" name="section" value="<?php echo e($selected_section); ?>" hidden>
                            <input type="text" name="type" value="<?php echo e($selected_type); ?>" hidden>

                            <div class="form-group col-md-3">
                                <button type="submit" class="btn btn-success btn-filter"><i class="fas fa-check"></i> <?php echo e(__('btn_save')); ?></button>
                            </div>
                        </div>
                        </form>
                   </div>
                   <?php endif; ?>
                </div>
                
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\exam-routine\create.blade.php ENDPATH**/ ?>