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

                    <?php if(isset($contribution)): ?>
                    <?php if($contribution != 100): ?>
                    <div class="card-block">
                        <div class="alert alert-danger" role="alert">
                            <?php echo e(__('msg_your_contribution_is_not_correct')); ?>

                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
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
                        <?php if(isset($markings)): ?>
                        <?php if(count($markings) > 0): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(__('marks_given')); ?>

                        </div>
                        <?php else: ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo e(__('marks_not_given')); ?>

                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <?php if(isset($rows)): ?>
                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        foreach($row->subjectMarks->where('subject_id', $selected_subject) as $check){

                            if($check->student_enroll_id == $row->id){
                                $check_data = $check;
                                break;
                            }
                        }
                        ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <div class="card-block">
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-3">
                                <label for="publish_date"><?php echo e(__('field_publish_date')); ?> <span>*</span></label>
                                <input type="date" class="form-control date" name="publish_date" id="publish_date" value="<?php echo e($check_data->publish_date ?? ''); ?>" required>
                                    
                                <div class="invalid-feedback">
                                    <?php echo e(__('required_field')); ?> <?php echo e(__('field_publish_date')); ?>

                                </div>
                            </div>

                            <div class="form-group col-sm-6 col-md-3">
                                <label for="publish_time"><?php echo e(__('field_publish_time')); ?> <span>*</span></label>
                                <input type="time" class="form-control time" name="publish_time" id="publish_time" value="<?php echo e($check_data->publish_time ?? ''); ?>" required>
                                    
                                <div class="invalid-feedback">
                                    <?php echo e(__('required_field')); ?> <?php echo e(__('field_publish_time')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>


                    <?php if(isset($rows)): ?>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_student_id')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
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
                                        <th><?php echo e(__('field_exam')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <input type="hidden" name="students[]" value="<?php echo e($row->id); ?>">
                                    <input type="hidden" name="subjects[]" value="<?php echo e($subject->id); ?>">
                                    <tr>
                                        <td>
                                            <?php if(isset($row->student->student_id)): ?>
                                            <a href="<?php echo e(route('admin.student.show', $row->student->id)); ?>">
                                            #<?php echo e($row->student->student_id ?? ''); ?>

                                            </a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->student->first_name ?? ''); ?> <?php echo e($row->student->last_name ?? ''); ?></td>
                                        <td>
                                        <?php
                                            $exam_marks = 0;
                                            $contributeOfMarks = 0;
                                            $max_marks = $exam_contribution ?? 0;
                                        ?>
                                        <?php $__currentLoopData = $row->exams->where('subject_id', $selected_subject); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($exam->attendance == 1 && $exam->student_enroll_id == $row->id && $exam->contribution > 0): ?>

                                        <?php
                                            $percentOfMarks = ($exam->achieve_marks / $exam->marks) * 100;
                                            $contributeOfMarks = $contributeOfMarks + (($percentOfMarks / 100) * $exam->contribution);
                                            $exam_marks = $contributeOfMarks;
                                        ?>
                                            
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php
                                        $mark = '0';
                                        $attend = '0';
                                        $assignment = '0';
                                        $activity = '0';

                                        //Subject Marks
                                        foreach($row->subjectMarks->where('subject_id', $selected_subject) as $marking){
                                        if($marking->student_enroll_id == $row->id){
                                         $mark = $marking->exam_marks;
                                         $attend = $marking->attendances;
                                         $assignment = $marking->assignments;
                                         $activity = $marking->activities;
                                         break;
                                        }
                                        }
                                        ?>
                                        <input type="text" class="form-control exam_marks autonumber" name="exam_marks[]" id="exam_marks" value="<?php echo e(round($exam_marks ?? $mark)); ?>" 
                                        style="width: 80px;" data-v-max="<?php echo e($max_marks); ?>" data-v-min="0" data_id="total-<?php echo e($row->id); ?>" onkeyup="marksCalculator('total', <?php echo e($row->id); ?>)" readonly required>
                                        </td>
                                        <?php
                                        $present = $studentAttendance->where('student_enroll_id', $row->id)->where('subject_id', $selected_subject)->where('attendance', 1)->count();

                                        $absent = $studentAttendance->where('student_enroll_id', $row->id)->where('subject_id', $selected_subject)->where('attendance', 2)->count();

                                        $leave = $studentAttendance->where('student_enroll_id', $row->id)->where('subject_id', $selected_subject)->where('attendance', 3)->count();

                                        $total_present = $present + $leave;
                                        $total_attendance = $total_present + $absent;

                                        if(!empty($total_attendance)){
                                            $attendance_mark = ($con_attendances / $total_attendance) * $total_present;
                                        }else{
                                            $attendance_mark = 0;
                                        }
                                        ?>

                                        <?php if(isset($con_attendances) && $con_attendances > 0): ?>
                                        <td>
                                            <input type="text" class="form-control attendances autonumber" name="attendances[]" id="attendances" value="<?php echo e(round($attendance_mark ?? $attend)); ?>" style="width: 80px;" data-v-max="<?php echo e($con_attendances); ?>" data-v-min="0" data_id="total-<?php echo e($row->id); ?>" onkeyup="marksCalculator('total', <?php echo e($row->id); ?>)" readonly required>
                                        </td>
                                        <?php endif; ?>
                                        <?php if(isset($con_assignments) && $con_assignments > 0): ?>
                                        <td>
                                            <input type="text" class="form-control assignments autonumber" name="assignments[]" id="assignments" value="<?php echo e($assignment ? round($assignment, 2) : ''); ?>" style="width: 80px;" data-v-max="<?php echo e($con_assignments); ?>" data-v-min="0" data_id="total-<?php echo e($row->id); ?>" onkeyup="marksCalculator('total', <?php echo e($row->id); ?>)" required>
                                        </td>
                                        <?php endif; ?>
                                        <?php if(isset($con_activities) && $con_activities > 0): ?>
                                        <td>
                                            <input type="text" class="form-control activities autonumber" name="activities[]" id="activities" value="<?php echo e($activity ? round($activity, 2) : ''); ?>" style="width: 80px;" data-v-max="<?php echo e($con_activities); ?>" data-v-min="0" data_id="total-<?php echo e($row->id); ?>" onkeyup="marksCalculator('total', <?php echo e($row->id); ?>)" required>
                                        </td>
                                        <?php endif; ?>

                                        <td>
                                            <?php
                                            $total_marks = round($assignment ?? '0', 2) + round($activity ?? '0', 2) + round($exam_marks ?? $mark) + round($attendance_mark ?? $attend)
                                            ?>
                                            <input type="text" class="form-control total_marks autonumber" name="total_marks[]" id="total_marks" value="<?php echo e(round($total_marks)); ?>" style="width: 80px;" data-v-max="100" data-v-min="0" readonly data_id="total-<?php echo e($row->id); ?>" onkeyup="marksCalculator('total', <?php echo e($row->id); ?>)" readonly required>
                                        </td>
                                        <td>
                                            <?php $__currentLoopData = $row->exams->where('subject_id', $selected_subject)->sortByDesc('contribution'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($exam->contribution > 0): ?>
                                                <span class="badge badge-dark">
                                                <?php echo e($exam->type->title ?? ''); ?> - <?php echo e(round($exam->achieve_marks ?? '0', 2)); ?> (<?php echo e(round($exam->type->marks ?? '', 2)); ?>) (<?php echo e(round($exam->contribution, 2)); ?> %)
                                                </span><br>
                                            <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>

                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($subject_code->id == $selected_subject): ?>
                                <?php
                                    $cur_subject = $subject_code->code;
                                ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <caption><?php echo e($cur_subject ?? ''); ?> - <?php echo e($row->session->title ?? ''); ?></caption>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>

                    <?php if(isset($contribution)): ?>
                    <?php if(count($rows) > 0 && $contribution == 100): ?>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success update" ><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                    </div>
                    <?php endif; ?>
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

          var exam_marks = $(".exam_marks[data_id='"+type+"-"+id+"']").val();
          var attendances = $(".attendances[data_id='"+type+"-"+id+"']").val();
          var assignments = $(".assignments[data_id='"+type+"-"+id+"']").val();
          var activities = $(".activities[data_id='"+type+"-"+id+"']").val();
          var total_marks = $(".total_marks[data_id='"+type+"-"+id+"']").val();

          if (isNaN(attendances)) attendances = 0;
          if (isNaN(assignments)) assignments = 0;
          if (isNaN(activities)) activities = 0;

          var total_marks = parseFloat(exam_marks) + parseFloat(attendances) + parseFloat(assignments) + parseFloat(activities);

          $(".attendances[data_id='"+type+"-"+id+"']").val(attendances);
          $(".assignments[data_id='"+type+"-"+id+"']").val(assignments);
          $(".activities[data_id='"+type+"-"+id+"']").val(activities);
          $(".total_marks[data_id='"+type+"-"+id+"']").val(total_marks);

        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\subject-marking\marking.blade.php ENDPATH**/ ?>