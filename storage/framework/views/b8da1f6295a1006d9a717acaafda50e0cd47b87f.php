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
                                    <label for="type"><?php echo e(__('field_exam')); ?> <?php echo e(__('field_type')); ?> <span>*</span></label>
                                    <select class="form-control" name="type" id="type" required>
                                          <option value=""><?php echo e(__('select')); ?></option>
                                          <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($type->id); ?>" <?php if( $selected_type == $type->id): ?> selected <?php endif; ?>><?php echo e($type->title); ?></option>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                    <?php echo e(__('required_field')); ?> <?php echo e(__('field_exam')); ?> <?php echo e(__('field_type')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php if(isset($rows)): ?>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_subject')); ?></th>
                                        <th><?php echo e(__('field_teacher')); ?></th>
                                        <th><?php echo e(__('field_room')); ?></th>
                                        <th><?php echo e(__('field_date')); ?></th>
                                        <th><?php echo e(__('field_start_time')); ?></th>
                                        <th><?php echo e(__('field_end_time')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($row->subject->code ?? ''); ?> - <?php echo e($row->subject->title ?? ''); ?></td>
                                        <td>
                                            <?php $__currentLoopData = $row->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e($teacher->first_name); ?> <?php echo e($teacher->last_name); ?><?php if($loop->last): ?> <?php else: ?> , <?php endif; ?><br/>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td>
                                            <?php $__currentLoopData = $row->rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e($room->title); ?><?php if($loop->last): ?> <?php else: ?> , <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(isset($setting->time_format)): ?>
                                            <?php echo e(date($setting->time_format, strtotime($row->start_time))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("h:i A", strtotime($row->start_time))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(isset($setting->time_format)): ?>
                                            <?php echo e(date($setting->time_format, strtotime($row->end_time))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("h:i A", strtotime($row->end_time))); ?>

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
<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/exam-routine/index.blade.php ENDPATH**/ ?>