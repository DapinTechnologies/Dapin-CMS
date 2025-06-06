<?php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use App\Models\Setting;
    use App\Models\Payment;
    use App\Models\Invoice;
    use App\Models\Fee;
    use Illuminate\Support\Facades\DB;
    
    $setting = Setting::first();
    $appSetting = DB::table('application_settings')->first();
    
    // Calculate total installments
    $totalInstallments = $payment->is_installment ? Payment::where('invoice_id', $payment->invoice_id)
        ->where('is_installment', true)
        ->count() : 0;
    
    // Get the invoice with student enrollment info
    $invoice = Invoice::with([
        'studentEnroll.student', 
        'studentEnroll.program',
        'studentEnroll.session'
    ])->find($payment->invoice_id);
    
    // Get fees for this student enrollment
    $fees = [];
    if ($invoice && $invoice->student_enroll_id) {
        $fees = Fee::with('category')
            ->where('student_enroll_id', $invoice->student_enroll_id)
            ->where('status', 1)
            ->get();
    }

    // Generate verification text for QR code
    $verificationText = "Payment Verification\n";
    $verificationText .= "Transaction ID: {$payment->transaction_id}\n";
    $verificationText .= "Amount: KES ".number_format($payment->amount, 2)."\n";
    $verificationText .= "Date: ".$payment->paid_at->format('d M Y');

    // Get logo path
    $logoPath = $setting && $setting->logo_path ? 
        public_path($setting->logo_path) : 
        null;
    $logoUrl = $setting && $setting->logo_path ? 
        asset($setting->logo_path) : 
        null;

    // Generate the HTML content
    $htmlContent = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Official Receipt - '.$payment->transaction_id.'</title>
        <style>
            body {
                font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                font-size: 12px;
                line-height: 1.4;
                padding: 15px;
                margin: 0;
                color: #333;
            }
            .receipt {
                width: 100%;
                max-width: 800px;
                margin: 0 auto;
                border: 1px solid #e0e0e0;
                border-radius: 5px;
                padding: 15px;
                box-sizing: border-box;
            }
            .header {
                text-align: center;
                margin-bottom: 15px;
                padding-bottom: 10px;
                border-bottom: 1px solid #e0e0e0;
            }
            .header img {
                max-height: 60px;
                margin-bottom: 5px;
            }
            .institution-name {
                font-size: 18px;
                font-weight: 700;
                margin-bottom: 3px;
            }
            .institution-details {
                font-size: 11px;
                margin-bottom: 5px;
            }
            .receipt-title {
                text-align: center;
                font-size: 16px;
                font-weight: 600;
                margin: 10px 0;
            }
            .meta, .student-info {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
                flex-wrap: wrap;
            }
            .info-block {
                flex: 1;
                min-width: 200px;
                margin-bottom: 5px;
            }
            .info-block p {
                margin: 3px 0;
                font-size: 11px;
            }
            .info-label {
                font-weight: 600;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 10px 0;
                font-size: 11px;
            }
            table th {
                background-color: #2c3e50;
                color: white;
                text-align: left;
                padding: 8px;
            }
            table td {
                padding: 8px;
                border-bottom: 1px solid #e0e0e0;
            }
            table tfoot td {
                font-weight: bold;
                background-color: #f5f5f5;
            }
            .signature-section {
                display: flex;
                justify-content: space-between;
                align-items: flex-end;
                margin-top: 15px;
                padding-top: 10px;
                border-top: 1px dashed #e0e0e0;
            }
            .signature-box {
                width: 150px;
                text-align: center;
                font-size: 11px;
            }
            .signature-line {
                border-top: 1px solid #333;
                margin-top: 30px;
                padding-top: 3px;
            }
            .qr-container {
                text-align: right;
                padding: 5px;
                display: inline-block;
            }
            .qr-text {
                font-size: 9px;
                margin-top: 3px;
            }
            .footer {
                margin-top: 15px;
                padding-top: 10px;
                border-top: 1px solid #e0e0e0;
                text-align: center;
                font-size: 10px;
            }
            .footer-message {
                margin: 5px 0;
            }
            .contact-info {
                margin: 8px 0;
            }
            .copyright {
                font-size: 9px;
                margin-top: 10px;
            }
            .amount-paid {
                color: #27ae60;
                font-weight: bold;
            }
            .amount-due {
                color: #e74c3c;
                font-weight: bold;
            }
            .installment-notice {
                background-color: rgba(243, 156, 18, 0.1);
                padding: 8px;
                border-left: 3px solid #f39c12;
                margin-bottom: 10px;
                border-radius: 0 3px 3px 0;
                font-size: 11px;
            }
            .payment-details {
                margin: 10px 0;
            }
            .payment-details-title {
                font-size: 13px;
                font-weight: 600;
                margin-bottom: 5px;
            }
            @media print {
                body {
                    padding: 0;
                }
                .receipt {
                    border: none;
                    padding: 10px;
                }
                .no-print {
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <div class="receipt">
            <div class="header">
                '.($logoUrl ? '<img src="'.$logoUrl.'" alt="Institution Logo">' : '').'
                <div class="institution-name">'.($setting->title ?? 'Institution Name').'</div>
                <div class="institution-details">
                    '.nl2br($setting->address ?? 'Institution Address').'
                    <br>Tel: '.($setting->phone ?? 'N/A').' | Email: '.($setting->email ?? 'N/A').'
                </div>
            </div>

            <div class="receipt-title">OFFICIAL PAYMENT RECEIPT</div>

            '.($payment->is_installment ? '
            <div class="installment-notice">
                <strong>INSTALLMENT PAYMENT:</strong> This is installment '.$payment->installment_number.' of '.$totalInstallments.'
            </div>' : '').'

            <div class="meta">
                <div class="info-block">
                    <p><span class="info-label">Receipt No:</span> '.$payment->transaction_id.'</p>
                    <p><span class="info-label">Date:</span> '.\Carbon\Carbon::parse($payment->paid_at)->format('d M Y h:i A').'</p>
                    <p><span class="info-label">Invoice No:</span> '.$invoice->invoice_no.'</p>
                </div>
                <div class="info-block">
                    <p><span class="info-label">Payment Method:</span> '.ucfirst($payment->payment_method).'</p>
                    '.(in_array($payment->payment_method, ['mpesa', 'bank']) ? '
                    <p><span class="info-label">Reference No:</span> '.$payment->reference_number.'</p>' : '').'
                    '.($payment->confirmed_by ? '
                    <p><span class="info-label">Processed By:</span> '.$payment->confirmed_by.'</p>' : '').'
                </div>
            </div>

            <div class="student-info">
                <div class="info-block">
                    '.($invoice->studentEnroll && $invoice->studentEnroll->student ? '
                    <p><span class="info-label">Student:</span> 
                        '.$invoice->studentEnroll->student->first_name.' 
                        '.$invoice->studentEnroll->student->last_name.'
                    </p>
                    <p><span class="info-label">Student ID:</span> '.($invoice->studentEnroll->student->student_id ?? 'N/A').'</p>' : '
                    <p><span class="info-label">Student:</span> Not Available</p>').'
                </div>
                <div class="info-block">
                    '.($invoice->studentEnroll && $invoice->studentEnroll->program ? '
                    <p><span class="info-label">Program:</span> '.($invoice->studentEnroll->program->title ?? 'N/A').'</p>
                    <p><span class="info-label">Academic Year:</span> '.($invoice->studentEnroll->session->title ?? 'N/A').'</p>' : '
                    <p><span class="info-label">Program:</span> Not Available</p>').'
                </div>
            </div>

            <div class="payment-details">
                <div class="payment-details-title">Payment Details</div>
                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Amount (KES)</th>
                            '.($payment->is_installment ? '
                            <th>Installment</th>' : '').'
                        </tr>
                    </thead>
                    <tbody>
                        '.implode('', array_map(function($fee) use ($payment) {
                            return '
                            <tr>
                                <td>'.($fee->category->title ?? 'Fee Category').'</td>
                                <td>'.number_format($fee->fee_amount, 2).'</td>
                                '.($payment->is_installment ? '
                                <td></td>' : '').'
                            </tr>';
                        }, $invoice->fees->all())).'
                        <tr>
                            <td>Payment for Invoice '.$invoice->invoice_no.'</td>
                            <td>'.number_format($payment->amount, 2).'</td>
                            '.($payment->is_installment ? '
                            <td>'.$payment->installment_number.'/'.$totalInstallments.'</td>' : '').'
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Total Paid</strong></td>
                            <td class="amount-paid">'.number_format($payment->amount, 2).'</td>
                            '.($payment->is_installment ? '
                            <td></td>' : '').'
                        </tr>
                        <tr>
                            <td><strong>Invoice Total</strong></td>
                            <td>'.number_format($invoice->total_fee, 2).'</td>
                            '.($payment->is_installment ? '
                            <td></td>' : '').'
                        </tr>
                        <tr>
                            <td><strong>Amount Due</strong></td>
                            <td class="amount-due">'.number_format($invoice->amount_due, 2).'</td>
                            '.($payment->is_installment ? '
                            <td></td>' : '').'
                        </tr>
                    </tfoot>
                </table>
            </div>

            '.($payment->notes ? '
            <div class="notes">
                <p><strong>Notes:</strong> '.$payment->notes.'</p>
            </div>' : '').'

            <div class="signature-section">
                <div class="signature-box">
                    <p>Authorized Signature</p>
                    <div class="signature-line"></div>
                    <p>Date: '.\Carbon\Carbon::now()->format('d/m/Y').'</p>
                </div>
                <div class="qr-container">
                    '.QrCode::size(80)->generate($verificationText).'
                    <div class="qr-text">Scan to verify</div>
                </div>
            </div>

            <div class="footer">
                <div class="footer-message">Received with thanks on behalf of '.($setting->title ?? 'the Institution').'</div>
                <div class="footer-message">This is a computer generated receipt. No signature required.</div>
                
                <div class="contact-info">
                    '.nl2br($setting->address ?? '').'<br>
                    Tel: '.($setting->phone ?? '').' | Email: '.($setting->email ?? '').'
                </div>
                
                <div class="copyright">
                    '.strip_tags($setting->copyright_text ?? '© '.date('Y').' '.($setting->title ?? 'Institution Name')).'
                </div>
            </div>
        </div>
    </body>
    </html>';

    // Check if Browsershot is available
    $browsershotAvailable = class_exists('Spatie\Browsershot\Browsershot');
    
    // Generate PDF and image only if Browsershot is available
    if ($browsershotAvailable) {
        try {
            $pdfContent = Spatie\Browsershot\Browsershot::html($htmlContent)
                ->format('A4')
                ->margins(5, 5, 5, 5)
                ->pdf();

            $imageContent = Spatie\Browsershot\Browsershot::html($htmlContent)
                ->windowSize(800, 1200)
                ->screenshot();
        } catch (Exception $e) {
            // Handle error if Browsershot fails
            $browsershotAvailable = false;
        }
    }
