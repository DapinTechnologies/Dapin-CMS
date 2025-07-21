

<?php $__env->startSection('title', 'Add New Accreditation'); ?>

<?php $__env->startSection('content'); ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <form action="<?php echo e(route('admin.admin.about-us.accreditations.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="card">
                        <div class="card-header">
                            <h5>Add New Accreditation</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Accreditation Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" class="form-control" name="logo">
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Save Accreditation
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/web/about-us/accreditations/create.blade.php ENDPATH**/ ?>