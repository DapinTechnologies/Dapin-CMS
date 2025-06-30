<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Advance Allocations</h5>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle btn-icon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="feather icon-more-vertical"></i>
                                </button>
                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-end">
                                    <li><a href="<?php echo e(route($route.'.index')); ?>" class="dropdown-item"><i class="fas fa-list"></i> View Payment History</a></li>
                                    <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#batchBursaryModal"><i class="fas fa-users"></i> Batch Bursary Allocation</a></li>
                                    <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reconciliationModal"><i class="fas fa-exchange-alt"></i> Payment Reconciliation</a></li>
                                    <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#bursaryFundModal"><i class="fas fa-plus-circle"></i> Create New Bursary Fund</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.quick.received.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-6">
                            <label for="student"><?php echo e(__('field_student_id')); ?> <span>*</span></label>
                            <select class="form-control select2" name="student" id="student" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($student->id); ?>" data-balance="<?php echo e($student->outstanding_balance ?? 0); ?>" <?php if(old('student') == $student->id): ?> selected <?php endif; ?>>
                                    <?php echo e($student->student->student_id ?? ''); ?> - <?php echo e($student->student->first_name ?? ''); ?> <?php echo e($student->student->last_name ?? ''); ?>

                                    <?php if(isset($student->outstanding_balance)): ?> (Balance: <?php echo e($setting->currency_symbol); ?><?php echo e(number_format($student->outstanding_balance, 2)); ?>) <?php endif; ?>
                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="invalid-feedback">
                                <?php echo e(__('required_field')); ?> <?php echo e(__('field_student_id')); ?>

                            </div>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="invoice"><?php echo e(__('Select Invoice')); ?></label>
                            <select class="form-control select2" name="invoice" id="invoice">
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php if(isset($invoices)): ?>
                                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($invoice->id); ?>" data-amount="<?php echo e($invoice->amount); ?>" data-balance="<?php echo e($invoice->balance); ?>">
                                            INV-<?php echo e($invoice->id); ?> (<?php echo e($setting->currency_symbol); ?><?php echo e(number_format($invoice->amount, 2)); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="category"><?php echo e(__('field_fees_type')); ?> <span>*</span></label>
                            <select class="form-control" name="category" id="category" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php if(old('category') == $category->id): ?> selected <?php endif; ?>><?php echo e($category->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_fees_type')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="due_date" class="form-label"><?php echo e(__('field_due_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="due_date" id="due_date" value="<?php echo e(date('Y-m-d')); ?>" required>
                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_due_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="pay_date" class="form-label"><?php echo e(__('field_pay_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="pay_date" id="pay_date" value="<?php echo e(date('Y-m-d')); ?>" required>
                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_pay_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="fee_amount" class="form-label"><?php echo e(__('field_fee')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="fee_amount" id="fee_amount" value="<?php echo e(old('fee_amount') ?? 0); ?>" onkeyup="feesCalculator()" required>
                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_fee')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="discount_amount" class="form-label">Waiver (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control autonumber" name="discount_amount" id="discount_amount" value="<?php echo e(old('discount_amount') ?? 0); ?>" onkeyup="feesCalculator()" required>
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#waiverModal"><i class="fas fa-edit"></i> Waiver</button>
                            </div>
                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_discount')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="fine_amount" class="form-label"><?php echo e(__('field_fine_amount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control autonumber" name="fine_amount" id="fine_amount" value="<?php echo e(old('fine_amount') ?? 0); ?>" onkeyup="feesCalculator()" required>
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#fineModal"><i class="fas fa-gavel"></i> Fine</button>
                            </div>
                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_fine_amount')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="paid_amount" class="form-label">Total Amount (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="paid_amount" id="paid_amount" value="<?php echo e(old('paid_amount') ?? 0); ?>" onkeyup="feesCalculator()" readonly required>
                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_net_amount')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="payment_method" class="form-label"><?php echo e(__('field_payment_method')); ?> <span>*</span></label>
                            <select class="form-control" name="payment_method" id="payment_method" required onchange="togglePaymentFields()">
                                <option value=""><?php echo e(__('select')); ?></option>
                                <option value="2" <?php if( old('payment_method') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_cash')); ?></option>
                                <option value="4" <?php if( old('payment_method') == 4 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_bank')); ?></option>
                                <option value="5" <?php if( old('payment_method') == 5 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_e_wallet')); ?></option>
                                <option value="6" <?php if( old('payment_method') == 6 ): ?> selected <?php endif; ?>>Bursary</option>
                                <option value="7" <?php if( old('payment_method') == 7 ): ?> selected <?php endif; ?>>M-Pesa</option>
                                <option value="8" <?php if( old('payment_method') == 8 ): ?> selected <?php endif; ?>>Donation</option>
                            </select>
                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_payment_method')); ?>

                            </div>
                        </div>

                        <!-- Payment Method Specific Fields -->
                        <div class="form-group col-md-6" id="bankFields" style="display:none;">
                            <label for="bank_id">Bank <span>*</span></label>
                            <select class="form-control" name="bank_id" id="bank_id">
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($bank->id); ?>"><?php echo e($bank->name); ?> (<?php echo e($bank->account_number); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a bank
                            </div>
                        </div>

                        <div class="form-group col-md-6" id="referenceFields" style="display:none;">
                            <label for="reference">Reference Number</label>
                            <input type="text" class="form-control" name="reference" id="reference" placeholder="Payment reference number">
                        </div>

                        <div class="form-group col-md-6" id="bursaryFields" style="display:none;">
                            <label for="bursary_id">Bursary Fund <span>*</span></label>
                            <select class="form-control" name="bursary_id" id="bursary_id" onchange="updateBursaryBalance()">
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $bursaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bursary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($bursary->id); ?>" data-balance="<?php echo e($bursary->remaining_amount); ?>">
                                        <?php echo e($bursary->name); ?> (Balance: <?php echo e($setting->currency_symbol); ?><?php echo e(number_format($bursary->remaining_amount, 2)); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small id="bursaryBalance" class="form-text text-muted"></small>
                            <div class="invalid-feedback">
                                Please select a bursary fund
                            </div>
                        </div>

                        <div class="form-group col-md-6" id="donationFields" style="display:none;">
                            <label for="donor_id">Donor <span>*</span></label>
                            <select class="form-control" name="donor_id" id="donor_id">
                                <option value=""><?php echo e(__('select')); ?></option>
                                
                                    <option value=""></option>
                               
                            </select>
                            <div class="invalid-feedback">
                                Please select a donor
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="note" class="form-label"><?php echo e(__('field_note')); ?></label>
                            <textarea class="form-control" name="note" id="note" rows="2"><?php echo old('note'); ?></textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="send_sms" id="send_sms" checked>
                                <label class="form-check-label" for="send_sms">Send SMS Confirmation</label>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="send_email" id="send_email" checked>
                                <label class="form-check-label" for="send_email">Send Email Receipt</label>
                            </div>
                        </div>
                        <!-- Form End -->
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_save')); ?></button>
                        <button type="button" class="btn btn-primary" onclick="printReceipt()"><i class="fas fa-print"></i> Print Receipt</button>
                        <button type="button" class="btn btn-info" onclick="previewNotification()"><i class="fas fa-envelope"></i> Preview Notification</button>
                    </div>
                    </form>
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<!-- Waiver Modal -->
<div class="modal fade" id="waiverModal" tabindex="-1" aria-labelledby="waiverModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="waiverModalLabel">Fee Waiver Authorization</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="waiverForm">
                    <div class="mb-3">
                        <label for="waiver_reason" class="form-label">Waiver Reason <span class="text-danger">*</span></label>
                        <select class="form-control" name="waiver_reason" id="waiver_reason" required>
                            <option value="">Select Reason</option>
                            <option value="Financial Hardship">Financial Hardship</option>
                            <option value="Academic Excellence">Academic Excellence</option>
                            <option value="Sports Achievement">Sports Achievement</option>
                            <option value="Staff Discount">Staff Discount</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="waiver_amount" class="form-label">Waiver Amount <span class="text-danger">*</span></label>
                        <input type="text" class="form-control autonumber" name="waiver_amount" id="waiver_amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="waiver_notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control" name="waiver_notes" id="waiver_notes" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="authorized_by" class="form-label">Authorized By <span class="text-danger">*</span></label>
                        <select class="form-control" name="authorized_by" id="authorized_by" required>
                            <option value="">Select Authorizer</option>
                            <?php $__currentLoopData = $authorizers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $authorizer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($authorizer); ?>"><?php echo e($authorizer); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="applyWaiver()">Apply Waiver</button>
            </div>
        </div>
    </div>
</div>

<!-- Fine Modal -->
<div class="modal fade" id="fineModal" tabindex="-1" aria-labelledby="fineModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="fineModalLabel">Fine Management</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="fineForm">
                    <div class="mb-3">
                        <label for="fine_reason" class="form-label">Fine Reason <span class="text-danger">*</span></label>
                        <select class="form-control" name="fine_reason" id="fine_reason" required>
                            <option value="">Select Reason</option>
                            <option value="Late Payment">Late Payment</option>
                            <option value="Library Fine">Library Fine</option>
                            <option value="Disciplinary">Disciplinary</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fine_amount" class="form-label">Fine Amount <span class="text-danger">*</span></label>
                        <input type="text" class="form-control autonumber" name="fine_amount" id="fine_amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="fine_notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control" name="fine_notes" id="fine_notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="applyFine()">Apply Fine</button>
            </div>
        </div>
    </div>
</div>

<!-- Bursary Fund Creation Modal -->
<div class="modal fade" id="bursaryFundModal" tabindex="-1" aria-labelledby="bursaryFundModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="bursaryFundModalLabel">Create New Bursary Fund</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="bursaryFundForm" action="" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bursary_name" class="form-label">Bursary Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="bursary_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="bursary_amount" class="form-label">Initial Amount <span class="text-danger">*</span></label>
                        <input type="text" class="form-control autonumber" name="initial_amount" id="bursary_amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="bursary_start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="start_date" id="bursary_start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="bursary_end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="end_date" id="bursary_end_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="bursary_description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="bursary_description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Create Bursary</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Batch Bursary Allocation Modal -->
<div class="modal fade" id="batchBursaryModal" tabindex="-1" aria-labelledby="batchBursaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="batchBursaryModalLabel">Batch Bursary Allocation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="batchBursaryForm" action="" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="batch_bursary_id" class="form-label">Bursary Fund <span class="text-danger">*</span></label>
                            <select class="form-control" name="bursary_id" id="batch_bursary_id" required onchange="updateBatchBursaryBalance()">
                                <option value="">Select Bursary</option>
                                <?php $__currentLoopData = $bursaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bursary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($bursary->id); ?>" data-balance="<?php echo e($bursary->remaining_amount); ?>">
                                        <?php echo e($bursary->name); ?> (Balance: <?php echo e($setting->currency_symbol); ?><?php echo e(number_format($bursary->remaining_amount, 2)); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small id="batchBursaryBalance" class="form-text text-muted"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="batch_amount" class="form-label">Amount per Student (<?php echo $setting->currency_symbol; ?>) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control autonumber" name="amount" id="batch_amount" required onkeyup="calculateBatchTotal()">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="batch_students" class="form-label">Select Students <span class="text-danger">*</span></label>
                            <select class="form-control select2-multiple" name="students[]" id="batch_students" multiple required onchange="calculateBatchTotal()">
                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($student->id); ?>">
                                        <?php echo e($student->student->student_id ?? ''); ?> - <?php echo e($student->student->first_name ?? ''); ?> <?php echo e($student->student->last_name ?? ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="alert alert-info">
                                <strong>Batch Summary:</strong>
                                <div id="batchSummary">
                                    Number of Students: 0 | Total Amount: <?php echo e($setting->currency_symbol); ?>0.00
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="batch_notes" class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" id="batch_notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info">Allocate Bursary</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Notification Preview Modal -->
<div class="modal fade" id="notificationPreviewModal" tabindex="-1" aria-labelledby="notificationPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="notificationPreviewModalLabel">Payment Notification Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h6>SMS Preview</h6>
                            </div>
                            <div class="card-body">
                                <p id="smsPreviewText">Loading preview...</p>
                                <hr>
                                <small class="text-muted">Recipient: <span id="smsRecipient"></span></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h6>Email Preview</h6>
                            </div>
                            <div class="card-body">
                                <div id="emailPreviewContent">Loading preview...</div>
                                <hr>
                                <small class="text-muted">Recipient: <span id="emailRecipient"></span></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Reconciliation Modal -->
<div class="modal fade" id="reconciliationModal" tabindex="-1" aria-labelledby="reconciliationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-purple text-white">
                <h5 class="modal-title" id="reconciliationModalLabel">Payment Reconciliation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="recon_start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="recon_start_date" value="<?php echo e(date('Y-m-d', strtotime('-7 days'))); ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="recon_end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="recon_end_date" value="<?php echo e(date('Y-m-d')); ?>">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary" type="button" onclick="fetchReconciliationData()">
                            <i class="fas fa-search"></i> Search Payments
                        </button>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="reconciliation-table">
                        <thead class="bg-purple text-white">
                            <tr>
                                <th width="40"><input type="checkbox" id="select-all"></th>
                                <th>Transaction ID</th>
                                <th>Date</th>
                                <th>Student</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Reference</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                <td id="reconTotalAmount">0.00</td>
                                <td colspan="4"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="reconcileAll()">
                    <i class="fas fa-check-circle"></i> Reconcile Selected
                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
<script type="text/javascript">
    "use strict";
    
    // Initialize elements when document is ready
    $(document).ready(function() {
        // Initialize select2
        $('.select2').select2();
        $('.select2-multiple').select2();
        
        // Initialize date pickers
        $('.date').flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true
        });
        
        // Initialize auto-number formatting
        $('.autonumber').inputmask('decimal', {
            rightAlign: false,
            digits: 2,
            groupSeparator: ',',
            autoGroup: true,
            prefix: '<?php echo e($setting->currency_symbol); ?>',
            placeholder: '0'
        });
        
        // Load outstanding balance when student is selected
        $('#student').change(function() {
            var balance = $(this).find(':selected').data('balance');
            $("input[name='fee_amount']").val(balance).trigger('keyup');
            
            // Load student's invoices via AJAX
            var studentId = $(this).val();
            if(studentId) {
                $.ajax({
                    url: "",
                    type: "GET",
                    data: { student_id: studentId },
                    success: function(response) {
                        var invoiceSelect = $("#invoice");
                        invoiceSelect.empty().append('<option value=""><?php echo e(__('select')); ?></option>');
                        
                        $.each(response.invoices, function(index, invoice) {
                            invoiceSelect.append(
                                '<option value="' + invoice.id + '" data-amount="' + invoice.total_amount + '" data-balance="' + invoice.due_amount + '">' +
                                'INV-' + invoice.invoice_number + ' (' + invoice.total_amount.toFixed(2) + ')' +
                                '</option>'
                            );
                        });
                    }
                });
            }
        });
        
        // Select all checkbox for reconciliation
        $("#select-all").click(function() {
            $(".payment-check").prop('checked', $(this).prop('checked'));
        });
        
        // Trigger change if student is pre-selected
        if($('#student').val()) {
            $('#student').trigger('change');
        }
    });
    
    // Fee calculation function
    function feesCalculator() {
        var fee_amount = parseFloat($("input[name='fee_amount']").val().replace(/[^0-9.]/g, '')) || 0;
        var fine_amount = parseFloat($("input[name='fine_amount']").val().replace(/[^0-9.]/g, '')) || 0;
        var discount_amount = parseFloat($("input[name='discount_amount']").val().replace(/[^0-9.]/g, '')) || 0;
        
        // Calculate net total
        var net_total = (fee_amount - discount_amount) + fine_amount;
        $("input[name='paid_amount']").val(net_total.toFixed(2));
        
        // If bursary is selected, validate against bursary balance
        if($("#payment_method").val() == 6) {
            validateBursaryBalance(net_total);
        }
    }
    
    // Toggle payment method specific fields
    function togglePaymentFields() {
        var method = $("#payment_method").val();
        
        // Hide all first
        $("#bankFields, #referenceFields, #bursaryFields, #donationFields").hide();
        
        // Show relevant fields
        if(method == 4) { // Bank
            $("#bankFields, #referenceFields").show();
        } else if(method == 5 || method == 7) { // E-Wallet or M-Pesa
            $("#referenceFields").show();
        } else if(method == 6) { // Bursary
            $("#bursaryFields").show();
            validateBursaryBalance($("input[name='paid_amount']").val().replace(/[^0-9.]/g, ''));
        } else if(method == 8) { // Donation
            $("#donationFields").show();
        }
    }
    
    // Validate bursary balance
    function validateBursaryBalance(amount) {
        var bursarySelect = $("#bursary_id");
        var selectedOption = bursarySelect.find('option:selected');
        var bursaryBalance = selectedOption.data('balance') || 0;
        amount = parseFloat(amount) || 0;
        
        if(amount > bursaryBalance) {
            $("#bursaryBalance").html('<span class="text-danger">Insufficient bursary funds. Required: <?php echo e($setting->currency_symbol); ?>' + amount.toFixed(2) + ', Available: <?php echo e($setting->currency_symbol); ?>' + bursaryBalance.toFixed(2) + '</span>');
            return false;
        } else {
            $("#bursaryBalance").html('Available balance: <?php echo e($setting->currency_symbol); ?>' + bursaryBalance.toFixed(2));
            return true;
        }
    }
    
    // Update bursary balance display
    function updateBursaryBalance() {
        var selectedOption = $("#bursary_id").find('option:selected');
        var bursaryBalance = selectedOption.data('balance') || 0;
        $("#bursaryBalance").html('Available balance: <?php echo e($setting->currency_symbol); ?>' + bursaryBalance.toFixed(2));
        
        // Revalidate if payment method is bursary
        if($("#payment_method").val() == 6) {
            var amount = parseFloat($("input[name='paid_amount']").val().replace(/[^0-9.]/g, '')) || 0;
            validateBursaryBalance(amount);
        }
    }
    
    // Apply waiver from modal
    function applyWaiver() {
        var reason = $("#waiver_reason").val();
        var amount = $("#waiver_amount").val().replace(/[^0-9.]/g, '') || 0;
        var notes = $("#waiver_notes").val();
        var authorizedBy = $("#authorized_by").val();
        
        if(!reason || !authorizedBy || amount <= 0) {
            alert("Please provide waiver reason, amount and authorizer");
            return;
        }
        
        // Apply to current form
        $("input[name='discount_amount']").val(amount).trigger('keyup');
        $("#waiver_notes").val(notes);
        
        // Close modal
        var waiverModal = bootstrap.Modal.getInstance(document.getElementById('waiverModal'));
        waiverModal.hide();
    }
    
    // Apply fine from modal
    function applyFine() {
        var reason = $("#fine_reason").val();
        var amount = $("#fine_amount").val().replace(/[^0-9.]/g, '') || 0;
        var notes = $("#fine_notes").val();
        
        if(!reason || amount <= 0) {
            alert("Please provide fine reason and amount");
            return;
        }
        
        // Apply to current form
        $("input[name='fine_amount']").val(amount).trigger('keyup');
        $("#fine_notes").val(notes);
        
        // Close modal
        var fineModal = bootstrap.Modal.getInstance(document.getElementById('fineModal'));
        fineModal.hide();
    }

    // Calculate batch allocation total
    function calculateBatchTotal() {
        var amountPerStudent = parseFloat($("#batch_amount").val().replace(/[^0-9.]/g, '')) || 0;
        var selectedStudents = $("#batch_students").val() || [];
        var totalAmount = amountPerStudent * selectedStudents.length;
        
        $("#batchSummary").html(
            "Number of Students: " + selectedStudents.length + " | " +
            "Total Amount: <?php echo e($setting->currency_symbol); ?>" + totalAmount.toFixed(2)
        );
        
        // Validate against bursary balance if selected
        updateBatchBursaryBalance();
    }

    // Update batch bursary balance display
    function updateBatchBursaryBalance() {
        var selectedOption = $("#batch_bursary_id").find('option:selected');
        var bursaryBalance = selectedOption.data('balance') || 0;
        var batchAmount = parseFloat($("#batch_amount").val().replace(/[^0-9.]/g, '')) || 0;
        var selectedStudents = $("#batch_students").val() || [];
        var totalAmount = batchAmount * selectedStudents.length;
        
        if(totalAmount > bursaryBalance) {
            $("#batchBursaryBalance").html(
                '<span class="text-danger">Insufficient bursary funds. Required: <?php echo e($setting->currency_symbol); ?>' + 
                totalAmount.toFixed(2) + ', Available: <?php echo e($setting->currency_symbol); ?>' + bursaryBalance.toFixed(2) + '</span>'
            );
            return false;
        } else {
            $("#batchBursaryBalance").html(
                'Available balance: <?php echo e($setting->currency_symbol); ?>' + bursaryBalance.toFixed(2) + 
                ' | Remaining after allocation: <?php echo e($setting->currency_symbol); ?>' + (bursaryBalance - totalAmount).toFixed(2)
            );
            return true;
        }
    }

    // Print receipt function
    function printReceipt() {
        var studentId = $("#student").val();
        if(!studentId) {
            alert("Please select a student first");
            return;
        }
        
        
    }

    // Preview notification function
    function previewNotification() {
        var studentId = $("#student").val();
        if(!studentId) {
            alert("Please select a student first");
            return;
        }
        
        // Get form data
        var formData = {
            student_id: studentId,
            amount: $("input[name='paid_amount']").val(),
            payment_method: $("#payment_method").find('option:selected').text(),
            date: $("input[name='pay_date']").val()
        };
        
        // Show loading state
        $("#smsPreviewText").text("Loading preview...");
        $("#emailPreviewContent").html("Loading preview...");
        
        // Fetch preview via AJAX
        $.ajax({
            url: "",
            type: "POST",
            data: formData,
            success: function(response) {
                $("#smsPreviewText").text(response.sms_content);
                $("#emailPreviewContent").html(response.email_content);
                $("#smsRecipient").text(response.student_mobile);
                $("#emailRecipient").text(response.student_email);
                
                // Show modal
                var previewModal = new bootstrap.Modal(document.getElementById('notificationPreviewModal'));
                previewModal.show();
            },
            error: function() {
                alert("Error loading preview");
            }
        });
    }

    // Fetch reconciliation data
    function fetchReconciliationData() {
        var startDate = $("#recon_start_date").val();
        var endDate = $("#recon_end_date").val();
        
        // Show loading state
        $("#reconciliation-table tbody").html('<tr><td colspan="9" class="text-center">Loading data...</td></tr>');
        
        $.ajax({
            url: "",
            type: "GET",
            data: { 
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                var tbody = $("#reconciliation-table tbody");
                tbody.empty();
                
                if(response.payments.length === 0) {
                    tbody.append('<tr><td colspan="9" class="text-center">No payments found for the selected period</td></tr>');
                    $("#reconTotalAmount").text('0.00');
                    return;
                }
                
                var totalAmount = 0;
                
                $.each(response.payments, function(index, payment) {
                    totalAmount += parseFloat(payment.amount);
                    
                    var statusBadge = '';
                    if(payment.status === 1) {
                        statusBadge = '<span class="badge bg-success">Reconciled</span>';
                    } else {
                        statusBadge = '<span class="badge bg-warning">Pending</span>';
                    }
                    
                    var actionBtn = '';
                    if(payment.status === 0) {
                        actionBtn = '<button class="btn btn-sm btn-success" onclick="reconcileSingle(' + payment.id + ')">Reconcile</button>';
                    } else {
                        actionBtn = '<button class="btn btn-sm btn-danger" onclick="unreconcileSingle(' + payment.id + ')">Undo</button>';
                    }
                    
                    tbody.append(
                        '<tr>' +
                        '<td><input type="checkbox" class="payment-check" value="' + payment.id + '"></td>' +
                        '<td>PAY-' + payment.id + '</td>' +
                        '<td>' + payment.date + '</td>' +
                        '<td>' + payment.student_name + '</td>' +
                        '<td><?php echo e($setting->currency_symbol); ?>' + parseFloat(payment.amount).toFixed(2) + '</td>' +
                        '<td>' + payment.method + '</td>' +
                        '<td>' + (payment.reference || 'N/A') + '</td>' +
                        '<td>' + statusBadge + '</td>' +
                        '<td>' + actionBtn + '</td>' +
                        '</tr>'
                    );
                });
                
                $("#reconTotalAmount").text('<?php echo e($setting->currency_symbol); ?>' + totalAmount.toFixed(2));
            },
            error: function() {
                alert("Error loading reconciliation data");
            }
        });
    }

    // Reconcile single payment
    function reconcileSingle(paymentId) {
        if(!confirm("Are you sure you want to reconcile this payment?")) {
            return;
        }
        
        $.ajax({
            url: "",
            type: "POST",
            data: { 
                payment_id: paymentId,
                _token: "<?php echo e(csrf_token()); ?>"
            },
            success: function(response) {
                if(response.success) {
                    alert("Payment reconciled successfully");
                    fetchReconciliationData();
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function() {
                alert("Error processing request");
            }
        });
    }

    // Unreconcile single payment
    function unreconcileSingle(paymentId) {
        if(!confirm("Are you sure you want to undo reconciliation for this payment?")) {
            return;
        }
        
        $.ajax({
            url: "",
            type: "POST",
            data: { 
                payment_id: paymentId,
                _token: "<?php echo e(csrf_token()); ?>"
            },
            success: function(response) {
                if(response.success) {
                    alert("Reconciliation undone successfully");
                    fetchReconciliationData();
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function() {
                alert("Error processing request");
            }
        });
    }

    // Reconcile all selected payments
    function reconcileAll() {
        var selectedPayments = [];
        $(".payment-check:checked").each(function() {
            selectedPayments.push($(this).val());
        });
        
        if(selectedPayments.length === 0) {
            alert("Please select at least one payment to reconcile");
            return;
        }
        
        if(!confirm("Are you sure you want to reconcile " + selectedPayments.length + " selected payments?")) {
            return;
        }
        
        $.ajax({
            url: "",
            type: "POST",
            data: { 
                payment_ids: selectedPayments,
                _token: "<?php echo e(csrf_token()); ?>"
            },
            success: function(response) {
                if(response.success) {
                    alert(response.message);
                    fetchReconciliationData();
                    $("#select-all").prop('checked', false);
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function() {
                alert("Error processing request");
            }
        });
    }

    // Load invoice details when selected
    $("#invoice").change(function() {
        var selectedOption = $(this).find('option:selected');
        var invoiceAmount = selectedOption.data('amount') || 0;
        var invoiceBalance = selectedOption.data('balance') || 0;
        
        if(invoiceAmount > 0) {
            $("input[name='fee_amount']").val(invoiceBalance).trigger('keyup');
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/fees-student/quick-received.blade.php ENDPATH**/ ?>