@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<div class="page-header d-print-none">
    <div class="container-fluid">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                  
                </h2>
                <div class="text-muted mt-1">
                    <i class="fas fa-info-circle me-1"></i> Record and manage student fee payments
                </div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="{{ route($route.'.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-history me-2"></i> Payment History
                </a>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg">
                    <form action="{{ route($route.'.store') }}" method="POST" id="paymentForm" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">
                                <i class="fas fa-money-bill-wave me-2"></i> Record Payment
                            </h3>
                        </div>
                        
                        @if ($errors->any())
                        <div class="alert alert-danger m-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="card-body">
                           <!-- Student Selection -->
                            <div class="form-group mb-4">
                                <label for="student_enroll_id" class="form-label">{{ __('field_student') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-control select2" name="student_enroll_id" id="student_enroll_id" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}"
                                                data-program="{{ $student->program->title ?? 'N/A' }}"
                                                data-batch="{{ $student->batch->title ?? 'N/A' }}"
                                                data-regno="{{ $student->student->registration_number ?? $student->student->student_id }}">
                                                {{ $student->student->student_id ?? $student->student->registration_number }} - 
                                                {{ $student->student->first_name }} {{ $student->student->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-primary" type="button" id="view-invoices-btn" data-bs-toggle="modal" data-bs-target="#invoicesModal">
                                        <i class="fas fa-file-invoice me-1"></i> View Invoices
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Student Info Display -->
                            <div class="row mb-4 g-3" id="student-info" style="display: none;">
                                <div class="col-md-4">
                                    <div class="form-label">Program</div>
                                    <div class="form-control-plaintext fw-bold" id="program-display"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-label">Batch</div>
                                    <div class="form-control-plaintext fw-bold" id="batch-display"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-label">Registration No</div>
                                    <div class="form-control-plaintext fw-bold" id="regno-display"></div>
                                </div>
                            </div>
                            
                            <!-- Selected Invoices -->
                            <div class="mb-4" id="selected-invoices-section" style="display: none;">
                                <label class="form-label fw-bold">Selected Invoices</label>
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body p-2">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-borderless mb-0" id="selected-invoices-table">
                                                <thead>
                                                    <tr>
                                                        <th>Invoice No</th>
                                                        <th>Due Date</th>
                                                        <th class="text-end">Amount Due</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Will be populated by JavaScript -->
                                                </tbody>
                                                <tfoot>
                                                    <tr class="border-top">
                                                        <th colspan="2">Total</th>
                                                        <th class="text-end" id="total-due-amount">0.00</th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="invoice_ids" id="invoice_ids">
                            </div>
                            
                            <!-- Payment Method -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Payment Method <span class="text-danger">*</span></label>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="payment-method-option" data-method="mpesa" data-bs-toggle="modal" data-bs-target="#mpesaModal">
                                            <input type="radio" name="payment_method" id="mpesaMethod" value="mpesa" class="d-none" required>
                                            <label for="mpesaMethod" class="border rounded p-3 d-block text-center cursor-pointer">
                                                <i class="fas fa-mobile-alt fa-2x text-success mb-2"></i>
                                                <h6 class="fw-bold mb-1">M-Pesa</h6>
                                                <small class="text-muted">Mobile Money</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="payment-method-option" data-method="bank" data-bs-toggle="modal" data-bs-target="#bankModal">
                                            <input type="radio" name="payment_method" id="bankMethod" value="bank" class="d-none">
                                            <label for="bankMethod" class="border rounded p-3 d-block text-center cursor-pointer">
                                                <i class="fas fa-university fa-2x text-primary mb-2"></i>
                                                <h6 class="fw-bold mb-1">Bank Transfer</h6>
                                                <small class="text-muted">Bank Payment</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="payment-method-option" data-method="cash" data-bs-toggle="modal" data-bs-target="#cashModal">
                                            <input type="radio" name="payment_method" id="cashMethod" value="cash" class="d-none">
                                            <label for="cashMethod" class="border rounded p-3 d-block text-center cursor-pointer">
                                                <i class="fas fa-money-bill-wave fa-2x text-warning mb-2"></i>
                                                <h6 class="fw-bold mb-1">Cash</h6>
                                                <small class="text-muted">Physical Payment</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="payment-method-option" data-method="cheque" data-bs-toggle="modal" data-bs-target="#chequeModal">
                                            <input type="radio" name="payment_method" id="chequeMethod" value="cheque" class="d-none">
                                            <label for="chequeMethod" class="border rounded p-3 d-block text-center cursor-pointer">
                                                <i class="fas fa-money-check fa-2x text-info mb-2"></i>
                                                <h6 class="fw-bold mb-1">Cheque</h6>
                                                <small class="text-muted">Bank Cheque</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Amount Section -->
                            <div class="mb-4">
                                <label for="amount" class="form-label fw-bold">Amount (KES) <span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bg-light fw-bold">KES</span>
                                    <input type="number" class="form-control" name="amount" id="amount" min="0.01" step="0.01" required>
                                    <button class="btn btn-outline-secondary" type="button" id="pay-full-btn">Pay Full</button>
                                </div>
                                <small class="text-muted" id="amount-help-text">Enter the payment amount</small>
                            </div>
                            
                            <!-- Notes -->
                            <div class="mb-3">
                                <label for="notes" class="form-label fw-bold">Payment Notes</label>
                                <textarea class="form-control" name="notes" id="notes" rows="3" placeholder="Additional payment details"></textarea>
                            </div>
                            
                            <!-- Payment Summary -->
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h4 class="card-title mb-0">
                                        <i class="fas fa-receipt me-2"></i> Payment Summary
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <td width="40%"><strong>Student:</strong></td>
                                                <td width="60%" id="summary-student">Not selected</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Payment Method:</strong></td>
                                                <td id="summary-method">Not selected</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Amount:</strong></td>
                                                <td id="summary-amount">0.00 KES</td>
                                            </tr>
                                            <tr id="summary-reference-row" style="display: none;">
                                                <td><strong>Reference:</strong></td>
                                                <td id="summary-reference">-</td>
                                            </tr>
                                            <tr id="summary-invoices-row" style="display: none;">
                                                <td><strong>Invoices:</strong></td>
                                                <td id="summary-invoices">-</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer text-end bg-light">
                            <div class="d-flex justify-content-between">
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo me-1"></i> Reset Form
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Record Payment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Invoice Selection Modal -->
<div class="modal fade" id="invoicesModal" tabindex="-1" aria-labelledby="invoicesModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header py-3 bg-primary text-white">
                <h5 class="modal-title fw-bold" id="invoicesModalLabel">
                    <i class="fas fa-file-invoice me-2"></i> Select Invoices to Pay
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> Select one or more invoices to include in this payment.
                </div>
                
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle" id="invoices-table">
                        <thead class="bg-light">
                            <tr>
                                <th width="40px">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="select-all-invoices">
                                    </div>
                                </th>
                                <th>Invoice No</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                                <th class="text-end">Total Amount</th>
                                <th class="text-end">Paid</th>
                                <th class="text-end">Due</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="fas fa-user-graduate fa-2x mb-3"></i>
                                    <p>Please select a student first</p>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <th colspan="4" class="text-end">Total</th>
                                <th class="text-end" id="modal-total-fee">0.00</th>
                                <th class="text-end" id="modal-total-paid">0.00</th>
                                <th class="text-end" id="modal-total-due">0.00</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary" id="confirm-invoices-btn" disabled>
                    <i class="fas fa-check me-1"></i> Confirm Selection
                </button>
            </div>
        </div>
    </div>
</div>

<!-- M-Pesa Payment Modal -->
<div class="modal fade" id="mpesaModal" tabindex="-1" aria-labelledby="mpesaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header py-3 bg-success text-white">
                <h5 class="modal-title fw-bold" id="mpesaModalLabel">
                    <i class="fas fa-mobile-alt me-2"></i> M-Pesa Payment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-warning">
                    <strong>⚠️ Anti-Fraud M-Pesa Payment Rules</strong>
                    <ol class="small">
                        <li><strong>Verify every payment</strong> via M-Pesa Business App/SMS—<u>no screenshots accepted</u>.</li>
                        <li><strong>Account format must be:</strong> <code>STD-[StudentID]</code>.</li>
                        <li><strong>Match payments to student records</strong>—reject mismatched amounts/names.</li>
                        <li><strong>Call Safaricom (234)</strong> if a transaction looks suspicious.</li>
                    </ol>
                    <p class="mt-2 small"><strong>Note:</strong> Be cautious of fake M-Pesa texts. Always double-check!</p>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Standard Payment</h5>
                                <ol>
                                    <li>Go to M-Pesa on your phone</li>
                                    <li>Select <strong>Lipa Na M-Pesa</strong></li>
                                    <li>Select <strong>Pay Bill</strong></li>
                                    <li>Business No: <strong>123456</strong></li>
                                    <li>Account No: <strong id="mpesa-account">[Student Reg No]</strong></li>
                                    <li>Enter Amount: <strong id="mpesa-amount">[Amount]</strong></li>
                                    <li>Enter your M-Pesa PIN</li>
                                    <li>Confirm and send</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Till Number Payment</h5>
                                <ol>
                                    <li>Go to M-Pesa on your phone</li>
                                    <li>Select <strong>Buy Goods and Services</strong></li>
                                    <li>Enter Till Number: <strong>54321</strong></li>
                                    <li>Enter Amount: <strong id="mpesa-amount2">[Amount]</strong></li>
                                    <li>Enter your M-Pesa PIN</li>
                                    <li>Confirm and send</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="mpesa_number" class="form-label fw-bold">M-Pesa Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="mpesa_number" id="mpesa_number" placeholder="e.g. 2547XXXXXXXX">
                </div>
                <div class="mb-3">
                    <label for="mpesa_transaction" class="form-label fw-bold">Transaction Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="reference_number" id="mpesa_transaction" placeholder="e.g. RF48J9H2K">
                </div>
            </div>
            <div class="modal-footer bg-light py-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancel
                </button>
                <button type="button" class="btn btn-success confirm-payment-method" data-method="mpesa">
                    <i class="fas fa-check me-1"></i> Confirm M-Pesa Payment
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bank Payment Modal -->
<div class="modal fade" id="bankModal" tabindex="-1" aria-labelledby="bankModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header py-3 bg-primary text-white">
                <h5 class="modal-title fw-bold" id="bankModalLabel">
                    <i class="fas fa-university me-2"></i> Bank Transfer Payment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-warning">
                    <strong>⚠️ Anti-Fraud Bank Payment Rules</strong>
                    <ol class="small">
                        <li><strong>Verify payments via bank statement</strong> – Never trust SMS/emails alone.</li>
                        <li><strong>Require student ID in reference</strong> – Reject payments without <code>STD-[ID]</code>.</li>
                        <li><strong>Confirm large deposits (>KES 50k) via call</strong> – Call Bank: <strong>0700 000 000</strong>.</li>
                    </ol>
                    <p class="mt-2 small text-danger"><strong>Warning:</strong> Be cautious of fake deposit slips. Always check with the bank!</p>
                </div>
                
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Bank Details</h5>
                        <ul class="list-unstyled">
                            <li><strong>Bank Name:</strong> Equity Bank</li>
                            <li><strong>Account Name:</strong> College Name</li>
                            <li><strong>Account Number:</strong> 1234567890</li>
                            <li><strong>Branch:</strong> Nairobi Main</li>
                            <li><strong>Swift Code:</strong> KCBKENYA</li>
                        </ul>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="bank_reference" class="form-label fw-bold">Payment Reference <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="reference_number" id="bank_reference" placeholder="e.g. Bank Transaction ID">
                </div>
                <div class="mb-3">
                    <label for="bank_slip" class="form-label fw-bold">Upload Deposit Slip (Optional)</label>
                    <input type="file" class="form-control" name="bank_slip" id="bank_slip">
                </div>
            </div>
            <div class="modal-footer bg-light py-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary confirm-payment-method" data-method="bank">
                    <i class="fas fa-check me-1"></i> Confirm Bank Payment
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cash Payment Modal -->
<div class="modal fade" id="cashModal" tabindex="-1" aria-labelledby="cashModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header py-3 bg-warning text-dark">
                <h5 class="modal-title fw-bold" id="cashModalLabel">
                    <i class="fas fa-money-bill-wave me-2"></i> Cash Payment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-warning">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-money-bill-wave me-2"></i>
                        <div>
                            <strong>Cash Payment Disclaimer</strong>
                            <p class="mb-0 small">Please be cautious when making cash payments. Always check the security features of the notes.</p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="receipt_number" class="form-label fw-bold">Receipt Number</label>
                    <input type="text" class="form-control" name="reference_number" id="receipt_number" placeholder="e.g. RC-2023-0001">
                </div>
                
                <div class="alert alert-info">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <div>
                            <strong>Cash Handling Procedure</strong>
                            <ol class="mb-0 small">
                                <li>Count cash in presence of payer</li>
                                <li>Verify using counterfeit detection pen</li>
                                <li>Issue receipt immediately</li>
                                <li>Deposit to bank within 24 hours</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light py-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancel
                </button>
                <button type="button" class="btn btn-warning confirm-payment-method" data-method="cash">
                    <i class="fas fa-check me-1"></i> Confirm Cash Payment
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cheque Payment Modal -->
<div class="modal fade" id="chequeModal" tabindex="-1" aria-labelledby="chequeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header py-3 bg-info text-white">
                <h5 class="modal-title fw-bold" id="chequeModalLabel">
                    <i class="fas fa-money-check me-2"></i> Cheque Payment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-warning">
                    <strong>⚠️ Cheque Payment Rules</strong>
                    <ol class="small">
                        <li><strong>Verify cheque details</strong> – Name, date, amount, signature</li>
                        <li><strong>Check for alterations</strong> – Reject any cheques with corrections</li>
                        <li><strong>Confirm drawer's identity</strong> – Match ID with cheque details</li>
                        <li><strong>Processing time:</strong> 3-5 working days to clear</li>
                    </ol>
                </div>
                
                <div class="mb-3">
                    <label for="cheque_number" class="form-label fw-bold">Cheque Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="cheque_number" id="cheque_number" placeholder="e.g. CHQ123456">
                </div>
                <div class="mb-3">
                    <label for="cheque_bank" class="form-label fw-bold">Bank Name <span class="text-danger">*</span></label>
                    <select class="form-select" name="cheque_bank" id="cheque_bank">
                        <option value="">Select Bank</option>
                        <option value="equity">Equity Bank</option>
                        <option value="kcb">KCB Bank</option>
                        <option value="coop">Co-operative Bank</option>
                        <option value="standard">Standard Chartered</option>
                        <option value="barclays">Absa Bank</option>
                        <option value="dtb">Diamond Trust Bank</option>
                        <option value="ncba">NCBA Bank</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="cheque_branch" class="form-label fw-bold">Branch <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="cheque_branch" id="cheque_branch" placeholder="e.g. Nairobi West">
                </div>
                <div class="mb-3">
                    <label for="cheque_date" class="form-label fw-bold">Cheque Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="cheque_date" id="cheque_date">
                </div>
                <div class="mb-3">
                    <label for="cheque_image" class="form-label fw-bold">Upload Cheque Copy (Front)</label>
                    <input type="file" class="form-control" name="cheque_image" id="cheque_image" accept="image/*">
                </div>
            </div>
            <div class="modal-footer bg-light py-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancel
                </button>
                <button type="button" class="btn btn-info confirm-payment-method" data-method="cheque">
                    <i class="fas fa-check me-1"></i> Confirm Cheque Payment
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // When student is selected
    $('#student_enroll_id').change(function() {
        const selectedOption = $(this).find('option:selected');
        const studentSelected = $(this).val() !== '';
        
        // Toggle student info display
        $('#student-info').toggle(studentSelected);
        $('#view-invoices-btn').prop('disabled', !studentSelected);
        
        if (studentSelected) {
            // Update student info
            $('#program-display').text(selectedOption.data('program'));
            $('#batch-display').text(selectedOption.data('batch'));
            $('#regno-display').text(selectedOption.data('regno'));
            $('#summary-student').text(selectedOption.text());
            $('#mpesa-account').text(selectedOption.data('regno'));
        } else {
            $('#summary-student').text('Not selected');
            $('#selected-invoices-section').hide();
            $('#invoice_ids').val('');
        }
    });

    // View invoices button click - load data when modal is shown
    $('#invoicesModal').on('show.bs.modal', function() {
        const studentEnrollId = $('#student_enroll_id').val();
        
        if (!studentEnrollId) {
            Toastr.warning('Please select a student first');
            return false; // Prevent modal from opening
        }
        
        loadStudentInvoices(studentEnrollId);
    });

    // Function to load student invoices
    function loadStudentInvoices(studentEnrollId) {
        // Show loading state
        $('#invoices-table tbody').html(`
            <tr>
                <td colspan="8" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 mb-0">Loading invoices...</p>
                </td>
            </tr>
        `);
        
        // Reset confirm button
        $('#confirm-invoices-btn').prop('disabled', true);

        // Fetch student invoices via AJAX
        $.ajax({
            url: '{{ route("admin.payments.getStudentInvoices") }}',
            type: 'POST',
            data: {
                student_enroll_id: studentEnrollId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    populateInvoicesTable(response.invoices);
                } else {
                    showInvoiceError(response.message || 'Failed to load invoices');
                }
            },
            error: function(xhr) {
                showInvoiceError('Error loading invoices. Please try again.');
                console.error(xhr.responseText);
            }
        });
    }

    // Populate invoices table
    function populateInvoicesTable(invoices) {
        let invoicesHtml = '';
        let totalFee = 0;
        let totalPaid = 0;
        let totalDue = 0;

        if (invoices.length > 0) {
            invoices.forEach(function(invoice) {
                const statusClass = getStatusClass(invoice.payment_status);
                
                invoicesHtml += `
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input invoice-checkbox" type="checkbox" value="${invoice.id}" 
                                    data-invoice-no="${invoice.invoice_no}"
                                    data-due-date="${invoice.due_date}"
                                    data-total-fee="${invoice.total_fee}"
                                    data-amount-paid="${invoice.amount_paid}"
                                    data-amount-due="${invoice.amount_due}"
                                    data-status="${invoice.payment_status}">
                            </div>
                        </td>
                        <td>${invoice.invoice_no}</td>
                        <td>${formatDate(invoice.assign_date)}</td>
                        <td>${formatDate(invoice.due_date)}</td>
                        <td class="text-end">${formatCurrency(invoice.total_fee)}</td>
                        <td class="text-end">${formatCurrency(invoice.amount_paid)}</td>
                        <td class="text-end">${formatCurrency(invoice.amount_due)}</td>
                        <td><span class="badge ${statusClass}">${invoice.payment_status}</span></td>
                    </tr>
                `;
                
                totalFee += parseFloat(invoice.total_fee);
                totalPaid += parseFloat(invoice.amount_paid);
                totalDue += parseFloat(invoice.amount_due);
            });
        } else {
            invoicesHtml = `
                <tr>
                    <td colspan="8" class="text-center py-4 text-muted">
                        <i class="fas fa-file-invoice-dollar fa-2x mb-3"></i>
                        <p>No unpaid invoices found for this student</p>
                    </td>
                </tr>
            `;
        }

        $('#invoices-table tbody').html(invoicesHtml);
        $('#modal-total-fee').text(formatCurrency(totalFee));
        $('#modal-total-paid').text(formatCurrency(totalPaid));
        $('#modal-total-due').text(formatCurrency(totalDue));

        // Enable checkboxes if invoices exist
        if (invoices.length > 0) {
            $('.invoice-checkbox').change(function() {
                const checkedInvoices = $('.invoice-checkbox:checked').length;
                $('#confirm-invoices-btn').prop('disabled', checkedInvoices === 0);
            });
            
            // Select all invoices checkbox
            $('#select-all-invoices').change(function() {
                $('.invoice-checkbox').prop('checked', $(this).prop('checked'));
                $('#confirm-invoices-btn').prop('disabled', !$(this).prop('checked'));
            });
        }
    }

    // Confirm invoice selection
    $('#confirm-invoices-btn').click(function() {
        const selectedInvoices = [];
        const selectedInvoiceData = [];
        let totalDue = 0;
        
        $('.invoice-checkbox:checked').each(function() {
            const invoiceId = $(this).val();
            selectedInvoices.push(invoiceId);
            
            selectedInvoiceData.push({
                invoice_no: $(this).data('invoice-no'),
                due_date: $(this).data('due-date'),
                amount_due: $(this).data('amount-due'),
                status: $(this).data('status')
            });
            
            totalDue += parseFloat($(this).data('amount-due'));
        });
        
        if (selectedInvoices.length === 0) {
            Toastr.warning('Please select at least one invoice');
            return;
        }
        
        // Update the selected invoices display
        let invoicesHtml = '';
        selectedInvoiceData.forEach(function(invoice) {
            const statusClass = getStatusClass(invoice.status);
            
            invoicesHtml += `
                <tr>
                    <td>${invoice.invoice_no}</td>
                    <td>${formatDate(invoice.due_date)}</td>
                    <td class="text-end">${formatCurrency(invoice.amount_due)}</td>
                    <td><span class="badge ${statusClass}">${invoice.status}</span></td>
                </tr>
            `;
        });
        
        $('#selected-invoices-table tbody').html(invoicesHtml);
        $('#total-due-amount').text(formatCurrency(totalDue));
        $('#invoice_ids').val(selectedInvoices.join(','));
        $('#selected-invoices-section').show();
        
        // Update amount field and help text
        $('#amount').val(totalDue.toFixed(2));
        $('#amount-help-text').html(`Total due for ${selectedInvoices.length} selected invoice(s)`);
        
        // Update summary
        $('#summary-invoices').text(selectedInvoices.length + ' selected');
        $('#summary-invoices-row').show();
        
        // Close the modal
        $('#invoicesModal').modal('hide');
    });

    // Helper functions
    function getStatusClass(status) {
        switch(status) {
            case 'paid': return 'bg-success';
            case 'partial': return 'bg-warning text-dark';
            default: return 'bg-danger';
        }
    }

    function formatDate(dateString) {
        if (!dateString) return '-';
        return new Date(dateString).toLocaleDateString();
    }

    function formatCurrency(amount) {
        return parseFloat(amount).toFixed(2);
    }

    function showInvoiceError(message) {
        $('#invoices-table tbody').html(`
            <tr>
                <td colspan="8" class="text-center py-4 text-danger">
                    <i class="fas fa-exclamation-circle fa-2x mb-3"></i>
                    <p>${message}</p>
                </td>
            </tr>
        `);
    }

    // Full payment button
    $('#pay-full-btn').click(function() {
        const totalDue = parseFloat($('#total-due-amount').text()) || 0;
        if (totalDue > 0) {
            $('#amount').val(totalDue.toFixed(2)).trigger('input');
        }
    });
    
    // Payment method selection
    $('.payment-method-option').click(function() {
        const method = $(this).data('method');
        $('.payment-method-option').removeClass('border-primary');
        $(this).addClass('border-primary');
        $('#' + method + 'Method').prop('checked', true);
        
        // Update summary
        $('#summary-method').text(method.charAt(0).toUpperCase() + method.slice(1));
        
        // Show reference row if not cash
        if (method !== 'cash') {
            $('#summary-reference-row').show();
        } else {
            $('#summary-reference-row').hide();
        }
    });
    
    // When amount changes
    $('#amount').on('input', function() {
        const amount = $(this).val();
        $('#summary-amount').text(amount ? parseFloat(amount).toFixed(2) + ' KES' : '0.00 KES');
        $('#mpesa-amount').text(amount || '[Amount]');
        $('#mpesa-amount2').text(amount || '[Amount]');
    });
    
    // When reference number changes
    $('input[name="reference_number"], input[name="cheque_number"], input[name="receipt_number"]').on('input', function() {
        $('#summary-reference').text($(this).val() || '-');
    });
    
    // Reset form
    $('button[type="reset"]').click(function() {
        $('#student-info').hide();
        $('.payment-method-option').removeClass('border-primary');
        $('#summary-student').text('Not selected');
        $('#summary-method').text('Not selected');
        $('#summary-amount').text('0.00 KES');
        $('#summary-reference-row').hide();
        $('#summary-invoices-row').hide();
        $('#selected-invoices-section').hide();
        $('#invoice_ids').val('');
    });
});
</script>
@endpush