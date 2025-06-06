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
    </style>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('dashboard/css/prints/visitor_token.css')); ?>" media="screen, print">

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
    .template-container .table-no-border tr td.temp-logo {
      float: none;
    }
    .template-container .temp-title {
      float: right;
      text-align: right;
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
                <td class="temp-title">
                  <div class="inner">
                    <h2><?php echo e($print->title); ?></h2>
                    <p><?php echo e($print->prefix ?? ''); ?><?php echo e($row->token); ?></p>
                  </div>
                </td>
                <td class="temp-logo last">
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
    <table class="table-no-border top-meta-table">
        <tbody>
            <tr>
                <td class="meta-data"><?php echo e(__('field_name')); ?></td>
                <td class="meta-data value width2">: <?php echo e($row->name); ?></td>
                <td class="meta-data"><?php echo e(__('field_purpose')); ?></td>
                <td class="meta-data value width2">: <?php echo e($row->purpose->title ?? ''); ?></td>
            </tr>
            <tr>
                <td class="meta-data"><?php echo e(__('field_phone')); ?></td>
                <td class="meta-data value width2">: <?php echo e($row->phone); ?></td>
                <td class="meta-data"><?php echo e(__('field_department')); ?></td>
                <td class="meta-data value width2">: <?php echo e($row->department->title ?? ''); ?></td>
            </tr>
            <tr>
                <td class="meta-data"><?php echo e(__('field_email')); ?></td>
                <td class="meta-data value width2">: <?php echo e($row->email); ?></td>
                <td class="meta-data"><?php echo e(__('field_date')); ?></td>
                <td class="meta-data value width2">: 
                    <?php if(isset($setting->date_format)): ?>
                    <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                    <?php else: ?>
                    <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="meta-data"><?php echo e(__('field_persons')); ?></td>
                <td class="meta-data value width2">: <?php echo e($row->persons); ?></td>
                <td class="meta-data"><?php echo e(__('field_in_time')); ?></td>
                <td class="meta-data value width2">: 
                    <?php if(isset($setting->time_format)): ?>
                    <?php echo e(date($setting->time_format, strtotime($row->in_time))); ?>

                    <?php else: ?>
                    <?php echo e(date("h:i A", strtotime($row->in_time))); ?>

                    <?php endif; ?>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <!-- Header Section -->
    <br/>
    <?php if($print->barcode == 1): ?>
    <br/>
    <table class="table-no-border">
        <tbody>
            <tr>
                <td style="width: 33.33%; text-align: center;"></td>
                <td style="width: 33.33%; text-align: center; font-family: 'IDAHC39M Code 39 Barcode', Times, serif;">
                    <?php echo DNS1D::getBarcodeSVG($row->token, 'C39', 1, 33, '#000', false); ?>

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
                  <?php if(isset($print->footer_left)): ?>
                  <div class="inner">
                    <p><?php echo $print->footer_left; ?></p>
                  </div>
                  <?php endif; ?>
                </td>
                <td class="temp-footer last">
                  <?php if(isset($print->footer_right)): ?>
                  <div class="inner">
                    <p><?php echo $print->footer_right; ?></p>
                  </div>
                  <?php endif; ?>
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
</html><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\visitor\print.blade.php ENDPATH**/ ?>