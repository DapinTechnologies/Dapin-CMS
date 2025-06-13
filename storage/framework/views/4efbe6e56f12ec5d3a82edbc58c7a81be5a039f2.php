
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
                        <h5>All Exam Attendance</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">
                                <!-- Faculty Filter -->
                                <div class="form-group col-md-3">
                                    <label for="faculty"><?php echo e(__('field_faculty')); ?></label>
                                    <select class="form-control select2" name="faculty" id="faculty">
                                        <option value="0">All</option>
                                        <?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($faculty->id); ?>" <?php if($selected_faculty == $faculty->id): ?> selected <?php endif; ?>><?php echo e($faculty->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Program Filter -->
                                <div class="form-group col-md-3">
                                    <label for="program"><?php echo e(__('field_program')); ?></label>
                                    <select class="form-control select2" name="program" id="program">
                                        <option value="">All</option>
                                        <?php if(isset($programs)): ?>
                                            <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($program->id); ?>" <?php if($selected_program == $program->id): ?> selected <?php endif; ?>><?php echo e($program->title); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <!-- Semester Filter -->
                                <div class="form-group col-md-3">
                                    <label for="semester"><?php echo e(__('field_semester')); ?></label>
                                    <select class="form-control select2" name="semester" id="semester">
                                        <option value="">All</option>
                                        <?php if(isset($semesters)): ?>
                                            <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($semester->id); ?>" <?php if($selected_semester == $semester->id): ?> selected <?php endif; ?>><?php echo e($semester->title); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <!-- Exam Type Filter -->
                                <div class="form-group col-md-3">
                                    <label for="type"><?php echo e(__('field_type')); ?></label>
                                    <select class="form-control select2" name="type" id="type">
                                        <option value="0">All</option>
                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($type->id); ?>" <?php if($selected_type == $type->id): ?> selected <?php endif; ?>><?php echo e($type->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?></button>
                                </div>
                            </div>
                        </form>

                        <?php if(count($attendances) > 0): ?>
                        <div class="card-footer">
                            <button type="button" class="btn btn-dark btn-print">
                                <i class="fas fa-print"></i> <?php echo e(__('btn_print')); ?>

                            </button>
                            <button type="button" class="btn btn-primary btn-export">
                                <i class="fas fa-file-export"></i> <?php echo e(__('btn_export')); ?>

                            </button>
                        </div>
                        <?php endif; ?>

                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_subject')); ?></th>
                                        <th>Exam Type</th>
                                        <th>Exam Date</th>
                                        <th>Total Student</th>
                                        <th>Total Attended</th>
                                        <th>Total Absent</th>
                                        <th>Attendance Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Group attendance data by subject, date, and exam type
                                        $groupedAttendances = [];
                                        foreach($attendances as $attendance) {
                                            $key = $attendance->subject->code.'-'.$attendance->date.'-'.$attendance->exam_type_id;
                                            if (!isset($groupedAttendances[$key])) {
                                                $groupedAttendances[$key] = [
                                                    'subject_code' => $attendance->subject->code ?? '',
                                                    'subject_name' => $attendance->subject->title ?? '',
                                                    'type' => $attendance->exam_type_data->title ?? '',

                                                    'date' => $attendance->date ?? '',
                                                    'total' => 0,
                                                    'attended' => 0,
                                                    'absent' => 0
                                                ];
                                            }
                                            $groupedAttendances[$key]['total']++;
                                            if($attendance->attendance == 1) {
                                                $groupedAttendances[$key]['attended']++;
                                            } else {
                                                $groupedAttendances[$key]['absent']++;
                                            }
                                        }
                                    ?>

                                    <?php $__empty_1 = true; $__currentLoopData = $groupedAttendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($attendance['subject_code']); ?> - <?php echo e($attendance['subject_name']); ?></td>
                                        <td><?php echo e($attendance['type']); ?></td>
                                        <td><?php echo e($attendance['date']); ?></td>
                                        <td><?php echo e($attendance['total']); ?></td>
                                        <td><?php echo e($attendance['attended']); ?></td>
                                        <td><?php echo e($attendance['absent']); ?></td>
                                        <td>
                                            <?php if($attendance['total'] > 0): ?>
                                                <?php echo e(round(($attendance['attended'] / $attendance['total']) * 100, 2)); ?>%
                                            <?php else: ?>
                                                0%
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center"><?php echo e(__('no_results_found')); ?></td>
                                    </tr>
                                    <?php endif; ?>
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
    $(document).ready(function() {
        // Initialize select2
        $('.select2').select2({
            placeholder: "<?php echo e(__('select_option')); ?>",
            allowClear: true
        });

        // Print button functionality
        $('.btn-print').click(function() {
            window.print();
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/attendance-repo/index.blade.php ENDPATH**/ ?>