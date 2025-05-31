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
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('dashboard/css/prints/pay_slip.css')); ?>" media="screen, print">

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
    .table-no-border.receipt tbody td:nth-child(1), 
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

<div class="template-container printable" style="width: <?php echo e($print->width); ?>; height: <?php echo e($print->height); ?>;">
  <div class="template-inner">
    <!-- Header Section -->
    <table class="table-no-border">
        <tbody>
            <tr>
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

    <!-- Header Section -->
    <table class="table-no-border top-meta-table">
        <tbody>
            <tr>
                <td class="meta-data"><?php echo e(__('field_staff_id')); ?></td>
                <td class="meta-data value width2">: <?php echo e($row->user->staff_id ?? ''); ?></td>
                <td class="meta-data"><?php echo e(__('field_receipt')); ?></td>
                <td class="meta-data value">: <?php echo e($print->prefix ?? ''); ?><?php echo e(str_pad($row->id, 6, '0', STR_PAD_LEFT)); ?></td>
            </tr>
            <tr>
                <td class="meta-data"><?php echo e(__('field_name')); ?></td>
                <td class="meta-data value width2">: <?php echo e($row->user->first_name ?? ''); ?> <?php echo e($row->user->last_name ?? ''); ?></td>
                <td class="meta-data"><?php echo e(__('field_salary_type')); ?></td>
                <td class="meta-data value">: 
                    <?php if( $row->salary_type == 1 ): ?>
                    <?php echo e(__('salary_type_fixed')); ?>

                    <?php elseif( $row->salary_type == 2 ): ?>
                    <?php echo e(__('salary_type_hourly')); ?>

                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="meta-data"><?php echo e(__('field_department')); ?></td>
                <td class="meta-data value width2">: <?php echo e($row->user->department->title ?? ''); ?></td>
                <td class="meta-data"><?php echo e(__('field_pay_date')); ?></td>
                <td class="meta-data value">: 
                    <?php if($row->status == 1): ?>
                    <?php if(isset($setting->date_format)): ?>
                    <?php echo e(date($setting->date_format, strtotime($row->pay_date))); ?>

                    <?php else: ?>
                    <?php echo e(date("Y-m-d", strtotime($row->pay_date))); ?>

                    <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="meta-data"><?php echo e(__('field_designation')); ?></td>
                <td class="meta-data value width2">: <?php echo e($row->user->designation->title ?? ''); ?></td>
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

                    <?php endif; ?>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <!-- Header Section -->
    <table class="table-no-border receipt">
        <thead>
            <tr>
                <th class="width2"><?php echo e(__('field_type')); ?></th>
                <th><?php echo e(__('field_amount')); ?></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="2" class="exam-title">
                    <?php echo e(date("F Y", strtotime($row->salary_month))); ?>

                </td>
            </tr>
            <tr class="border-bottom">
                <td><?php echo e(__('field_total_earning')); ?></td>
                <td><?php echo e(number_format((float)$row->total_earning, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
            </tr>
            <?php $__currentLoopData = $row->details->where('status', 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="border-bottom">
                <td><?php echo e($detail->title); ?></td>
                <td>+ <?php echo e(number_format((float)$detail->amount, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php $__currentLoopData = $row->details->where('status', 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="border-bottom">
                <td><?php echo e($detail->title); ?></td>
                <td>- <?php echo e(number_format((float)$detail->amount, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr class="border-bottom">
                <td><?php echo e(__('field_gross_salary')); ?></td>
                <td>~ <?php echo e(number_format((float)$row->gross_salary, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
            </tr>
            <tr class="border-bottom">
                <td><?php echo e(__('field_tax')); ?></td>
                <td>- <?php echo e(number_format((float)$row->tax, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
            </tr>
            <tr class="tfoot">
                <th><?php echo e(__('field_net_salary')); ?>:</th>
                <th>= <?php echo e(number_format((float)$row->net_salary, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></th>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <!-- Header Section -->
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
</html><?php /**PATH /home7/httpurba/public_html/college/resources/views/admin/payroll/print.blade.php ENDPATH**/ ?>