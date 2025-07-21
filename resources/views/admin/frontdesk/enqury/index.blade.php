@extends('admin.layouts.master')

@section('content')


<style>
    .btn-icon {
    margin-right: 5px;
}

</style>
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
<button>
    <a href="{{route('admin.admin.subscriptions.index')}}">Subscription </a>
</button>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inquiries as $inquiry)
                <tr>
                    <td>{{ $inquiry->name }}</td>
                    <td>{{ $inquiry->email }}</td>
                    <td>{{ $inquiry->phone }}</td>
                    <td>{{ Str::limit($inquiry->message, 50) }} <a href="#" class="view-email" data-email="{{ $inquiry->email }}" data-message="{{ $inquiry->message }}">View</a></td>
                    <td>{{ $inquiry->created_at->diffForHumans() }}</td>
                    <td>
                        <!-- View Button to open modal or show email -->
                        <a href="{{route('admin.admin.inquiry.show',$inquiry->id)}}" class="btn btn-info btn-sm view-btn" data-id="{{ $inquiry->id }}">View</a>
                        
                        <!-- Delete Button -->
                        <form action="{{ route('admin.admin.inquiry.delete', $inquiry->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $inquiries->links() }}
    </div>
</div>






















          </div>
</div>
@endsection