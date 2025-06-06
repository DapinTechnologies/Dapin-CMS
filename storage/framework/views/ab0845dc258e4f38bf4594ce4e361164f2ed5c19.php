

<?php $__env->startSection('title', __('View Material')); ?>

<?php $__env->startSection('content'); ?>
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
                            <h2><?php echo e($material->title); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="breadcrumb-wrap2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('navbar_home')); ?></a></li>
                            <li class="breadcrumb-item"><a href=""><?php echo e(__('Library')); ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo e($material->title); ?></li>
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
                            <?php if($material->type === 'PDF' && !$material->is_downloadable): ?>
                                <div class="text-center">
                                    <div id="pdf-viewer" style="border: 1px solid #ddd; overflow: auto; width: 100%; height: 600px;"></div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <h3><?php echo e($material->title); ?></h3>

                        <div class="material-info">
                            <ul>
                                <li><strong><?php echo e(__('Author')); ?>:</strong> <?php echo e($material->author); ?></li>
                                <li><strong><?php echo e(__('Publisher')); ?>:</strong> <?php echo e($material->publisher); ?></li>
                                <li><strong><?php echo e(__('Language')); ?>:</strong> <?php echo e($material->language); ?></li>
                                <li><strong><?php echo e(__('Edition')); ?>:</strong> <?php echo e($material->edition); ?></li>
                                <li><strong><?php echo e(__('ISBN')); ?>:</strong> <?php echo e($material->isbn); ?></li>
                                <li><strong><?php echo e(__('Description')); ?>:</strong> <?php echo e($material->description); ?></li>
                                <li><strong><?php echo e(__('Created At')); ?>:</strong> <?php echo e(date('d F, Y', strtotime($material->created_at))); ?></li>
                                <?php if($material->is_public): ?>
                                    <li><span class="badge bg-success"><?php echo e(__('Public')); ?></span></li>
                                <?php else: ?>
                                    <?php if(auth()->guard()->check()): ?>
                                        <li><span class="badge bg-warning"><?php echo e(__('Private')); ?></span></li>
                                    <?php else: ?>
                                        <li><span class="badge bg-warning"><?php echo e(__('Private')); ?></span></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <?php if($material->is_downloadable): ?>
                            <div class="text-center mt-4">
                                <a href="<?php echo e(asset($material->file_path)); ?>" class="btn btn-primary btn-sm" style="padding: 5px 10px; font-size: 12px;" download>
                                    <i class="fas fa-download"></i> <?php echo e(__('Download File')); ?>

                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

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
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\web\file\book.blade.php ENDPATH**/ ?>