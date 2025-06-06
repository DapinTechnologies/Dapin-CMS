<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?> <?php echo e(__('btn_import')); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                        <a href="<?php echo e(route($route.'.import')); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <div class="card-block">
                        <p>1. Your Excel data should be in the format of the download file. The first line of your Excel file should be the column headers as in the table example. Also make sure that your file is UTF-8 to avoid unnecessary encoding problems. <a href="<?php echo e(asset('dashboard/sample/courses.xlsx')); ?>" class="text-primary" download>Download Sample File</a></p><hr/>
                        <p>2. Duplicate "Title" (unique in table) rows will not be imported. Course Title must be unique.</p><hr/>
                        <p>3. Duplicate "Code" (unique in table) rows will not be imported. Course Code must be unique.</p><hr/>
                        <p>4. "Credit Hour" must contain a numeric value (course credits).</p><hr/>
                        <p>5. For "Subject Type" use ID ( 1=Compulsory, 0=Optional ).</p><hr/>
                        <p>6. For "Class Type" use ID ( 1=Theory, 2=Practical, 3=Both ).</p><hr/>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <form class="needs-validation" novalidate action="<?php echo e(route($route.'.import.store')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="import"><?php echo e(__('File xlsx')); ?> <span>*</span></label>
                                    <input type="file" class="form-control" name="import" id="import" value="<?php echo e(old('import')); ?>" accept=".xlsx" required>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('File xlsx')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-upload"></i> <?php echo e(__('btn_upload')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\subject\import.blade.php ENDPATH**/ ?>