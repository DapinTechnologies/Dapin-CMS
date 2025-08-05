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
 <div class="form-group">
            <label for="icon">Icon</label>
            <select class="form-control" name="icon" required>
                <?php $__currentLoopData = \App\Models\Statistic::iconOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($value); ?>" <?php echo e($statistic->icon == $value ? 'selected' : ''); ?>>
                        <?php echo e($label); ?> (<?php echo e($value); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

 <div class="form-group">
            <label for="icon_color">Icon Color</label>
            <select class="form-control" name="icon_color" required>
                <?php $__currentLoopData = \App\Models\Statistic::colorOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($value); ?>" <?php echo e($statistic->icon_color == $value ? 'selected' : ''); ?>>
                        <?php echo e($label); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update Statistic</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Dapin-CMS/resources/views/admin/statistics/edit.blade.php ENDPATH**/ ?>