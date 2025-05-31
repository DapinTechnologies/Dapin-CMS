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
                                <div class="form-group col-md-2">
                                    <label for="purpose"><?php echo e(__('field_purpose')); ?></label>
                                    <select class="form-control" name="purpose" id="purpose">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $purposes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purpose): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($purpose->id); ?>" <?php if($selected_purpose == $purpose->id): ?> selected <?php endif; ?>><?php echo e($purpose->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_purpose')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="department"><?php echo e(__('field_department')); ?></label>
                                    <select class="form-control" name="department" id="department">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($department->id); ?>" <?php if($selected_department == $department->id): ?> selected <?php endif; ?>><?php echo e($department->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_department')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="token"><?php echo e(__('field_token')); ?></label>
                                    <input type="text" class="form-control" name="token" id="token" value="<?php echo e($selected_token); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_token')); ?>

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
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <th><?php echo e(__('field_purpose')); ?></th>
                                        <th><?php echo e(__('field_department')); ?></th>
                                        <th><?php echo e(__('field_token')); ?></th>
                                        <th><?php echo e(__('field_date')); ?></th>
                                        <th><?php echo e(__('field_in_time')); ?></th>
                                        <th><?php echo e(__('field_out_time')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($row->name); ?></td>
                                        <td><?php echo e($row->purpose->title ?? ''); ?></td>
                                        <td><?php echo e($row->department->title ?? ''); ?></td>
                                        <td><?php echo e($print->prefix ?? ''); ?><?php echo e($row->token); ?></td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-pill badge-success">
                                            <?php if(isset($setting->time_format)): ?>
                                            <?php echo e(date($setting->time_format, strtotime($row->in_time))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("h:i A", strtotime($row->in_time))); ?>

                                            <?php endif; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if(isset($row->out_time)): ?>
                                            <span class="badge badge-pill badge-danger">
                                            <?php if(isset($setting->time_format)): ?>
                                            <?php echo e(date($setting->time_format, strtotime($row->out_time))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("h:i A", strtotime($row->out_time))); ?>

                                            <?php endif; ?>
                                            </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(empty($row->out_time)): ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-print')): ?>
                                            <?php if(isset($print)): ?>
                                            <a href="#" class="btn btn-dark btn-sm" onclick="PopupWin('<?php echo e(route($route.'.token.print', $row->id)); ?>', '<?php echo e($title); ?>', 800, 500);">
                                                <i class="fas fa-print"></i> <?php echo e(__('field_token')); ?>

                                            </a>
                                            <?php endif; ?>
                                            <?php endif; ?>

                                            <button type="button" class="btn btn-icon btn-secondary btn-sm" title="Visitor Exit" data-bs-toggle="modal" data-bs-target="#confirmModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </button>
                                            <!-- Include Confirm modal -->
                                            <?php echo $__env->make($view.'.confirm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <br/>
                                            <?php endif; ?>

                                            <button type="button" class="btn btn-icon btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#showModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <!-- Include Show modal -->
                                            <?php echo $__env->make($view.'.show', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                            <?php if(is_file('uploads/'.$path.'/'.$row->attach)): ?>
                                            <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->attach)); ?>" class="btn btn-icon btn-dark btn-sm" download><i class="fas fa-download"></i></a>
                                            <?php endif; ?>

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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home7/httpurba/public_html/college/resources/views/admin/visitor/index.blade.php ENDPATH**/ ?>