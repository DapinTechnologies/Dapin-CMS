@extends('web.layouts.master')

@section('title', __('View Material'))

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.15.349/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.15.349/pdf.worker.min.js"></script>

<!-- main-area -->
<main>
    <section class="breadcrumb-area d-flex p-relative align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-12 col-lg-12">
                    <div class="breadcrumb-wrap text-left">
                        <div class="breadcrumb-title">
                            <h2>{{ $material->title }}</h2>
                        </div>
                    </div>
                </div>
                <div class="breadcrumb-wrap2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('navbar_home') }}</a></li>
                            <li class="breadcrumb-item"><a href="">{{ __('Library') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $material->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="material-details pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="material-card">
                        <!-- Material Thumbnail -->
                        <div class="material-thumbnail">
                            @if ($material->type === 'PDF' && !$material->is_downloadable)
                                <div class="text-center">
                                    <div id="pdf-viewer" style="border: 1px solid #ddd; overflow: auto; width: 100%; height: 600px;"></div>
                                </div>
                            @endif
                        </div>

                        <h3>{{ $material->title }}</h3>

                        <div class="material-info">
                            <ul>
                                <li><strong>{{ __('Author') }}:</strong> {{ $material->author }}</li>
                                <li><strong>{{ __('Publisher') }}:</strong> {{ $material->publisher }}</li>
                                <li><strong>{{ __('Language') }}:</strong> {{ $material->language }}</li>
                                <li><strong>{{ __('Edition') }}:</strong> {{ $material->edition }}</li>
                                <li><strong>{{ __('ISBN') }}:</strong> {{ $material->isbn }}</li>
                                <li><strong>{{ __('Description') }}:</strong> {{ $material->description }}</li>
                                <li><strong>{{ __('Created At') }}:</strong> {{ date('d F, Y', strtotime($material->created_at)) }}</li>
                                @if ($material->is_public)
                                    <li><span class="badge bg-success">{{ __('Public') }}</span></li>
                                @else
                                    @auth
                                        <li><span class="badge bg-warning">{{ __('Private') }}</span></li>
                                    @else
                                        <li><span class="badge bg-warning">{{ __('Private') }}</span></li>
                                    @endauth
                                @endif
                            </ul>
                        </div>

                        @if ($material->is_downloadable)
                            <div class="text-center mt-4">
                                <a href="{{ asset($material->file_path) }}" class="btn btn-primary btn-sm" style="padding: 5px 10px; font-size: 12px;" download>
                                    <i class="fas fa-download"></i> {{ __('Download File') }}
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
                    const scale = 1.5;
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

            // Scroll event to load more pages
            window.addEventListener('scroll', function () {
                const scrollPosition = window.scrollY + window.innerHeight;
                const viewerBottom = pdfViewer.offsetHeight + pdfViewer.offsetTop;
                if (scrollPosition >= viewerBottom - 50) {
                    // Load the next page if the user is near the bottom of the viewer
                    currentPage++;
                    renderPage(currentPage);
                }
            });
        }).catch(function (error) {
            console.error('Error loading PDF:', error);
        });
    });
</script>
@endsection
