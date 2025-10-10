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
                        <h5>{{ __('modal_add') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>
                        <a href="{{ route($route.'.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" id="invoiceForm">
                    @csrf
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-6">
                            <label for="invoice_no">{{ __('field_invoice_no') }} <span>*</span></label>
                            <input type="text" class="form-control" name="invoice_no" id="invoice_no" value="{{ $invoice_no }}" required readonly>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_invoice_no') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="payer_type">{{ __('field_payer_type') }} <span>*</span></label>
                            <select class="form-control" name="payer_type" id="payer_type" required>
                                <option value="">{{ __('select') }}</option>
                                <option value="student">{{ __('field_student') }}</option>
                                <option value="staff">{{ __('field_staff') }}</option>
                                <option value="outsider">{{ __('field_outsider') }}</option>
                            </select>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_payer_type') }}
                            </div>
                        </div>

                        <!-- Student Payer Fields -->
<div class="form-group col-md-6 payer-field" id="student-field" style="display: none;">
    <label for="payer_id_student">{{ __('field_student') }} <span>*</span></label>
    <select class="form-control select2" name="payer_id_student" id="payer_id_student">
        <option value="">{{ __('select') }}</option>
        @foreach($students as $student)
        <option value="{{ $student->id }}" data-email="{{ $student->email }}" data-phone="{{ $student->phone }}">
            {{ $student->student_id }} - {{ $student->first_name }} {{ $student->last_name }}
        </option>
        @endforeach
    </select>
</div>

<!-- Staff Payer Fields -->
<div class="form-group col-md-6 payer-field" id="staff-field" style="display: none;">
    <label for="payer_id_staff">{{ __('field_staff') }} <span>*</span></label>
    <select class="form-control select2" name="payer_id_staff" id="payer_id_staff">
        <option value="">{{ __('select') }}</option>
        @foreach($staff as $staffMember)
        <option value="{{ $staffMember->id }}" data-email="{{ $staffMember->email }}" data-phone="{{ $staffMember->phone }}">
            {{ $staffMember->staff_id }} - {{ $staffMember->first_name }} {{ $staffMember->last_name }}
        </option>
        @endforeach
    </select>
</div>

                        <!-- Outsider Payer Fields -->
                        <div class="payer-field" id="outsider-field" style="display: none;">
                            <div class="form-group col-md-4">
                                <label for="payer_name">{{ __('field_name') }} <span>*</span></label>
                                <input type="text" class="form-control" name="payer_name" id="payer_name">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="payer_email">{{ __('field_email') }}</label>
                                <input type="email" class="form-control" name="payer_email" id="payer_email">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="payer_phone">{{ __('field_phone') }}</label>
                                <input type="text" class="form-control" name="payer_phone" id="payer_phone">
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="title">{{ __('field_title') }} <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_title') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="amount">{{ __('field_amount') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="amount" id="amount" value="{{ old('amount') }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_amount') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="date">{{ __('field_date') }} <span>*</span></label>
                            <input type="date" class="form-control date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_date') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="due_date">{{ __('field_due_date') }}</label>
                            <input type="date" class="form-control date" name="due_date" id="due_date" value="{{ old('due_date') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_due_date') }}
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description">{{ __('field_description') }}</label>
                            <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="status" class="form-label">{{ __('field_status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1">{{ __('status_active') }}</option>
                                <option value="0">{{ __('status_inactive') }}</option>
                            </select>
                        </div>
                        <!-- Form End -->
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
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

@section('page_js')
<script>
$(document).ready(function() {
    // Payer type change handler
    $('#payer_type').change(function() {
        var payerType = $(this).val();
        
        // Hide all payer fields and clear values
        $('.payer-field').hide();
        $('.payer-field select, .payer-field input').prop('required', false);
        $('#payer_id_student, #payer_id_staff').val('').trigger('change');
        $('#payer_name, #payer_email, #payer_phone').val('');
        
        // Show selected payer field
        if (payerType === 'student') {
            $('#student-field').show();
            $('#payer_id_student').prop('required', true);
        } else if (payerType === 'staff') {
            $('#staff-field').show();
            $('#payer_id_staff').prop('required', true);
        } else if (payerType === 'outsider') {
            $('#outsider-field').show();
            $('#payer_name').prop('required', true);
        }
    });

    // Initialize Select2
    $('.select2').select2();

    // Form validation and data preparation before submit
    $('#invoiceForm').on('submit', function(e) {
        var payerType = $('#payer_type').val();
        var isValid = true;
        var payerId = null;

        // Validate based on payer type
        if (payerType === 'student') {
            payerId = $('#payer_id_student').val();
            if (!payerId) {
                isValid = false;
                alert('Please select a student');
            }
        } else if (payerType === 'staff') {
            payerId = $('#payer_id_staff').val();
            if (!payerId) {
                isValid = false;
                alert('Please select a staff member');
            }
        } else if (payerType === 'outsider') {
            if (!$('#payer_name').val()) {
                isValid = false;
                alert('Please enter outsider name');
            }
        }

        if (isValid) {
            // Set the main payer_id field based on selection
            if (payerType === 'student' || payerType === 'staff') {
                // Create a hidden input or set the main payer_id field
                $('<input>').attr({
                    type: 'hidden',
                    name: 'payer_id',
                    value: payerId
                }).appendTo('#invoiceForm');
            }
        } else {
            e.preventDefault();
        }
    });

    // Auto-fill email and phone when student/staff is selected
    $(document).on('change', '#payer_id_student, #payer_id_staff', function() {
        var selectedOption = $(this).find('option:selected');
        var email = selectedOption.data('email');
        var phone = selectedOption.data('phone');
        
        // You can auto-fill these in additional fields if needed
        console.log('Selected - Email:', email, 'Phone:', phone);
    });
});
</script>
@endsection

@endsection