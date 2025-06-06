
<?php $__env->startSection('title', $material->title); ?>

<?php $__env->startSection('content'); ?>

<main>
    <section class="material-view pt-120 pb-120">
        <div class="container">
            <h2><?php echo e($material->title); ?></h2>

            <!-- Viewing the Material -->
            <div class="material-viewer text-center">
                <?php if($material->type === 'PDF'): ?>
                    <!-- Embed the PDF without toolbar, navigation, and scrollbar -->
                    <iframe 
                        src="<?php echo e(asset($material->file_path)); ?>#toolbar=0&navpanes=0&scrollbar=0" 
                        width="100%" 
                        height="600px">
                    </iframe>
                <?php else: ?>
                    <p><?php echo e(__('Preview not available for this file type.')); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\viewpdf.blade.php ENDPATH**/ ?>