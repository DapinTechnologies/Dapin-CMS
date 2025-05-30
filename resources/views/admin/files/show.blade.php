<!-- resources/views/files/show.blade.php -->

@extends('admin.layouts.master')
@section('title', 'File Details')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>{{ $file->title }}</h5>
    </div>
    <div class="card-body">
        <p><strong>Description:</strong> {{ $file->description }}</p>
        <p><strong>File Type:</strong> {{ $file->file_type }}</p>
        <p><strong>Uploaded By:</strong> {{ $file->uploaded_by }}</p>
        <a href="{{ Storage::url($file->file_path) }}" class="btn btn-primary" target="_blank">Download File</a>
    </div>
    <div class="card-footer">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a> <!-- Back button -->
    </div>
</div>
@endsection
