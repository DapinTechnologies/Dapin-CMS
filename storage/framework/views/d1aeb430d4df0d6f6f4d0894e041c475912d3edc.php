

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Payment Receipt #<?php echo e($payment->receipt_no ?? $payment->id); ?></h4>
                            <small class="d-block">Issued on: <?php echo e(now()->format('d/m/Y H:i')); ?></small>
                        </div>
                        <div class="text-right">
                            <img src="<?php echo e(asset('storage/logo.png')); ?>" alt="Institution Logo" style="height: 50px;">
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Institution Information -->
                    <div class="row mb-4">
                        <div class="col-12 text-center">
                            <h3><?php echo e(config('app.name')); ?></h3>
                            <p class="mb-1"><?php echo e(config('app.address')); ?></p>
                            <p class="mb-1">Phone: <?php echo e(config('app.phone')); ?> | Email: <?php echo e(config('app.email')); ?></p>
                            <p class="mb-1">Website: <?php echo e(config('app.url')); ?></p>
                            <hr class="my-2">
                        </div>
                    </div>

                    <!-- Payment and Student Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="border p-3 bg-light">
                                <h5 class="border-bottom pb-2">Payment Details</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Receipt No:</strong><br> <?php echo e($payment->receipt_no ?? 'N/A'); ?></p>
                                        <p><strong>Invoice No:</strong><br> <?php echo e($payment->invoice->invoice_no ?? 'N/A'); ?></p>
                                        <p><strong>Date:</strong><br> <?php echo e($payment->paid_at->format('d/m/Y H:i')); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Amount:</strong><br> <?php echo e(config('app.currency')); ?> <?php echo e(number_format($payment->amount, 2)); ?></p>
                                        <p><strong>Method:</strong><br> <?php echo e(ucfirst($payment->payment_method)); ?></p>
                                        <p><strong>Status:</strong><br> 
                                            <span class="badge badge-<?php echo e($payment->status === 'completed' ? 'success' : ($payment->status === 'pending' ? 'warning' : 'danger')); ?>">
                                                <?php echo e(ucfirst($payment->status)); ?>

                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <?php if($payment->reference_number): ?>
                                    <p><strong>Reference No:</strong> <?php echo e($payment->reference_number); ?></p>
                                <?php endif; ?>
                                <?php if($payment->is_installment && $payment->invoice): ?>
    <p><strong>Installment:</strong> 
        #<?php echo e($payment->installment_number); ?> 
        <?php if($payment->invoice->installments): ?>
            of <?php echo e($payment->invoice->installments->count()); ?>

        <?php endif; ?>
    </p>
