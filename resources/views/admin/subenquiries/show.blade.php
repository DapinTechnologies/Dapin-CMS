@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h4>Submission Detail</h4>
    <ul class="list-group">
        <li class="list-group-item"><strong>Type:</strong> {{ ucfirst($entry->type) }}</li>
        @if($entry->name)
        <li class="list-group-item"><strong>Name:</strong> {{ $entry->name }}</li>
        @endif
        @if($entry->phone)
        <li class="list-group-item"><strong>Phone:</strong> {{ $entry->phone }}</li>
        @endif
        <li class="list-group-item"><strong>Email:</strong> {{ $entry->email }}</li>
        @if($entry->message)
        <li class="list-group-item"><strong>Message:</strong> {{ $entry->message }}</li>
        @endif
        <li class="list-group-item"><strong>Submitted:</strong> {{ $entry->created_at->diffForHumans() }}</li>
    </ul>
    <a href="{{ route('sub_enquiries.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
