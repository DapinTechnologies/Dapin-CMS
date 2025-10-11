@extends('admin.layouts.master')

@section('title', 'Edit Core Value')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Edit Core Value</h2>

    <form action="{{ route('admin.core-values.update', $value->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="icon">Icon</label>
            <input type="text" class="form-control" name="icon" value="{{ $value->icon }}" required>
        </div>

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" value="{{ $value->title }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" required>{{ $value->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update Core Value</button>
    </form>
</div>
@endsection
