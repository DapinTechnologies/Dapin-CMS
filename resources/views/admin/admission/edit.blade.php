@extends('admin.layouts.master')

@section('content')
    <h3>Edit Admission Process Step</h3>

    <form action="{{ route('admin.admission.process.update', $step->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $step->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description" rows="3" required>{{ old('description', $step->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="requirements" class="form-label">Requirements</label>

            @foreach(json_decode($step->requirements) as $requirement)
                <input type="text" name="requirements[]" class="form-control mb-2" value="{{ $requirement }}">
            @endforeach

            <input type="text" name="requirements[]" class="form-control mb-2">
            <input type="text" name="requirements[]" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
