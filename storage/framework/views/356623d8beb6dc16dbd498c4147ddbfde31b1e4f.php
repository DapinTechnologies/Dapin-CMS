<!-- resources/views/admin/categories/edit.blade.php -->

<?php $__env->startSection('title', 'Edit Category'); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form class="needs-validation" novalidate action="<?php echo e(route('categoriesupdate', $category->id)); ?>" method="post">
                <?php echo csrf_field(); ?>

                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Edit Category')); ?></h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="name" class="form-label"><?php echo e(__('Category Name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="<?php echo e(old('name', $category->name)); ?>" required>
                                <div class="invalid-feedback">
                                  <?php echo e(__('This field is required')); ?>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-label"><?php echo e(__('Category Description')); ?></label>
                                <textarea class="form-control" name="description" id="description"><?php echo e(old('description', $category->description)); ?></textarea>
                            </div>
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('Update')); ?></button>
                            <a href="<?php echo e(route('alldigitalbooks')); ?>" class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\files\editcate.blade.php ENDPATH**/ ?>