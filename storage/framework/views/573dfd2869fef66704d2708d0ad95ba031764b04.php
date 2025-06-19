<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5><?php echo e($title); ?></h5>
                  </div>

                  <ul class="list-group list-group-flush">
                    <?php if(isset($row->student_id)): ?>
                    <li class="list-group-item"><mark class="text-primary"><?php echo e(__('field_student_id')); ?> :</mark> #<?php echo e($row->student_id); ?></li>
                    <?php endif; ?>
                    <li class="list-group-item"><mark class="text-primary"><?php echo e(__('field_name')); ?> :</mark> <?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></li>

                    <li class="list-group-item"><mark class="text-primary"><?php echo e(__('field_batch')); ?> :</mark> <?php echo e($row->batch->title ?? ''); ?></li>
                    <li class="list-group-item"><mark class="text-primary"><?php echo e(__('field_program')); ?> :</mark> <?php echo e($row->program->title ?? ''); ?> (<?php echo e($row->program->shortcode ?? ''); ?>)</li>

                    
                    </li>
                  </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                  <div class="card-block">
                      <table class="display table table-striped">
                          <thead>
                              <tr>
                                <th><?php echo e(__('field_grade')); ?></th>
                                <th><?php echo e(__('field_point')); ?></th>
                                <th><?php echo e(__('field_min_mark')); ?></th>
                                <th><?php echo e(__('field_max_mark')); ?></th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <td><?php echo e($grade->title); ?></td>
                                <td><?php echo e(number_format((float)$grade->point, 2, '.', '')); ?></td>
                                <td><?php echo e(number_format((float)$grade->min_mark, 2, '.', '')); ?> %</td>
                                <td><?php echo e(number_format((float)$grade->max_mark, 2, '.', '')); ?> %</td>
                              </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                      </table>
                  </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <?php
                    $semesters_check = 0;
                    $semester_items = array();
                ?>

                <?php $__currentLoopData = $row->studentEnrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $enroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($semesters_check != $enroll->session->title): ?>
                <?php
                    array_push($semester_items, array($enroll->session->title, $enroll->semester->title, $enroll->section->title));
                    $semesters_check = $enroll->session->title;
                ?>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php $__currentLoopData = $semester_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $semester_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="clearfix"></div>
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($semester_item[0]); ?> | <?php echo e($semester_item[1]); ?> | <?php echo e($semester_item[2]); ?></h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table table-striped">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_code')); ?></th>
                                        <th><?php echo e(__('field_subject')); ?></th>
                                        <th><?php echo e(__('field_credit_hour')); ?></th>
                                        <th><?php echo e(__('field_point')); ?></th>
                                        <th><?php echo e(__('field_grade')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $semester_credits = 0;
                                        $semester_cgpa = 0;
                                    ?>
                                    <?php $__currentLoopData = $row->studentEnrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($semester_item[1] == $item->semester->title && $semester_item[0] == $item->session->title): ?>

                                    <?php $__currentLoopData = $item->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $semester_credits = $semester_credits + $subject->credit_hour;
                                        $subject_grade = null;
                                    ?>
                                    
                                    <tr>
                                        <td><?php echo e($subject->code); ?></td>
                                        <td>
                                            <?php echo e($subject->title); ?>

                                            <?php if($subject->subject_type == 0): ?>
                                             (<?php echo e(__('subject_type_optional')); ?>)
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(round($subject->credit_hour, 2)); ?></td>
                                        <td>
                                            <?php if(isset($item->subjectMarks)): ?>
                                            <?php $__currentLoopData = $item->subjectMarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($mark->subject_id == $subject->id): ?>
                                                <?php if((date('Y-m-d', strtotime($mark->publish_date)) == date('Y-m-d') && date('H:i:s', strtotime($mark->publish_time)) <= date('H:i:s')) || date('Y-m-d', strtotime($mark->publish_date)) < date('Y-m-d')): ?>

                                                <?php
                                                $marks_per = round($mark->total_marks);
                                                ?>

                                                <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($marks_per >= $grade->min_mark && $marks_per <= $grade->max_mark): ?>
                                                <?php echo e(number_format((float)$grade->point * $subject->credit_hour, 2, '.', '')); ?>

                                                <?php
                                                $semester_cgpa = $semester_cgpa + ($grade->point * $subject->credit_hour);
                                                $subject_grade = $grade->title;
                                                ?>
                                                <?php break; ?>
                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($subject_grade ?? ''); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2"><?php echo e(__('field_term_total')); ?></th>
                                        <th><?php echo e($semester_credits); ?></th>
                                        <th><?php echo e(number_format((float)$semester_cgpa, 2, '.', '')); ?></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/transcript/index.blade.php ENDPATH**/ ?>