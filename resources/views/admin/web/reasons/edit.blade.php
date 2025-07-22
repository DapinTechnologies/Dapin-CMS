@extends('admin.layouts.master')

@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <h4>Edit Reason</h4>
        <form action="{{ route('admin.admin.reasons.update', $reason->id) }}" method="POST">
            @csrf
         
            <div class="form-group">
                <label for="title">Reason Title</label>
                <input type="text" name="title" class="form-control" value="{{ $reason->title }}" required>
            </div>
            <div class="form-group">
                <label for="icon">Icon (FontAwesome)</label>
                <input type="text" name="icon" class="form-control" value="{{ $reason->icon }}" required>
            </div>
            <div class="form-group">
                <label for="description">Reason Description</label>
                <textarea name="description" class="form-control" rows="4" required>{{ $reason->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Reason</button>
        </form>
    </div>
</div>

@endsection
