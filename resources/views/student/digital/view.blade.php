@extends('student.layouts.master')
@section('title', $material->title ?? 'Digital Library')

@section('content')

<style>
    :root {
        --primary-color: #007bff;
        --primary-hover: #0056b3;
        --background-color: #f8f9fa;
        --card-background: #ffffff;
        --text-primary: #2c3e50;
        --text-secondary: #6c757d;
        --border-radius: 12px;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .material-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .material-header {
        background: var(--card-background);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow);
        border-left: 4px solid var(--primary-color);
    }

    .material-viewer {
        background: var(--card-background);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .material-viewer:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    .material-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
    }

    .meta-label {
        font-size: 0.875rem;
        color: var(--text-secondary);
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .meta-value {
        font-size: 1rem;
        color: var(--text-primary);
        font-weight: 600;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        border: none;
        border-radius: 25px;
        padding: 12px 30px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        background: linear-gradient(135deg, var(--primary-hover), var(--primary-color));
    }

    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .pdf-container {
        border-radius: 8px;
        overflow: hidden;
        background: #f8f9fa;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .pdf-page-container {
        width: 100%;
        text-align: center;
    }

    .pdf-page {
        max-width: 100%;
        height: auto;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-radius: 4px;
        margin: 0 auto;
    }

    .pdf-navigation {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        margin-top: 1rem;
        padding: 1rem;
        background: var(--card-background);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .page-info {
        font-weight: 600;
        color: var(--text-primary);
        min-width: 100px;
        text-align: center;
    }

    .nav-btn {
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .nav-btn:hover:not(:disabled) {
        background: var(--primary-hover);
        transform: scale(1.1);
    }

    .nav-btn:disabled {
        background: #6c757d;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .video-container {
        border-radius: 8px;
        overflow: hidden;
        background: #000;
    }

    .image-container {
        border-radius: 8px;
        overflow: hidden;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .image-container img {
        max-height: 70vh;
        width: auto;
        max-width: 100%;
        border-radius: 4px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .alert-modern {
        border: none;
        border-radius: var(--border-radius);
        padding: 1rem 1.5rem;
        margin: 1rem 0;
        font-weight: 500;
    }

    .alert-info {
        background: linear-gradient(135deg, #d1ecf1, #bee5eb);
        color: #0c5460;
        border-left: 4px solid #0c5460;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
        border-left: 4px solid #721c24;
    }

    .debug-badge {
        position: fixed;
        top: 10px;
        right: 10px;
        background: #ff6b6b;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 1000;
        opacity: 0.8;
    }

    /* Mobile optimizations */
    @media (max-width: 768px) {
        .material-container {
            padding: 0 10px;
        }

        .material-viewer {
            order: 1;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .material-header {
            order: 2;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .material-meta {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .btn-primary {
            padding: 10px 24px;
            font-size: 0.9rem;
            width: 100%;
            max-width: 300px;
        }

        .pdf-container {
            min-height: 300px;
        }

        .image-container img {
            max-height: 50vh;
        }

        h2 {
            font-size: 1.5rem;
        }

        .pdf-navigation {
            position: sticky;
            bottom: 10px;
            z-index: 100;
            margin: 1rem -1rem -1rem -1rem;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }
    }

    @media (max-width: 480px) {
        .material-container {
            padding: 0 5px;
        }

        .material-header {
            padding: 0.75rem;
        }

        h2 {
            font-size: 1.3rem;
        }

        .meta-value {
            font-size: 0.9rem;
        }

        .nav-btn {
            width: 35px;
            height: 35px;
        }

        .page-info {
            font-size: 0.9rem;
            min-width: 80px;
        }
    }

    /* Desktop layout */
    @media (min-width: 769px) {
        .material-content {
            display: block;
        }
    }

    /* Security styles */
    body {
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    iframe {
        pointer-events: none;
    }

    /* Loading animation */
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .mobile-only {
        display: none;
    }

    @media (max-width: 768px) {
        .mobile-only {
            display: block;
        }
        .desktop-only {
            display: none;
        }
    }
</style>

<!-- Debug badge - remove in production -->
@if(env('APP_DEBUG'))
<div class="debug-badge">Debug: Material ID: {{ $material->id ?? 'Not found' }}</div>
@endif

<main class="material-container" style="padding-top: 0;">
    <section class="material-view py-4">
        
        @if(isset($material) && $material)
        <!-- Material Viewer - Comes FIRST on mobile -->
        <div class="material-viewer">
            @if ($material->type === 'PDF')
                <div id="pdf-viewer" class="pdf-container">
                    <div class="text-center">
                        <div class="loading-spinner mb-2"></div>
                        <p class="mb-0" style="color: var(--text-secondary);">Loading PDF document...</p>
                    </div>
                </div>

                <!-- PDF Navigation - Mobile Only -->
                <div class="mobile-only pdf-navigation" id="pdf-navigation" style="display: none;">
                    <button class="nav-btn" id="prev-page" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="page-info" id="page-info">Page 1 of 1</div>
                    <button class="nav-btn" id="next-page" disabled>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            @elseif ($material->type === 'Video')
                <div class="video-container">
                    <video width="100%" height="auto" controls controlsList="nodownload" style="display: block;">
                        <source src="{{ asset($material->file_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            @elseif ($material->type === 'Image')
                <div class="image-container">
                    <img src="{{ asset($material->file_path) }}" alt="{{ $material->title }}" loading="lazy">
                </div>
            @else
                <div class="alert alert-info alert-modern text-center">
                    <p class="mb-2"><strong>Preview Not Available</strong></p>
                    <p class="mb-3">This file type cannot be previewed in the browser.</p>
                    @if ($material->is_public && $material->is_downloadable)
                    <a href="{{ route('student.digital.download', $material->id) }}" class="btn btn-primary btn-download">
                        <i class="fas fa-download"></i>Download File
                    </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Material Information - Comes SECOND on mobile -->
        <div class="material-header">
            <h2 class="mb-3" style="color: var(--text-primary); font-weight: 700;">{{ $material->title }}</h2>
            
            <div class="material-meta">
                <div class="meta-item">
                    <span class="meta-label">Type</span>
                    <span class="meta-value">{{ $material->type }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Author</span>
                    <span class="meta-value">{{ $material->author ?? 'Unknown' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Publisher</span>
                    <span class="meta-value">{{ $material->publisher ?? 'Unknown' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Uploaded</span>
                    <span class="meta-value">{{ $material->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            @if($material->description)
            <div class="mt-3 pt-3" style="border-top: 1px solid #e9ecef;">
                <span class="meta-label">Description</span>
                <p class="mt-1 mb-0" style="color: var(--text-primary); line-height: 1.6;">{{ $material->description }}</p>
            </div>
            @endif
        </div>

        <!-- Download Section -->
        @if ($material->is_public && $material->is_downloadable && $material->type !== 'Other')
        <div class="text-center mt-4">
            <a href="{{ route('student.digital.download', $material->id) }}" class="btn btn-primary btn-download">
                <i class="fas fa-download"></i>Download {{ $material->type }}
            </a>
        </div>
        @elseif(!$material->is_downloadable)
        <div class="alert alert-info alert-modern text-center">
            <i class="fas fa-info-circle me-2"></i>Download is not available for this material
        </div>
        @endif
        
        @else
        <!-- Material Not Found -->
        <div class="alert alert-danger alert-modern text-center">
            <h4 class="alert-heading mb-3">Material Not Found</h4>
            <p class="mb-3">The requested material could not be found or is no longer available.</p>
            <a href="{{ url('/library') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to Library
            </a>
        </div>
        @endif
    </section>
</main>

@if(isset($material) && $material->type === 'PDF')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.15.349/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.15.349/pdf.worker.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const url = "{{ asset($material->file_path) }}";
        const pdfjsLib = window['pdfjs-dist/build/pdf'];
        const pdfViewer = document.getElementById('pdf-viewer');
        const pdfNavigation = document.getElementById('pdf-navigation');
        const prevBtn = document.getElementById('prev-page');
        const nextBtn = document.getElementById('next-page');
        const pageInfo = document.getElementById('page-info');
        
        let pdfDoc = null;
        let currentPage = 1;
        let isMobile = window.innerWidth <= 768;
        
        console.log('Loading PDF:', url);
        
        // Set up the PDF.js worker
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.15.349/pdf.worker.min.js';

        const loadingTask = pdfjsLib.getDocument(url);
        
        loadingTask.promise.then(function(pdf) {
            pdfDoc = pdf;
            const numPages = pdf.numPages;
            console.log('PDF loaded successfully:', numPages + ' pages');
            
            // Clear loading message
            pdfViewer.innerHTML = '<div class="pdf-page-container"></div>';
            
            // Show navigation if mobile
            if (isMobile) {
                pdfNavigation.style.display = 'flex';
                updateNavigation();
            }
            
            // Load initial page
            renderPage(currentPage);
            
        }).catch(function(error) {
            console.error('Error loading PDF:', error);
            pdfViewer.innerHTML = `
                <div class="alert alert-danger alert-modern">
                    <h5>Error Loading PDF</h5>
                    <p class="mb-2">Unable to load the PDF document.</p>
                    <small>Technical details: ${error.message}</small>
                </div>
            `;
        });

        // Render specific page
        function renderPage(pageNum) {
            if (!pdfDoc) return;
            
            pdfDoc.getPage(pageNum).then(function(page) {
                const scale = isMobile ? 1.0 : 1.5;
                const viewport = page.getViewport({ scale: scale });

                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                canvas.className = 'pdf-page';

                const container = pdfViewer.querySelector('.pdf-page-container');
                container.innerHTML = '';
                container.appendChild(canvas);

                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                
                return page.render(renderContext).promise;
            }).then(function() {
                console.log('Page ' + pageNum + ' rendered');
                updateNavigation();
            });
        }

        // Update navigation buttons and info
        function updateNavigation() {
            if (!pdfDoc) return;
            
            pageInfo.textContent = `Page ${currentPage} of ${pdfDoc.numPages}`;
            prevBtn.disabled = currentPage <= 1;
            nextBtn.disabled = currentPage >= pdfDoc.numPages;
        }

        // Navigation event listeners
        prevBtn.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                renderPage(currentPage);
            }
        });

        nextBtn.addEventListener('click', function() {
            if (currentPage < pdfDoc.numPages) {
                currentPage++;
                renderPage(currentPage);
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const newIsMobile = window.innerWidth <= 768;
            if (newIsMobile !== isMobile) {
                isMobile = newIsMobile;
                if (pdfDoc) {
                    renderPage(currentPage);
                }
            }
        });

        // Security measures
        document.addEventListener("contextmenu", function(event) {
            event.preventDefault();
        });

        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey && (event.key === 's' || event.key === 'p')) {
                event.preventDefault();
            }
            
            // Arrow key navigation for desktop
            if (!isMobile) {
                if (event.key === 'ArrowLeft' && currentPage > 1) {
                    currentPage--;
                    renderPage(currentPage);
                    event.preventDefault();
                } else if (event.key === 'ArrowRight' && currentPage < pdfDoc.numPages) {
                    currentPage++;
                    renderPage(currentPage);
                    event.preventDefault();
                }
            }
        });

        // Swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        pdfViewer.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, false);

        pdfViewer.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, false);

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0 && currentPage < pdfDoc.numPages) {
                    // Swipe left - next page
                    currentPage++;
                    renderPage(currentPage);
                } else if (diff < 0 && currentPage > 1) {
                    // Swipe right - previous page
                    currentPage--;
                    renderPage(currentPage);
                }
            }
        }
    });
</script>
@endif

@endsection