@extends('admin.layouts.master')
@section('title', 'Assigned Fees History')
@section('content')

<h4>Assigned Fees History</h4>
<a href="{{ route('admin.fees-summary') }}" class="btn btn-info mb-3">View School Fees Summary</a>

@foreach($studentEnrolls as $enroll)
    @php
        $student = $enroll->student;
        $fees = $enroll->fees;

        $totalAssigned = $fees->sum('fee_amount');
        $totalPaid = $fees->where('status', 1)->sum('fee_amount');
        $totalDue = $fees->where('status', 0)->sum('fee_amount');
    @endphp

    <div class="card mb-4">
        <div class="card-header">
            <strong>
                {{ $student->student_id }} - {{ $student->first_name }} {{ $student->last_name }}
            </strong>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Amount (Ksh)</th>
                        <th>Assigned Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fees as $fee)
                        <tr>
                            <td>{{ $fee->category->title ?? 'N/A' }}</td>
                            <td>{{ number_format($fee->fee_amount, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($fee->assign_date)->format('d-M-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($fee->due_date)->format('d-M-Y') }}</td>
                            <td>
                                @if($fee->status == 0)
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($fee->status == 1)
                                    <span class="badge badge-success">Paid</span>
                                @else
                                    <span class="badge badge-secondary">Unknown</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total Assigned</th>
                        <th>{{ number_format($totalAssigned, 2) }}</th>
                        <th colspan="3"></th>
                    </tr>
                    <tr>
                        <th>Total Paid</th>
                        <th>{{ number_format($totalPaid, 2) }}</th>
                        <th colspan="3"></th>
                    </tr>
                    <tr>
                        <th>Total Due</th>
                        <th>{{ number_format($totalDue, 2) }}</th>
                        <th colspan="3"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endforeach

@endsection
