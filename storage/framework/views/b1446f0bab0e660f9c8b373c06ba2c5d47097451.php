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
                                <label for="title" class="form-label"><?php echo e(__('field_title')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="<?php echo e(old('title')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="year" class="form-label"><?php echo e(__('field_year')); ?> <span>*</span></label>
                                <select class="form-control" name="year" id="year" required>
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="1" <?php if( old('year') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('1st_year')); ?></option>
                                    <option value="2" <?php if( old('year') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('2nd_year')); ?></option>
                                    <option value="3" <?php if( old('year') == 3 ): ?> selected <?php endif; ?>><?php echo e(__('3rd_year')); ?></option>
                                    <option value="4" <?php if( old('year')== 4 ): ?> selected <?php endif; ?>><?php echo e(__('4th_year')); ?></option>
                                    <option value="5" <?php if( old('year') == 5 ): ?> selected <?php endif; ?>><?php echo e(__('5th_year')); ?></option>
                                    <option value="6" <?php if( old('year') == 6 ): ?> selected <?php endif; ?>><?php echo e(__('6th_year')); ?></option>
                                    <option value="7" <?php if( old('year') == 7 ): ?> selected <?php endif; ?>><?php echo e(__('7th_year')); ?></option>
                                    <option value="8" <?php if( old('year') == 8 ): ?> selected <?php endif; ?>><?php echo e(__('8th_year')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_year')); ?>

                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="program"><?php echo e(__('field_assign')); ?> <?php echo e(__('field_program')); ?> <span>*</span></label>

                                <div class="checkbox">
                                    <input type="checkbox" name="all_check" id="all_check" class="all_check" checked>
                                    <label for="all_check" class="cr"><?php echo e(__('all')); ?></label>
                                </div>

                                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <br/>
                                <div class="checkbox d-inline">
                                    <input type="checkbox" class="program" name="programs[]" id="program-<?php echo e($key); ?>" value="<?php echo e($program->id); ?>" checked>
                                    <label for="program-<?php echo e($key); ?>" class="cr"><?php echo e($program->title); ?></label>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <div class="invalid-feedback">
                                <?php echo e(__('required_field')); ?> <?php echo e(__('field_program')); ?>

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
                                        <th><?php echo e(__('field_year')); ?></th>
                                        <th><?php echo e(__('field_program')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($row->title); ?></td>
                                        <td>
                                            <?php if( $row->year == 1 ): ?>
                                            <?php echo e(__('1st_year')); ?>

                                            <?php elseif( $row->year == 2 ): ?>
                                            <?php echo e(__('2nd_year')); ?>

                                            <?php elseif( $row->year == 3 ): ?>
                                            <?php echo e(__('3rd_year')); ?>

                                            <?php elseif( $row->year == 4 ): ?>
                                            <?php echo e(__('4th_year')); ?>

                                            <?php elseif( $row->year == 5 ): ?>
                                            <?php echo e(__('5th_year')); ?>

                                            <?php elseif( $row->year == 6 ): ?>
                                            <?php echo e(__('6th_year')); ?>

                                            <?php elseif( $row->year == 7 ): ?>
                                            <?php echo e(__('7th_year')); ?>

                                            <?php elseif( $row->year == 8 ): ?>
                                            <?php echo e(__('8th_year')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php $__currentLoopData = $row->programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge badge-primary"><?php echo e($program->title); ?></span><br>
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
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo e($row->id); ?>">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <!-- Include Edit modal -->
                                            <?php echo $__env->make($view.'.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

<?php $__env->startSection('page_js'); ?>
<script type="text/javascript">
    "use strict";
    // checkbox all-check-button selector
    $(".all_check").on('click',function(e){
        if($(this).is(":checked")){
            // check all checkbox
            $(".program").prop('checked', true);
        }
        else if($(this).is(":not(:checked)")){
            // uncheck all checkbox
            $(".program").prop('checked', false);
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/semester/index.blade.php ENDPATH**/ ?>