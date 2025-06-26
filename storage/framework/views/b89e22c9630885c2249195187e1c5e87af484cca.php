

<?php $__env->startSection('content'); ?>
<div class="container">
    <h4 class="mb-3">All Submissions</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Type</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Received At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $enquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e(ucfirst($item->type)); ?></td>
                <td><?php echo e($item->name ?? '-'); ?></td>
                <td><?php echo e($item->email); ?></td>
                <td><?php echo e($item->phone ?? '-'); ?></td>
                <td><?php echo e($item->created_at->format('d M Y, H:i')); ?></td>
                <td>
                    <a href="<?php echo e(route('sub_enquiries.show', $item->id)); ?>" class="btn btn-sm btn-info">View</a>
                    <form action="<?php echo e(route('sub_enquiries.destroy', $item->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this entry?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e($enquiries->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/subenquiries/index.blade.php ENDPATH**/ ?>