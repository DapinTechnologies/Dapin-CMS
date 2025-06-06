

<?php $__env->startSection('content'); ?>
<main>
    <section class="material-view pt-120 pb-120">
        <div class="container">
            <h2><?php echo e($material->title); ?></h2>

            <!-- Display PDF Pages as Images -->
            <div class="pdf-images">
                <?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <img src="<?php echo e(asset('storage/pdf_images/' . pathinfo($material->file_path, PATHINFO_FILENAME) . '/' . $image)); ?>" 
                         class="img-fluid mb-4" 
                         alt="PDF Page">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>No pages available to display.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\web\file\materials\show.blade.php ENDPATH**/ ?>