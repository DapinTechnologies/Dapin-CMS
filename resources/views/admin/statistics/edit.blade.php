@extends('admin.layouts.master')

@section('title', 'Edit Statistic')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Edit Statistic</h2>

    <form action="{{ route('admin.statistics.update', $statistic->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" name="type" value="{{ $statistic->type }}" required>
        </div>

        <div class="form-group">
            <label for="count">Count</label>
            <input type="number" class="form-control" name="count" value="{{ $statistic->count }}" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update Statistic</button>
    </form>
</div>
@endsection
