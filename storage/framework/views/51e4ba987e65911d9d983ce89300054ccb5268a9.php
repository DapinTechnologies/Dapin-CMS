<?php $__env->startSection('title', 'Manage Partners'); ?>

<?php $__env->startSection('content'); ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Manage Partners</h5>
                        <div class="float-right">
                            <a href="<?php echo e(route('admin.admin.about-us.partners.create')); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add New Partner
                            </a>
                        </div>
                    </div>
                    <div class="card-block">
                        <?php if(session('success')): ?>
                            <div class="alert alert-success">
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th style="width: 30%">Description</th>
                                    <th>Logo</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($partner->name); ?></td>
                                        <td style="word-wrap: break-word; white-space: normal;">
                                            <?php echo e(\Illuminate\Support\Str::limit($partner->description, 150)); ?>

                                            <?php if(strlen($partner->description) > 150): ?>
                                                <span class="text-muted">...</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($partner->logo): ?>
                                                <img src="<?php echo e(asset('uploads/about-us/partners/'.$partner->logo)); ?>" alt="Logo" style="max-height: 50px; max-width: 100px; object-fit: contain;">
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?php echo e(route('admin.admin.about-us.partners.edit', $partner->id)); ?>" class="btn btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="<?php echo e(route('admin.admin.about-us.partners.destroy', $partner->id)); ?>" method="POST" style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this partner?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Dapin-CMS/resources/views/admin/web/about-us/partners/index.blade.php ENDPATH**/ ?>