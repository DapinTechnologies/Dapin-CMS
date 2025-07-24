


<?php $__env->startSection('content'); ?>
 <h3>Add New Admission Process Step</h3>

    <form action="<?php echo e(route('admin.admission.process.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" id="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="requirements" class="form-label">Requirements</label>
            <input type="text" name="requirements[]" class="form-control mb-2" required>
            <input type="text" name="requirements[]" class="form-control mb-2">
            <input type="text" name="requirements[]" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/admission/create.blade.php ENDPATH**/ ?>