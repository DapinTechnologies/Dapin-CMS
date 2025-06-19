<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,maximum-scale=1.0">
    <title><?php echo e($title); ?></title>
    
    <style type="text/css" media="print">
    @media print {
      @page { size: A4 portrait; margin: 50px auto; }   
      @page :footer { display: none }
      @page :header { display: none }
      body { margin: 15mm auto 15mm auto; }
      table, tbody, tr {page-break-before: auto;}
    }
    img, svg {
      break-inside: avoid;
    }
    .template-container {
      -webkit-transform: scale(1.0);  /* Saf3.1+, Chrome */
      -moz-transform: scale(1.0);  /* FF3.5+ */
      -ms-transform: scale(1.0);  /* IE9 */
      -o-transform: scale(1.0);  /* Opera 10.5+ */
      transform: scale(1.0);
    }
    </style>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('dashboard/css/prints/marksheet.css')); ?>" media="screen, print">

    <?php 
    $version = App\Models\Language::version(); 
    ?>
    <?php if($version->direction == 1): ?>
    <!-- RTL css -->
    <style type="text/css" media="screen, print">
    .template-container {
      direction: rtl;
    }
    .template-container .top-meta-table tr td,
    .template-container .top-meta-table tr th {
      float: right;
      text-align: right;
    }
    .table-no-border.marksheet td:nth-child(1), 
    .table-no-border.marksheet td:nth-child(2) {
      text-align: right;
    }
    </style>
    <?php endif; ?>
</head>
<body>

<div class="template-container printable" style="width: <?php echo e($marksheet->width); ?>; height: <?php echo e($marksheet->height); ?>;">
  <div class="template-inner">
    <!-- Header Section -->
    <table class="table-no-border">
        <tbody>
            <tr>
                <td class="temp-logo">
                  <div class="inner">
                    <?php if(is_file('uploads/'.$path.'/'.$marksheet->logo_left)): ?>
                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$marksheet->logo_left)); ?>" alt="Logo">
                    <?php endif; ?>
                  </div>
                </td>
                <td class="temp-title">
                  <div class="inner">
                    <h2><?php echo e($setting->title); ?></h2>
                    <h4><?php echo e($marksheet->title); ?></h4>
                  </div>
                </td>
                <td class="temp-logo last">
                  <div class="inner">
                    <?php if(is_file('uploads/'.$path.'/'.$marksheet->logo_right)): ?>
                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$marksheet->logo_right)); ?>" alt="Logo">
                    <?php endif; ?>
                  </div>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <?php
        $total_credits = 0;
        $total_cgpa = 0;
        $starting_year = '';
        $ending_year = '';
    ?>


    
    <?php $__currentLoopData = $row->studentEnrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($loop->first): ?>
        <?php
            $starting_year = $item->session->title;
        ?>
        <?php endif; ?>

        <?php if($loop->last): ?>
        <?php
            $ending_year = $item->session->title;
        ?>
        <?php endif; ?>

        <?php if(isset($item->subjectMarks)): ?>
        <?php $__currentLoopData = $item->subjectMarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php
            $marks_per = round($mark->total_marks);
            ?>

            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($marks_per >= $grade->min_mark && $marks_per <= $grade->max_mark): ?>
            <?php
            if($grade->point > 0){
            $total_cgpa = $total_cgpa + ($grade->point * $mark->subject->credit_hour);
            $total_credits = $total_credits + $mark->subject->credit_hour;
            }
            ?>
            <?php break; ?>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <br/>

    <!-- Header Section -->
    <table class="table-no-border top-meta-table">
        <tbody>
            <tr>
                <td class="meta-data"><?php echo e(__('field_student_id')); ?></td>
                <td class="meta-data width2">: <?php echo e($row->student_id); ?></td>

                <td class="meta-data"><?php echo e(__('field_starting_year')); ?></td>
                <td class="meta-data">: <?php echo e($starting_year); ?></td>
            </tr>
            <tr>
                <td class="meta-data"><?php echo e(__('field_name')); ?></td>
                <td class="meta-data width2">: <?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></td>
                <td class="meta-data"><?php echo e(__('field_ending_year')); ?></td>
                <td class="meta-data">: <?php echo e($ending_year); ?></td>
            </tr>
            <tr>
                <td class="meta-data"><?php echo e(__('field_gender')); ?></td>
                <td class="meta-data width2">: 
                    <?php if( $row->gender == 1 ): ?>
                    <?php echo e(__('gender_male')); ?>

                    <?php elseif( $row->gender == 2 ): ?>
                    <?php echo e(__('gender_female')); ?>

                    <?php elseif( $row->gender == 3 ): ?>
                    <?php echo e(__('gender_other')); ?>

                    <?php endif; ?>
                </td>
                <td class="meta-data"><?php echo e(__('field_dob')); ?></td>
                <td class="meta-data">:
                    <?php if(isset($setting->date_format)): ?>
                    <?php echo e(date($setting->date_format, strtotime($row->dob))); ?>

                    <?php else: ?>
                    <?php echo e(date("Y-m-d", strtotime($row->dob))); ?>

                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="meta-data"><?php echo e(__('field_batch')); ?></td>
                <td class="meta-data width2">: <?php echo e($row->batch->title ?? ''); ?></td>
               
                
            </tr>
            <tr>
                <td class="meta-data"><?php echo e(__('field_program')); ?></td>
                <td class="meta-data width2">: <?php echo e($row->program->title ?? ''); ?></td>

                <?php
                    if($total_credits <= 0){
                        $total_credits = 1;
                    }
                    $com_gpa = $total_cgpa / $total_credits;
                ?>

                 </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <br/>

    <!-- Header Section -->
    <table class="table-no-border marksheet">
        <thead>
            <tr>
                <th><?php echo e(__('field_code')); ?></th>
                <th class="width2"><?php echo e(__('field_subject')); ?></th>
                <th><?php echo e(__('field_credit_hour')); ?></th>
                <th><?php echo e(__('field_point')); ?></th>
                <th><?php echo e(__('field_grade')); ?></th>
            </tr>
        </thead>


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
        <tbody>
            <tr>
                <td colspan="5" class="semester-title"><?php echo e($semester_item[0]); ?> | <?php echo e($semester_item[1]); ?> | <?php echo e($semester_item[2]); ?></td>
            </tr>

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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </td>
                <td><?php echo e($subject_grade ?? ''); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <tr class="tfoot">
                <th colspan="2"><?php echo e(__('field_term_total')); ?>:</th>
                <th><?php echo e($semester_credits); ?></th>
                <th><?php echo e(number_format((float)$semester_cgpa, 2, '.', '')); ?></th>
                <th></th>
            </tr>
        </tbody>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
    <!-- Header Section -->

    <!-- Header Section -->
    <table class="table-no-border">
        <tbody>
            <tr>
                <td class="temp-footer">
                  <div class="inner">
                    <p><?php echo $marksheet->footer_left; ?></p>
                  </div>
                </td>
                <td class="temp-footer">
                  <div class="inner">
                    <p><?php echo $marksheet->footer_center; ?></p>
                  </div>
                </td>
                <td class="temp-footer">
                  <div class="inner">
                    <p><?php echo $marksheet->footer_right; ?></p>
                  </div>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->
  </div>
</div>

    <!-- Print Js -->
    <script src="<?php echo e(asset('dashboard/plugins/jquery/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dashboard/plugins/print/js/jQuery.print.min.js')); ?>"></script>

    <script type="text/javascript">
    $( document ).ready(function() {
      "use strict";
      $.print(".printable");
    });
    </script>

</body>
</html><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/marksheet/print.blade.php ENDPATH**/ ?>