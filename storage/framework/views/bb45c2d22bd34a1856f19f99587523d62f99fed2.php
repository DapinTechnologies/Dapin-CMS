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
                        <h5><?php echo e($title); ?></h5>
                    </div>

                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="report-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_library_id')); ?></th>
                                        <th><?php echo e(__('field_member')); ?></th>
                                        <th><?php echo e(__('field_isbn')); ?></th>
                                        <th><?php echo e(__('field_phone')); ?></th>
                                        <th><?php echo e(__('field_issue_date')); ?></th>
                                        <th><?php echo e(__('field_due_return_date')); ?></th>
                                        <th><?php echo e(__('field_recorded_by')); ?></th>
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
                                        <td>#<?php echo e($row->issuedBy->staff_id ?? ''); ?></td>
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
    <?php echo $__env->make('admin.report.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\report\book-return.blade.php ENDPATH**/ ?>