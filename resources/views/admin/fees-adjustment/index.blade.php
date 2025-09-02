@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Discounts & Fines') }}</h5>
        </div>
        <div class="card-block">
            <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post">
                @csrf
                <div class="row">
                    <!-- Student Selection -->
                    <div class="form-group col-md-6">
                        <label for="student_id">{{ __('field_student') }} <span>*</span></label>
                        <select class="form-control select2" name="student_id" id="student_id" required>
                            <option value="">{{ __('select') }}</option>
                            @foreach($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->student->student_id }} - {{ $student->student->first_name }} {{ $student->student->last_name }}
                            </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_student') }}
                        </div>
                    </div>

                    <!-- Invoice Selection -->
                    <div class="form-group col-md-6">
                        <label for="invoice_id">Issued Invoices <span>*</span></label>
                        <select class="form-control select2" name="invoice_id" id="invoice_id" required disabled>
                            <option value="">{{ __('select') }}</option>
                        </select>
                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_invoice') }}
                        </div>
                    </div>

                    <!-- Invoice Details -->
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Total Invoiced Fee:</strong> 
                                    <span id="total_fee">0.00</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Amount Due:</strong> 
                                    <span id="amount_due" class="font-weight-bold">0.00</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Previous Discounts Amount:</strong> 
                                    <span id="discount_amount">0.00</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Previous Fines Amount:</strong> 
                                    <span id="fine_amount">0.00</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                
                                <div class="col-md-12 mt-2">
                                    <strong>Previous Adjustment Notes:</strong> 
                                    <span id="adjustment_notes"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Adjustment Type -->
                    <div class="form-group col-md-4">
                        <label for="type">{{ __('Type') }} <span>*</span></label>
                        <select class="form-control" name="type" id="type" required>
                            <option value="">{{ __('select') }}</option>
                            <option value="discount">{{ __('Discount') }}</option>
                            <option value="fine">{{ __('Fine') }}</option>
                            <option value="adjustment">{{ __('Manual Adjustment') }}</option>
                        </select>
                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('Type') }}
                        </div>
                    </div>

                    <!-- Discount/Fine Selection -->
                    <div class="form-group col-md-4" id="discount_field">
                        <label for="discount_id">{{ __('Discount') }} <span>*</span></label>
                        <select class="form-control select2" name="adjustment_id" id="discount_id" disabled>
                            <option value="">{{ __('select') }}</option>
                            @foreach($discounts as $discount)
                            <option value="{{ $discount->id }}" data-type="{{ $discount->type }}" data-amount="{{ $discount->amount }}">
                                {{ $discount->title }} ({{ $discount->type == 1 ? $discount->amount.'%' : config('app.currency_symbol').$discount->amount }})
                            </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('Discount') }}
                        </div>
                    </div>

                    <div class="form-group col-md-4" id="fine_field" style="display:none;">
                        <label for="fine_id">{{ __('Fine') }} <span>*</span></label>
                        <select class="form-control select2" name="adjustment_id" id="fine_id" disabled>
                            <option value="">{{ __('select') }}</option>
                            @foreach($fines as $fine)
                            <option value="{{ $fine->id }}" data-amount="{{ $fine->amount }}">
                                {{ $fine->title }} ({{ config('app.currency_symbol').$fine->amount }})
                            </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('Fine') }}
                        </div>
                    </div>

                    <!-- Manual Adjustment Operation -->
                    <div class="form-group col-md-4" id="adjustment_operation_field" style="display:none;">
                        <label for="adjustment_operation">{{ __('Operation') }} <span>*</span></label>
                        <select class="form-control" name="adjustment_operation" id="adjustment_operation" disabled>
                            <option value="add">{{ __('Add to Due') }}</option>
                            <option value="deduct">{{ __('Deduct from Due') }}</option>
                        </select>
                    </div>

                    <!-- Amount -->
                    <div class="form-group col-md-4">
                        <label for="amount">{{ __('Amount') }} <span>*</span></label>
                        <input type="text" class="form-control" name="amount" id="amount" required readonly>
                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('Amount') }}
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="row">
    <!-- Notes -->
    <div class="form-group col-md-4">
        <label for="notes">{{ __('Notes') }}</label>
        <textarea class="form-control" name="notes" id="notes" rows="1"></textarea>
    </div>

    <!-- Centered SMS Toggle with horizontal line -->
    <div class="col-md-4 d-flex align-items-center">
        <div class="w-100 position-relative">
            <hr class="my-0">
            <div class="position-absolute top-50 start-50 translate-middle bg-white px-3">
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="send_sms" name="send_sms" checked>
                    <label class="form-check-label" for="send_sms">{{ __('Send SMS') }}</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty column to maintain layout -->
    <div class="col-md-4"></div>
