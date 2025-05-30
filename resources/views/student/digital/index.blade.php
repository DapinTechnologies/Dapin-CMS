@extends('student.layouts.master')

@section('title', 'Digital Library')

@section('content')

<style>
/* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    color: #212529;
}

/* Section Header */
h2 {
    font-size: 2rem;
    font-weight: bold;
    color: #343a40;
}

/* Search Bar */
.search-bar {
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
}

.search-input {
    width: 100%;
    max-width: 500px;
    padding: 10px 15px;
    border: 1px solid #dee2e6;
    border-radius: 25px;
    font-size: 1rem;
    outline: none;
    transition: box-shadow 0.3s ease-in-out;
}

.search-input:focus {
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.25);
    border-color: #007bff;
}

/* Card Styling */
.card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    background-color: #ffffff;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.card-img-top {
    border-bottom: 1px solid #dee2e6;
}

.material-thumbnail {
    border-radius: 0;
    transition: transform 0.3s ease-in-out;
}

.material-thumbnail:hover {
    transform: scale(1.1);
}

/* Card Body */
.card-body {
    padding: 20px;
    text-align: center;
}

.card-title {
    font-size: 1.15rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.card-text {
    font-size: 0.9rem;
    color: #6c757d;
}

.card h2 {
    font-size: 1rem;
    font-weight: bold;
    margin: 10px 0;
    color: #007bff;
}

.card h5 {
    font-size: 0.95rem;
    margin-bottom: 5px;
    color: #495057;
}

/* Responsive Grid */
@media (max-width: 768px) {
    h2 {
        font-size: 1.5rem;
    }

    .card-title {
        font-size: 1rem;
    }

    .card-text {
        font-size: 0.85rem;
    }
}
</style>

<div class="container py-4">
    <h2 class="text-center mb-4">Digital Library</h2>

    <!-- Search Bar -->
    <form action="{{ route('library.index') }}" method="GET" class="search-bar">
        <input type="text" name="query" value="{{ request('query') }}" class="search-input" placeholder="Search by title, author, or publisher..." />
        <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
   
    </form>

    <div class="row g-4">
        @forelse ($materials as $material)
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm">
                <a href="{{ route('viewshow', $material->id) }}">
                    <img src="{{ asset($material->thumbnail) }}" alt="{{ $material->title }}" class="card-img-top material-thumbnail" style="height: 150px; object-fit: cover;">
                </a>
                <div class="card-body">
                    <h5 class="card-title">Title: {{ $material->title }}</h5>
                    <h5 class="card-title">Author: {{ $material->author }}</h5>
                    <h5 class="card-title">Publisher: {{ $material->publisher }}</h5>
                    <h2>Category: {{ $material->category->name }}</h2>
                    <p class="card-text">
                        Added on: {{ date('d F, Y', strtotime($material->created_at)) }}
                    </p>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">No materials found for your search query.</p>
        @endforelse
    </div>
</div>

@endsection
