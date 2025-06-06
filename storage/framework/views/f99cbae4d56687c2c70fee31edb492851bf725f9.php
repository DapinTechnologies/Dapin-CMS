<!DOCTYPE html>
<html>
<head>
    <title>Invoice <?php echo e($invoice->invoice_no); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 15px;
            color: #333;
            line-height: 1.4;
        }
        
        .invoice-container {
            max-width: 700px;
            margin: 0 auto;
            padding: 15px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .institution-header {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .institution-header h1 {
            margin: 0;
            font-size: 18px;
            color: #2c3e50;
        }
        
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .invoice-info {
            text-align: right;
        }
        
        .invoice-info h2 {
            margin: 0 0 5px 0;
            color: #2c3e50;
            font-size: 18px;
        }
        
        .student-info {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .info-column {
            width: 50%;
            padding: 0 5px;
        }
        
        h4 {
            margin: 0 0 8px 0;
            color: #2c3e50;
            font-size: 12px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 9px;
        }
        
        th {
            background-color: #f8f9fa;
            text-align: left;
            padding: 6px;
            border: 1px solid #e0e0e0;
            font-weight: 600;
        }
        
        td {
            padding: 6px;
            border: 1px solid #e0e0e0;
        }
        
        .summary-table {
            width: 60%;
            margin-left: auto;
            margin-bottom: 15px;
        }
        
        .total-row {
            font-weight: bold;
            border-top: 2px solid #2c3e50;
        }
        
        .balance-row {
            font-weight: bold;
            border-top: 2px solid #2c3e50;
            border-bottom: 2px solid #2c3e50;
        }
        
        .invoice-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            font-size: 9px;
        }
        
        .footer-column {
            width: 48%;
        }
        
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            display: inline-block;
            font-size: 9px;
            font-weight: 600;
        }
        
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .pending-stamp {
            position: absolute;
            top: 30px;
            left: 50px;
            background-color: #dc3545;
            color: white;
            padding: 8px 15px;
            transform: rotate(-15deg);
            font-weight: bold;
            font-size: 16px;
            opacity: 0.8;
            border-radius: 3px;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-bold {
            font-weight: 600;
        }
        
        .mb-10 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <?php if($invoice->payment_status == 'pending'): ?>
            <div class="pending-stamp">PENDING</div>
        <?php endif; ?>

        <div class="institution-header">
            <h1><?php echo e(\App\Models\Setting::first()->title ?? 'Your Institution'); ?></h1>
        </div>

        <div class="invoice-header">
            <div class="logo">
                <?php if(\App\Models\Setting::first()->logo_path && file_exists(public_path(\App\Models\Setting::first()->logo_path))): ?>
                    <img src="<?php echo e(public_path(\App\Models\Setting::first()->logo_path)); ?>" alt="Institution Logo" width="120">
                <?php endif; ?>
            </div>
            <div class="invoice-info">
                <h2>INVOICE</h2>
                <p><strong>No:</strong> <?php echo e($invoice->invoice_no); ?></p>
                <p><strong>Date:</strong> <?php echo e(\Carbon\Carbon::parse($invoice->assign_date)->format('d/m/Y')); ?></p>
                <p><strong>Due:</strong> <?php echo e(\Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y')); ?></p>
            </div>
        </div>

        <div class="student-info">
            <div class="info-column">
                <h4>STUDENT INFORMATION</h4>
                <p class="mb-10"><strong>ID:</strong> <?php echo e($invoice->studentEnroll->student->student_id ?? 'N/A'); ?></p>
                <p class="mb-10"><strong>Name:</strong> <?php echo e($invoice->studentEnroll->student->full_name ?? 'N/A'); ?></p>
                <p class="mb-10"><strong>Program:</strong> <?php echo e($invoice->studentEnroll->program->title ?? 'N/A'); ?></p>
            </div>
            <div class="info-column">
                <h4>PAYMENT STATUS</h4>
                <p class="mb-10"><strong>Status:</strong> 
                    <span class="badge <?php echo e($invoice->payment_status == 'paid' ? 'badge-success' : 'badge-danger'); ?>">
                        <?php echo e(ucfirst($invoice->payment_status)); ?>

                    </span>
                </p>
                <p class="mb-10"><strong>Balance:</strong> <?php echo e(number_format($invoice->amount_due, 2)); ?></p>
                <p class="mb-10"><strong>Phone:</strong> <?php echo e($invoice->studentEnroll->student->phone ?? 'N/A'); ?></p>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fee Type</th>
                    <th>Amount</th>
                    <th>Assign Date</th>
                    <th>Due Date</th>
                </tr>
       <tbody>
    <?php $counter = 1; ?>
    <?php $__empty_1 = true; $__currentLoopData = $invoice->fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($counter++); ?></td>
            <td>
                <?php echo e($fee->category->title ?? 'Tuition Fee'); ?>

            </td>
            <td><?php echo e(number_format($fee->fee_amount, 2)); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($fee->assign_date)->format('d M Y')); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($fee->due_date)->format('d M Y')); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="5" class="text-center">No fee items found</td>
        </tr>
    <?php endif; ?>
</tbody>
        </table>

        <table class="summary-table">
            <tr>
                <th>Subtotal:</th>
                <td class="text-right"><?php echo e(number_format($invoice->fees->sum('fee_amount') > 0 ? $invoice->fees->sum('fee_amount') : $invoice->total_fee, 2)); ?></td>
            </tr>
            <?php if($invoice->fees->sum('fine_amount') > 0): ?>
            <tr>
                <th>Late Fees:</th>
                <td class="text-right"><?php echo e(number_format($invoice->fees->sum('fine_amount'), 2)); ?></td>
            </tr>
            <?php endif; ?>
            <?php if($invoice->fees->sum('discount_amount') > 0): ?>
            <tr>
                <th>Discounts:</th>
                <td class="text-right">-<?php echo e(number_format($invoice->fees->sum('discount_amount'), 2)); ?></td>
            </tr>
            <?php endif; ?>
            <tr class="total-row">
                <th>TOTAL DUE:</th>
                <td class="text-right"><?php echo e(number_format($invoice->total_fee, 2)); ?></td>
            </tr>
            <tr>
                <th>Amount Paid:</th>
                <td class="text-right"><?php echo e(number_format($invoice->amount_paid, 2)); ?></td>
            </tr>
            <tr class="balance-row">
                <th>BALANCE:</th>
                <td class="text-right"><?php echo e(number_format($invoice->amount_due, 2)); ?></td>
            </tr>
        </table>

        <div class="invoice-footer">
            <div class="footer-column">
                <h4>PAYMENT INSTRUCTIONS</h4>
                <p class="mb-10">1. Make payment by the due date to avoid penalties.</p>
                <p class="mb-10">2. Quote invoice number as reference.</p>
                <p class="mb-10">3. Contact accounts office for discrepancies.</p>
            </div>
            <div class="footer-column">
                <h4>PAYMENT METHODS</h4>
                <p class="mb-10 text-bold">BANK TRANSFER</p>
                <p class="mb-10"><?php echo e($bankDetails->bank_name ?? 'Kenya Commercial Bank (KCB)'); ?></p>
                <p class="mb-10">Acc Name: <?php echo e(\App\Models\Setting::first()->title ?? 'Your Institution'); ?></p>
                <p class="mb-10">Acc No: <?php echo e($bankDetails->bank_account ?? '12968644'); ?></p>
                
                <p class="mb-10 text-bold">M-PESA</p>
                <p class="mb-10">Paybill: 123456</p>
                <p class="mb-10">Account: <?php echo e($invoice->studentEnroll->student->student_id ?? 'N/A'); ?></p>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\fees-student\pdf.blade.php ENDPATH**/ ?>