</div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('Apply Adjustment') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
            <!-- [ Card ] end -->

            <!-- Adjustment History -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Adjustment History') }}</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>{{ __('Student Names') }}</th>
                            <th>{{ __('Student ID') }}</th>
                            <th>{{ __('Course') }}</th>
                            <th>{{ __('Invoice') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Amount Due Before') }}</th>
                            <th>{{ __('Adjustment') }}</th>
                            <th>{{ __('Amount Due After') }}</th>
                            <th>{{ __('Notes') }}</th>
                            <th>{{ __('Updated At') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            @foreach($student->invoices as $invoice)
                                @if($invoice->discount_amount > 0 || $invoice->fine_amount > 0 || $invoice->adjustment_notes)
                                @php
                                    // Get the actual amount due BEFORE this adjustment was applied
                                    $before_amount = $invoice->amount_due;
                                    
                                    // Calculate what the amount was BEFORE this adjustment
                                    if($invoice->adjustment_type == 'discount') {
                                        $before_amount += $invoice->discount_amount; // Add back the discount
                                    } elseif($invoice->adjustment_type == 'fine') {
                                        $before_amount -= $invoice->fine_amount; // Remove the fine
                                    }
                                    
                                    // The adjustment amount
                                    $adjustment_amount = $invoice->amount_due - $before_amount;
                                    
                                    // After amount is simply the current amount_due
                                    $after_amount = $invoice->amount_due;
                                @endphp
                                <tr>
                                    <td>{{ $student->student->first_name }} {{ $student->student->last_name }}</td>
                                    <td>{{ $student->student->student_id }}</td>
                                    <td>{{ $student->program->title ?? '' }}</td>
                                    <td>{{ $invoice->invoice_no }}</td>
                                    <td>
                                        @if($invoice->adjustment_type == 'discount')
                                            <span class="badge bg-success">{{ __('Discount') }}</span>
                                        @elseif($invoice->adjustment_type == 'fine')
                                            <span class="badge bg-danger">{{ __('Fine') }}</span>
                                        @else
                                            <span class="badge bg-info">{{ __('Adjustment') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ config('app.currency_symbol') }}{{ number_format($before_amount, 2) }}</td>
                                    <td>
                                        @if($adjustment_amount < 0)
                                            -{{ config('app.currency_symbol') }}{{ number_format(abs($adjustment_amount), 2) }}
                                        @else
                                            +{{ config('app.currency_symbol') }}{{ number_format($adjustment_amount, 2) }}
                                        @endif
                                    </td>
                                    <td>{{ config('app.currency_symbol') }}{{ number_format($after_amount, 2) }}</td>
                                    <td>{{ $invoice->adjustment_notes }}</td>
                                    <td>{{ $invoice->updated_at->format('Y-m-d H:i') }}</td>
                                </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')
<script>
    // When student changes, load their invoices
    $('#student_id').change(function() {
        var studentId = $(this).val();
        if(studentId) {
            $.ajax({
                url: "{{ route($route.'.getInvoices') }}",
                type: "GET",
                data: { student_id: studentId },
                success: function(response) {
                    $('#invoice_id').empty().append('<option value="">{{ __('select') }}</option>');
                    $.each(response, function(key, invoice) {
                        $('#invoice_id').append('<option value="'+invoice.id+'">'+invoice.invoice_no+' (Due: {{ config('app.currency_symbol') }}'+invoice.amount_due+')</option>');
                    });
                    $('#invoice_id').prop('disabled', false);
                }
            });
        } else {
            $('#invoice_id').empty().append('<option value="">{{ __('select') }}</option>');
            $('#invoice_id').prop('disabled', true);
        }
    });

    // When invoice changes, load its details
    $('#invoice_id').change(function() {
        var invoiceId = $(this).val();
        if(invoiceId) {
            $.ajax({
                url: "{{ route($route.'.getInvoiceDetails') }}",
                type: "GET",
                data: { invoice_id: invoiceId },
                success: function(response) {
                    $('#total_fee').text(response.total_fee);
                    $('#amount_paid').text(response.amount_paid);
                    $('#discount_amount').text(response.discount_amount);
                    $('#fine_amount').text(response.fine_amount);
                    $('#amount_due').text(response.amount_due);
                    $('#adjustment_notes').text(response.adjustment_notes || 'None');
                }
            });
        }
    });

    // When type changes, show appropriate field
    $('#type').change(function() {
        var type = $(this).val();
        
        // Reset and hide all fields
        $('#discount_field, #fine_field, #adjustment_operation_field').hide();
        $('#discount_id, #fine_id, #adjustment_operation').prop('disabled', true);
        $('#amount').val('').prop('readonly', true);
        
        if(type == 'discount') {
            $('#discount_field').show();
            $('#discount_id').prop('disabled', false);
        } else if(type == 'fine') {
            $('#fine_field').show();
            $('#fine_id').prop('disabled', false);
        } else if(type == 'adjustment') {
            $('#adjustment_operation_field').show();
            $('#adjustment_operation').prop('disabled', false);
            $('#amount').prop('readonly', false);
        }
    });

    // When discount is selected, calculate amount
    $('#discount_id').change(function() {
        var selected = $(this).find('option:selected');
        var type = selected.data('type');
        var amount = selected.data('amount');
        var dueAmount = parseFloat($('#amount_due').text()) || 0;
        
        if(type == 1) { // Percentage
            var discountAmount = (dueAmount * amount) / 100;
            $('#amount').val(discountAmount.toFixed(2));
        } else { // Fixed
            $('#amount').val(amount);
        }
    });

    // When fine is selected, set amount
    $('#fine_id').change(function() {
        var selected = $(this).find('option:selected');
        var amount = selected.data('amount');
        $('#amount').val(amount);
    });
</script>
@endsection