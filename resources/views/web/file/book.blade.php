@extends('web.layouts.master')

@section('title', __('View Material'))

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.15.349/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.15.349/pdf.worker.min.js"></script>

<main>
    {{-- Adjusted padding for a more compact header --}}
    <section class="breadcrumb-area d-flex p-relative align-items-center" style="padding: 60px 0 30px; background: #f8f9fa;">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-12">
                    {{-- Title: Increased font-size and adjusted margin for impact --}}
                    <h1 class="fw-bold material-page-title mb-2" style="color: #000 !important;">{{ $material->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0"> {{-- Removed default bottom margin --}}
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb-link" style="color: #555 !important;">{{ __('navbar_home') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link" style="color: #555 !important;">{{ __('Library') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="color: #000 !important; font-weight: 600;">{{ $material->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    {{-- Adjusted padding top and bottom for the main content section --}}
    <section class="material-details pt-80 pb-80 bg-light">
        <div class="container">
            <div class="row justify-content-center"> {{-- Centered the content column --}}
                <div class="col-md-10 col-lg-8"> {{-- Constrained width for a more focused layout --}}
                    {{-- Reduced padding in material card for compactness --}}
                    <div class="material-card shadow-lg rounded p-5" style="background: #fff;">
                        <div class="material-thumbnail mb-4">
                            @if ($material->type === 'PDF' && !$material->is_downloadable)
                                <div class="text-center">
                                    {{-- Adjusted height for PDF viewer for compactness --}}
                                    <div id="pdf-viewer" style="border: 1px solid #e0e0e0; overflow: auto; width: 100%; height: 500px; border-radius: 8px;"></div>
                                </div>
                            @endif
                        </div>

                        {{-- Main title within the card, slightly smaller than page title --}}
                        <h3 class="mb-3" style="color: #000 !important; font-size: 1.8rem; font-weight: 700;">{{ $material->title }}</h3>
                        <hr class="mb-4"> {{-- Added a subtle separator --}}

                        <div class="material-info">
                            <ul class="list-unstyled mb-4" style="color: #333 !important;"> {{-- Added margin-bottom and slightly softer text color --}}
                                <li><strong style="color: #000 !important;">{{ __('Author') }}:</strong> <span>{{ $material->author }}</span></li>
                                <li><strong style="color: #000 !important;">{{ __('Publisher') }}:</strong> <span>{{ $material->publisher }}</span></li>
                                <li><strong style="color: #000 !important;">{{ __('Language') }}:</strong> <span>{{ $material->language }}</span></li>
                                <li><strong style="color: #000 !important;">{{ __('Edition') }}:</strong> <span>{{ $material->edition }}</span></li>
                                <li><strong style="color: #000 !important;">{{ __('ISBN') }}:</strong> <span>{{ $material->isbn }}</span></li>
                                {{-- Description now as a paragraph for better flow --}}
                                <li style="border-bottom: none;"><strong style="color: #000 !important;">{{ __('Description') }}:</strong></li>
                                <p style="color: #333; line-height: 1.6; margin-top: 5px;">{{ $material->description }}</p>

                                <li style="margin-top: 15px;"><strong style="color: #000 !important;">{{ __('Created At') }}:</strong> <span>{{ date('d F, Y', strtotime($material->created_at)) }}</span></li>
                                <li>
                                    <strong style="color: #000 !important;">{{ __('Status') }}:</strong> 
                                    @if ($material->is_public)
                                        <span class="badge bg-success" style="color: #fff !important; background-color: #28a745 !important;">{{ __('Public') }}</span>
                                    @else
                                        @auth
                                            <span class="badge bg-warning" style="color: #000 !important; background-color: #ffc107 !important;">{{ __('Private') }}</span>
                                        @else
                                            <span class="badge bg-warning" style="color: #000 !important; background-color: #ffc107 !important;">{{ __('Private') }}</span>
                                        @endauth
                                    @endif
                                </li>
                            </ul>
                        </div>

                        @if ($material->is_downloadable)
                            <div class="text-center mt-5"> {{-- Increased top margin for button --}}
                                <a href="{{ asset($material->file_path) }}" class="btn btn-primary btn-lg px-4 py-2" style="font-size: 1rem; color: #fff !important; border-radius: 50px;" download>
                                    <i class="fas fa-download me-2"></i> {{ __('Download File') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const url = "{{ asset($material->file_path) }}";
        const pdfjsLib = window['pdfjs-dist/build/pdf'];
        const pdfViewer = document.getElementById('pdf-viewer');
        let isRendering = false;
        let currentPage = 1;

        // Set up the PDF.js worker
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.15.349/pdf.worker.min.js';

        const loadingTask = pdfjsLib.getDocument(url);
        loadingTask.promise.then(function (pdf) {
            const numPages = pdf.numPages;

            // Function to render a specific page
            function renderPage(pageNum) {
                if (pageNum > numPages || isRendering) return;

                isRendering = true;
                pdf.getPage(pageNum).then(function (page) {
                    const scale = pdfViewer.clientWidth / page.getViewport({ scale: 1 }).width; // Adjust scale to fit viewer width
                    const viewport = page.getViewport({ scale });

                    // Create a canvas for the page
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    // Append the canvas to the viewer
                    pdfViewer.appendChild(canvas);

                    // Render the page into the canvas
                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    page.render(renderContext).promise.then(function () {
                        isRendering = false;
                        // Render next page when needed
                        if (pageNum + 1 <= numPages) {
                            renderPage(pageNum + 1);
                        }
                    });
                });
            }

            // Initial render of the first page
            renderPage(currentPage);

            // Scroll event to load more pages (within the PDF viewer itself)
            pdfViewer.addEventListener('scroll', function () {
                const scrollPosition = pdfViewer.scrollTop + pdfViewer.clientHeight;
                const viewerScrollHeight = pdfViewer.scrollHeight;

                if (scrollPosition >= viewerScrollHeight - 50 && !isRendering) { // Load next page when near bottom of viewer
                    currentPage++;
                    renderPage(currentPage);
                }
            });
        }).catch(function (error) {
            console.error('Error loading PDF:', error);
            // Display a user-friendly message if PDF fails to load
            if (pdfViewer) {
                pdfViewer.innerHTML = '<p class="text-danger text-center p-4">Error loading PDF. Please try again later.</p>';
            }
        });
    });
</script>
@endsection

@push('styles')
<style>
    /* Global styles for cleaner look */
    body {
        font-family: 'Roboto', sans-serif; /* Modern sans-serif font */
        line-height: 1.6;
        color: #333 !important; /* Default body text color */
        background-color: #f0f2f5; /* A slightly softer background */
    }

    h1, h2, h3, h4, h5, h6 {
        font-weight: 700;
        color: #222 !important; /* Darker headings */
    }

    a {
        color: #4361ee;
        text-decoration: none;
    }

    a:hover {
        color: #3f37c9;
        text-decoration: underline;
    }

    /* Breadcrumb area - compact header */
    .breadcrumb-area {
        /* background removed from inline style, now handled by body or master layout */
        padding: 60px 0 30px; /* Reduced vertical padding */
    }

    .material-page-title {
        font-size: 3.2rem !important; /* Slightly adjusted for balance */
        margin-bottom: 0.5rem !important; /* More compact spacing */
        color: #222 !important;
    }

    .breadcrumb-area .breadcrumb {
        padding: 0;
        margin-top: 10px; /* Small space below title */
    }

    .breadcrumb-area .breadcrumb-item a,
    .breadcrumb-area .breadcrumb-item.active {
        color: #555 !important; /* Slightly softer breadcrumb link color */
        font-size: 0.95rem;
    }

    .breadcrumb-area .breadcrumb-item.active {
        font-weight: 600;
        color: #222 !important; /* Active item bolder and darker */
    }

    /* Material Details Section - overall compactness */
    .material-details {
        padding-top: 80px; /* Reduced padding */
        padding-bottom: 80px; /* Reduced padding */
        background-color: #f0f2f5; /* Match body background for continuity */
    }

    .material-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08); /* Softer, slightly larger shadow */
        padding: 40px; /* More generous inner padding for content, but overall compact due to reduced section padding */
        transition: transform 0.2s ease-in-out; /* Subtle hover effect */
    }

    .material-card:hover {
        transform: translateY(-5px);
    }

    /* Material thumbnail / PDF viewer */
    .material-thumbnail {
        margin-bottom: 30px; /* Adjusted spacing */
    }

    #pdf-viewer {
        min-height: 500px; /* Ensure a good minimum height */
        max-height: 70vh; /* Max height relative to viewport for responsiveness */
        border: 1px solid #e0e0e0; /* Lighter border */
        border-radius: 8px;
        background-color: #fdfdfd; /* Slight off-white for viewer background */
        box-shadow: inset 0 2px 5px rgba(0,0,0,0.05); /* Inner shadow for depth */
    }

    /* Material info list - refined layout */
    .material-info ul {
        margin-bottom: 25px; /* Spacing below the list */
    }

    .material-info ul li {
        padding: 10px 0; /* Consistent vertical padding */
        font-size: 1rem; /* Standard font size */
        color: #333; /* Default text color for list items */
        border-bottom: 1px solid #f0f0f0; /* Lighter, more subtle divider */
        display: flex; /* Flexbox for alignment */
        justify-content: space-between; /* Space out key and value */
        align-items: baseline;
    }

    .material-info ul li:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .material-info ul li strong {
        color: #222; /* Darker color for labels */
        font-weight: 600; /* Slightly heavier weight for labels */
        flex-shrink: 0; /* Prevent label from shrinking */
        margin-right: 15px; /* Space between label and value */
    }
    
    .material-info ul li span {
        color: #555; /* Value text color */
        text-align: right; /* Align value to the right */
        flex-grow: 1; /* Allow value to take remaining space */
    }

    .material-info p { /* For description */
        font-size: 0.95rem;
        color: #444;
        margin-top: 10px;
        line-height: 1.7;
    }

    /* Badges - style update for modern look */
    .badge {
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px; /* Pill-shaped badges */
        text-transform: capitalize;
        font-size: 0.85rem;
        display: inline-flex; /* Use flex for potential icon/text alignment */
        align-items: center;
        gap: 5px; /* Space between icon and text if any */
    }
    .badge.bg-success {
        background-color: #28a745 !important;
        color: #fff !important;
    }
    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #333 !important; /* Darker text for warning badge for contrast */
    }

    /* Download button - modern styling */
    .btn-primary {
        background-color: #4361ee;
        border-color: #4361ee;
        color: #fff !important;
        padding: 12px 25px; /* Larger padding for better touch targets */
        font-size: 1.05rem; /* Slightly larger font */
        border-radius: 50px; /* Fully rounded button */
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3); /* Subtle shadow */
    }

    .btn-primary:hover {
        background-color: #3f37c9;
        border-color: #3f37c9;
        transform: translateY(-2px); /* Lift effect on hover */
        box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
    }

    .btn-primary .fas {
        margin-right: 8px; /* Space for the icon */
    }

    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .material-details {
            padding-top: 60px;
            padding-bottom: 60px;
        }
        .material-card {
            padding: 30px;
        }
        .material-page-title {
            font-size: 2.8rem !important;
        }
    }

    @media (max-width: 767.98px) {
        .breadcrumb-area {
            padding: 40px 0 20px; /* More compact on mobile */
        }
        .material-page-title {
            font-size: 2.2rem !important;
        }
        .material-details {
            padding-top: 40px;
            padding-bottom: 40px;
        }
        .material-card {
            padding: 25px;
            border-radius: 8px;
        }
        #pdf-viewer {
            height: 400px; /* Shorter PDF viewer on mobile */
            min-height: unset;
        }
        .material-info ul li {
            font-size: 0.95rem;
            display: block; /* Stack key and value on small screens */
            padding: 8px 0;
        }
        .material-info ul li strong {
            margin-right: 0;
            display: block; /* Make strong tag block for stacking */
            margin-bottom: 3px; /* Small space below label */
        }
        .material-info ul li span {
            text-align: left; /* Align values to the left on small screens */
        }
    }
</style>
@endpush