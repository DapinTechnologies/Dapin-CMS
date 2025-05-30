<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-edit')): ?>
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="<?php echo e(route($route.'.update', $row->id)); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('btn_update')); ?> <?php echo e($title); ?></h5>
                        </div>
                        <div class="card-block">
                            <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                            <a href="<?php echo e(route($route.'.edit', $row->id)); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="title" class="form-label"><?php echo e(__('field_title')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="<?php echo e($row->title); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="start_date" class="form-label"><?php echo e(__('field_start_date')); ?> <span>*</span></label>
                                <input type="date" class="form-control date" name="start_date" id="start_date" value="<?php echo e($row->start_date); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_start_date')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="end_date" class="form-label"><?php echo e(__('field_end_date')); ?> <span>*</span></label>
                                <input type="date" class="form-control date" name="end_date" id="end_date" value="<?php echo e($row->end_date); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_end_date')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="amount" class="form-label"><?php echo e(__('field_amount')); ?> (<?php echo $setting->currency_symbol; ?> / %) <span>*</span></label>
                                <input type="text" class="form-control autonumber" name="amount" id="amount" value="<?php echo e(round($row->amount, 2)); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_amount')); ?>

                                </div>
                            </div>

                            <div class="form-group d-inline">
                                <div class="radio d-inline">
                                    <input type="radio" name="type" id="type_fixed-<?php echo e($row->id); ?>" value="1" <?php if( $row->type == 1 ): ?> checked <?php endif; ?>>
                                    <label for="type_fixed-<?php echo e($row->id); ?>" class="cr"><?php echo e(__('amount_type_fixed')); ?></label>
                                </div>
                            </div>
                            <div class="form-group d-inline">
                                <div class="radio d-inline">
                                    <input type="radio" name="type" id="type_percentage-<?php echo e($row->id); ?>" value="2" <?php if( $row->type == 2 ): ?> checked <?php endif; ?>>
                                    <label for="type_percentage-<?php echo e($row->id); ?>" class="cr"><?php echo e(__('amount_type_percentage')); ?></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <br/>
                                <label for="categories" class="form-label"><?php echo e(__('field_fees_type')); ?> <span>* (<?php echo e(__('select_multiple')); ?>)</span></label>
                                <select class="form-control select2" name="categories[]" id="categories" multiple required>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php $__currentLoopData = $row->feesCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $selected_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($selected_category->id == $category->id ? 'selected' : ''); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>><?php echo e($category->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <div class="invalid-feedback">
                                    <?php echo e(__('required_field')); ?> <?php echo e(__('field_fees_type')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <br/>
                                <label for="statuses" class="form-label"><?php echo e(__('field_student')); ?> <?php echo e(__('field_status')); ?> <span>* (<?php echo e(__('select_multiple')); ?>)</span></label>
                                <select class="form-control select2" name="statuses[]" id="statuses" multiple required>
                                    <?php $__currentLoopData = $statusTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($statusType->id); ?>" <?php $__currentLoopData = $row->statusTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $selected_status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($selected_status->id == $statusType->id ? 'selected' : ''); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>><?php echo e($statusType->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_student')); ?> <?php echo e(__('field_status')); ?>

                                </div>
                            </div>
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
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
                                        <th><?php echo e(__('field_date')); ?></th>
                                        <th><?php echo e(__('field_amount')); ?></th>
                                        <th><?php echo e(__('field_fees_type')); ?></th>
                                        <th><?php echo e(__('field_student')); ?> <?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($row->title); ?></td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->start_date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->start_date))); ?>

                                            <?php endif; ?>
                                            <br>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->end_date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->end_date))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                          <?php if(isset($setting->decimal_place)): ?>
                                          <?php echo e(number_format((float)$row->amount, $setting->decimal_place, '.', '')); ?> 
                                          <?php else: ?>
                                          <?php echo e(number_format((float)$row->amount, 2, '.', '')); ?> 
                                          <?php endif; ?>
                                          <?php if($row->type == 1): ?>
                                          <?php echo $setting->currency_symbol; ?>

                                          <?php elseif($row->type == 2): ?>
                                          %
                                          <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php $__currentLoopData = $row->feesCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge badge-primary"><?php echo e($category->title); ?></span><br>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td>
                                            <?php $__currentLoopData = $row->statusTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $statusType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge badge-primary"><?php echo e($statusType->title); ?></span><br>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\fees-discount\edit.blade.php ENDPATH**/ ?>