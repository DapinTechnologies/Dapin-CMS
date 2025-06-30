<?php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Setting;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

// Verify payment exists
if (!isset($payment)) {
    throw new Exception('Payment data not available');
}

// Safely access nested relationships
$student = $payment->invoice->studentEnroll->student ?? null;
$program = $payment->invoice->studentEnroll->program ?? null;
$session = $payment->invoice->studentEnroll->session ?? null;

// Calculate installments
$totalInstallments = $payment->is_installment 
    ? Payment::where('invoice_id', $payment->invoice_id)
        ->where('is_installment', true)
        ->count() 
    : 0;

// Get application settings
$setting = Setting::first();

// Calculate payment status FIRST
$isFullyPaid = abs($payment->invoice->amount_due) < 0.01; // Using floating point comparison
$paymentStatus = $isFullyPaid ? 'Fully Paid' : 'Partial Payment';
$statusColor = $isFullyPaid ? '#28a745' : '#ffc107';

// Generate verification text (now using the already defined $isFullyPaid)
$verificationText = "Payment Verification\n";
$verificationText .= "Institution: ".($setting->title ?? 'N/A')."\n";
$verificationText .= "Transaction ID: {$payment->transaction_id}\n";
$verificationText .= "Student: ".($student ? $student->first_name.' '.$student->last_name : 'N/A')."\n";
$verificationText .= "Amount: ".number_format($payment->amount, 2)." KES\n";
$verificationText .= "Date: ".($payment->paid_at?->format('d M Y') ?? 'N/A')."\n";
$verificationText .= "Status: ".($isFullyPaid ? 'Fully Paid' : 'Partial Payment');

// Load logo dynamically from public/uploads/setting directory
$logoPath = $setting && $setting->logo_path ? $setting->logo_path : null;
$logoUrl = $logoPath ? asset('storage/'.$logoPath) : null;

