

<?php $__env->startSection('title', 'Add New Statistic'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h2 class="text-center">Add New Statistic</h2>

    <form action="<?php echo e(route('admin.statistics.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" name="type" required>
        </div>

        <div class="form-group">
            <label for="count">Count</label>
            <input type="number" class="form-control" name="count" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Statistic</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/statistics/create.blade.php ENDPATH**/ ?>