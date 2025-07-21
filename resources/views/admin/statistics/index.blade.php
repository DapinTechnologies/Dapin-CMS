@extends('admin.layouts.master')

@section('title', 'Statistics')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Statistics</h2>
    <div class="mb-4 text-right">
        <a href="{{ route('admin.statistics.create') }}" class="btn btn-success">Add New Statistic</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Type</th>
                <th>Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statistics as $statistic)
                <tr>
                    <td>{{ $statistic->type }}</td>
                    <td>{{ $statistic->count }}</td>
                    <td>
                        <a href="{{ route('admin.statistics.edit', $statistic->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.statistics.destroy', $statistic->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
