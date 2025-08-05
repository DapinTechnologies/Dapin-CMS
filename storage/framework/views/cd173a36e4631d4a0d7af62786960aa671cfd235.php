<?php $__env->startSection('title', 'Statistics'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h2 class="text-center">Statistics</h2>
    <div class="mb-4 text-right">
        <a href="<?php echo e(route('admin.statistics.create')); ?>" class="btn btn-success">Add New Statistic</a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

   <table class="table table-bordered">
        <thead>
            <tr>
                <th>Icon</th>
                <th>Type</th>
                <th>Count</th>
                <th>Color</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $statistics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statistic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><i class="fas <?php echo e($statistic->icon); ?> text-<?php echo e($statistic->icon_color); ?>"></i></td>
                    <td><?php echo e($statistic->type); ?></td>
                    <td><?php echo e(number_format($statistic->count)); ?></td>
                    <td><span class="badge bg-<?php echo e($statistic->icon_color); ?>"><?php echo e($statistic->icon_color); ?></span></td>
                    <td>
                        <a href="<?php echo e(route('admin.statistics.edit', $statistic->id)); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form action="<?php echo e(route('admin.statistics.destroy', $statistic->id)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Dapin-CMS/resources/views/admin/statistics/index.blade.php ENDPATH**/ ?>