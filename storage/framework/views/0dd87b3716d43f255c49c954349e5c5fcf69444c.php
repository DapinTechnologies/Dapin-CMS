

<?php $__env->startSection('title', 'Edit Statistic'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h2 class="text-center">Edit Statistic</h2>

    <form action="<?php echo e(route('admin.statistics.update', $statistic->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" name="type" value="<?php echo e($statistic->type); ?>" required>
        </div>

        <div class="form-group">
            <label for="count">Count</label>
            <input type="number" class="form-control" name="count" value="<?php echo e($statistic->count); ?>" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update Statistic</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/statistics/edit.blade.php ENDPATH**/ ?>