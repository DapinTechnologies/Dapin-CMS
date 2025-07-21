

<?php $__env->startSection('content'); ?>

<style>
    .btn-icon {
        margin-right: 5px;
    }
</style>

<!-- Start Content -->
<div class="main-body">
    <div class="page-wrapper">

        <div class="table-responsive">
            <h4>Subscriptions</h4>
            <form action="<?php echo e(route('admin.admin.subscriptions.sendBulkEmail')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="message_content">Bulk Email Message</label>
                    <textarea id="message_content" name="message_content" class="form-control" rows="4" placeholder="Enter message to send to all subscribers" required></textarea>
                    <div class="invalid-feedback">
                        Please provide a message for the bulk email.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Send Bulk Email</button>
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Subscribed Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($subscription->email); ?></td>
                            <td><?php echo e($subscription->created_at->diffForHumans()); ?></td>
                            <td>
                                <!-- Delete Button -->
                                <form action="<?php echo e(route('admin.admin.subscriptions.destroy', $subscription->id)); ?>" method="POST" style="display:inline-block;">
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
                <?php echo e($subscriptions->links()); ?>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/frontdesk/enqury/subscription.blade.php ENDPATH**/ ?>