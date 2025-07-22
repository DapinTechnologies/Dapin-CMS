

<?php $__env->startSection('content'); ?>

<div class="main-body">
    <div class="page-wrapper">
        <h4>Reasons</h4>
        <a href="<?php echo e(route('admin.admin.reasons.create')); ?>" class="btn btn-primary mb-3">Add New Reason</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Icon</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $reasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($reason->title); ?></td>
                        <td><i class="fas <?php echo e($reason->icon); ?>"></i></td>
                        <td><?php echo e(Str::limit($reason->description, 50)); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.admin.reasons.edit', $reason->id)); ?>" class="btn btn-info btn-sm">Edit</a>

                            <form action="<?php echo e(route('admin.admin.reasons.destroy', $reason->id)); ?>" method="POST" style="display:inline-block;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/web/reasons/index.blade.php ENDPATH**/ ?>