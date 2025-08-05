<?php $__env->startSection('title', 'Manage History Timeline'); ?>

<?php $__env->startSection('content'); ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Manage History Timeline</h5>
                        <div class="float-right">
                            <a href="<?php echo e(route('admin.histories.create')); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add New
                            </a>
                        </div>
                    </div>
                    <div class="card-block">
                        <?php if($histories->count() > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="80">Year</th>
                                            <th width="150">Title</th>
                                            <th>Description</th>
                                            <th width="80">Order</th>
                                            <th width="120">Image</th>
                                            <th width="150">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="text-center"><?php echo e($history->year); ?></td>
                                            <td><?php echo e($history->title); ?></td>
                                            <td style="word-wrap: break-word; white-space: normal;">
                                                <?php echo e(\Illuminate\Support\Str::limit($history->description, 100)); ?>

                                                <?php if(strlen($history->description) > 100): ?>
                                                    <span class="text-muted">...</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center"><?php echo e($history->order); ?></td>
                                            <td class="text-center">
                                                <?php if($history->image): ?>
                                                    <img src="<?php echo e(asset('uploads/about-us/history/'.$history->image)); ?>" 
                                                         alt="History Image" 
                                                         style="max-height: 50px; max-width: 100px; object-fit: contain;">
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">No Image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?php echo e(route('admin.histories.edit', $history->id)); ?>" class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="<?php echo e(route('admin.histories.destroy', $history->id)); ?>" method="POST" style="display:inline;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this item?')">
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
                        <?php else: ?>
                            <div class="alert alert-info">No history items found.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Dapin-CMS/resources/views/admin/web/about-us/histories/index.blade.php ENDPATH**/ ?>