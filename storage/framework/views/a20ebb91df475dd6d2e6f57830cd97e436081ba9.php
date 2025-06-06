

<?php $__env->startSection('content'); ?>
<main>
    <section class="materials-list pt-120 pb-120">
        <div class="container">
            <h2>Available Materials</h2>

            <?php if($materials->isEmpty()): ?>
                <p>No PDF materials available.</p>
            <?php else: ?>
                <div class="row">
                    <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo e($material->title); ?></h5>
                                    <p class="card-text">
                                        <strong>Category:</strong> <?php echo e($material->category->name ?? 'Uncategorized'); ?><br>
                                        <strong>Author:</strong> <?php echo e($material->author ?? 'N/A'); ?><br>
                                        <strong>Language:</strong> <?php echo e($material->language); ?>

                                    </p>
                                    <a href="<?php echo e(route('materials.show', $material->id)); ?>" class="btn btn-primary">
                                        View Material
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\web\file\materials\index.blade.php ENDPATH**/ ?>