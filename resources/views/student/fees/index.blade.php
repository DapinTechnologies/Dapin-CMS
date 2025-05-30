@extends('student.layouts.master')
@section('title', $title)
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- Notification for Bank Payment Details -->
                      

                        <form class="needs-validation" novalidate method="get" action="{{ route($route .'.index') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="session">{{ __('field_session') }}</label>
                                    <select class="form-control" name="session" id="session">
                                        <option value="0">{{ __('all') }}</option>
                                        @foreach( $sessions as $session )
                                        <option value="{{ $session->session_id }}" @if( $selected_session == $session->session_id) selected @endif>{{ $session->session->title }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_session') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="semester">{{ __('field_semester') }}</label>
                                    <select class="form-control" name="semester" id="semester">
                                        <option value="0">{{ __('all') }}</option>
                                        @foreach( $semesters as $semester )
                                        <option value="{{ $semester->semester_id }}" @if( $selected_semester == $semester->semester_id) selected @endif>{{ $semester->semester->title }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_semester') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="category">{{ __('field_fees_type') }}</label>
                                    <select class="form-control" name="category" id="category" required>
                                        <option value="0">{{ __('all') }}</option>
                                        @foreach( $categories as $category )
                                        <option value="{{ $category->id }}" @if( $selected_category == $category->id) selected @endif>{{ $category->title }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_fees_type') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-block">
                        {{-- <div class="alert alert-info" role="alert">
                            <strong>Bank Payment Details:</strong><br>
                            Bank Name:  Kenya Commercial Bank (KCB)<br>
                            Account Number:  1296864421 
                        </div> --}}
                        <!-- [ Data table ] start -->
                        @isset($rows)
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">{{ __('field_session') }}</th>
                                        <th class="text-center">{{ __('field_semester') }}</th>
                                        <th class="text-center">{{ __('field_fees_type') }}</th>
                                        <th class="text-right">{{ __('field_fee') }}</th>
                                        <th class="text-right">{{ __('field_paid_amount') }}</th>
                                        <th class="text-right">{{ __('Due Amount') }}</th>
                                        <th class="text-center">{{ __('field_due_date') }}</th>
                                        <th class="text-center">{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key => $row)
                                    <tr>
                                        <!-- Serial Number -->
                                        <td class="text-center">{{ $key + 1 }}</td>
                            
                                        <!-- Session and Semester -->
                                        <td class="text-center">{{ $row->studentEnroll->session->title ?? '' }}</td>
                                        <td class="text-center">{{ $row->studentEnroll->semester->title ?? '' }}</td>
                            
                                        <!-- Fees Type -->
                                        <td class="text-center">{{ $row->category->title ?? '' }}</td>
                            
                                        <!-- Total Fee -->
                                        <td class="text-right">
                                            {{ number_format((float)$row->fee_amount, $setting->decimal_place ?? 2, '.', '') }} {!! $setting->currency_symbol !!}
                                        </td>
                            
                                        <!-- Paid Amount -->
                                        <td class="text-right">
                                            {{ number_format($row->paid_amount, $setting->decimal_place ?? 2, '.', '') }} {!! $setting->currency_symbol !!}
                                        </td>
                            
                                        <!-- Due Amount -->
                                        <td class="text-right">
                                            @php
                                                $dueAmount = max(0, $row->fee_amount - $row->paid_amount);
                                            @endphp
                                            {{ number_format($dueAmount, $setting->decimal_place ?? 2, '.', '') }} {!! $setting->currency_symbol !!}
                                        </td>
                            
                                        <!-- Due Date -->
                                        <td class="text-center">
                                            @if($row->due_date != '1970-01-01')
                                                {{ date($setting->date_format ?? "Y-m-d", strtotime($row->due_date)) }}
                                            @endif
                                        </td>
                            
                                        <!-- Action -->
                                        <td class="text-center">
                                            @php
                                            $queryData = [
                                                'fee_id' => $row->id,
                                                'student_id' => Auth::user()->id,
                                                'fee_category_id' => $row->category->id ?? '',
                                                'due_date' => $row->due_date ?? '',
                                                'fee_amount' => $row->fee_amount,
                                                'paid_amount' => $row->paid_amount ?? 0,
                                                'phone_number' => Auth::user()->phone,
                                            ];
                                            $queryString = http_build_query($queryData);
                                        @endphp
                                        
                                        <a href="{{ route('paymentprocess', $row->id) }}?{{ $queryString }}" 
                                           class="btn btn-success" 
                                           style="padding: 4px 8px; font-size: 12px;">
                                            <i class="fas fa-money-bill-alt"></i> {{ __('Pay') }}
                                        </a>
                                        
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            
                            
                                
                        </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#basic-table').DataTable();
    });
</script>
@endsection
