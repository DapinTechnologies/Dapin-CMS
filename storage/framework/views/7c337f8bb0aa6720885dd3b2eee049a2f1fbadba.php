

<?php $__env->startSection('content'); ?>
    <h3>Edit Admission Process Step</h3>

    <form action="<?php echo e(route('admin.admission.process.update', $step->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" id="title" value="<?php echo e(old('title', $step->title)); ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description" rows="3" required><?php echo e(old('description', $step->description)); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="requirements" class="form-label">Requirements</label>

            <?php $__currentLoopData = json_decode($step->requirements); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requirement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input type="text" name="requirements[]" class="form-control mb-2" value="<?php echo e($requirement); ?>">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <input type="text" name="requirements[]" class="form-control mb-2">
            <input type="text" name="requirements[]" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/admission/edit.blade.php ENDPATH**/ ?>