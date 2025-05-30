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
                                <label for="start_day" class="form-label"><?php echo e(__('field_from')); ?> <?php echo e(__('field_day')); ?> <span>* (<?php echo e(__('field_after_due_date')); ?>)</span></label>
                                <input type="text" class="form-control" name="start_day" id="start_day" value="<?php echo e(old('start_day')); ?>" required data-v-max="999999999" data-v-min="0">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_from')); ?> <?php echo e(__('field_day')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="end_day" class="form-label"><?php echo e(__('field_to')); ?> <?php echo e(__('field_day')); ?> <span>* (<?php echo e(__('field_after_due_date')); ?>)</span></label>
                                <input type="text" class="form-control" name="end_day" id="end_day" value="<?php echo e(old('end_day')); ?>" required data-v-max="999999999" data-v-min="0">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_to')); ?> <?php echo e(__('field_day')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="amount" class="form-label"><?php echo e(__('field_amount')); ?> (<?php echo $setting->currency_symbol; ?> / %) <span>*</span></label>
                                <input type="text" class="form-control autonumber" name="amount" id="amount" value="<?php echo e(old('amount')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_amount')); ?>

                                </div>
                            </div>

                            <div class="form-group d-inline">
                                <div class="radio d-inline">
                                    <input type="radio" name="type" id="type_fixed" value="1" <?php if( old('type') == null ): ?> checked <?php elseif( old('type') == 1 ): ?>  checked <?php endif; ?>>
                                    <label for="type_fixed" class="cr"><?php echo e(__('amount_type_fixed')); ?></label>
                                </div>
                            </div>
                            <div class="form-group d-inline">
                                <div class="radio d-inline">
                                    <input type="radio" name="type" id="type_percentage" value="2" <?php if( old('type') == 2 ): ?> checked <?php endif; ?>>
                                    <label for="type_percentage" class="cr"><?php echo e(__('amount_type_percentage')); ?></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <br/>
                                <label for="categories" class="form-label"><?php echo e(__('field_fees_type')); ?> <span>* (<?php echo e(__('select_multiple')); ?>)</span></label>
                                <select class="form-control select2" name="categories[]" id="categories" multiple required>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_fees_type')); ?>

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
                                        <th><?php echo e(__('field_from')); ?> <?php echo e(__('field_day')); ?></th>
                                        <th><?php echo e(__('field_to')); ?> <?php echo e(__('field_day')); ?></th>
                                        <th><?php echo e(__('field_amount')); ?></th>
                                        <th><?php echo e(__('field_fees_type')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e(__('field_day')); ?> <?php echo e($row->start_day); ?></td>
                                        <td><?php echo e(__('field_day')); ?> <?php echo e($row->end_day); ?></td>
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
                                            <?php if( $row->status == 1 ): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('status_active')); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(__('status_inactive')); ?></span>
                                            <?php endif; ?>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\fees-fine\index.blade.php ENDPATH**/ ?>