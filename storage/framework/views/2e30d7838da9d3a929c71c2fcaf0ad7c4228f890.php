<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-info-tab" data-bs-toggle="pill" href="#pills-info" role="tab" aria-controls="pills-info" aria-selected="true"><?php echo e(__('tab_profile_info')); ?></a>
                            </li>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-edit')): ?>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"><?php echo e(__('tab_profile_update')); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-account')): ?>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-account-tab" data-bs-toggle="pill" href="#pills-account" role="tab" aria-controls="pills-account" aria-selected="false"><?php echo e(__('tab_account_update')); ?></a>
                            </li>
                            <?php endif; ?>
                        </ul>
                        <?php
                            function field($slug){
                                return \App\Models\Field::field($slug);
                            }
                        ?>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-info" role="tabpanel" aria-labelledby="pills-info-tab">
                                <?php echo $__env->make('admin.profile.show', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-edit')): ?>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <?php echo $__env->make('admin.profile.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-account')): ?>
                            <div class="tab-pane fade" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab">
                                <?php echo $__env->make('admin.profile.account', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <?php endif; ?>
                        </div>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/profile/index.blade.php ENDPATH**/ ?>