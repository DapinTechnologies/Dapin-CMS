
<?php $__env->startSection('title', 'Add New History Item'); ?>

<?php $__env->startSection('content'); ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <form action="<?php echo e(route('admin.histories.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5>Add New History Item</h5>
                            <div class="float-right">
                                 <a href="<?php echo e(route('admin.histories.index')); ?>" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to History
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-block">
                            <?php if($errors->any()): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            
                            <div class="form-group">
                                <label>Year</label>
                                <input type="text" class="form-control" name="year" value="<?php echo e(old('year')); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" value="<?php echo e(old('title')); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Order</label>
                                <input type="number" class="form-control" name="order" value="<?php echo e(old('order')); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                            
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" rows="3"><?php echo e(old('description')); ?></textarea>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Save Item
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/web/about-us/histories.blade.php ENDPATH**/ ?>