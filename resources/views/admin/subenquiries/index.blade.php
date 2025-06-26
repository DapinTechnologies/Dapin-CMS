@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">All Submissions</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Type</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Received At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enquiries as $item)
            <tr>
                <td>{{ ucfirst($item->type) }}</td>
                <td>{{ $item->name ?? '-' }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone ?? '-' }}</td>
                <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                <td>
                    <a href="{{ route('sub_enquiries.show', $item->id) }}" class="btn btn-sm btn-info">View</a>
                    <form action="{{ route('sub_enquiries.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this entry?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $enquiries->links() }}
</div>
@endsection
