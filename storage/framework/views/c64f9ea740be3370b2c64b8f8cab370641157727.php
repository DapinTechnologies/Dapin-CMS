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

                    <?php
                        $contribution = 0;
                        $exam_contribution = 0;
                    ?>

                    <?php $__currentLoopData = $examTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $contribution += $examType->contribution;
                            $exam_contribution += $examType->contribution;
                        ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if(isset($resultContributions)): ?>
                        <?php
                            $con_attendances = $resultContributions->attendances;
                            $con_assignments = $resultContributions->assignments;
                            $con_activities = $resultContributions->activities;
                            $contribution += $con_attendances + $con_assignments + $con_activities;
                        ?>
                    <?php endif; ?>

                    <?php if($contribution != 100): ?>
                    <div class="card-block">
                        <div class="alert alert-danger" role="alert">
                            <?php echo e(__('msg_your_contribution_is_not_correct')); ?>

                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">
                                <?php echo $__env->make('common.inc.subject_search_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter">
                                        <i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?>

                                    </button>
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
                        <?php if(isset($markings) && count($markings) > 0): ?>
                        <div class="alert alert-success"><?php echo e(__('marks_given')); ?></div>
                        <?php else: ?>
                        <div class="alert alert-danger"><?php echo e(__('marks_not_given')); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post">
                        <?php echo csrf_field(); ?>

                        <?php if(isset($rows)): ?>
                        <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $check_data = $row->subjectMarks->where('subject_id', $selected_subject)
                                            ->where('student_enroll_id', $row->id)
                                            ->first();
                            ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="card-block">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="publish_date"><?php echo e(__('field_publish_date')); ?> <span>*</span></label>
                                    <input type="date" class="form-control" name="publish_date" id="publish_date" value="<?php echo e($check_data->publish_date ?? ''); ?>" required>
                                    <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_publish_date')); ?></div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="publish_time"><?php echo e(__('field_publish_time')); ?> <span>*</span></label>
                                    <input type="time" class="form-control" name="publish_time" id="publish_time" value="<?php echo e($check_data->publish_time ?? ''); ?>" required>
                                    <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_publish_time')); ?></div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if(isset($rows)): ?>
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('field_student_id')); ?></th>
                                            <th><?php echo e(__('field_name')); ?></th>
                                            <th><?php echo e(__('field_exam')); ?> (<?php echo e(round($exam_contribution ?? 0, 2)); ?>)</th>
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
                                            <th><?php echo e(__('field_exam_details')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <input type="hidden" name="students[]" value="<?php echo e($row->id); ?>">
                                        <input type="hidden" name="subjects[]" value="<?php echo e($subject->id); ?>">
                                        <?php
                                            $exam_marks = 0;
                                            foreach(['Mock Exam', 'CAT 1', 'CAT 2'] as $title) {
                                                $exam = $row->exams->where('subject_id', $selected_subject)
                                                    ->where('type.title', $title)
                                                    ->where('attendance', 1)
                                                    ->first();

                                                if ($exam) {
                                                    $exam_marks += $exam->achieve_marks;
                                                }
                                            }

                                            $marking = $row->subjectMarks->where('subject_id', $selected_subject)
                                                        ->where('student_enroll_id', $row->id)->first();

                                            $attend = $marking->attendances ?? 0;
                                            $assignment = $marking->assignments ?? 0;
                                            $activity = $marking->activities ?? 0;

                                            $present = $studentAttendance->where('student_enroll_id', $row->id)->where('subject_id', $selected_subject)->where('attendance', 1)->count();
                                            $absent = $studentAttendance->where('student_enroll_id', $row->id)->where('subject_id', $selected_subject)->where('attendance', 2)->count();
                                            $leave = $studentAttendance->where('student_enroll_id', $row->id)->where('subject_id', $selected_subject)->where('attendance', 3)->count();

                                            $total_attendance = $present + $absent + $leave;
                                            $total_present = $present + $leave;

                                            $attendance_mark = $total_attendance ? ($con_attendances / $total_attendance) * $total_present : 0;

                                            $total_marks = round($exam_marks + $attendance_mark + $assignment + $activity, 2);
                                        ?>
                                        <tr>
                                            <td>
                                                <?php if(isset($row->student->student_id)): ?>
                                                <a href="<?php echo e(route('admin.student.show', $row->student->id)); ?>">
                                                    #<?php echo e($row->student->student_id); ?>

                                                </a>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($row->student->first_name ?? ''); ?> <?php echo e($row->student->last_name ?? ''); ?></td>
                                            <td>
                                                <input type="text" class="form-control exam_marks" name="exam_marks[]" value="<?php echo e(round($exam_marks)); ?>" readonly>
                                            </td>

                                            <?php if(isset($con_attendances) && $con_attendances > 0): ?>
                                            <td>
                                                <input type="text" class="form-control attendances" name="attendances[]" value="<?php echo e(round($attendance_mark)); ?>" readonly>
                                            </td>
                                            <?php endif; ?>

                                            <?php if(isset($con_assignments) && $con_assignments > 0): ?>
                                            <td>
                                                <input type="text" class="form-control assignments" name="assignments[]" value="<?php echo e(round($assignment, 2)); ?>">
                                            </td>
                                            <?php endif; ?>

                                            <?php if(isset($con_activities) && $con_activities > 0): ?>
                                            <td>
                                                <input type="text" class="form-control activities" name="activities[]" value="<?php echo e(round($activity, 2)); ?>">
                                            </td>
                                            <?php endif; ?>

                                            <td>
                                                <input type="text" class="form-control total_marks" name="total_marks[]" value="<?php echo e($total_marks); ?>" readonly>
                                            </td>
                                            <td>
                                                <?php $__currentLoopData = $row->exams->where('subject_id', $selected_subject)->sortByDesc('contribution'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(in_array($exam->type->title ?? '', ['Mock Exam', 'CAT 1', 'CAT 2'])): ?>
                                                        <span class="badge badge-dark">
                                                            <?php echo e($exam->type->title ?? ''); ?> - <?php echo e(round($exam->achieve_marks ?? 0, 2)); ?> / <?php echo e(round($exam->marks ?? 0, 2)); ?>

                                                        </span><br>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    <caption>
                                        <?php echo e($subjects->firstWhere('id', $selected_subject)->code ?? ''); ?> - <?php echo e($row->session->title ?? ''); ?>

                                    </caption>
                                </table>
                            </div>
                        </div>

                        <?php if(count($rows) > 0 && $contribution == 100): ?>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?>

                            </button>
                        </div>
                        <?php endif; ?>

                        <?php if(count($rows) < 1): ?>
                        <div class="card-block">
                            <h5><?php echo e(__('no_result_found')); ?></h5>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    </form>
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
function marksCalculator(type, id) {
    var exam_marks = parseFloat($(".exam_marks[data_id='"+type+"-"+id+"']").val()) || 0;
    var attendances = parseFloat($(".attendances[data_id='"+type+"-"+id+"']").val()) || 0;
    var assignments = parseFloat($(".assignments[data_id='"+type+"-"+id+"']").val()) || 0;
    var activities = parseFloat($(".activities[data_id='"+type+"-"+id+"']").val()) || 0;

    var total = exam_marks + attendances + assignments + activities;
    $(".total_marks[data_id='"+type+"-"+id+"']").val(total.toFixed(2));
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/subject-marking/marking.blade.php ENDPATH**/ ?>