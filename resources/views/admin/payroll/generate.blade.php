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
                        <h5>{{ __('btn_generate') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>
                        <a href="{{ route($route.'.generate', ['id' => $row->id, 'month' => $selected_month, 'year' => $selected_year]) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    @php
                    // Your existing PHP calculations here...
                    $paid_leave = \App\Models\Leave::paid_leave($row->id, $selected_month, $selected_year);
                    $unpaid_leave = \App\Models\Leave::unpaid_leave($row->id, $selected_month, $selected_year);

                    $present = $attendances->where('attendance', 1)->where('user_id', $row->id)->count();
                    $absent = $attendances->where('attendance', 2)->where('user_id', $row->id)->count();
                    $leave = $attendances->where('attendance', 3)->where('user_id', $row->id)->count();
                    $holiday = $attendances->where('attendance', 4)->where('user_id', $row->id)->count();

                    $payable_days = $present + $holiday + $paid_leave;
                    $unpayable_days = $absent + $unpaid_leave;

                    if($row->basic_salary != null || $row->basic_salary != ''){
                        $basic_salary = $row->basic_salary;
                    }else{
                        $basic_salary = 0;
                    }

                    if($row->salary_type == 1){
                        $per_day_salary = $basic_salary / $total_days;
                        $total_earning = $per_day_salary * $payable_days;
                        $deduction_salary = $per_day_salary * $unpayable_days;
                    }

                    if($row->salary_type == 2){
                        $total_earning = $basic_salary * $payable_days;
                        $deduction_salary = $basic_salary * $unpayable_days;
                    }

                    $total_allowance = round($payroll->total_allowance ?? 0);
                    $bonus = round($payroll->bonus ?? 0);
                    $total_deduction = round($payroll->total_deduction ?? 0);

                    $gross_salary = round($total_earning + $total_allowance + $bonus) - round($total_deduction);
                    $tax_amount = 0;

                    if(isset($payroll) && round($total_earning) == round($payroll->total_earning)){  
                        $tax_amount = round($payroll->tax ?? 0);
                    }
                    else{
                        if(isset($taxs)){
                        foreach($taxs as $tax){
                            if($tax->min_amount <= $gross_salary && $tax->max_amount >= $gross_salary){
                                $taxable_amount = $gross_salary - $tax->max_no_taxable_amount;
                                $tax_amount = ($taxable_amount / 100) * $tax->percentange;
                            }
                        }}
                    }

                    $net_salary = round($gross_salary - $tax_amount);
                    @endphp

                    <!-- Your existing staff info and attendance display -->

                    <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <input type="hidden" name="user_id" value="{{ $row->id }}">
                        <input type="hidden" name="basic_salary" value="{{ round($basic_salary, 2) }}">
                        <input type="hidden" name="salary_type" value="{{ $row->salary_type }}">
                        <input type="hidden" name="salary_month" value="{{ date("Y-m-d", strtotime($selected_year.'-'.$selected_month.'-01')) }}">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('field_total_allowance') }}</h5>
                                        <button id="addAllowance" type="button" class="btn btn-info btn-sm btn-icon"><i class="fas fa-plus"></i></button>
                                    </div>
                                    <div class="card-block">
                                        @isset($payroll)
                                        @foreach($payroll->details->where('status', 1) as $detail)
                                        <div id="allowanceFormField" class="row">
                                            <div class="form-group col-md-6">
                                                <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                                                <input type="text" class="form-control" name="allowance_titles[]" id="title" value="{{ $detail->title }}" required>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_title') }}</div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="allowance" class="form-label">{{ __('field_amount') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                                                <input type="text" class="form-control allowance" name="allowances[]" id="allowance" value="{{ round($detail->amount) }}" data_id="add-{{ $row->id }}" onkeyup="salaryCalculator('add', {{ $row->id }})" required>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_amount') }}</div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <button type="button" class="btn btn-danger btn-sm btn-icon remove-allowance"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endisset
                                        <div id="newAllowance" class="clearfix"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('field_total_deduction') }}</h5>
                                        <button id="addDeduction" type="button" class="btn btn-info btn-sm btn-icon"><i class="fas fa-plus"></i></button>
                                    </div>
                                    <div class="card-block">
                                        <!-- Statutory Deductions Section -->
                                        <div class="form-group">
                                            <label class="form-label"><strong>{{ __('Statutory Deductions') }}</strong></label>
                                            <div class="deduction-checkboxes">
                                                @foreach($deduction_settings as $deduction)
                                                <div class="form-check mb-2">
                                                    <input type="checkbox" 
                                                           class="form-check-input statutory-deduction" 
                                                           name="selected_deductions[]" 
                                                           value="{{ $deduction->id }}"
                                                           id="deduction_{{ $deduction->id }}"
                                                           {{ isset($user_deduction_preferences[$deduction->id]) && $user_deduction_preferences[$deduction->id]->is_selected ? 'checked' : '' }}
                                                           data-deduction-id="{{ $deduction->id }}"
                                                           data-type="{{ $deduction->type }}"
                                                           data-fixed-amount="{{ $deduction->fixed_amount ?? 0 }}"
                                                           data-rate="{{ $deduction->rate ?? 0 }}"
                                                           data-percentage="{{ $deduction->percentage ?? 0 }}"
                                                           data-min-salary="{{ $deduction->min_salary ?? 0 }}"
                                                           data-max-salary="{{ $deduction->max_salary ?? 0 }}"
                                                           data-min-amount="{{ $deduction->min_amount ?? 0 }}"
                                                           data-max-amount="{{ $deduction->max_amount ?? 0 }}"
                                                           data-max-no-deduction="{{ $deduction->max_no_deduction_amount ?? 0 }}">
                                                    <label class="form-check-label" for="deduction_{{ $deduction->id }}">
                                                        {{ $deduction->name }}
                                                        @if($deduction->type == 'fixed')
                                                            (Fixed: {!! $setting->currency_symbol !!}{{ number_format($deduction->fixed_amount, 2) }})
                                                        @elseif($deduction->type == 'rate')
                                                            (Rate: {{ number_format($deduction->rate * 100, 2) }}%)
                                                        @elseif($deduction->type == 'tiered')
                                                            (Tiered: {{ $deduction->percentage }}%)
                                                        @endif
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <hr>

                                        <!-- Manual Deductions -->
                                        @isset($payroll)
                                        @foreach($payroll->details->where('status', 0)->where('is_auto', false) as $detail)
                                        <div id="deductionFormField" class="row manual-deduction">
                                            <div class="form-group col-md-6">
                                                <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                                                <input type="text" class="form-control" name="deduction_titles[]" id="title" value="{{ $detail->title }}" required>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_title') }}</div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="deduction" class="form-label">{{ __('field_amount') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                                                <input type="text" class="form-control deduction" name="deductions[]" id="deduction" value="{{ round($detail->amount) }}" data_id="add-{{ $row->id }}" onkeyup="salaryCalculator('add', {{ $row->id }})" required>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_amount') }}</div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <button type="button" class="btn btn-danger btn-sm btn-icon remove-deduction"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endisset

                                        <div id="newDeduction" class="clearfix"></div>

                                        <!-- Auto-calculated Deductions Display -->
                                        <div id="autoDeductionsDisplay" class="mt-3">
                                            <h6>{{ __('Auto-calculated Deductions') }}</h6>
                                            <div id="autoDeductionsList" class="small">
                                                <!-- Auto deductions will be displayed here -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('field_calculate') }}</h5>
                                        <button type="button" class="btn btn-info btn-sm btn-icon" data_id="add-{{ $row->id }}" onclick="salaryCalculator('add', {{ $row->id }})"><i class="fa-solid fa-arrows-rotate"></i></button>
                                    </div>
                                    <div class="card-block">
                                        <div class="form-group">
                                            <label for="total_earning">{{ __('field_total_earning') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                                            <input type="text" class="form-control" name="total_earning" id="total_earning" value="{{ round($total_earning, 0) }}" readonly required>
                                        </div>
                                        <div class="form-group">
                                            <label for="total_allowance">{{ __('field_total_allowance') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                                            <input type="text" class="form-control" name="total_allowance" id="total_allowance" value="{{ round($total_allowance, 0) }}" readonly required>
                                        </div>
                                        <div class="form-group">
                                            <label for="total_deduction">{{ __('field_total_deduction') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                                            <input type="text" class="form-control" name="total_deduction" id="total_deduction" value="{{ round($total_deduction, 0) }}" readonly required>
                                        </div>
                                        <div class="form-group">
                                            <label for="gross_salary">{{ __('field_gross_salary') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                                            <input type="text" class="form-control" name="gross_salary" id="gross_salary" value="{{ round($gross_salary, 0) }}" readonly required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tax">{{ __('field_tax') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                                            <input type="text" class="form-control" name="tax" id="tax" value="{{ round($tax_amount, 0) }}" readonly required>
                                        </div>
                                        <div class="form-group">
                                            <label for="net_salary">{{ __('field_net_salary') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                                            <input type="text" class="form-control" name="net_salary" id="net_salary" value="{{ round($net_salary, 0) }}" readonly required>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_js')
<script type="text/javascript">
"use strict";

// Handle statutory deduction changes
$(document).on('change', '.statutory-deduction', function() {
    salaryCalculator('add', {{ $row->id }});
});

// Enhanced salary calculator with automatic deductions
function salaryCalculator(type, id) {
    // Get base values first
    var total_earning = parseFloat($("input[name='total_earning']").val()) || 0;
    var basic_salary = parseFloat($("input[name='basic_salary']").val()) || 0;
    
    // Calculate manual allowances
    var allowance_sum = 0;
    $(".allowance").each(function () {
        var get_allowance_value = $(this).val();
        if ($.isNumeric(get_allowance_value)) {
            allowance_sum += parseFloat(get_allowance_value);
        }
    });

    // Calculate manual deductions
    var manual_deduction_sum = 0;
    $(".deduction").each(function () {
        var get_deduction_value = $(this).val();
        if ($.isNumeric(get_deduction_value)) {
            manual_deduction_sum += parseFloat(get_deduction_value);
        }
    });

    // Calculate initial gross salary (before auto deductions)
    var initial_gross = (total_earning + allowance_sum) - manual_deduction_sum;

    // Calculate automatic deductions
    var autoDeductions = calculateAutoDeductions(basic_salary, initial_gross);
    var totalAutoDeductions = autoDeductions.total;

    // Update auto deductions display
    updateAutoDeductionsDisplay(autoDeductions.deductions);

    // Calculate final gross salary (after auto deductions)
    var final_gross = initial_gross - totalAutoDeductions;

    // Calculate tax
    var tax_amount = calculateTax(final_gross);

    // Final net salary
    var net_total = final_gross - tax_amount;

    // Update form fields
    $("input[name='total_allowance']").val(Math.ceil(allowance_sum));
    $("input[name='total_deduction']").val(Math.ceil(manual_deduction_sum + totalAutoDeductions));
    $("input[name='gross_salary']").val(Math.ceil(final_gross));
    $("input[name='tax']").val(Math.ceil(tax_amount));
    $("input[name='net_salary']").val(Math.ceil(net_total));
}

// Calculate automatic deductions
function calculateAutoDeductions(basicSalary, grossSalary) {
    var total = 0;
    var deductions = [];
    
    $('.statutory-deduction:checked').each(function() {
        var deductionElement = $(this);
        var amount = 0;
        
        var deductionType = deductionElement.data('type');
        var fixedAmount = parseFloat(deductionElement.data('fixed-amount')) || 0;
        var rate = parseFloat(deductionElement.data('rate')) || 0;
        var percentage = parseFloat(deductionElement.data('percentage')) || 0;
        var minSalary = parseFloat(deductionElement.data('min-salary')) || 0;
        var maxSalary = parseFloat(deductionElement.data('max-salary')) || Infinity;
        var minAmount = parseFloat(deductionElement.data('min-amount')) || 0;
        var maxAmount = parseFloat(deductionElement.data('max-amount')) || Infinity;
        var maxNoDeduction = parseFloat(deductionElement.data('max-no-deduction')) || 0;
        
        switch(deductionType) {
            case 'fixed':
                amount = fixedAmount;
                break;
            case 'rate':
                var baseAmount = basicSalary;
                if (minSalary > 0) baseAmount = Math.max(baseAmount, minSalary);
                if (maxSalary < Infinity) baseAmount = Math.min(baseAmount, maxSalary);
                amount = baseAmount * rate;
                break;
            case 'tiered':
                var taxableAmount = Math.max(0, grossSalary - maxNoDeduction);
                if (taxableAmount > 0) {
                    var tierAmount = Math.min(taxableAmount, maxAmount) - minAmount;
                    amount = Math.max(0, tierAmount) * (percentage / 100);
                }
                break;
        }
        
        if (amount > 0) {
            total += amount;
            deductions.push({
                name: deductionElement.closest('.form-check').find('label').text().split(' (')[0],
                amount: Math.ceil(amount)
            });
        }
    });
    
    return {
        total: total,
        deductions: deductions
    };
}

// Calculate tax based on tax brackets
function calculateTax(grossSalary) {
    var tax_amount = 0;
    
    @php
    $taxsArray = [];
    if(isset($taxs)){
        foreach($taxs as $key => $value){
            $taxsArray[] = [
                'min_amount' => $value->min_amount,
                'max_amount' => $value->max_amount,
                'max_no_taxable_amount' => $value->max_no_taxable_amount,
                'percentange' => $value->percentange
            ];
        }
    }
    @endphp

    var taxs = <?php echo json_encode($taxsArray ?? []); ?>;
    
    if (taxs && taxs.length > 0) {
        for (var i = 0; i < taxs.length; ++i) {
            if (grossSalary >= taxs[i].min_amount && grossSalary <= taxs[i].max_amount) {
                var taxable_amount = Math.max(0, grossSalary - (taxs[i].max_no_taxable_amount || 0));
                tax_amount = (taxable_amount / 100) * taxs[i].percentange;
                break;
            }
        }
    }
    
    return tax_amount;
}

// Update auto deductions display
function updateAutoDeductionsDisplay(deductions) {
    var html = '';
    if (deductions.length > 0) {
        var totalAuto = 0;
        deductions.forEach(function(deduction) {
            totalAuto += deduction.amount;
            html += '<div class="alert alert-sm alert-info p-2 mb-1">';
            html += '<strong>' + deduction.name + ':</strong> ';
            html += '{!! $setting->currency_symbol !!}' + deduction.amount.toLocaleString();
            html += '</div>';
        });
        html += '<div class="alert alert-sm alert-warning p-2 mb-0">';
        html += '<strong>Total Auto Deductions:</strong> ';
        html += '{!! $setting->currency_symbol !!}' + totalAuto.toLocaleString();
        html += '</div>';
    } else {
        html = '<p class="text-muted">No auto-calculated deductions selected</p>';
    }
    $('#autoDeductionsList').html(html);
}

// Initialize calculation on page load
$(document).ready(function() {
    salaryCalculator('add', {{ $row->id }});
});

// Your existing JavaScript for adding/removing allowances and deductions
$(document).on('click', '#addAllowance', function () {
    var html = '';
    html += '<hr/>';
    html += '<div id="allowanceFormField" class="row">';
    html += '<div class="form-group col-md-6"><label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label><input type="text" class="form-control" name="allowance_titles[]" id="title" value="" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_title') }}</div></div>';
    html += '<div class="form-group col-md-4"><label for="allowance" class="form-label">{{ __('field_amount') }} ({!! $setting->currency_symbol !!}) <span>*</span></label><input type="text" class="form-control allowance" name="allowances[]" id="allowance" value="" onkeyup="salaryCalculator(\'add\', {{ $row->id }})" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_amount') }}</div></div>';
    html += '<div class="form-group col-md-2"><button type="button" class="btn btn-danger btn-sm btn-icon remove-allowance"><i class="fas fa-trash-alt"></i></button></div>';
    html += '</div>';

    $('#newAllowance').append(html);
});

$(document).on('click', '.remove-allowance', function () {
    $(this).closest('#allowanceFormField').remove();
    salaryCalculator('add', {{ $row->id }});
});

$(document).on('click', '#addDeduction', function () {
    var html = '';
    html += '<hr/>';
    html += '<div id="deductionFormField" class="row">';
    html += '<div class="form-group col-md-6"><label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label><input type="text" class="form-control" name="deduction_titles[]" id="title" value="" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_title') }}</div></div>';
    html += '<div class="form-group col-md-4"><label for="deduction" class="form-label">{{ __('field_amount') }} ({!! $setting->currency_symbol !!}) <span>*</span></label><input type="text" class="form-control deduction" name="deductions[]" id="deduction" value="" onkeyup="salaryCalculator(\'add\', {{ $row->id }})" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_amount') }}</div></div>';
    html += '<div class="form-group col-md-2"><button type="button" class="btn btn-danger btn-sm btn-icon remove-deduction"><i class="fas fa-trash-alt"></i></button></div>';
    html += '</div>';

    $('#newDeduction').append(html);
});

$(document).on('click', '.remove-deduction', function () {
    $(this).closest('#deductionFormField').remove();
    salaryCalculator('add', {{ $row->id }});
});
</script>
@endsection