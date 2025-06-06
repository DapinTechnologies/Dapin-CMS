<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-create')): ?>
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('btn_create')); ?> <?php echo e($title); ?></h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="name"><?php echo e(__('field_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="<?php echo e(old('name')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_name')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="code"><?php echo e(__('field_code')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="code" id="code" value="<?php echo e(old('code')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_code')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="direction"><?php echo e(__('field_direction')); ?> <span>*</span></label>
                                <select class="form-control" name="direction" id="direction" required>
                                    <option value="0" <?php if(old('direction') == 0): ?> selected <?php endif; ?>><?php echo e(__('direction_ltr')); ?></option>
                                    <option value="1" <?php if(old('direction') == 1): ?> selected <?php endif; ?>><?php echo e(__('direction_rtl')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_direction')); ?>

                                </div>
                            </div>
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_save')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
            <?php endif; ?>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?> <?php echo e(__('list')); ?></h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_title')); ?></th>
                                        <th><?php echo e(__('field_code')); ?></th>
                                        <th><?php echo e(__('field_direction')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($row->name); ?></td>
                                        <td><?php echo e($row->code); ?></td>
                                        <td>
                                            <?php if($row->direction == 0): ?>
                                            <?php echo e(__('direction_ltr')); ?>

                                            <?php elseif($row->direction == 1): ?>
                                            <?php echo e(__('direction_rtl')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if( $row->default == 1 ): ?>
                                            <span class="btn btn-primary btn-sm"><?php echo e(__('status_default')); ?></span>
                                            <?php else: ?>
                                            <a href="<?php echo e(route($route.'.default', $row->id)); ?>" class="btn btn-secondary btn-sm"><?php echo e(__('status_not_default')); ?></a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-edit')): ?>
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo e($row->id); ?>">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <!-- Include Edit modal -->
                                            <?php echo $__env->make($view.'.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endif; ?>

                                            <?php if( $row->id != 1 && $row->default != 1 ): ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-delete')): ?>
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            <?php echo $__env->make('admin.layouts.inc.delete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\language\index.blade.php ENDPATH**/ ?>