?>

<!-- Display the receipt -->
<?php echo $htmlContent; ?>


<!-- Download buttons -->
<div class="no-print" style="text-align: center; margin-top: 10px;">
    <?php if($browsershotAvailable): ?>
        <form action="<?php echo e(route('receipt.download')); ?>" method="POST" target="_blank" style="display: inline-block;">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="type" value="pdf">
            <input type="hidden" name="html" value="<?php echo e(base64_encode($htmlContent)); ?>">
            <button type="submit" style="padding: 8px 12px; background: #4CAF50; color: white; border: none; border-radius: 3px; margin-right: 5px; cursor: pointer; font-size: 12px;">
                Download PDF
            </button>
        </form>
        
        <form action="<?php echo e(route('receipt.download')); ?>" method="POST" target="_blank" style="display: inline-block;">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="type" value="image">
            <input type="hidden" name="html" value="<?php echo e(base64_encode($htmlContent)); ?>">
            <button type="submit" style="padding: 8px 12px; background: #2196F3; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 12px;">
                Download Image
            </button>
        </form>
    <?php endif; ?>
    
    <button onclick="window.print()" style="padding: 8px 12px; background: #607d8b; color: white; border: none; border-radius: 3px; margin-left: 5px; cursor: pointer; font-size: 12px;">
        Print Receipt
    </button>
</div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\fees-student\receipt-pdf.blade.php ENDPATH**/ ?>