
<?php $__env->startSection('title', 'Director Management'); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('director-create')): ?>
            <div class="col-md-4">
                <form class="needs-validation" novalidate 
                    action="<?php echo e(isset($director) ? route('directors.update', $director->id) : route('directors.store')); ?>" 
                    method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php if(isset($director)): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(isset($director) ? __('Edit Director') : __('Add Director')); ?></h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="name"><?php echo e(__('Director Name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="name" id="name" 
                                    value="<?php echo e(old('name', $director->name ?? '')); ?>" required>

                                <div class="invalid-feedback">
                                    <?php echo e(__('This field is required')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title"><?php echo e(__('Position/Title')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" 
                                    value="<?php echo e(old('title', $director->title ?? '')); ?>" required>

                                <div class="invalid-feedback">
                                    <?php echo e(__('This field is required')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message"><?php echo e(__('Message from Director')); ?> <span>*</span></label>
                                <textarea class="form-control" name="message" id="message" rows="4" required><?php echo e(old('message', $director->message ?? '')); ?></textarea>

                                <div class="invalid-feedback">
                                    <?php echo e(__('This field is required')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="image"><?php echo e(__('Director Image')); ?></label>
                                <input type="file" class="form-control" name="image" id="image" accept="image/*">

                                <small class="text-muted">Max size: 2MB | Formats: jpeg, png, jpg, gif</small>
                            </div>

                            <?php if(isset($director) && $director->image): ?>
                            <div class="mt-3">
                                <label><?php echo e(__('Current Image')); ?></label>
                                <div>
                                    <img src="<?php echo e(asset($director->image)); ?>" alt="Director Image" width="80">
                                </div>
                            </div>
                        <?php endif; ?>
                        
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> <?php echo e(isset($director) ? __('Update') : __('Save')); ?>

                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <?php endif; ?>

            <!-- Director Information Display -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(__('Director Details')); ?></h5>
                    </div>
                    <div class="card-block">
                        <?php if(isset($director)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <td><?php echo e($director->name); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Title')); ?></th>
                                    <td><?php echo e($director->title); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Message')); ?></th>
                                    <td><?php echo e($director->message); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Image')); ?></th>
                                    <td>
                                        <?php if($director->image): ?>
                                            <img src="<?php echo e(asset($director->image)); ?>" alt="Director Image" width="100">
                                        <?php else: ?>
                                            <span class="text-muted">No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                </tr>
                            </table>
                        </div>
                        <?php else: ?>
                        <p class="text-muted text-center">No Director Information Available</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\director\index.blade.php ENDPATH**/ ?>