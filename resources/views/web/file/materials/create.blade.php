@extends('web.layouts.master')

@section('content')
<main>
    <section class="upload-material pt-120 pb-120">
        <div class="container">
            <h2>Upload Material</h2>
            <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="1">Category 1</option>
                        <option value="2">Category 2</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Upload File</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".pdf" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </section>
</main>
@endsection
