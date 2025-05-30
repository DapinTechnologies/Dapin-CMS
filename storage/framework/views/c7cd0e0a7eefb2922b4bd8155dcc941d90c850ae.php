<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,maximum-scale=1.0">
    <title><?php echo e($title); ?></title>
    
    <style type="text/css" media="print">
    @media print {
      @page { size: A4 landscape; margin: 10px; }  
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
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('dashboard/css/prints/book_token.css')); ?>" media="screen, print">

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
    </style>
    <?php endif; ?>
</head>
<body>

<?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="printable">
<div class="template-container">
  <div class="template-inner">
    <!-- Header Section -->
    <table class="table-no-border">
        <tbody>
            <tr>
                <td class="temp-title">
                  <h2><?php echo e($row->title); ?></h2>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <!-- Header Section -->
    <table class="table-no-border top-meta-table">
        <tbody>
            <tr>
                <td class="meta-data"><?php echo e(__('field_rack')); ?></td>
                <td class="meta-data value">: <?php echo e($row->section); ?></td>
                <td class="meta-data"><?php echo e(__('field_column')); ?></td>
                <td class="meta-data value">: <?php echo e($row->column); ?></td>
                <td class="meta-data"><?php echo e(__('field_row')); ?></td>
                <td class="meta-data value">: <?php echo e($row->row); ?></td>
            </tr>
        </tbody>
    </table>
    <!-- Header Section -->

    <br/>
    <?php
        $barcode = $row->isbn;
    ?>
    <?php if(strlen($barcode) <= 20): ?>
    <table class="table-no-border">
        <tbody>
            <tr>
                <td style="width: 10%; text-align: center;"></td>
                <td style="width: 80%; text-align: center; font-family: 'IDAHC39M Code 39 Barcode', Times, serif;">
                    <?php echo DNS1D::getBarcodeSVG($barcode, 'C39', 1, 50, '#000', false); ?>

                    <div>
                        <?php echo e($barcode); ?>

                    </div>
                </td>
                <td style="width: 10%; text-align: center;"></td>
            </tr>
        </tbody>
    </table>
    <?php else: ?>
    <?php echo e(__('Barcode value too large to print!')); ?>

    <?php endif; ?>
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
</html><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\book\print.blade.php ENDPATH**/ ?>