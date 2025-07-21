

<?php $__env->startSection('content'); ?>


<style>
    .btn-icon {
    margin-right: 5px;
}

</style>
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
<button>
    <a href="<?php echo e(route('admin.admin.subscriptions.index')); ?>">Subscription </a>
</button>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $inquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($inquiry->name); ?></td>
                    <td><?php echo e($inquiry->email); ?></td>
                    <td><?php echo e($inquiry->phone); ?></td>
                    <td><?php echo e(Str::limit($inquiry->message, 50)); ?> <a href="#" class="view-email" data-email="<?php echo e($inquiry->email); ?>" data-message="<?php echo e($inquiry->message); ?>">View</a></td>
                    <td><?php echo e($inquiry->created_at->diffForHumans()); ?></td>
                    <td>
                        <!-- View Button to open modal or show email -->
                        <a href="<?php echo e(route('admin.admin.inquiry.show',$inquiry->id)); ?>" class="btn btn-info btn-sm view-btn" data-id="<?php echo e($inquiry->id); ?>">View</a>
                        
                        <!-- Delete Button -->
                        <form action="<?php echo e(route('admin.admin.inquiry.delete', $inquiry->id)); ?>" method="POST" style="display:inline-block;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        <?php echo e($inquiries->links()); ?>

    </div>
</div>






















          </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/frontdesk/enqury/index.blade.php ENDPATH**/ ?>