<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(__('modal_view')); ?> <?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                        <a href="<?php echo e(route($route.'.show', $role->id)); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <div class="card-block">
                        
                        <!-- Details View Start -->
                        <h4><mark class="text-primary"><?php echo e(__('field_title')); ?>:</mark> <?php echo e($role->name); ?></h4>
                        <hr/>
                                        
                        <?php if(!empty($rolePermissions)): ?>
                            <?php
                                $separation = '0';
                            ?>
                                  
                            <?php $__currentLoopData = $rolePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 

                            <?php if($separation != $value->group): ?>
                                <hr/>
                                <h6 class="mt-4 text-primary"><?php echo e($value->group); ?></h6>
                            <?php endif; ?>
                                <span class="badge badge-secondary">
                                    <?php echo e($value->title); ?>

                                </span> 
                            <?php
                                $separation = $value->group;
                            ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <!-- Details View End -->

                    </div>
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/role/show.blade.php ENDPATH**/ ?>