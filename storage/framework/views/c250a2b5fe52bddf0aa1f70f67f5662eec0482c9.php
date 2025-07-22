

<?php $__env->startSection('content'); ?>

<div class="main-body">
    <div class="page-wrapper">
        <h4>Add New Reason</h4>
        <form action="<?php echo e(route('admin.admin.reasons.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label for="title">Reason Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="icon">Icon (FontAwesome)</label>
        <input type="text" name="icon" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Reason Description</label>
        <textarea name="description" class="form-control" rows="4" required></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Save Reason</button>
</form>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/web/reasons/create.blade.php ENDPATH**/ ?>