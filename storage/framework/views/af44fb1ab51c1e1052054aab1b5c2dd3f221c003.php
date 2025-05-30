<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($title); ?></title>

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

<div class="template-container" id="downloadable" style="width: <?php echo e($print->width); ?>; height: <?php echo e($print->height); ?>;">
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
</div>
    
    <!-- PDF Js -->
    <script src="<?php echo e(asset('dashboard/plugins/jquery/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dashboard/plugins/html2pdf/js/html2pdf.bundle.min.js')); ?>"></script>

    <script type="text/javascript">
        "use strict";
        var pdf_title =  '<?php echo e($row->student_id); ?>-<?php echo e($enroll->semester->title); ?>' + '.pdf'
        var pdf_content = document.getElementById("downloadable");

        var options = {
          margin:       0,
          filename:     pdf_title,
          image:        { type: 'jpeg', quality: 8.00 },
          html2canvas:  { scale: 2 },
          jsPDF:        { unit: 'in', format: 'A4', orientation: 'portrait' }
        };

        html2pdf(pdf_content, options);
    </script>
</body>
</html><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\admit-card\download.blade.php ENDPATH**/ ?>