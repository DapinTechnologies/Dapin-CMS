<?php $__env->startSection('title', 'Edit Core Value'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h2 class="text-center">Edit Core Value</h2>

    <form action="<?php echo e(route('admin.core-values.update', $value->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="form-group">
            <label for="icon">Icon</label>
            <input type="text" class="form-control" name="icon" value="<?php echo e($value->icon); ?>" required>
        </div>

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" value="<?php echo e($value->title); ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" required><?php echo e($value->description); ?></textarea>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update Core Value</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Dapin-CMS/resources/views/admin/web/about-us/core-values/edit.blade.php ENDPATH**/ ?>