<!-- resources/views/files/show.blade.php -->


<?php $__env->startSection('title', 'File Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5><?php echo e($file->title); ?></h5>
    </div>
    <div class="card-body">
        <p><strong>Description:</strong> <?php echo e($file->description); ?></p>
        <p><strong>File Type:</strong> <?php echo e($file->file_type); ?></p>
        <p><strong>Uploaded By:</strong> <?php echo e($file->uploaded_by); ?></p>
        <a href="<?php echo e(Storage::url($file->file_path)); ?>" class="btn btn-primary" target="_blank">Download File</a>
    </div>
    <div class="card-footer">
        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary">Back</a> <!-- Back button -->
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\files\show.blade.php ENDPATH**/ ?>