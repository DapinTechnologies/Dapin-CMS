<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,maximum-scale=1.0">
    <title><?php echo e($title); ?></title>
    
    <style type="text/css" media="print">
    @media print {
      @page { size: A4 portrait; margin: 10px auto; }    
      @page :footer { display: none }
      @page :header { display: none }
      body { margin: 15mm 15mm 15mm 15mm; }
      .page-break { page-break-before: auto; }
      table, tbody, tr, .template-inner, .template-container {page-break-inside: avoid;}
    }
    table, img, svg, .template-container {
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
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('dashboard/css/prints/admit_card.css')); ?>" media="screen, print">

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

<?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                    <h2><?php echo e($print->title); ?></h2>

                    <h4><?php echo strip_tags($print->body, '<br><b><i><strong><u><a><span><del>'); ?></h4>
                  </div>
                </td>
                <td class="temp-logo last">
                  <div class="inner">
                    <?php if($print->student_photo == 1): ?>
                    <?php if(is_file('uploads/student/'.$row->photo)): ?>
                    <img src="<?php echo e(asset('uploads/student/'.$row->photo)); ?>" alt="Photo">
                    <?php endif; ?>
                    <?php endif; ?>
                  </div>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <?php
        $enroll = \App\Models\Student::enroll($row->id);
    ?>
    <!-- Header Section -->
    <table class="table-border">
        <tbody>
            <tr>
                <th><?php echo e(__('field_student_id')); ?></th>
                <th><?php echo e(__('field_name')); ?></th>
                <th><?php echo e(__('field_program')); ?></th>
                <th><?php echo e(__('field_session')); ?></th>
                <th><?php echo e(__('field_semester')); ?></th>
            </tr>
            <tr>
                <td><?php echo e($row->student_id); ?></td>
                <td><?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></td>
                <td><?php echo e($enroll->program->shortcode ?? ''); ?></td>
                <td><?php echo e($enroll->session->title ?? ''); ?></td>
                <td><?php echo e($enroll->semester->title ?? ''); ?></td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <!-- Header Section -->
    <table class="table-no-border">
        <tbody>
            <tr>
                <td class="temp-footer">
                  <div class="inner">
                    <p><?php echo $print->footer_left; ?></p>
                  </div>
                </td>
                <td class="temp-footer last">
                  <div class="inner">
                    <p><?php echo $print->footer_right; ?></p>
                  </div>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->
  </div>

  <div class="page-break"></div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
</html><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\admit-card\print.blade.php ENDPATH**/ ?>