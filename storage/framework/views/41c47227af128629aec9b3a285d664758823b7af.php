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
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-create')): ?>
                        <a href="<?php echo e(route($route.'.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> <?php echo e(__('btn_add_new')); ?></a>
                        <?php endif; ?>

                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="call_type"><?php echo e(__('field_call_type')); ?></label>
                                    <select class="form-control" name="call_type" id="call_type">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <option value="1" <?php if( $selected_call_type == 1 ): ?> selected <?php endif; ?>><?php echo e(__('call_type_incoming')); ?></option>
                                        <option value="2" <?php if( $selected_call_type == 2 ): ?> selected <?php endif; ?>><?php echo e(__('call_type_outgoing')); ?></option>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_call_type')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="phone"><?php echo e(__('field_phone')); ?></label>
                                    <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e($selected_phone); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_phone')); ?>

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
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_filter')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_call_type')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <th><?php echo e(__('field_phone')); ?></th>
                                        <th><?php echo e(__('field_purpose')); ?></th>
                                        <th><?php echo e(__('field_date')); ?></th>
                                        <th><?php echo e(__('field_next_follow_up_date')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td>
                                            <?php if( $row->call_type == 1 ): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('call_type_incoming')); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(__('call_type_outgoing')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->name); ?></td>
                                        <td><?php echo e($row->phone); ?></td>
                                        <td><?php echo str_limit($row->purpose, 30, ' ...'); ?></td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(isset($row->follow_up_date)): ?>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->follow_up_date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->follow_up_date))); ?>

                                            <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#showModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <!-- Include Show modal -->
                                            <?php echo $__env->make($view.'.show', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-edit')): ?>
                                            <a href="<?php echo e(route($route.'.edit', $row->id)); ?>" class="btn btn-icon btn-primary btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
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
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home7/httpurba/public_html/college/resources/views/admin/phone-log/index.blade.php ENDPATH**/ ?>