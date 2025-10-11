@extends('web.layouts.master')
@section('title', $material->title)

@section('content')

<main>
    <section class="material-view-header bg-light py-4 py-md-5"> {{-- Adjusted padding, added light background --}}
        <div class="container text-center">
            <h1 class="material-title-main fw-bold mb-0" style="color: #222;">{{ $material->title }}</h1> {{-- Larger, bolder title --}}
        </div>
    </section>

    <section class="material-viewer-section py-4 py-md-5"> {{-- Adjusted padding --}}
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12"> {{-- Constrained width for better focus --}}
                    <div class="material-viewer-wrapper shadow-lg rounded-3 overflow-hidden" style="background-color: #fdfdfd;"> {{-- Enhanced viewer container --}}
                        @if ($material->type === 'PDF')
                            <iframe 
                                src="{{ asset('storage/' . $material->file_path) }}" 
                                width="100%" 
                                height="700px" {{-- Increased height for better viewing experience --}}
                                sandbox="allow-scripts allow-same-origin" 
                                style="border: none; pointer-events: none;"> {{-- Removed border --}}
                            </iframe>
                        @elseif ($material->type === 'Video')
                            <video 
                                width="100%" 
                                height="auto" 
                                controls 
                                controlslist="nodownload noremoteplayback" 
                                disablepictureinpicture 
                                class="w-100 h-auto rounded-3"> {{-- Added Bootstrap classes for responsiveness and rounded corners --}}
                                <source src="{{ asset('storage/' . $material->file_path) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @elseif ($material->type === 'Image')
                            <div class="material-image-viewer d-flex align-items-center justify-content-center" 
                                style="background-image: url('{{ asset('storage/' . $material->file_path) }}'); 
                                       background-size: contain; background-repeat: no-repeat; background-position: center; 
                                       width: 100%; min-height: 600px; height: 80vh; max-height: 800px; 
                                       pointer-events: none;"> {{-- Enhanced image viewer --}}
                            </div>
                        @else
                            <div class="text-center p-5">
                                <p class="lead text-muted">{{ __('Preview not available for this file type.') }}</p>
                            </div>
                        @endif

                        {{-- Transparent overlay for additional protection --}}
                        <div class="overlay-protection" 
                            style="position: absolute; top: 0; left: 0; width: 100%; 
                                   height: 100%; background: rgba(255,255,255,0); 
                                   pointer-events: none;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection

@push('scripts') {{-- Pushed script to 'scripts' stack --}}
<script>
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    // Disable print via media queries
    const style = document.createElement('style');
    style.type = 'text/css';
    style.innerHTML = `
        @media print {
            body * {
                visibility: hidden !important; /* Force hide all */
            }
            .material-viewer-section { /* Hide the section containing the viewer */
                display: none !important;
            }
            .material-view-header { /* You might want to hide the header too */
                display: none !important;
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush

@push('styles') {{-- Pushed styles to 'styles' stack --}}
<style>
    /* Global styles for cleaner look */
    body {
        font-family: 'Roboto', sans-serif; /* Modern sans-serif font */
        line-height: 1.6;
        color: #333; /* Default body text color */
        background-color: #f0f2f5; /* A slightly softer background */
    }

    /* --- Material View Header --- */
    .material-view-header {
        background-color: #f8f9fa; /* Light background */
        border-bottom: 1px solid #e9ecef; /* Subtle separator */
    }

    .material-title-main {
        font-size: 2.5rem; /* Larger, more impactful title */
        font-weight: 700;
        color: #222;
    }

    /* --- Material Viewer Section --- */
    .material-viewer-section {
        background-color: #f0f2f5; /* Match body background */
    }

    .material-viewer-wrapper {
        position: relative;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); /* More prominent, modern shadow */
        border: 1px solid #e0e0e0; /* Subtle border */
        background-color: #fff; /* White background for the viewer */
    }

    /* PDF, Video, Image Specific Styles */
    .material-viewer-wrapper iframe,
    .material-viewer-wrapper video,
    .material-image-viewer {
        display: block; /* Ensure no extra space below */
        border-radius: 6px; /* Slightly rounded corners for the media */
    }

    .material-image-viewer {
        background-color: #fdfdfd; /* Light background for image container */
        border: 1px solid #eee; /* Light border */
        min-height: 600px; /* Consistent minimum height */
        max-height: 800px; /* Max height to prevent excessive stretching */
        height: 80vh; /* Responsive height */
    }

    /* Overlay protection - ensure it covers the media content */
    .overlay-protection {
        z-index: 10; /* Ensure it's above the content */
    }

    /* Responsive Adjustments */
    @media (max-width: 991.98px) {
        .material-title-main {
            font-size: 2rem;
        }
        .material-viewer-section {
            padding: 30px 0;
        }
        .material-viewer-wrapper iframe,
        .material-image-viewer {
            height: 60vh; /* Adjust height for smaller screens */
            min-height: 450px;
        }
    }

    @media (max-width: 767.98px) {
        .material-view-header {
            padding: 30px 0;
        }
        .material-title-main {
            font-size: 1.8rem;
        }
        .material-viewer-section {
            padding: 20px 0;
        }
        .material-viewer-wrapper iframe,
        .material-image-viewer {
            height: 50vh; /* More compact on very small screens */
            min-height: 350px;
        }
    }
</style>
@endpush