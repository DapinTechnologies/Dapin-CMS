<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,maximum-scale=1.0">
    <title><?php echo e($title); ?></title>
    
    <style type="text/css" media="screen, print">
    @media print {
      @page { size: A4 landscape; margin: 10px; }  
      @page :footer { display: none }
      @page :header { display: none }
      body { margin: 15mm 15mm 15mm 15mm; }
      table, tbody {page-break-before: auto;}
    }
    table, img, svg {
      break-inside: avoid;
    }
    .template-container {
      -webkit-transform: scale(1.0);  /* Saf3.1+, Chrome */
      -moz-transform: scale(1.0);  /* FF3.5+ */
      -ms-transform: scale(1.0);  /* IE9 */
      -o-transform: scale(1.0);  /* Opera 10.5+ */
      transform: scale(1.0);
    }
    
    .class-routine-table {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100% !important;
    }
    .class-routine-table thead th {
        font-size: 14px;
        font-weight: 600;
    }
    .class-routine-table tbody td {
      min-width: auto;
      padding: 5px;
      font-size: 14px;
      border: 1px solid black;
      box-sizing: border-box;
    }
    </style>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('dashboard/css/prints/routine.css')); ?>" media="screen, print">

    <?php 
    $version = App\Models\Language::version(); 
    ?>
    <?php if($version->direction == 1): ?>
    <!-- RTL css -->
    <style type="text/css" media="screen, print">
      .template-container {
        direction: rtl;
      }
    </style>
    <?php endif; ?>
</head>
<body>

<div class="template-container printable" style="width: <?php echo e($print->width); ?>; height: <?php echo e($print->height); ?>;">
  <div class="template-inner">
    <!-- Header Section -->
    <table class="table-no-border">
        <tbody>
            <tr>
                <td class="temp-logo">
                  <div class="inner">
                    <?php if(is_file('uploads/'.$path.'/'.$print->logo_left)): ?>
                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$print->logo_left)); ?>" alt="Logo">
                    <?php endif; ?>
                  </div>
                </td>
                <td class="temp-title">
                  <div class="inner">
                    <h2><?php echo $print->title; ?></h2>
                    <p><?php echo strip_tags($print->body, '<br><b><i><strong><u><a><span><del>'); ?></p>
                  </div>
                </td>
                <td class="temp-logo">
                  <div class="inner">
                    <?php if(is_file('uploads/'.$path.'/'.$print->logo_right)): ?>
                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$print->logo_right)); ?>" alt="Logo">
                    <?php endif; ?>
                  </div>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <!-- Header Section -->
    <table class="table-border">
        <thead>
            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($loop->first): ?>
            <tr>
                <th><?php echo e(__('field_program')); ?>: <?php echo e($row->program->shortcode ?? ''); ?></th>
                <th><?php echo e(__('field_session')); ?>: <?php echo e($row->session->title ?? ''); ?></th>
                <th><?php echo e(__('field_semester')); ?>: <?php echo e($row->semester->title ?? ''); ?></th>
                <th><?php echo e(__('field_section')); ?>: <?php echo e($row->section->title ?? ''); ?></th>
            </tr>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </thead>
    </table>
    <!-- Header Section -->

    <!-- Header Section -->
    <?php if(isset($rows)): ?>
    <div class="card-block">
        <!-- [ Data table ] start -->
        <table class="class-routine-table">
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
                        <?php echo e($teacher->staff_id); ?> - <?php echo e($teacher->first_name); ?> <?php echo e($teacher->last_name); ?><?php if($loop->last): ?> <?php else: ?>, <?php endif; ?><br/>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td>
                        <?php $__currentLoopData = $row->rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($room->title); ?><?php if($loop->last): ?> <?php else: ?>, <?php endif; ?>
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
        <!-- [ Data table ] end -->
    </div>
    <?php endif; ?>
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
</html><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\exam-routine\print.blade.php ENDPATH**/ ?>