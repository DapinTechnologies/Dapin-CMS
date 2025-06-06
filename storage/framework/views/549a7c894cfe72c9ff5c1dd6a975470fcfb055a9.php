
<?php $__env->startSection('title', $material->title); ?>

<?php $__env->startSection('content'); ?>

<main>
    <section class="material-view pt-120 pb-120">
        <div class="container">
            <h2><?php echo e($material->title); ?></h2>

            <!-- Viewing the Material -->
            <div class="material-viewer text-center" style="position: relative;">
                <?php if($material->type === 'PDF'): ?>
                    <!-- Embed PDF with restrictions -->
                    <iframe 
                        src="<?php echo e(asset('storage/' . $material->file_path)); ?>" 
                        width="100%" 
                        height="600px" 
                        sandbox="allow-scripts allow-same-origin" 
                        style="pointer-events: none;">
                    </iframe>
                <?php elseif($material->type === 'Video'): ?>
                    <!-- Video with download disabled -->
                    <video 
                        width="100%" 
                        height="auto" 
                        controls 
                        controlslist="nodownload noremoteplayback" 
                        disablepictureinpicture>
                        <source src="<?php echo e(asset('storage/' . $material->file_path)); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php elseif($material->type === 'Image'): ?>
                    <!-- Display image with interaction disabled -->
                    <div 
                        style="background-image: url('<?php echo e(asset('storage/' . $material->file_path)); ?>'); 
                               background-size: cover; width: 100%; height: 600px; 
                               pointer-events: none;">
                    </div>
                <?php else: ?>
                    <p><?php echo e(__('Preview not available for this file type.')); ?></p>
                <?php endif; ?>

                <!-- Transparent overlay for additional protection -->
                <div 
                    style="position: absolute; top: 0; left: 0; width: 100%; 
                           height: 100%; background: rgba(255,255,255,0); 
                           pointer-events: none;">
                </div>
            </div>
        </div>
    </section>
</main>

<?php $__env->stopSection(); ?>

<!-- JavaScript to disable right-click -->
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
                visibility: hidden;
            }
            .material-viewer {
                display: none;
            }
        }
    `;
    document.head.appendChild(style);
</script>

<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\web\file\viewonly.blade.php ENDPATH**/ ?>