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
                                <div class="form-group col-md-3">
                                    <label for="department"><?php echo e(__('field_department')); ?></label>
                                    <select class="form-control" name="department" id="department">
                                        <option value="0"><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($department->id); ?>" <?php if( $selected_department == $department->id): ?> selected <?php endif; ?>><?php echo e($department->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_department')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="designation"><?php echo e(__('field_designation')); ?></label>
                                    <select class="form-control" name="designation" id="designation">
                                        <option value="0"><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($designation->id); ?>" <?php if( $selected_designation == $designation->id): ?> selected <?php endif; ?>><?php echo e($designation->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_designation')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="staff_id"><?php echo e(__('field_staff_id')); ?></label>
                                    <input type="text" class="form-control" name="staff_id" id="staff_id" value="<?php echo e($selected_staff_id); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_staff_id')); ?>

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
                                        <th><?php echo e(__('field_staff_id')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <th><?php echo e(__('field_gender')); ?></th>
                                        <th><?php echo e(__('field_department')); ?></th>
                                        <th><?php echo e(__('field_designation')); ?></th>
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
                                            <a href="<?php echo e(route('admin.user.show', $row->id)); ?>">
                                                #<?php echo e($row->staff_id); ?>

                                            </a>
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
                                        <td><?php echo e($row->department->title ?? ''); ?></td>
                                        <td><?php echo e($row->designation->title ?? ''); ?></td>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\transport-staff\index.blade.php ENDPATH**/ ?>