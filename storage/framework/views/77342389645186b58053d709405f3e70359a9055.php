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
                        <h5><?php echo e($title); ?> <?php echo e(__('list')); ?></h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-2">
                                    <label for="program"><?php echo e(__('field_program')); ?></label>
                                    <select class="form-control" name="program" id="program">
                                        <option value="0"><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($program->id); ?>" <?php if( $selected_program == $program->id): ?> selected <?php endif; ?>><?php echo e($program->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_program')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="status"><?php echo e(__('field_status')); ?></label>
                                    <select class="form-control" name="status" id="status">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <option value="1" <?php if( $selected_status == 1 ): ?> selected <?php endif; ?>><?php echo e(__('status_pending')); ?></option>
                                        <option value="2" <?php if( $selected_status == 2 ): ?> selected <?php endif; ?>><?php echo e(__('status_approved')); ?></option>
                                        <option value="0" <?php if( $selected_status == 0 ): ?> selected <?php endif; ?>><?php echo e(__('status_rejected')); ?></option>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_status')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="start_date"><?php echo e(__('field_from_date')); ?></label>
                                    <input type="date" class="form-control date" name="start_date" id="start_date" value="<?php echo e($selected_start_date); ?>" required>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_from_date')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="end_date"><?php echo e(__('field_to_date')); ?></label>
                                    <input type="date" class="form-control date" name="end_date" id="end_date" value="<?php echo e($selected_end_date); ?>" required>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_to_date')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="registration_no"><?php echo e(__('field_registration_no')); ?></label>
                                    <input type="text" class="form-control" name="registration_no" id="registration_no" value="<?php echo e($selected_registration_no); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_registration_no')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php if(isset($rows)): ?>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_registration_no')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <th><?php echo e(__('field_gender')); ?></th>
                                        <th><?php echo e(__('field_program')); ?></th>
                                        <th><?php echo e(__('field_apply_date')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td>
                                            <a href="<?php echo e(route($route.'.show', $row->id)); ?>">
                                            #<?php echo e($row->registration_no); ?>

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
                                        <td><?php echo e($row->program->title ?? ''); ?></td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->apply_date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->apply_date))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if( $row->status == 1 ): ?>
                                            <span class="badge badge-pill badge-primary"><?php echo e(__('status_pending')); ?></span>
                                            <?php elseif( $row->status == 2 ): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('status_approved')); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(__('status_rejected')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route($route.'.show', $row->id)); ?>" class="btn btn-icon btn-success btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <?php if( $row->status == 1 ): ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-create')): ?>
                                            <a href="<?php echo e(route($route.'.edit', $row->id)); ?>" class="btn btn-icon btn-primary btn-sm">
                                                <i class="fa-solid fa-right-from-bracket"></i>
                                            </a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-edit')): ?>
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" title="<?php echo e(__('status_rejected')); ?>" data-bs-toggle="modal" data-bs-target="#cancelModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <!-- Include Cancel modal -->
                                            <?php echo $__env->make($view.'.cancel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endif; ?>

                                            <?php elseif( $row->status == 0 ): ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-edit')): ?>
                                            <button type="button" class="btn btn-icon btn-success btn-sm" title="<?php echo e(__('status_pending')); ?>" data-bs-toggle="modal" data-bs-target="#cancelModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <!-- Include Cancel modal -->
                                            <?php echo $__env->make($view.'.cancel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-delete')): ?>
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            <?php echo $__env->make('admin.layouts.inc.delete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
            <?php endif; ?>
            
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\application\index.blade.php ENDPATH**/ ?>