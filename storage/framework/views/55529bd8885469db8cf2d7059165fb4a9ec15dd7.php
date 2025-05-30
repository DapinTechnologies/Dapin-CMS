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
                        <h5><?php echo e(__('modal_edit')); ?> <?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                        <a href="<?php echo e(route($route.'.edit', $row->id)); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.update', [$row->id])); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="card-block">
                        <!-- Form Start -->
                        <fieldset class="row scheduler-border">
                        <div class="form-group col-md-4">
                            <label for="category"><?php echo e(__('field_category')); ?> <span>*</span></label>
                            <select class="form-control" name="category" id="category" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php if( $category->id == $row->category_id ): ?> selected <?php endif; ?>><?php echo e($category->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_category')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="title"><?php echo e(__('field_title')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="<?php echo e($row->title); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="isbn"><?php echo e(__('field_isbn')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="isbn" id="isbn" value="<?php echo e($row->isbn); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_isbn')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="author"><?php echo e(__('field_author')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="author" id="author" value="<?php echo e($row->author); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_author')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="publisher"><?php echo e(__('field_publisher')); ?></label>
                            <input type="text" class="form-control" name="publisher" id="publisher" value="<?php echo e($row->publisher); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_publisher')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="edition"><?php echo e(__('field_edition')); ?></label>
                            <input type="text" class="form-control" name="edition" id="edition" value="<?php echo e($row->edition); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_edition')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="publish_year"><?php echo e(__('field_publish_year')); ?></label>
                            <input type="text" class="form-control" name="publish_year" id="publish_year" value="<?php echo e($row->publish_year); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_publish_year')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="language"><?php echo e(__('field_language')); ?></label>
                            <input type="text" class="form-control" name="language" id="language" value="<?php echo e($row->language); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_language')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="price"><?php echo e(__('field_price')); ?> (<?php echo $setting->currency_symbol; ?>)</label>
                            <input type="text" class="form-control autonumber" name="price" id="price" value="<?php echo e(round($row->price)); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_price')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="quantity"><?php echo e(__('field_quantity')); ?> <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="quantity" id="quantity" value="<?php echo e($row->quantity); ?>" required data-v-max="999999999" data-v-min="0">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_quantity')); ?>

                            </div>
                        </div>
                        </fieldset>

                        <fieldset class="row scheduler-border">
                        <legend><?php echo e(__('field_location')); ?></legend>
                        <div class="form-group col-md-4">
                            <label for="section"><?php echo e(__('field_rack')); ?></label>
                            <input type="text" class="form-control" name="section" id="section" value="<?php echo e($row->section); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_rack')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="column"><?php echo e(__('field_column')); ?></label>
                            <input type="text" class="form-control" name="column" id="column" value="<?php echo e($row->column); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_column')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="row"><?php echo e(__('field_row')); ?></label>
                            <input type="text" class="form-control" name="row" id="row" value="<?php echo e($row->row); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_row')); ?>

                            </div>
                        </div>
                        </fieldset>

                        <fieldset class="row scheduler-border">
                        <div class="form-group col-md-6">
                            <label for="description"><?php echo e(__('field_description')); ?></label>
                            <textarea class="form-control" name="description" id="description"><?php echo e($row->description); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_description')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="note"><?php echo e(__('field_note')); ?></label>
                            <textarea class="form-control" name="note" id="note"><?php echo e($row->note); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_note')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="status" class="form-label"><?php echo e(__('select_status')); ?></label>
                            <select class="form-control" name="status" id="status">
                                <option value="1" <?php if( $row->status == 1 ): ?> selected <?php endif; ?>><?php echo e(__('status_available')); ?></option>
                                <option value="2" <?php if( $row->status == 2 ): ?> selected <?php endif; ?>><?php echo e(__('status_damage')); ?></option>
                                <option value="0" <?php if( $row->status == 0 ): ?> selected <?php endif; ?>><?php echo e(__('status_lost')); ?></option>
                            </select>
                        </div>
                        </fieldset>
                        <!-- Form End -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\book\edit.blade.php ENDPATH**/ ?>