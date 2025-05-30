<!-- resources/views/admin/categories/create.blade.php -->

<?php $__env->startSection('title', 'Add Category'); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(__('Categories List')); ?></h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('Name')); ?></th>
                                        <th><?php echo e(__('Description')); ?></th>
                                        <th><?php echo e(__('Actions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($category->name); ?></td>
                                        <td><?php echo e(\Illuminate\Support\Str::limit($category->description, 30, '...')); ?></td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-category')): ?>
                                            <a href="<?php echo e(route('catedit', $category->id)); ?>" class="btn btn-icon btn-primary btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-category')): ?> <form action="<?php echo e(route('categdestroy', $category->id)); ?>" 
                                                method="POST" style="display:inline-block;"> 
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?> 
                                                <button type="submit"
                                                 class="btn btn-icon btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                  <i class="fas fa-trash-alt"></i> </button>
                                                 </form> <?php endif; ?>
                                        </td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="<?php echo e(route('categoriesstore')); ?>" method="post">
                <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Add New Category')); ?></h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="name" class="form-label"><?php echo e(__('Category Name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="<?php echo e(old('name')); ?>" required>
                                <div class="invalid-feedback">
                                  <?php echo e(__('This field is required')); ?>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-label"><?php echo e(__('Category Description')); ?></label>
                                <textarea class="form-control" name="description" id="description"><?php echo e(old('description')); ?></textarea>
                            </div>
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('Save')); ?></button>
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

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\files\addcate.blade.php ENDPATH**/ ?>