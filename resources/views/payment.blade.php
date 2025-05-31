@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Payment Successful</h3>
        <p>Fee: {{ $fee->category->name }}</p>
        <p>Amount Paid: KES {{ number_format($fee->paid_amount, 2) }}</p>
        <p>Remaining Balance: KES {{ number_format($fee->remaining_balance, 2) }}</p>
        <a href="{{ route('fees.index') }}" class="btn btn-primary">Back to Fees</a>
    </div>
@endsection
