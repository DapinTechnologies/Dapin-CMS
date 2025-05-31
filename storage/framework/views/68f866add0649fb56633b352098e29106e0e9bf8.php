
<?php $__env->startSection('title', $material->title); ?>

<?php $__env->startSection('content'); ?>

<style>
    .btn-primary {
        background-color: #007bff;
        color: #ffffff;
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 25px;
        transition: background-color 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Disabling user-select to prevent text selection */
    body {
        user-select: none;
    }

    iframe {
        pointer-events: none; /* Prevent interaction with the embedded iframe */
    }
</style>

<main>
    <section class="material-view pt-120 pb-120">
        <div class="container">
            <h2><?php echo e($material->title); ?></h2>

            <!-- Viewing the Material -->
            <div class="material-viewer text-center mb-4">
                <?php if($material->type === 'PDF'): ?>
                    <!-- Embed the PDF with restrictions using PDF.js -->
                    <div id="pdf-viewer" style="border: 1px solid #ddd; overflow: auto; width: 100%; height: 600px;"></div>
                <?php elseif($material->type === 'Video'): ?>
                    <video width="100%" height="auto" controls>
                        <source src="<?php echo e(asset($material->file_path)); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php elseif($material->type === 'Image'): ?>
                    <img src="<?php echo e(asset($material->file_path)); ?>" alt="<?php echo e($material->title); ?>" class="img-fluid">
                <?php else: ?>
                    <p><?php echo e(__('Preview not available for this file type.')); ?></p>
                <?php endif; ?>
            </div>

            <!-- Download Button for Public Material (removed for non-downloadable materials) -->
            <?php if($material->is_public && $material->is_downloadable): ?>
                <div class="text-center">
                    <a href="<?php echo e(asset($material->file_path)); ?>" class="btn btn-primary" download>
                        Download <?php echo e($material->type); ?>

                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.15.349/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.15.349/pdf.worker.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const url = "<?php echo e(asset($material->file_path)); ?>";
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

        // Disable Right-Click Context Menu
        document.addEventListener("contextmenu", function(event) {
            event.preventDefault();
        });

        // Prevent text selection
        document.addEventListener('mousedown', function(event) {
            if (event.button == 2) {
                event.preventDefault();
            }
        });
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views/student/digital/view.blade.php ENDPATH**/ ?>