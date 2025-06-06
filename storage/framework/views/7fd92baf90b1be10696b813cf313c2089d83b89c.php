

<?php $__env->startSection('content'); ?>
<div class="container">
    <form method="POST" action="<?php echo e(route('payments.store', $invoice->id)); ?>" id="payment-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="invoice_id" value="<?php echo e($invoice->id); ?>">
        <input type="hidden" name="student_enroll_id" value="<?php echo e($invoice->student_enroll_id); ?>">

        <div class="card">
            <div class="card-header">Payment for Invoice #<?php echo e($invoice->invoice_no); ?></div>
            <div class="card-body">
                <div class="alert alert-info">
                    <ul>
                        <li>Total Fee: KES <?php echo e(number_format($invoice->total_fee, 2)); ?></li>
                        <li>Paid: KES <?php echo e(number_format($invoice->amount_paid, 2)); ?></li>
                        <li>Balance: KES <?php echo e(number_format($invoice->amount_due, 2)); ?></li>
                    </ul>
                </div>

                <div class="form-group">
                    <label>Amount to Pay</label>
                    <input type="number" step="0.01" min="0" max="<?php echo e($invoice->amount_due); ?>"
                        name="amount" id="amount" class="form-control" value="<?php echo e(old('amount', $invoice->amount_due)); ?>" required>
                </div>

                <div class="form-group">
                    <label>Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="">Select Method</option>
                        <option value="mpesa">M-Pesa</option>
                        <option value="bank">Bank</option>
                        <option value="cash">Cash</option>
                    </select>
                </div>

                <div class="form-group" id="ref-div" style="display:none;">
                    <label>Reference Number</label>
                    <input type="text" name="reference_number" class="form-control">
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_installment" id="is_installment" value="1">
                    <label class="form-check-label" for="is_installment">Pay as Installment</label>
                </div>

                <div id="fee-section" style="display:none;">
                    <h5>Allocate Amounts to Categories</h5>
                    <?php $__currentLoopData = $invoice->feeCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $paid = $previousPayments[$cat->id] ?? 0;
                            $balance = $cat->amount - $paid;
                        ?>
                        <?php if($balance > 0): ?>
                        <div class="form-group">
                            <label><?php echo e($cat->title); ?> (Balance: KES <?php echo e(number_format($balance, 2)); ?>)</label>
                            <input type="number" step="0.01" min="0" max="<?php echo e($balance); ?>"
                                   name="fee_amounts[<?php echo e($cat->id); ?>]" class="form-control fee-amount-input"
                                   value="<?php echo e(old('fee_amounts.' . $cat->id)); ?>">
                        </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="form-group">
                    <label>Notes</label>
                    <textarea name="notes" class="form-control"></textarea>
                </div>

                <button type="button" class="btn btn-warning" onclick="openSummaryModal()">Review Summary</button>
                <button type="submit" class="btn btn-primary">Submit Payment</button>
            </div>
        </div>
    </form>

    <!-- Summary Modal -->
    <div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">Confirm Payment Summary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Total Amount:</strong> KES <span id="modalAmount"></span></p>
                    <p><strong>Method:</strong> <span id="modalMethod"></span></p>
                    <p><strong>Installment:</strong> <span id="modalInstallment"></span></p>
                    <p><strong>Fee Breakdown:</strong></p>
                    <ul id="modalBreakdown"></ul>
                    <p><strong>Notes:</strong> <span id="modalNotes"></span></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" onclick="document.getElementById('payment-form').submit()">Confirm & Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment History Table -->
    <?php if($invoice->payments->count()): ?>
        <div class="mt-4">
            <h5>Past Payments</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount (KES)</th>
                        <th>Method</th>
                        <th>Ref No</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $invoice->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($pay->paid_at->format('d M Y')); ?></td>
                            <td><?php echo e(number_format($pay->amount, 2)); ?></td>
                            <td><?php echo e(ucfirst($pay->payment_method)); ?></td>
                            <td><?php echo e($pay->reference_number ?? '-'); ?></td>
                            <td><?php echo e(ucfirst($pay->status)); ?></td>
                            <td>
                                <a href="<?php echo e(route('payments.receipt', $pay)); ?>" target="_blank" class="btn btn-sm btn-primary">View Receipt</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const method = document.getElementById('payment_method');
    const refDiv = document.getElementById('ref-div');
    const installment = document.getElementById('is_installment');
    const feeSection = document.getElementById('fee-section');

    method.addEventListener('change', () => {
        refDiv.style.display = (method.value === 'mpesa' || method.value === 'bank') ? 'block' : 'none';
    });

    installment.addEventListener('change', () => {
        feeSection.style.display = installment.checked ? 'block' : 'none';
    });
});

function openSummaryModal() {
    const modal = new bootstrap.Modal(document.getElementById('summaryModal'));
    const amount = document.getElementById('amount').value;
    const method = document.getElementById('payment_method').value;
    const isInstallment = document.getElementById('is_installment').checked;
    const notes = document.querySelector('textarea[name="notes"]').value;

    document.getElementById('modalAmount').textContent = parseFloat(amount).toFixed(2);
    document.getElementById('modalMethod').textContent = method;
    document.getElementById('modalInstallment').textContent = isInstallment ? 'Yes' : 'No';
    document.getElementById('modalNotes').textContent = notes || 'None';

    const breakdownList = document.getElementById('modalBreakdown');
    breakdownList.innerHTML = '';

    if (isInstallment) {
        document.querySelectorAll('.fee-amount-input').forEach(input => {
            const label = input.previousElementSibling.textContent;
            const value = parseFloat(input.value || 0).toFixed(2);
            if (!isNaN(value) && value >= 0) {
                const li = document.createElement('li');
                li.textContent = `${label.trim()}: KES ${value}`;
                breakdownList.appendChild(li);
            }
        });
    } else {
        const li = document.createElement('li');
        li.textContent = 'Not applicable for full payment';
        breakdownList.appendChild(li);
    }

    modal.show();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\fees-student\payment.blade.php ENDPATH**/ ?>