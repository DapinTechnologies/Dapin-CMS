@extends('web.layouts.master')
@section('title', __('Digital Library'))

@section('content')

<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area d-flex  p-relative align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-12 col-lg-12">
                    <div class="breadcrumb-wrap text-left">
                        <div class="breadcrumb-title">
                            <h2>{{ __('Digital Library') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="breadcrumb-wrap2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('navbar_home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Library') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <section class="materials-search pt-4">
        <div class="container">
            <form action="{{ route('materialhome') }}" method="GET" class="d-flex justify-content-center mb-4">
                <input 
                    type="text" 
                    name="query" 
                    class="form-control me-2" 
                    style="max-width: 400px;" 
                    placeholder="Search books by title or author" 
                    value="{{ request('query') }}">
                <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
            </form>
        </div>
    </section>
    
    <!-- materials-list -->
    <section class="materials-list pt-120 pb-120" style="background-color: #f9f9f9;">
        <div class="container">
            <div class="row g-4">
                @foreach ($materials as $material)
                <div class="col-lg-4 col-md-6">
                    <div class="material-card shadow-sm p-3 bg-white rounded" style="border: 1px solid #ddd;">
                        <!-- Thumbnail -->
                        <a 
                        href="{{ $material->is_public || (auth()->check() && $material->is_downloadable) ? route('viewFile', $material->id) : route('student.login') }}" 
                        target="_blank"
                        @if (!$material->is_public && !$material->is_downloadable && !auth()->check()) 
                            onclick="return confirm('You need to log in to access this material.')" 
                        @endif
                        class="d-block mb-3"
                    >
                        <img 
                            src="{{ asset($material->thumbnail) }}" 
                            alt="{{ $material->title }}" 
                            class="img-fluid rounded"
                            style="height: 200px; object-fit: cover;">
                    </a>
                    
                            {{-- <img 
                                src="{{ asset($material->thumbnail) }}" 
                                alt="{{ $material->title }}" 
                                class="img-fluid rounded"
                                style="height: 200px; object-fit: cover;">
                        </a> --}}
                        
                        <!-- Title -->
                        <div class="material-title text-center mt-2">
                            <h5>{{ $material->title }}</h5>
                        </div>

                        <!-- Meta Info -->
                        <div class="meta-info text-center mt-3">
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                <li><i class="fal fa-calendar-alt"></i> {{ date('d F, Y', strtotime($material->created_at)) }}</li>
                                <li>
                                    @if ($material->is_public)
                                        <span class="badge bg-success">{{ __('Public') }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ __('Private') }}</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- materials-list-end -->

</main>
<!-- main-area-end -->

@endsection
