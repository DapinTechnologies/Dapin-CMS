<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">
                                <?php echo $__env->make('common.inc.student_search_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-3">
                                    <label for="student_id"><?php echo e(__('field_student_id')); ?></label>
                                    <input type="text" class="form-control" name="student_id" id="student_id" value="<?php echo e($selected_student_id); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_student_id')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?></button>
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
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_route')); ?></th>
                                        <th><?php echo e(__('field_vehicle')); ?></th>
                                        <th><?php echo e(__('field_student_id')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <th><?php echo e(__('field_gender')); ?></th>
                                        <th><?php echo e(__('field_batch')); ?></th>
                                        <th><?php echo e(__('field_program')); ?></th>
                                        <th><?php echo e(__('field_phone')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($row->transport->transportRoute->title ?? ''); ?></td>
                                        <td><?php echo e($row->transport->transportVehicle->number ?? ''); ?></td>
                                        <td>
                                            <?php if(isset($row->student_id)): ?>
                                            <a href="<?php echo e(route('admin.student.show', $row->id)); ?>">
                                            #<?php echo e($row->student_id ?? ''); ?>

                                            </a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></td>
                                        <td>
                                            <?php if( $row->gender == 1 ): ?>
                                            <?php echo e(__('gender_male')); ?>

                                            <?php elseif( $row->gender == 2 ): ?>
                                            <?php echo e(__('gender_female')); ?>

                                            <?php elseif( $row->gender == 3 ): ?>
                                            <?php echo e(__('gender_other')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->batch->title ?? ''); ?></td>
                                        <td><?php echo e($row->program->shortcode ?? ''); ?></td>
                                        <td><?php echo e($row->phone); ?></td>
                                        <td>
                                            <?php if(isset($row->transport)): ?>
                                            <?php if( $row->transport->status == 1 ): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('status_active')); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(__('status_canceled')); ?></span>
                                            <?php endif; ?>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-primary"><?php echo e(__('status_pending')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-create')): ?>
                                        <?php if(isset($row->transport)): ?>
                                        <?php if($row->transport->status == 1): ?>
                                            <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal-<?php echo e($row->id); ?>"><i class="fas fa-times"></i></button>
                                            <?php echo $__env->make($view.'.cancel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#addModal-<?php echo e($row->id); ?>"><i class="fas fa-plus"></i></button>
                                            <?php echo $__env->make($view.'.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endif; ?>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#addModal-<?php echo e($row->id); ?>"><i class="fas fa-plus"></i></button>
                                            <?php echo $__env->make($view.'.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\transport-student\index.blade.php ENDPATH**/ ?>