// Open in new tab if auto_print is enabled (but won't auto-print)
if($auto_print ?? false) {
    echo "<script>window.open('', '_blank');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt - <?php echo e($payment->transaction_id); ?></title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }
        body {
            font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.5;
            color: #333;
            padding: 5mm;
            margin: 0;
            background-color: #f8f9fa;
        }
        .receipt-container {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            padding: 15mm;
        }
        .status-badge {
            position: absolute;
            top: 15mm;
            right: 15mm;
            padding: 5mm 10mm;
            background-color: <?php echo e($statusColor); ?>;
            color: white;
            font-weight: bold;
            font-size: 11pt;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-transform: uppercase;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 8mm;
            position: relative;
        }
        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 4mm;
        }
        .logo {
            max-height: 25mm;
            max-width: 100%;
        }
        .institution-name {
            font-size: 14pt;
            font-weight: 700;
            margin-bottom: 2mm;
            color: #0056b3;
            letter-spacing: 0.5px;
        }
        .receipt-title {
            font-size: 16pt;
            font-weight: 700;
            margin: 5mm 0;
            text-align: center;
            padding-bottom: 3mm;
            color: #0056b3;
            position: relative;
        }
        .receipt-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 25%;
            width: 50%;
            height: 2px;
            background: linear-gradient(90deg, #0056b3, #ff6600);
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(80mm, 1fr));
            gap: 5mm;
            margin-bottom: 5mm;
        }
        .info-block {
            background: #f8f9fa;
            padding: 4mm;
            border-radius: 6px;
            border-left: 4px solid #0056b3;
        }
        .info-block p {
            margin: 2mm 0;
            font-size: 9pt;
            display: flex;
        }
        .info-label {
            font-weight: 600;
            min-width: 35mm;
            color: #555;
        }
        .info-value {
            font-weight: 500;
        }
        .table-container {
            margin: 5mm 0;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        .table th {
            background-color: #0056b3;
            color: white;
            padding: 3mm;
            text-align: left;
            font-weight: 600;
        }
        .table td {
            padding: 3mm;
            border-bottom: 1px solid #eee;
        }
        .table tr:last-child td {
            border-bottom: none;
        }
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 8mm;
            padding-top: 5mm;
            border-top: 1px dashed #ddd;
            align-items: flex-end;
        }
        .signature-box {
            width: 60mm;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #555;
            margin: 15mm auto 2mm;
            width: 80%;
        }
        .qr-container {
            text-align: center;
            background: #f8f9fa;
            padding: 3mm;
            border-radius: 6px;
            display: inline-block;
        }
        .qr-code {
            width: 30mm;
            height: 30mm;
            margin: 0 auto;
        }
        .footer {
            margin-top: 8mm;
            padding-top: 5mm;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 8pt;
            color: #777;
        }
        .amount-highlight {
            font-weight: 700;
            font-size: 10.5pt;
        }
        .amount-paid {
            color: #ff6600;
        }
        .amount-due {
            color: #0056b3;
        }
        .partial-payment {
            color: #ff6600;
            font-weight: 600;
            background-color: #fff8e6;
            padding: 2mm;
            border-radius: 4px;
            margin-top: 3mm;
            border-left: 3px solid #ffc107;
        }
        @media print {
            body {
                padding: 0;
                background: white;
            }
            .receipt-container {
                box-shadow: none;
                border-radius: 0;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
        .print-button {
            padding: 8px 16px;
            background: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.2s;
            margin: 10mm auto;
            display: block;
        }
        .print-button:hover {
            background: #003d7a;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="receipt-container">
        <div class="status-badge">
            <?php echo e($paymentStatus); ?>

        </div>

        <div class="receipt-header">
            <?php if($logoUrl): ?>
                <div class="logo-container">
                    <img src="<?php echo e($logoUrl); ?>" alt="Institution Logo" class="logo">
                </div>
            <?php endif; ?>
            <div class="institution-name"><?php echo e($setting->title ?? 'Institution Name'); ?></div>
            <div style="color: #666; font-size: 9pt;"><?php echo nl2br($setting->address ?? 'Institution Address'); ?></div>
            <div style="color: #666; font-size: 9pt; margin-top: 1mm;">
                Tel: <?php echo e($setting->phone ?? 'N/A'); ?> | Email: <?php echo e($setting->email ?? 'N/A'); ?>

            </div>
        </div>

        <div class="receipt-title">PAYMENT RECEIPT</div>

        <div class="grid">
            <div class="info-block">
                <p><span class="info-label">Receipt No:</span> <span class="info-value"><?php echo e($payment->transaction_id); ?></span></p>
                <p><span class="info-label">Date:</span> <span class="info-value"><?php echo e($payment->paid_at?->format('d M Y h:i A') ?? 'N/A'); ?></span></p>
                <p><span class="info-label">Invoice No:</span> <span class="info-value"><?php echo e($payment->invoice->invoice_no); ?></span></p>
            </div>
            <div class="info-block">
                <p><span class="info-label">Payment Method:</span> <span class="info-value"><?php echo e(ucfirst($payment->payment_method)); ?></span></p>
                <?php if(in_array($payment->payment_method, ['mpesa', 'bank']) && $payment->reference_number): ?>
                <p><span class="info-label">Reference No:</span> <span class="info-value"><?php echo e($payment->reference_number); ?></span></p>
                <?php endif; ?>
                <p><span class="info-label">Status:</span> <span class="info-value" style="color: <?php echo e($statusColor); ?>; font-weight: 600;">
                    <?php echo e($paymentStatus); ?>

                </span></p>
            </div>
        </div>

        <div class="grid">
            <div class="info-block">
                <?php if($student): ?>
                <p><span class="info-label">Student Name:</span> <span class="info-value"><?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></span></p>
                <p><span class="info-label">Student ID:</span> <span class="info-value"><?php echo e($student->student_id ?? 'N/A'); ?></span></p>
                <?php else: ?>
                <p><span class="info-label">Student:</span> <span class="info-value">Not Available</span></p>
                <?php endif; ?>
            </div>
            <div class="info-block">
                <?php if($program): ?>
                <p><span class="info-label">Program:</span> <span class="info-value"><?php echo e($program->title ?? 'N/A'); ?></span></p>
                <p><span class="info-label">Academic Year:</span> <span class="info-value"><?php echo e($session->title ?? 'N/A'); ?></span></p>
                <?php else: ?>
                <p><span class="info-label">Program:</span> <span class="info-value">Not Available</span></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount (KES)</th>
                        <?php if($payment->is_installment): ?>
                        <th>Installment</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $payment->invoice->fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($fee->category->title ?? 'Fee Category'); ?></td>
                        <td><?php echo e(number_format($fee->fee_amount, 2)); ?></td>
                        <?php if($payment->is_installment): ?>
                        <td></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr style="background-color: #fff8e6;">
                        <td><strong>Payment for Invoice <?php echo e($payment->invoice->invoice_no); ?></strong></td>
                        <td class="amount-highlight amount-paid"><?php echo e(number_format($payment->amount, 2)); ?></td>
                        <?php if($payment->is_installment): ?>
                        <td><?php echo e($payment->installment_number); ?>/<?php echo e($totalInstallments); ?></td>
                        <?php endif; ?>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td><strong>Invoice Total</strong></td>
                        <td><?php echo e(number_format($payment->invoice->total_fee, 2)); ?></td>
                        <?php if($payment->is_installment): ?>
                        <td></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <td><strong>Total Paid</strong></td>
                        <td class="amount-highlight amount-paid"><?php echo e(number_format($payment->amount, 2)); ?></td>
                        <?php if($payment->is_installment): ?>
                        <td></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <td><strong>Amount Due</strong></td>
                        <td class="amount-highlight amount-due"><?php echo e(number_format($payment->invoice->amount_due, 2)); ?></td>
                        <?php if($payment->is_installment): ?>
                        <td></td>
                        <?php endif; ?>
                    </tr>
                </tfoot>
            </table>
        </div>

        <?php if(!$isFullyPaid): ?>
        <div class="partial-payment">
            <strong>Note:</strong> This is a partial payment. Remaining balance: KES <?php echo e(number_format($payment->invoice->amount_due, 2)); ?>

        </div>
        <?php endif; ?>

        <div class="signature-section">
            <div class="signature-box">
                <p>Authorized Signature</p>
                <div class="signature-line"></div>
                <p style="margin-top: 2mm; font-size: 8pt;">Date: <?php echo e(date('d/m/Y')); ?></p>
            </div>
            <div class="qr-container">
                <?php echo QrCode::size(150)->generate($verificationText); ?>

                <p style="margin-top: 2mm; font-size: 8pt;">Scan to verify payment</p>
            </div>
        </div>

        <div class="footer">
            <div>Received with thanks on behalf of <?php echo e($setting->title ?? 'the Institution'); ?></div>
            <div style="margin-top: 1mm;">This is a computer generated receipt. No signature required.</div>
            <div style="margin-top: 2mm; color: #999;"><?php echo e(strip_tags($setting->copyright_text ?? '© '.date('Y').' '.($setting->title ?? 'Institution Name'))); ?></div>
        </div>
    </div>

    <button class="print-button no-print" onclick="window.print()">
        Print Receipt
    </button>

    <?php if($auto_print ?? false): ?>
    <script>
        // Only open in new tab if auto_print is enabled, but don't auto-print
        window.onload = function() {
            window.open('', '_blank');
        };
    </script>
    <?php endif; ?>
</body>
</html><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/fees-student/receipt-pdf.blade.php ENDPATH**/ ?>