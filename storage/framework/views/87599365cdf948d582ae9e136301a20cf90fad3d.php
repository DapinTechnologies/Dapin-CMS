<?php $__env->startSection('title', 'Add New Core Value'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h2 class="text-center">Add New Core Value</h2>

    <form action="<?php echo e(route('admin.core-values.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="icon">Icon</label>
            <input type="text" class="form-control" name="icon" required>
        </div>

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" required></textarea>
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Core Value</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Dapin-CMS/resources/views/admin/web/about-us/core-values/create.blade.php ENDPATH**/ ?>