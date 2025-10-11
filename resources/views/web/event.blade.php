@extends('web.layouts.master')
@section('title', __('navbar_event'))

@section('content')

<main>

    <section class="breadcrumb-area d-flex p-relative align-items-center" style="padding: 60px 0 30px; background: #f8f9fa;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-12 col-lg-12 text-center">
                    <div class="breadcrumb-wrap text-center">
                        <div class="breadcrumb-title">
                            <h2 class="digital-library-title mb-2">{{ __('navbar_event') }}</h2>
                        </div>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb-link">{{ __('navbar_home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('navbar_event') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="materials-search pt-4 pb-0 mt-3">
        <div class="container">
           <form action="/web-event" method="GET" class="d-flex justify-content-center mb-4">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control me-2 search-input"
                    style="max-width: 500px;"
                    placeholder="Search events by title or description" 
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary search-button">{{ __('Search') }}</button>
            </form>
        </div>
    </section>

    <section class="materials-list pt-60 pb-80" style="background-color: #f0f2f5;">
        <div class="container">
            <div class="row g-4">
                @foreach ($events as $event)
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="material-card shadow-sm p-4 bg-white rounded">
                        <a 
                            href="{{ route('event.single', ['id' => $event->id, 'slug' => $event->slug]) }}" 
                            class="d-block material-thumbnail-link mb-3"
                        >
                            <img 
                                src="{{ asset('uploads/web-event/'.$event->attach) }}" 
                                alt="{{ $event->title }}" 
                                class="img-fluid rounded material-thumbnail-img"
                                style="height: 220px; object-fit: cover; width: 100%;">
                        </a>
                        
                        <div class="material-title text-center mt-3">
                            <h5 class="fw-bold mb-1 event-title">{{ $event->title }}</h5>
                        </div>

                        <div class="meta-info text-center mt-3">
                            <ul class="list-unstyled mb-0">
                                <li class="meta-item event-date">
                                    <i class="far fa-calendar-alt me-1"></i> {{ date('d F, Y', strtotime($event->date)) }}
                                </li>
                                <li class="meta-item mt-2 event-time">
                                    <i class="far fa-clock me-1"></i> 
                                    @if(isset($setting->time_format))
                                        {{ date($setting->time_format, strtotime($event->time)) }}
                                    @else
                                        {{ date("h:i A", strtotime($event->time)) }}
                                    @endif
                                </li>
                                <li class="meta-item mt-2 event-location">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $event->address }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            {{-- Pagination --}}
            <div class="row">
                <div class="col-12">
                    <div class="pagination-wrap mt-20 text-center">
                        <nav>
                            <ul class="pagination justify-content-center">
                                {{ $events->appends(Request::only('search'))->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>




<style>
    /* Global Styles for a Modern & Compact Look */
    body {
        font-family: 'Roboto', sans-serif;
        line-height: 1.6;
        color: #333;
        background-color: #f0f2f5;
    }

    h1, h2, h3, h4, h5, h6 {
        font-weight: 700;
        color: #222;
    }

    a {
        color: #4361ee;
        text-decoration: none;
    }

    a:hover {
        color: #3f37c9;
        text-decoration: underline;
    }

    /* --- Breadcrumb Area --- */
    .breadcrumb-area {
        padding: 60px 0 30px;
        background-color: #f8f9fa;
    }

    .digital-library-title {
        font-size: 3.2rem;
        margin-bottom: 0.5rem;
        color: #222;
    }

    .breadcrumb-area .breadcrumb {
        padding: 0;
        margin-top: 10px;
    }

    .breadcrumb-area .breadcrumb-item a,
    .breadcrumb-area .breadcrumb-item.active {
        color: #555;
        font-size: 0.95rem;
    }

    .breadcrumb-area .breadcrumb-item.active {
        font-weight: 600;
        color: #222;
    }

    /* --- Search Section --- */
    .materials-search {
        padding-top: 30px;
        padding-bottom: 30px;
        background-color: #f0f2f5;
    }

    .search-input {
        border-radius: 50px;
        padding: 0.75rem 1.25rem;
        border: 1px solid #ced4da;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .search-input::placeholder {
        color: #999;
    }

    .search-input:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        outline: none;
    }

    .search-button {
        background-color: #4361ee;
        border-color: #4361ee;
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
    }

    .search-button:hover {
        background-color: #3f37c9;
        border-color: #3f37c9;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
    }

    /* --- Materials List --- */
    .materials-list {
        padding-top: 60px;
        padding-bottom: 80px;
        background-color: #f0f2f5;
    }

    .material-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        overflow: hidden;
    }

    .material-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
    }

    .material-thumbnail-link {
        display: block;
        height: 220px;
        overflow: hidden;
        border-radius: 8px;
        position: relative;
    }

    .material-thumbnail-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .material-card:hover .material-thumbnail-img {
        transform: scale(1.05);
    }

    .material-title h5 {
        font-size: 1.25rem;
        margin-bottom: 5px;
        line-height: 1.4;
        color: #222; /* Dark color for title */
    }

    /* FIXED: DARK TEXT FOR META INFORMATION - ENSURED VISIBILITY */
    .meta-info ul {
        margin-top: 15px;
    }

    /* Force dark colors for all meta items */
    .meta-info .meta-item {
        font-size: 0.9rem;
        color: #000000 !important; /* Pure black for maximum contrast */
        font-weight: 600 !important; /* Bold weight */
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 5px;
        text-shadow: none !important;
    }

    /* Specific classes for each type of meta info */
    .event-date {
        color: #000000 !important;
        font-weight: 600 !important;
    }

    .event-time {
        color: #000000 !important;
        font-weight: 600 !important;
    }

    .event-location {
        color: #000000 !important;
        font-weight: 600 !important;
    }

    .meta-info .meta-item:last-child {
        margin-bottom: 0;
    }

    /* Force dark icons */
    .meta-info .meta-item i {
        color: #000000 !important; /* Pure black icons */
        font-size: 0.8rem;
        font-weight: 600 !important;
    }

    /* Ensure all text in meta-info is dark */
    .meta-info {
        color: #000000 !important; /* Pure black */
    }

    /* Additional aggressive styling to override any conflicts */
    .material-card .meta-info,
    .material-card .meta-item,
    .material-card .event-date,
    .material-card .event-time,
    .material-card .event-location {
        color: #000000 !important;
        font-weight: 600 !important;
    }

    /* Pagination styling */
    .pagination-wrap {
        margin-top: 40px;
    }

    .pagination {
        display: flex;
        justify-content: center;
    }

    .pagination .page-link {
        color: #4361ee;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
        margin: 0 2px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .pagination .page-link:hover {
        background-color: #4361ee;
        color: white;
        border-color: #4361ee;
    }

    .pagination .page-item.active .page-link {
        background-color: #4361ee;
        border-color: #4361ee;
        color: white;
    }

    /* --- Responsive Adjustments --- */
    @media (max-width: 991.98px) {
        .digital-library-title {
            font-size: 2.8rem;
        }
        .materials-list {
            padding-top: 40px;
            padding-bottom: 60px;
        }
        .material-card {
            padding: 30px;
        }
        .material-thumbnail-link {
            height: 180px;
        }
    }

    @media (max-width: 767.98px) {
        .breadcrumb-area {
            padding: 40px 0 20px;
        }
        .digital-library-title {
            font-size: 2.2rem;
        }
        .materials-search {
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .materials-list {
            padding-top: 30px;
            padding-bottom: 40px;
        }
        .material-card {
            padding: 25px;
            border-radius: 8px;
        }
        .material-thumbnail-link {
            height: 160px;
        }
        .search-input {
            width: 100% !important;
            margin-bottom: 10px;
        }
        .search-button {
            width: 100%;
        }
        .materials-search form {
            flex-direction: column;
            align-items: center;
        }
        
        /* Ensure text remains visible on mobile */
        .meta-info .meta-item {
            color: #000000 !important;
            font-size: 0.85rem;
            font-weight: 600 !important;
        }
    }

    /* High contrast mode support */
    @media (prefers-contrast: high) {
        .meta-info .meta-item {
            color: #000000 !important;
        }
        .meta-info .meta-item i {
            color: #000000 !important;
        }
    }

    /* Debug border - remove after testing */
    .meta-info .meta-item {
        /* border: 1px solid red;  Remove this line after testing */
    }
    
</style>
@endsection