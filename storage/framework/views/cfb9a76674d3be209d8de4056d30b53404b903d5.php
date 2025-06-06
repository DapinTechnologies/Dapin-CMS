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
                                    <label for="type"><?php echo e(__('field_type')); ?></label>
                                    <select class="form-control" name="type" id="type">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <option value="1" <?php if( $selected_type == 1 ): ?> selected <?php endif; ?>><?php echo e(__('exchange_type_import')); ?></option>
                                        <option value="2" <?php if( $selected_type == 2 ): ?> selected <?php endif; ?>><?php echo e(__('exchange_type_export')); ?></option>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_type')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="category"><?php echo e(__('field_category')); ?></label>
                                    <select class="form-control" name="category" id="category">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php if($selected_category == $category->id): ?> selected <?php endif; ?>><?php echo e($category->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_category')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="status"><?php echo e(__('field_status')); ?></label>
                                    <select class="form-control" name="status" id="status">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <option value="1" <?php if( $selected_status == 1 ): ?> selected <?php endif; ?>><?php echo e(__('status_on_hold')); ?></option>
                                        <option value="2" <?php if( $selected_status == 2 ): ?> selected <?php endif; ?>><?php echo e(__('status_progress')); ?></option>
                                        <option value="3" <?php if( $selected_status == 3 ): ?> selected <?php endif; ?>><?php echo e(__('status_received')); ?></option>
                                        <option value="4" <?php if( $selected_status == 4 ): ?> selected <?php endif; ?>><?php echo e(__('status_delivered')); ?></option>
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
                                        <th><?php echo e(__('field_type')); ?></th>
                                        <th><?php echo e(__('field_title')); ?></th>
                                        <th><?php echo e(__('field_category')); ?></th>
                                        <th><?php echo e(__('field_reference')); ?></th>
                                        <th><?php echo e(__('field_date')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td>
                                            <?php if( $row->type == 1 ): ?>
                                            <span class="badge badge-success"><i class="fas fa-download"></i></span> 
                                            <?php echo e(__('exchange_type_import')); ?>

                                            <?php elseif( $row->type == 2 ): ?>
                                            <span class="badge badge-danger"><i class="fas fa-upload"></i></span> 
                                            <?php echo e(__('exchange_type_export')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo str_limit($row->title, 50, ' ...'); ?></td>
                                        <td><?php echo e($row->category->title ?? ''); ?></td>
                                        <td><?php echo str_limit($row->reference, 30, ' ...'); ?></td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if( $row->status == 1 ): ?>
                                            <span class="badge badge-pill badge-primary"><?php echo e(__('status_on_hold')); ?></span>
                                            <?php elseif( $row->status == 2 ): ?>
                                            <span class="badge badge-pill badge-info"><?php echo e(__('status_progress')); ?></span>
                                            <?php elseif( $row->status == 3 ): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('status_received')); ?></span>
                                            <?php elseif( $row->status == 4 ): ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(__('status_delivered')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="dropdown show d-inline-block">
                                                <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button" id="statusMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-question"></i>
                                                </a>

                                                <div class="dropdown-menu" aria-labelledby="statusMenuLink">
                                                    <a class="dropdown-item" href="#" onclick="document.getElementById('status_on_hold_<?php echo e($row->id); ?>').submit();"><?php echo e(__('status_on_hold')); ?></a>
                                                    <a class="dropdown-item" href="#" onclick="document.getElementById('status_progress_<?php echo e($row->id); ?>').submit();"><?php echo e(__('status_progress')); ?></a>
                                                    <a class="dropdown-item" href="#" onclick="document.getElementById('status_received_<?php echo e($row->id); ?>').submit();"><?php echo e(__('status_received')); ?></a>
                                                    <a class="dropdown-item" href="#" onclick="document.getElementById('status_delivered_<?php echo e($row->id); ?>').submit();"><?php echo e(__('status_delivered')); ?></a>
                                                </div>

                                                <form action="<?php echo e(route($route.'.status', $row->id)); ?>" method="post" id="status_on_hold_<?php echo e($row->id); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="status" value="1">
                                                </form>
                                                <form action="<?php echo e(route($route.'.status', $row->id)); ?>" method="post" id="status_progress_<?php echo e($row->id); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="status" value="2">
                                                </form>
                                                <form action="<?php echo e(route($route.'.status', $row->id)); ?>" method="post" id="status_received_<?php echo e($row->id); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="status" value="3">
                                                </form>
                                                <form action="<?php echo e(route($route.'.status', $row->id)); ?>" method="post" id="status_delivered_<?php echo e($row->id); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="status" value="4">
                                                </form>
                                            </div>

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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\postal-exchange\index.blade.php ENDPATH**/ ?>