<?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border p-3 bg-light">
                                <h5 class="border-bottom pb-2">Student Information</h5>
                                <?php if($payment->studentEnroll && $payment->studentEnroll->student): ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Name:</strong><br> <?php echo e($payment->studentEnroll->student->first_name); ?> <?php echo e($payment->studentEnroll->student->last_name); ?></p>
                                            <p><strong>Student ID:</strong><br> <?php echo e($payment->studentEnroll->student->student_id ?? $payment->studentEnroll->student->registration_no); ?></p>
                                            <p><strong>Phone:</strong><br> <?php echo e($payment->studentEnroll->student->phone ?? 'N/A'); ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Program:</strong><br> <?php echo e($payment->studentEnroll->program->title ?? 'N/A'); ?></p>
                                            <p><strong>Semester:</strong><br> <?php echo e($payment->studentEnroll->semester->title ?? 'N/A'); ?></p>
                                            <p><strong>Section:</strong><br> <?php echo e($payment->studentEnroll->section->title ?? 'N/A'); ?></p>
                                        </div>
                                    </div>
                                    <p><strong>Academic Year:</strong> <?php echo e($payment->studentEnroll->session->title ?? 'N/A'); ?></p>
                                <?php else: ?>
                                    <div class="alert alert-warning mb-0">
                                        Student enrollment information not found
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Fee Breakdown -->
                    <?php if($payment->invoice->fees->count() > 0): ?>
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="border p-3">
                                <h5 class="border-bottom pb-2">Fee Breakdown</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Fee Category</th>
                                                <th>Original Amount</th>
                                                <th>Discount</th>
                                                <th>Fine</th>
                                                <th>Amount Paid</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $payment->invoice->fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($fee->category->name ?? 'General Fee'); ?></td>
                                                <td><?php echo e(config('app.currency')); ?> <?php echo e(number_format($fee->fee_amount, 2)); ?></td>
                                                <td><?php echo e(config('app.currency')); ?> <?php echo e(number_format($fee->discount_amount, 2)); ?></td>
                                                <td><?php echo e(config('app.currency')); ?> <?php echo e(number_format($fee->fine_amount, 2)); ?></td>
                                                <td><?php echo e(config('app.currency')); ?> <?php echo e(number_format($fee->paid_amount, 2)); ?></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Financial Summary -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="border p-3">
                                <h5 class="border-bottom pb-2">Financial Summary</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="70%">Total Invoice Amount</th>
                                            <td width="30%" class="text-right"><?php echo e(config('app.currency')); ?> <?php echo e(number_format($payment->invoice->total_fee, 2)); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Previously Paid</th>
                                            <td class="text-right"><?php echo e(config('app.currency')); ?> <?php echo e(number_format($payment->invoice->amount_paid - $payment->amount, 2)); ?></td>
                                        </tr>
                                        <tr class="table-active">
                                            <th>This Payment</th>
                                            <td class="text-right"><?php echo e(config('app.currency')); ?> <?php echo e(number_format($payment->amount, 2)); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Total Paid To Date</th>
                                            <td class="text-right"><?php echo e(config('app.currency')); ?> <?php echo e(number_format($payment->invoice->amount_paid, 2)); ?></td>
                                        </tr>
                                        <tr class="table-info">
                                            <th>Remaining Balance</th>
                                            <td class="text-right"><?php echo e(config('app.currency')); ?> <?php echo e(number_format($payment->invoice->amount_due, 2)); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- M-Pesa Transaction Details -->
                    <?php if($payment->payment_method === 'mpesa'): ?>
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="border p-3">
                                <h5 class="border-bottom pb-2">M-Pesa Transaction Details</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Transaction Date</th>
                                            <td width="70%"><?php echo e($payment->paid_at->format('d/m/Y H:i')); ?></td>
                                        </tr>
                                        <tr>
                                            <th>M-Pesa Code</th>
                                            <td><?php echo e($payment->reference_number ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Phone Number</th>
                                            <td><?php echo e($payment->studentEnroll->student->phone ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Amount</th>
                                            <td><?php echo e(config('app.currency')); ?> <?php echo e(number_format($payment->amount, 2)); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Payment Terms and Notes -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="border p-3">
                                <h5 class="border-bottom pb-2">Payment Terms</h5>
                                <div class="alert alert-light mb-0">
                                    <ul class="mb-0 pl-3">
                                        <li>This is an official receipt for payment made</li>
                                        <li>Please retain this receipt for your records</li>
                                        <li>For any discrepancies, please contact accounts office within 7 days</li>
                                        <li>All payments are non-refundable</li>
                                        <li>Late payments may incur additional charges</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?php if($payment->notes): ?>
                            <div class="border p-3">
                                <h5 class="border-bottom pb-2">Payment Notes</h5>
                                <div class="alert alert-info mb-0">
                                    <?php echo e($payment->notes); ?>

                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Signatures -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="border-top pt-3 text-center">
                                <p>Student Signature</p>
                                <div class="signature-line mt-4"></div>
                                <p class="mt-2">Date: _________________________</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border-top pt-3 text-center">
                                <p>Authorized Signature</p>
                                <div class="signature-line mt-4"></div>
                                <p class="mt-2">Date: <?php echo e(now()->format('d/m/Y')); ?></p>
                                <p class="small text-muted">For: <?php echo e(config('app.name')); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Print and Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <button onclick="window.print()" class="btn btn-primary mr-2">
                                <i class="fas fa-print"></i> Print Receipt
                            </button>
                            <a href="<?php echo e(route('invoice.show', $payment->invoice_id)); ?>" class="btn btn-secondary mr-2">
                                <i class="fas fa-file-invoice"></i> View Invoice
                            </a>
                            <a href="<?php echo e(route('payment.receipt.download', $payment->id)); ?>" class="btn btn-success">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .card, .card * {
            visibility: visible;
        }
        .card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
        }
        .no-print {
            display: none !important;
        }
        .signature-line {
            border-top: 1px dashed #000;
            width: 70%;
            margin: 0 auto;
            height: 1px;
        }
    }
    .signature-line {
        border-top: 1px dashed #000;
        width: 70%;
        margin: 0 auto;
        height: 1px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\fees-student\receipt.blade.php ENDPATH**/ ?>