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
                        <h5>{{ __('modal_edit') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>
                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <form class="needs-validation" novalidate action="{{ route($route.'.update', [$row->id]) }}" method="post" id="invoiceForm">
                    @csrf
                    @method('PUT')
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-6">
                            <label for="invoice_no">{{ __('field_invoice_no') }} <span>*</span></label>
                            <input type="text" class="form-control" name="invoice_no" id="invoice_no" value="{{ $row->invoice_no }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_invoice_no') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="payer_type">{{ __('field_payer_type') }} <span>*</span></label>
                            <select class="form-control" name="payer_type" id="payer_type" required>
                                <option value="">{{ __('select') }}</option>
                                <option value="student" @if($row->payer_type == 'student') selected @endif>{{ __('field_student') }}</option>
                                <option value="staff" @if($row->payer_type == 'staff') selected @endif>{{ __('field_staff') }}</option>
                                <option value="outsider" @if($row->payer_type == 'outsider') selected @endif>{{ __('field_outsider') }}</option>
                            </select>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_payer_type') }}
                            </div>
                        </div>

                        <!-- Student Payer Fields -->
                        <div class="form-group col-md-6 payer-field" id="student-field" style="display: {{ $row->payer_type == 'student' ? 'block' : 'none' }};">
                            <label for="payer_id_student">{{ __('field_student') }} <span>*</span></label>
                            <select class="form-control select2" name="payer_id" id="payer_id_student">
                                <option value="">{{ __('select') }}</option>
                                @foreach($students as $student)
                                <option value="{{ $student->id }}" 
                                    data-email="{{ $student->email }}" 
                                    data-phone="{{ $student->phone }}"
                                    @if($row->payer_type == 'student' && $row->payer_id == $student->id) selected @endif>
                                    {{ $student->student_id }} - {{ $student->first_name }} {{ $student->last_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Staff Payer Fields -->
                        <div class="form-group col-md-6 payer-field" id="staff-field" style="display: {{ $row->payer_type == 'staff' ? 'block' : 'none' }};">
                            <label for="payer_id_staff">{{ __('field_staff') }} <span>*</span></label>
                            <select class="form-control select2" name="payer_id" id="payer_id_staff">
                                <option value="">{{ __('select') }}</option>
                                @foreach($staff as $staffMember)
                                <option value="{{ $staffMember->id }}" 
                                    data-email="{{ $staffMember->email }}" 
                                    data-phone="{{ $staffMember->phone }}"
                                    @if($row->payer_type == 'staff' && $row->payer_id == $staffMember->id) selected @endif>
                                    {{ $staffMember->staff_id }} - {{ $staffMember->first_name }} {{ $staffMember->last_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Outsider Payer Fields -->
                        <div class="payer-field" id="outsider-field" style="display: {{ $row->payer_type == 'outsider' ? 'block' : 'none' }};">
                            <div class="form-group col-md-4">
                                <label for="payer_name">{{ __('field_name') }} <span>*</span></label>
                                <input type="text" class="form-control" name="payer_name" id="payer_name" value="{{ $row->payer_name }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="payer_email">{{ __('field_email') }}</label>
                                <input type="email" class="form-control" name="payer_email" id="payer_email" value="{{ $row->payer_email }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="payer_phone">{{ __('field_phone') }}</label>
                                <input type="text" class="form-control" name="payer_phone" id="payer_phone" value="{{ $row->payer_phone }}">
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="title">{{ __('field_title') }} <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ $row->title }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_title') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="amount">{{ __('field_amount') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="amount" id="amount" value="{{ round($row->amount) }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_amount') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="date">{{ __('field_date') }} <span>*</span></label>
                            <input type="date" class="form-control date" name="date" id="date" value="{{ $row->date }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_date') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="due_date">{{ __('field_due_date') }}</label>
                            <input type="date" class="form-control date" name="due_date" id="due_date" value="{{ $row->due_date }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_due_date') }}
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description">{{ __('field_description') }}</label>
                            <textarea class="form-control" name="description" id="description" rows="3">{{ $row->description }}</textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="status" class="form-label">{{ __('field_status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1" @if($row->status == 1) selected @endif>{{ __('status_active') }}</option>
                                <option value="0" @if($row->status == 0) selected @endif>{{ __('status_inactive') }}</option>
                            </select>
                        </div>
                        <!-- Form End -->
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
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
        
        // Hide all payer fields
        $('.payer-field').hide();
        $('.payer-field select, .payer-field input').prop('required', false);
        
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

    // Form validation
    $('#invoiceForm').on('submit', function(e) {
        var payerType = $('#payer_type').val();
        var isValid = true;

        if (payerType === 'student' && !$('#payer_id_student').val()) {
            isValid = false;
            alert('Please select a student');
        } else if (payerType === 'staff' && !$('#payer_id_staff').val()) {
            isValid = false;
            alert('Please select a staff member');
        } else if (payerType === 'outsider' && !$('#payer_name').val()) {
            isValid = false;
            alert('Please enter outsider name');
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    // Set initial payer ID based on current payer type
    var currentPayerType = '{{ $row->payer_type }}';
    if (currentPayerType === 'student') {
        $('#payer_id_student').val({{ $row->payer_id ?? 'null' }});
    } else if (currentPayerType === 'staff') {
        $('#payer_id_staff').val({{ $row->payer_id ?? 'null' }});
    }
});
</script>
@endsection

@endsection