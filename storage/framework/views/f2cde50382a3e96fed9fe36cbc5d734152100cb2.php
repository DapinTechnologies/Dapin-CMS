
<?php $__env->startSection('title', 'View Material'); ?>
<?php $__env->startSection('content'); ?>

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($material->title); ?></h5>
                    </div>
                    <div class="card-body">
                        <!-- Thumbnail -->
                        <div class="form-group text-center">
                            <img src="<?php echo e(asset($material->thumbnail)); ?>" alt="Thumbnail" class="img-thumbnail" style="max-height: 200px;">
                        </div>

                        <!-- Material Details -->
                        <div class="form-group">
                            <label><strong>Description:</strong></label>
                            <p><?php echo e($material->description); ?></p>
                        </div>

                        <div class="form-group">
                            <label><strong>Category:</strong></label>
                            <p><?php echo e($material->category->name ?? 'N/A'); ?></p>
                        </div>

                        <div class="form-group">
                            <label><strong>Type:</strong></label>
                            <p><?php echo e($material->type); ?></p>
                        </div>

                        <div class="form-group">
                            <label><strong>Author:</strong></label>
                            <p><?php echo e($material->author ?? 'N/A'); ?></p>
                        </div>

                        <div class="form-group">
                            <label><strong>Publisher:</strong></label>
                            <p><?php echo e($material->publisher ?? 'N/A'); ?></p>
                        </div>

                        <div class="form-group">
                            <label><strong>Language:</strong></label>
                            <p><?php echo e($material->language ?? 'N/A'); ?></p>
                        </div>

                        <div class="form-group">
                            <label><strong>Edition:</strong></label>
                            <p><?php echo e($material->edition ?? 'N/A'); ?></p>
                        </div>

                        <div class="form-group">
                            <label><strong>ISBN:</strong></label>
                            <p><?php echo e($material->isbn ?? 'N/A'); ?></p>
                        </div>

                        <div class="form-group">
                            <label><strong>Public:</strong></label>
                            <p><?php echo e($material->is_public ? 'Yes' : 'No'); ?></p>
                        </div>

                        <!-- Download File (Conditional) -->
                        <?php if($material->is_downloadable): ?> 
                            <div class="form-group text-center">
                                <a href="<?php echo e(asset($material->file_path)); ?>" class="btn btn-primary" download>
                                    <i class="fas fa-download"></i> Download File
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="form-group text-center">
                                <p>This material is not available for download.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\files\showmaterial.blade.php ENDPATH**/ ?>