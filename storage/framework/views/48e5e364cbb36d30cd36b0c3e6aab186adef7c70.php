<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,maximum-scale=1.0">
    <title><?php echo e($title); ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet"> 
    
    <style type="text/css" media="print">
    @media print {
      @page { size: A4 landscape; margin: 10px; }   
      @page :footer { display: none }
      @page :header { display: none }
      body { margin: 15mm 15mm 15mm 15mm; }
      table, tbody {page-break-before: auto;}
      .page-break { page-break-before: always; }
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
    </style>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('dashboard/css/prints/certificate.css')); ?>" media="screen, print">

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

<?php $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="printable">
<div class="template-container" style="border-image: url('<?php echo e(asset('uploads/'.$path.'/'.$certificate->template->background)); ?>') 30 stretch; width: <?php echo e($certificate->template->width); ?>; height: <?php echo e($certificate->template->height); ?>;">
    <div class="template-inner">
    <!-- Header Section -->
    <table class="table-no-border">
        <tbody>
            <tr>
                <td class="temp-logo">
                  <div class="inner">
                    <?php if(is_file('uploads/'.$path.'/'.$certificate->template->logo_left)): ?>
                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$certificate->template->logo_left)); ?>" alt="Logo">
                    <?php endif; ?>
                  </div>
                </td>
                <td class="temp-title">
                  <div class="inner">
                    <h2><?php echo e($setting->title ?? ''); ?></h2>
                  </div>
                </td>
                <td class="temp-logo last">
                  <div class="inner">
                    <?php if($certificate->template->student_photo == 1): ?>
                    <?php if(is_file('uploads/student/'.$certificate->student->photo)): ?>
                    <img src="<?php echo e(asset('uploads/student/'.$certificate->student->photo)); ?>" alt="Student">
                    <?php endif; ?>
                    <?php endif; ?>
                  </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table-no-border">
        <tbody>
            <tr>
                <td class="main-title">
                    <h4><?php echo e($certificate->template->title ?? ''); ?></h4>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <!-- Header Section -->
    <table class="table-no-border">
        <tbody>
            <tr>
                <td class="meta-data">
                    <div class="inner"><?php echo e(__('field_no')); ?>: <?php echo e($certificate->serial_no); ?></div>
                </td>
                <td class="meta-data last">
                    <div class="inner"><?php echo e(__('field_date')); ?>: 
                        <?php if(isset($setting->date_format)): ?>
                        <?php echo e(date($setting->date_format, strtotime($certificate->date))); ?>

                        <?php else: ?>
                        <?php echo e(date("Y-m-d", strtotime($certificate->date))); ?>

                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <!-- Header Section -->
    <table class="table-no-border">
        <tbody>
            <tr>
                <td>
                    <div class="temp-body">
                    <?php if(isset($setting->date_format)): ?>
                    <?php
                        $student_dob = date($setting->date_format, strtotime($certificate->student->dob));
                    ?>
                    <?php else: ?>
                    <?php
                        $student_dob = date("Y-m-d", strtotime($certificate->student->dob));
                    ?>
                    <?php endif; ?>


                    <?php if($certificate->student->gender == 1): ?>
                    <?php
                        $student_gender = __('gender_male');
                    ?>
                    <?php elseif($certificate->student->gender == 2): ?>
                    <?php
                        $student_gender = __('gender_female');
                    ?>
                    <?php elseif($certificate->student->gender == 3): ?>
                    <?php
                        $student_gender = __('gender_other');
                    ?>
                    <?php endif; ?>


                    <?php
                        $grade_point = '';
                    ?>
                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($certificate->point >= $grade->point): ?>
                    <?php
                        $grade_point = $grade->title;
                    ?>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    <?php
                        $first_name = $certificate->student->first_name ?? '';
                        $last_name = $certificate->student->last_name ?? '';
                        $student_id = $certificate->student->student_id ?? '';
                        $batch = $certificate->student->batch->title ?? '';
                        $program = $certificate->student->program->title ?? '';
                        $faculty = $certificate->student->program->faculty->title ?? '';
                        $father_name = $certificate->student->father_name ?? '';
                        $mother_name = $certificate->student->mother_name ?? '';
                        $email = $certificate->student->email ?? '';
                        $phone = $certificate->student->phone ?? '';
                        $starting_session = $certificate->student->firstEnroll->session->title ?? '';
                        $ending_session = $certificate->student->lastEnroll->session->title ?? '';
                    ?>
                    <?php
                    $search = array('[first_name]', '[last_name]', '[dob]', '[gender]', '[student_id]', '[batch]', '[program]', '[faculty]', '[father_name]', '[mother_name]', '[starting_year]', '[ending_year]', '[starting_session]', '[ending_session]', '[credits]', '[cgpa]', '[grade]', '[email]', '[phone]');

                    $replace = array('<span>'.$first_name.'</span>', '<span>'.$last_name.'</span>', '<span>'.$student_dob.'</span>', '<span>'.$student_gender.'</span>', '<span>'.$student_id.'</span>', '<span>'.$batch.'</span>', '<span>'.$program.'</span>', '<span>'.$faculty.'</span>', '<span>'.$father_name.'</span>', '<span>'.$mother_name.'</span>', '<span>'.date('Y',strtotime($certificate->starting_year)).'</span>', '<span>'.date('Y',strtotime($certificate->ending_year)).'</span>', '<span>'.$starting_session.'</span>', '<span>'.$ending_session.'</span>', '<span>'.round($certificate->credits, 2).'</span>', '<span>'.number_format((float)$certificate->point, 2, '.', '').'</span>', '<span>'.$grade_point.'</span>', '<span>'.$email.'</span>', '<span>'.$phone.'</span>');

                    $string = $certificate->template->body;
                    ?>

                    <?php echo str_replace($search, $replace, $string); ?>

                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <!-- Header Section -->
    <?php if($certificate->template->barcode == 1): ?>
    <table class="table-no-border">
        <tbody>
            <tr>
                <td style="width: 33.33%; text-align: center;"></td>
                <td style="width: 33.33%; text-align: center; font-family: 'IDAHC39M Code 39 Barcode', Times, serif;">
                    <?php echo DNS1D::getBarcodeSVG($certificate->barcode, 'C39', 1, 33, '#000', false); ?>

                </td>
                <td style="width: 33.33%; text-align: center;"></td>
            </tr>
        </tbody>
    </table>
    <?php endif; ?>
    <table class="table-no-border">
        <tbody>
            <tr>
                <td class="temp-footer">
                  <div class="inner">
                    <p><?php echo $certificate->template->footer_left; ?></p>
                  </div>
                </td>
                <td class="temp-footer">
                  <div class="inner">
                    <p><?php echo $certificate->template->footer_center; ?></p>
                  </div>
                </td>
                <td class="temp-footer">
                  <div class="inner">
                    <p><?php echo $certificate->template->footer_right; ?></p>
                  </div>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->
    </div>
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
</html><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/certificate/multi-print.blade.php ENDPATH**/ ?>