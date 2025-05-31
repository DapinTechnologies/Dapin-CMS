<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('DB Table Name')); ?></th>
                                        <th><?php echo e(__('btn_import')); ?></th>
                                        <th><?php echo e(__('btn_export')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo e(trans_choice('module_staff', 2)); ?></td>
                                        <td>
                                        <form class="needs-validation" novalidate action="<?php echo e(route('admin.bulk.import', ['table' => 'users'])); ?>" method="post" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="row">

                                            <div class="col-md-6">
                                            <input type="file" name="import" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> <?php echo e(__('btn_import')); ?></button>
                                            </div>
                                        </div>
                                        </form>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.bulk.export', ['table' => 'users'])); ?>" class="btn btn-info"><i class="fas fa-download"></i> <?php echo e(__('btn_export')); ?></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><?php echo e(trans_choice('module_student', 2)); ?></td>
                                        <td>
                                        <form class="needs-validation" novalidate action="<?php echo e(route('admin.bulk.import', ['table' => 'students'])); ?>" method="post" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="row">

                                            <div class="col-md-6">
                                            <input type="file" name="import" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> <?php echo e(__('btn_import')); ?></button>
                                            </div>
                                        </div>
                                        </form>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.bulk.export', ['table' => 'students'])); ?>" class="btn btn-info"><i class="fas fa-download"></i> <?php echo e(__('btn_export')); ?></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><?php echo e(trans_choice('module_application', 2)); ?></td>
                                        <td>
                                        <form class="needs-validation" novalidate action="<?php echo e(route('admin.bulk.import', ['table' => 'applications'])); ?>" method="post" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="row">

                                            <div class="col-md-6">
                                            <input type="file" name="import" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> <?php echo e(__('btn_import')); ?></button>
                                            </div>
                                        </div>
                                        </form>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.bulk.export', ['table' => 'applications'])); ?>" class="btn btn-info"><i class="fas fa-download"></i> <?php echo e(__('btn_export')); ?></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><?php echo e(trans_choice('module_subject', 2)); ?></td>
                                        <td>
                                        <form class="needs-validation" novalidate action="<?php echo e(route('admin.bulk.import', ['table' => 'subjects'])); ?>" method="post" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="row">

                                            <div class="col-md-6">
                                            <input type="file" name="import" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> <?php echo e(__('btn_import')); ?></button>
                                            </div>
                                        </div>
                                        </form>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.bulk.export', ['table' => 'subjects'])); ?>" class="btn btn-info"><i class="fas fa-download"></i> <?php echo e(__('btn_export')); ?></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><?php echo e(trans_choice('module_book', 2)); ?></td>
                                        <td>
                                        <form class="needs-validation" novalidate action="<?php echo e(route('admin.bulk.import', ['table' => 'books'])); ?>" method="post" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="row">

                                            <div class="col-md-6">
                                            <input type="file" name="import" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> <?php echo e(__('btn_import')); ?></button>
                                            </div>
                                        </div>
                                        </form>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.bulk.export', ['table' => 'books'])); ?>" class="btn btn-info"><i class="fas fa-download"></i> <?php echo e(__('btn_export')); ?></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\bulk-import-export\index.blade.php ENDPATH**/ ?>