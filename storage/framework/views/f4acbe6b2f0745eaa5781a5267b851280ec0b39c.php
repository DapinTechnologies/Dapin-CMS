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
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('dashboard/css/prints/receipt.css')); ?>" media="screen, print">

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
    .table-no-border.receipt thead th:nth-child(1), 
    .table-no-border.receipt td:nth-child(1), 
    .table-no-border.receipt .tfoot th:nth-child(1) {
      text-align: right;
    }
    .template-container .table-no-border tr td.temp-logo {
      float: none;
    }
    .table-no-border.receipt .exam-title {
      text-align: right !important;
    }
    </style>
    <?php endif; ?>
</head>
<body>

<?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="printable">
<div class="template-container" style="width: <?php echo e($print->width); ?>; height: <?php echo e($print->height); ?>;">
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

    <?php
        $enroll = \App\Models\Student::enroll($row->studentEnroll->student->id);
    ?>
    <!-- Header Section -->
    <table class="table-no-border top-meta-table">
        <tbody>
            <tr>
                <td class="meta-data"><?php echo e(__('field_student_id')); ?></td>
                <td class="meta-data value width2">: <?php echo e($row->studentEnroll->student->student_id ?? ''); ?></td>
                <td class="meta-data"><?php echo e(__('field_receipt')); ?></td>
                <td class="meta-data value">: <?php echo e($print->prefix ?? ''); ?><?php echo e(str_pad($row->id, 6, '0', STR_PAD_LEFT)); ?></td>
            </tr>
            <tr>
                <td class="meta-data"><?php echo e(__('field_name')); ?></td>
                <td class="meta-data value width2">: <?php echo e($row->studentEnroll->student->first_name ?? ''); ?> <?php echo e($row->studentEnroll->student->last_name ?? ''); ?></td>
                <td class="meta-data"><?php echo e(__('field_due_date')); ?></td>
                <td class="meta-data value">: 
                    <?php if(isset($setting->date_format)): ?>
                    <?php echo e(date($setting->date_format, strtotime($row->due_date))); ?>

                    <?php else: ?>
                    <?php echo e(date("Y-m-d", strtotime($row->due_date))); ?>

                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="meta-data"><?php echo e(__('field_program')); ?></td>
                <td class="meta-data value width2">: <?php echo e($row->studentEnroll->program->shortcode ?? ''); ?></td>
                <td class="meta-data"><?php echo e(__('field_pay_date')); ?></td>
                <td class="meta-data value">: 
                    <?php if(isset($setting->date_format)): ?>
                    <?php echo e(date($setting->date_format, strtotime($row->pay_date))); ?>

                    <?php else: ?>
                    <?php echo e(date("Y-m-d", strtotime($row->pay_date))); ?>

                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="meta-data"><?php echo e(__('field_session')); ?></td>
                <td class="meta-data value width2">: <?php echo e($enroll->session->title ?? ''); ?></td>
                <td class="meta-data"><?php echo e(__('field_payment_method')); ?></td>
                <td class="meta-data value">: 
                    <?php if( $row->payment_method == 1 ): ?>
                    <?php echo e(__('payment_method_card')); ?>

                    <?php elseif( $row->payment_method == 2 ): ?>
                    <?php echo e(__('payment_method_cash')); ?>

                    <?php elseif( $row->payment_method == 3 ): ?>
                    <?php echo e(__('payment_method_cheque')); ?>

                    <?php elseif( $row->payment_method == 4 ): ?>
                    <?php echo e(__('payment_method_bank')); ?>

                    <?php elseif( $row->payment_method == 5 ): ?>
                    <?php echo e(__('payment_method_e_wallet')); ?>

                    <?php elseif( $row->payment_method == 6 ): ?>
                    <?php echo e(__('PayPal')); ?>

                    <?php elseif( $row->payment_method == 7 ): ?>
                    <?php echo e(__('Stripe')); ?>

                    <?php elseif( $row->payment_method == 8 ): ?>
                    <?php echo e(__('RazorPay')); ?>

                    <?php elseif( $row->payment_method == 9 ): ?>
                    <?php echo e(__('PayStack')); ?>

                    <?php elseif( $row->payment_method == 10 ): ?>
                    <?php echo e(__('Flutterwave')); ?>

                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="meta-data"><?php echo e(__('field_semester')); ?></td>
                <td class="meta-data value width2">: <?php echo e($enroll->semester->title ?? ''); ?></td>
                <td class="meta-data"><?php echo e(__('field_batch')); ?></td>
                <td class="meta-data value">: <?php echo e($row->studentEnroll->student->batch->title ?? ''); ?></td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <!-- Header Section -->
    <table class="table-no-border receipt">
        <thead>
            <tr>
                <th class="width2"><?php echo e(__('field_fees_type')); ?></th>
                <th><?php echo e(__('field_amount')); ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" class="exam-title"><?php echo e($row->category->title ?? ''); ?></td>
            </tr>
            <tr class="border-bottom">
                <td><?php echo e(__('field_fee')); ?></td>
                <td>
                    <?php if(isset($setting->decimal_place)): ?>
                    <?php echo e(number_format((float)$row->fee_amount, $setting->decimal_place, '.', '')); ?> 
                    <?php else: ?>
                    <?php echo e(number_format((float)$row->fee_amount, 2, '.', '')); ?> 
                    <?php endif; ?> 
                    <?php echo $setting->currency_symbol; ?>

                </td>
            </tr>
            <tr class="border-bottom">
                <td><?php echo e(__('field_discount')); ?></td>
                <td>- 
                    <?php if(isset($setting->decimal_place)): ?>
                    <?php echo e(number_format((float)$row->discount_amount, $setting->decimal_place, '.', '')); ?> 
                    <?php else: ?>
                    <?php echo e(number_format((float)$row->discount_amount, 2, '.', '')); ?> 
                    <?php endif; ?> 
                    <?php echo $setting->currency_symbol; ?>

                </td>
            </tr>
            <tr class="border-bottom">
                <td><?php echo e(__('field_fine_amount')); ?></td>
                <td>+ 
                    <?php if(isset($setting->decimal_place)): ?>
                    <?php echo e(number_format((float)$row->fine_amount, $setting->decimal_place, '.', '')); ?> 
                    <?php else: ?>
                    <?php echo e(number_format((float)$row->fine_amount, 2, '.', '')); ?> 
                    <?php endif; ?> 
                    <?php echo $setting->currency_symbol; ?>

                </td>
            </tr>
            <tr class="tfoot">
                <th><?php echo e(__('field_total')); ?>:</th>
                <th>= 
                    <?php if(isset($setting->decimal_place)): ?>
                    <?php echo e(number_format((float)$row->paid_amount, $setting->decimal_place, '.', '')); ?> 
                    <?php else: ?>
                    <?php echo e(number_format((float)$row->paid_amount, 2, '.', '')); ?> 
                    <?php endif; ?> 
                    <?php echo $setting->currency_symbol; ?>

                </th>
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
                <td class="temp-footer">
                  <div class="inner">
                    <p><?php echo $print->footer_center; ?></p>
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
</html><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\fees-student\multi-print.blade.php ENDPATH**/ ?>