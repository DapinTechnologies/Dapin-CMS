<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?> <?php echo e(__('list')); ?></h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="book"><?php echo e(__('field_book')); ?></label>
                                    <select class="form-control select2" name="book" id="book">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $search_books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($book->id); ?>" <?php if($selected_book == $book->id): ?> selected <?php endif; ?>><?php echo e($book->isbn); ?> | <?php echo e($book->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_book')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="member"><?php echo e(__('field_member')); ?></label>
                                    <select class="form-control select2" name="member" id="member">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($member->id); ?>" <?php if($selected_member == $member->id): ?> selected <?php endif; ?>><?php echo e($member->library_id); ?> | <?php echo e($member->memberable->first_name ?? ''); ?> <?php echo e($member->memberable->last_name ?? ''); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_member')); ?>

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
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_library_id')); ?></th>
                                        <th><?php echo e(__('field_member')); ?></th>
                                        <th><?php echo e(__('field_isbn')); ?></th>
                                        <th><?php echo e(__('field_phone')); ?></th>
                                        <th><?php echo e(__('field_issue_date')); ?></th>
                                        <th><?php echo e(__('field_due_return_date')); ?></th>
                                        <th><?php echo e(__('field_return_date')); ?></th>
                                        <th><?php echo e(__('field_penalty')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td>#<?php echo e($row->member->library_id ?? ''); ?></td>
                                        <td>
                                            <?php if($row->member->memberable_type == 'App\Models\Student'): ?>
                                            <?php echo e(__('field_student')); ?>

                                            <?php elseif($row->member->memberable_type == 'App\User'): ?>
                                            <?php echo e(__('field_staff')); ?>

                                            <?php elseif($row->member->memberable_type == 'App\Models\OutsideUser'): ?>
                                            <?php echo e(__('field_outsider')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->book->isbn ?? ''); ?></td>
                                        <td><?php echo e($row->member->memberable->phone ?? ''); ?></td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                                <?php echo e(date($setting->date_format, strtotime($row->issue_date))); ?>

                                            <?php else: ?>
                                                <?php echo e(date("Y-m-d", strtotime($row->issue_date))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                                <?php echo e(date($setting->date_format, strtotime($row->due_date))); ?>

                                            <?php else: ?>
                                                <?php echo e(date("Y-m-d", strtotime($row->due_date))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(!empty($row->return_date)): ?>
                                                <?php if(isset($setting->date_format)): ?>
                                                    <?php echo e(date($setting->date_format, strtotime($row->return_date))); ?>

                                                <?php else: ?>
                                                    <?php echo e(date("Y-m-d", strtotime($row->return_date))); ?>

                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(isset($row->penalty)): ?>
                                            <?php echo e(round($row->penalty, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if( $row->status == 0 ): ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(__('status_lost')); ?></span>

                                            <?php elseif( $row->status == 1 ): ?>
                                            <?php if($row->due_date < date("Y-m-d")): ?>
                                            <span class="badge badge-pill badge-warning"><?php echo e(__('status_delay')); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-primary"><?php echo e(__('status_issued')); ?></span>
                                            <?php endif; ?>

                                            <?php elseif( $row->status == 2 ): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('status_returned')); ?></span>
                                            <?php if($row->due_date < $row->return_date): ?>
                                            <span class="badge badge-pill badge-info"><?php echo e(__('status_delayed')); ?></span>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-action')): ?>
                                            <?php if(empty($row->return_date) && $row->status == 1): ?>
                                            <button class="btn btn-icon btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#returnModal-<?php echo e($row->id); ?>"><i class="fas fa-reply"></i></button>
                                            <?php echo $__env->make($view.'.return', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                            <button class="btn btn-icon btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#lostModal-<?php echo e($row->id); ?>"><i class="fas fa-times"></i></button>
                                            <?php echo $__env->make($view.'.lost', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\issue-return\index.blade.php ENDPATH**/ ?>