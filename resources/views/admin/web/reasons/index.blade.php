@extends('admin.layouts.master')

@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <h4>Reasons</h4>
        <a href="{{ route('admin.admin.reasons.create') }}" class="btn btn-primary mb-3">Add New Reason</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Icon</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reasons as $reason)
                    <tr>
                        <td>{{ $reason->title }}</td>
                        <td><i class="fas {{ $reason->icon }}"></i></td>
                        <td>{{ Str::limit($reason->description, 50) }}</td>
                        <td>
                            <a href="{{ route('admin.admin.reasons.edit', $reason->id) }}" class="btn btn-info btn-sm">Edit</a>

                            <form action="{{ route('admin.admin.reasons.destroy', $reason->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{-- {{ $reasons->links() }} --}}
        </div>
    </div>
</div>

@endsection
