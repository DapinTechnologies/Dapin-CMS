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
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route('admin.subject-result')); ?>">
                            <div class="row gx-2">
                                <?php echo $__env->make('common.inc.subject_search_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <?php if(isset($rows)): ?>
                    <div class="card-header">
                        <a href="<?php echo e(route('admin.subject-result')); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                        
                        <button type="button" class="btn btn-dark btn-print">
                            <i class="fas fa-print"></i> <?php echo e(__('btn_print')); ?>

                        </button>
                    </div>
                    <?php endif; ?>

                    <?php
                        $contribution = 0;
                        $exam_contribution = 0;
                    ?>
                    <?php $__currentLoopData = $examTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $contribution = $contribution + $examType->contribution;
                        $exam_contribution = $exam_contribution + $examType->contribution;
                        ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if(isset($resultContributions)): ?>
                    <?php
                        $con_attendances = $resultContributions->attendances;
                        $con_assignments = $resultContributions->assignments;
                        $con_activities = $resultContributions->activities;

                        $contribution = $contribution + $con_attendances + $con_assignments + $con_activities;
                    ?>
                    <?php endif; ?>

                    <?php if(isset($rows)): ?>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover printable">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_student_id')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <th><?php echo e(__('field_point')); ?></th>
                                        <th><?php echo e(__('field_grade')); ?></th>
                                        <th><?php echo e(__('field_exam')); ?> (<?php echo e(round($exam_contribution ?? '', 2)); ?>)</th>
                                        <?php if(isset($con_attendances) && $con_attendances > 0): ?>
                                        <th><?php echo e(__('field_attendance')); ?> (<?php echo e(round($con_attendances, 2)); ?>)</th>
                                        <?php endif; ?>
                                        <?php if(isset($con_assignments) && $con_assignments > 0): ?>
                                        <th><?php echo e(__('field_assignment')); ?> (<?php echo e(round($con_assignments, 2)); ?>)</th>
                                        <?php endif; ?>
                                        <?php if(isset($con_activities) && $con_activities > 0): ?>
                                        <th><?php echo e(__('field_activities')); ?> (<?php echo e(round($con_activities, 2)); ?>)</th>
                                        <?php endif; ?>
                                        <th><?php echo e(__('field_total_marks')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php if(isset($row->studentEnroll->student->student_id)): ?>
                                            <a href="<?php echo e(route('admin.student.show', $row->studentEnroll->student->id)); ?>">
                                            #<?php echo e($row->studentEnroll->student->student_id ?? ''); ?>

                                            </a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->studentEnroll->student->first_name ?? ''); ?> <?php echo e($row->studentEnroll->student->last_name ?? ''); ?></td>
                                        
                                        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($grade->min_mark <= $row->total_marks && $grade->max_mark >= $row->total_marks): ?>
                                        
                                        <td><?php echo e($grade->title); ?></td>
                                        <td><?php echo e(number_format((float)$grade->point, 2, '.', '')); ?></td>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <td><?php echo e(round($row->exam_marks, 2)); ?></td>

                                        <?php if(isset($con_attendances) && $con_attendances > 0): ?>
                                        <td><?php echo e(round($row->attendances, 2)); ?></td>
                                        <?php endif; ?>
                                        <?php if(isset($con_assignments) && $con_assignments > 0): ?>
                                        <td><?php echo e(round($row->assignments, 2)); ?></td>
                                        <?php endif; ?>
                                        <?php if(isset($con_activities) && $con_activities > 0): ?>
                                        <td><?php echo e(round($row->activities, 2)); ?></td>
                                        <?php endif; ?>
                                        
                                        <td><?php echo e(round($row->total_marks)); ?></td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>

                                <caption><?php echo e($row->subject->code ?? ''); ?> - <?php echo e($row->studentEnroll->session->title ?? ''); ?></caption>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>

                    <?php if(count($rows) < 1): ?>
                    <div class="card-block">
                        <h5><?php echo e(__('no_result_found')); ?></h5>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\subject-marking\result.blade.php ENDPATH**/ ?>