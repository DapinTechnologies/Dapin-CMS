@extends('admin.layouts.master')

@section('title', 'Add New Core Value')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Add New Core Value</h2>

    <form action="{{ route('admin.core-values.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="icon">Icon</label>
            <input type="text" class="form-control" name="icon" required>
        </div>

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" required></textarea>
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Core Value</button>
    </form>
</div>
@endsection
