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
                        <h5><?php echo e(__('modal_add')); ?> <?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                        <a href="<?php echo e(route($route.'.create')); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group d-inline col-md-4">
                            <label for="type"><?php echo e(__('field_type')); ?> <span>*</span></label>
                            <br/>

                            <div class="radio radio-success d-inline">
                                <input type="radio" name="type" value="1" id="import" checked required>
                                <label for="import" class="cr"><?php echo e(__('exchange_type_import')); ?></label>
                            </div>

                            <div class="radio radio-danger d-inline">
                                <input type="radio" name="type" value="2" id="export" required>
                                <label for="export" class="cr"><?php echo e(__('exchange_type_export')); ?></label>
                            </div>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_type')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="category"><?php echo e(__('field_category')); ?> <span>*</span></label>
                            <select class="form-control" name="category" id="category" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php if(old('category') == $category->id): ?> selected <?php endif; ?>><?php echo e($category->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_category')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="title"><?php echo e(__('field_title')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="<?php echo e(old('title')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="reference"><?php echo e(__('field_reference')); ?></label>
                            <input type="text" class="form-control" name="reference" id="reference" value="<?php echo e(old('reference')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_reference')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="from"><?php echo e(__('field_from')); ?></label>
                            <input type="text" class="form-control" name="from" id="from" value="<?php echo e(old('from')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_from')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="to"><?php echo e(__('field_to')); ?></label>
                            <input type="text" class="form-control" name="to" id="to" value="<?php echo e(old('to')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_to')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="date"><?php echo e(__('field_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="date" id="date" value="<?php echo e(date('Y-m-d')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="attach"><?php echo e(__('field_attach')); ?></label>
                            <input type="file" class="form-control" name="attach" id="attach" value="<?php echo e(old('attach')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_attach')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="status" class="form-label"><?php echo e(__('select_status')); ?></label>
                            <select class="form-control" name="status" id="status">
                                <option value="1" <?php if( old('status') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('status_on_hold')); ?></option>
                                <option value="2" <?php if( old('status') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('status_progress')); ?></option>
                                <option value="3" <?php if( old('status') == 3 ): ?> selected <?php endif; ?>><?php echo e(__('status_received')); ?></option>
                                <option value="4" <?php if( old('status') == 4 ): ?> selected <?php endif; ?>><?php echo e(__('status_delivered')); ?></option>
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="note"><?php echo e(__('field_note')); ?></label>
                            <textarea class="form-control" name="note" id="note"><?php echo e(old('note')); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_note')); ?>

                            </div>
                        </div>
                        <!-- Form End -->
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_save')); ?></button>
                    </div>
                    </form>
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\postal-exchange\create.blade.php ENDPATH**/ ?>