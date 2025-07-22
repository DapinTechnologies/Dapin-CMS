@extends('admin.layouts.master')

@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <h4>Add New Reason</h4>
        <form action="{{ route('admin.admin.reasons.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="title">Reason Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="icon">Icon (FontAwesome)</label>
        <input type="text" name="icon" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Reason Description</label>
        <textarea name="description" class="form-control" rows="4" required></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Save Reason</button>
</form>

    </div>
</div>

@endsection
