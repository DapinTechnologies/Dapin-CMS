@extends('web.layouts.master')
@section('title', __('navbar_event'))

@section('content')

<main>

    <section class="breadcrumb-area d-flex p-relative align-items-center" style="padding: 60px 0 30px; background: #f8f9fa;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-12 col-lg-12 text-center"> {{-- Centered content in breadcrumb --}}
                    <div class="breadcrumb-wrap text-center"> {{-- Centered breadcrumb text --}}
                        <div class="breadcrumb-title">
                            <h2 class="digital-library-title mb-2">{{ __('navbar_event') }}</h2> {{-- Added specific class for title --}}
                        </div>
                    </div>
                    {{-- Moved breadcrumb nav directly under title for compactness --}}
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0"> {{-- Removed default bottom margin --}}
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb-link">{{ __('navbar_home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('navbar_event') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    {{-- Reduced padding and margin for compactness --}}
    <section class="materials-search pt-4 pb-0 mt-3"> 
        <div class="container">
            <form action="{{ route('events') }}" method="GET" class="d-flex justify-content-center mb-4">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control me-2 search-input" {{-- Added search-input class --}}
                    style="max-width: 500px;" {{-- Increased max-width for input for better usability --}}
                    placeholder="Search events by title or description" 
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary search-button">{{ __('Search') }}</button> {{-- Added search-button class --}}
            </form>
        </div>
    </section>
    {{-- Adjusted padding for list section --}}
    <section class="materials-list pt-60 pb-80" style="background-color: #f0f2f5;"> {{-- Matched background to body --}}
        <div class="container">
            <div class="row g-4"> {{-- Using Bootstrap's gutter utility --}}
                @foreach ($events as $event)
                <div class="col-lg-4 col-md-6 col-sm-6 col-12"> {{-- Added col-sm-6 and col-12 for better responsiveness --}}
                    <div class="material-card shadow-sm p-4 bg-white rounded"> {{-- Increased card padding slightly for inner content --}}
                        <a 
                            href="{{ route('event.single', ['id' => $event->id, 'slug' => $event->slug]) }}" 
                            class="d-block material-thumbnail-link mb-3"
                        >
                            <img 
                                src="{{ asset('uploads/web-event/'.$event->attach) }}" 
                                alt="{{ $event->title }}" 
                                class="img-fluid rounded material-thumbnail-img"
                                style="height: 220px; object-fit: cover; width: 100%;"> {{-- Ensured image takes full width of its container --}}
                        </a>
                        
                        <div class="material-title text-center mt-3"> {{-- Adjusted spacing --}}
                            <h5 class="fw-bold mb-1">{{ $event->title }}</h5> {{-- Bolder title, reduced margin --}}
                        </div>

                        <div class="meta-info text-center mt-3">
                            <ul class="list-unstyled mb-0"> {{-- Removed default bottom margin --}}
                                <li class="meta-item">
                                    <i class="far fa-calendar-alt me-1"></i> {{ date('d F, Y', strtotime($event->date)) }} {{-- Using 'far' for font-awesome regular --}}
                                </li>
                                <li class="meta-item mt-2">
                                    <i class="far fa-clock me-1"></i> 
                                    @if(isset($setting->time_format))
                                        {{ date($setting->time_format, strtotime($event->time)) }}
                                    @else
                                        {{ date("h:i A", strtotime($event->time)) }}
                                    @endif
                                </li>
                                <li class="meta-item mt-2">
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

@endsection

@push('styles')
<style>
    /* Global Styles for a Modern & Compact Look */
    body {
        font-family: 'Roboto', sans-serif; /* Modern sans-serif font */
        line-height: 1.6;
        color: #333; /* Default body text color */
        background-color: #f0f2f5; /* A slightly softer background */
    }

    h1, h2, h3, h4, h5, h6 {
        font-weight: 700; /* Bolder headings */
        color: #222; /* Darker headings */
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
        padding: 60px 0 30px; /* Reduced vertical padding for compactness */
        background-color: #f8f9fa; /* Light background for the header */
    }

    .digital-library-title {
        font-size: 3.2rem; /* Consistent large title size */
        margin-bottom: 0.5rem; /* Reduced space below title */
        color: #222; /* Dark title color */
    }

    .breadcrumb-area .breadcrumb {
        padding: 0;
        margin-top: 10px; /* Small space below the title */
    }

    .breadcrumb-area .breadcrumb-item a,
    .breadcrumb-area .breadcrumb-item.active {
        color: #555; /* Softer breadcrumb link color */
        font-size: 0.95rem; /* Slightly smaller font for breadcrumbs */
    }

    .breadcrumb-area .breadcrumb-item.active {
        font-weight: 600; /* Active item bolder */
        color: #222; /* Active item darker */
    }

    /* --- Search Section --- */
    .materials-search {
        padding-top: 30px; /* Reduced top padding */
        padding-bottom: 30px; /* Consistent bottom padding */
        background-color: #f0f2f5; /* Match body background */
    }

    .search-input {
        border-radius: 50px; /* Rounded search input */
        padding: 0.75rem 1.25rem; /* More vertical padding */
        border: 1px solid #ced4da;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05); /* Subtle shadow */
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
        padding: 0.75rem 1.5rem; /* Consistent padding with input */
        border-radius: 50px; /* Rounded search button */
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3); /* Subtle shadow */
    }

    .search-button:hover {
        background-color: #3f37c9;
        border-color: #3f37c9;
        transform: translateY(-2px); /* Lift effect on hover */
        box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
    }

    /* --- Materials List --- */
    .materials-list {
        padding-top: 60px; /* Reduced top padding */
        padding-bottom: 80px; /* Consistent bottom padding */
        background-color: #f0f2f5; /* Match body background */
    }

    .material-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08); /* Softer, slightly larger shadow */
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; /* Subtle hover effect */
        overflow: hidden; /* Ensure rounded corners for image */
    }

    .material-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12); /* Enhanced shadow on hover */
    }

    .material-thumbnail-link {
        display: block; /* Ensure the link fills the image container */
        height: 220px; /* Fixed height for image container */
        overflow: hidden; /* Hide overflow if image is too large */
        border-radius: 8px; /* Rounded corners for thumbnail */
        position: relative;
    }

    .material-thumbnail-img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Cover the container */
        border-radius: 8px; /* Match link border-radius */
        transition: transform 0.3s ease;
    }

    .material-card:hover .material-thumbnail-img {
        transform: scale(1.05); /* Slight zoom on image hover */
    }

    .material-title h5 {
        font-size: 1.25rem; /* Standard title size */
        margin-bottom: 5px; /* Reduced margin */
        line-height: 1.4;
        color: #222;
    }

    .meta-info ul {
        margin-top: 15px; /* Spacing for meta info */
    }

    .meta-info .meta-item {
        font-size: 0.9rem; /* Smaller font for meta info */
        color: #777; /* Muted color for meta info */
        display: flex; /* Use flex for icon alignment */
        align-items: center;
        justify-content: center; /* Center horizontally */
        margin-bottom: 5px;
    }
    .meta-info .meta-item:last-child {
        margin-bottom: 0;
    }

    .meta-info .meta-item i {
        color: #555; /* Icon color */
        font-size: 0.8rem;
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
            height: 180px; /* Adjust height for medium screens */
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
            height: 160px; /* Further adjust height for small screens */
        }
        .search-input {
            width: 100% !important; /* Full width input on small screens */
            margin-bottom: 10px; /* Space below input */
        }
        .search-button {
            width: 100%; /* Full width button on small screens */
        }
        .materials-search form {
            flex-direction: column; /* Stack input and button vertically */
            align-items: center; /* Center items when stacked */
        }
    }
</style>
@endpush
