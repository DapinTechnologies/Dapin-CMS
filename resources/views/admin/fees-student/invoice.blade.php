@extends('admin.layouts.master')
@section('title', 'Fees Invoice')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <h3>Fees Invoice</h3>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Student Name</th>
                            <th>Student ID</th>
                            <th>Total Fee</th>
                            <th>Amount Paid</th>
                            <th>Amount Due</th>
                            <th>Payment Status</th>
                            <th>Assign Date</th>
                            <th>Due Date</th>
                            <th>Action</th>  <!-- New column -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $item)
                            <tr>
                                <td>{{ $item['invoice']->invoice_no }}</td>
                                <td>{{ $item['student']->first_name }} {{ $item['student']->last_name }}</td>
                                <td>{{ $item['student']->student_id }}</td>
                                <td>Ksh {{ number_format($item['total_fee_amount'], 2) }}</td>
                                <td>Ksh {{ number_format($item['total_paid'], 2) }}</td>
                                <td>Ksh {{ number_format($item['total_due'], 2) }}</td>
                                <td>{{ $item['payment_status'] }}</td>
                                <td>{{ $item['invoice']->assign_date }}</td>
                                <td>{{ $item['invoice']->due_date }}</td>
                                <td>
                                    <a href="{{ route('fees.invoice.show', $item['invoice']->id) }}" class="btn btn-sm btn-primary" title="View Invoice">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection
