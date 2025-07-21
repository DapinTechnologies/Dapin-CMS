@extends('student.layouts.master')
@section('title', $title)
@section('content')

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
                        <!-- Filter Form -->
                        <form class="needs-validation" novalidate method="get" action="{{ route($route .'.index') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="session">{{ __('field_session') }}</label>
                                    <select class="form-control" name="session" id="session">
                                        <option value="0">{{ __('all') }}</option>
                                        @foreach($sessions as $session)
                                        <option value="{{ $session->session_id }}" 
                                            @if($selected_session == $session->session_id) selected @endif>
                                            {{ $session->session->title }}
                                        </option>
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
                                        @foreach($semesters as $semester)
                                        <option value="{{ $semester->semester_id }}" 
                                            @if($selected_semester == $semester->semester_id) selected @endif>
                                            {{ $semester->semester->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_semester') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="category">{{ __('field_fees_type') }}</label>
                                    <select class="form-control" name="category" id="category">
                                        <option value="0">{{ __('all') }}</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            @if($selected_category == $category->id) selected @endif>
                                            {{ $category->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_fees_type') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter">
                                        <i class="fas fa-search"></i> {{ __('btn_filter') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    @if(!empty($invoices) && $invoices->count())
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Latest Invoices</h5>
                            <input type="text" id="invoice-search" class="form-control w-50" placeholder="Search by invoice no...">
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="invoice-table">
                                    <thead>
                                        <tr>
                                            
                                            <th>Session</th>
                                            <th>Semester</th>
                                            <th>Fee Categories</th>
                                            <th class="text-right">Total Fee</th>
                                            <th class="text-right">Amount Paid</th>
                                            <th class="text-right">Amount Due</th>
                                            <th>Assign Date</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoices as $invoice)
                                        @php
    // Calculate total paid amount
    $totalPaid = $invoice->payments->sum('amount');
    $amountDue = max(0, $invoice->total_fee - $totalPaid);
    
    
   
    // Get fees from relationship or direct query
    $fees = $invoice->fees ?? \App\Models\Fee::where('invoice_id', $invoice->id)->get();
    
    // Fallback query if still empty
    if ($fees->isEmpty()) {
        $fees = \App\Models\Fee::where('student_enroll_id', $invoice->student_enroll_id)
            ->where('assign_date', $invoice->assign_date)
            ->where('due_date', $invoice->due_date)
            ->get();
    }

    // Generate HTML for each fee category in separate spans
    $categoryList = $fees->map(function($fee) {
        $categoryTitle = $fee->category->title ?? 'Category #' . $fee->category_id;
        $amount = number_format($fee->category->amount ?? $fee->amount, 2);
        
        return sprintf(
            '<div class="mb-1"><span class="badge badge-info">%s (%s)</span></div>',
            $categoryTitle,
            $amount
        );
    })->implode('');

    if ($fees->isEmpty()) {
        $categoryList = '<span class="text-danger">No fees assigned</span>';
    }


    // Determine status
    if ($totalPaid >= $invoice->total_fee) {
        $status = 'Paid';
        $statusClass = 'success';
    } elseif ($totalPaid > 0) {
        $status = 'Partial';
        $statusClass = 'warning';
    } else {
        $status = 'Unpaid';
        $statusClass = 'danger';
    }
@endphp

                                        <tr>
                                            
                                            <td>{{ $invoice->studentEnroll->session->title ?? '' }}</td>
                                            <td>{{ $invoice->studentEnroll->semester->title ?? '' }}</td>
                                            <td class="d-flex flex-column">
                                                {!! $categoryList !!}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($invoice->total_fee, $setting->decimal_place ?? 2) }} 
                                                {!! $setting->currency_symbol !!}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($totalPaid, $setting->decimal_place ?? 2) }} 
                                                {!! $setting->currency_symbol !!}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($amountDue, $setting->decimal_place ?? 2) }} 
                                                {!! $setting->currency_symbol !!}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->assign_date)->format('d M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $statusClass }}">{{ $status }}</span>
                                            </td>
                                            <td>
                                                @if($amountDue > 0)
                                                <a href="{{ route('paymentprocess', $invoice->id) }}" 
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-money-bill-alt"></i> Pay
                                                </a>
                                                @else
                                                <span class="badge bg-success">Paid</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="card-body">
                        <div class="alert alert-info" role="alert">
                            No invoices found matching your criteria.
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Invoice search functionality
        $('#invoice-search').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#invoice-table tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection