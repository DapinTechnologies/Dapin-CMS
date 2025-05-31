@extends('web.layouts.master')

@section('content')
<main>
    <section class="material-view pt-120 pb-120">
        <div class="container">
            <h2>{{ $material->title }}</h2>

            <!-- Display PDF Pages as Images -->
            <div class="pdf-images">
                @forelse ($images as $image)
                    <img src="{{ asset('storage/pdf_images/' . pathinfo($material->file_path, PATHINFO_FILENAME) . '/' . $image) }}" 
                         class="img-fluid mb-4" 
                         alt="PDF Page">
                @empty
                    <p>No pages available to display.</p>
                @endforelse
            </div>
        </div>
    </section>
</main>
@endsection
