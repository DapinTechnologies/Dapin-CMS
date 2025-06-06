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
                        <p>1. Your Excel data should be in the format of the download file. The first line of your Excel file should be the column headers as in the table example. Also make sure that your file is UTF-8 to avoid unnecessary encoding problems. <a href="<?php echo e(asset('dashboard/sample/staffs.xlsx')); ?>" class="text-primary" download>Download Sample File</a></p><hr/>
                        <p>2. If the column you are trying to import is date, Make sure that is formatted in format Y-m-d (2022-06-30). Also keep the excel field format as text instead of date.</p><hr/>
                        <p>3. Duplicate "Staff ID" (unique in table) rows will not be imported. Staff ID must be unique.</p><hr/>
                        <p>4. Duplicate "Email" (unique in table) rows will not be imported. Staff email address must be unique and valid email.</p><hr/>
                        <p>5. For "Gender" use ID ( 1=Male, 2=Female, 3=Others ).</p><hr/>
                        <p>6. "DOB" represent the Date of birth. Please follow this date format(2022-06-15) for Date of birth.</p><hr/>
                        <p>7. "Basic Salary" must contain a numeric value (amount of salary).</p><hr/>
                        <p>8. For "Contract Type" use ID ( 1=Full Time, 2=Part Time ).</p><hr/>
                        <p>9. For "Salary Type" use ID ( 1=Fixed, 2=Hourly ).</p><hr/>
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
                                    <label for="department"><?php echo e(__('field_department')); ?> <span>*</span></label>
                                    <select class="form-control" name="department" id="department" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($department->id); ?>" <?php if(old('department') == $department->id): ?> selected <?php endif; ?>><?php echo e($department->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_department')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="designation"><?php echo e(__('field_designation')); ?> <span>*</span></label>
                                    <select class="form-control" name="designation" id="designation" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($designation->id); ?>" <?php if(old('designation') == $designation->id): ?> selected <?php endif; ?>><?php echo e($designation->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_designation')); ?>

                                    </div>
                                </div>

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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\user\import.blade.php ENDPATH**/ ?>