

<?php $__env->startSection('title', 'Edit Accreditation'); ?>

<?php $__env->startSection('content'); ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <form action="<?php echo e(route('admin.admin.about-us.accreditations.update', $accreditation->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Accreditation</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Accreditation Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo e($accreditation->name); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" required><?php echo e($accreditation->description); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" class="form-control" name="logo">
                                <?php if($accreditation->logo): ?>
                                    <img src="<?php echo e(asset('uploads/about-us/accreditations/'.$accreditation->logo)); ?>" alt="Logo" style="max-height: 50px;">
                                    <input type="checkbox" name="remove_logo" value="1"> Remove Logo
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/web/about-us/accreditations/edit.blade.php ENDPATH**/ ?>