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
                        <div class="form-group col-md-4">
                            <label for="item"><?php echo e(__('field_item')); ?> <span>*</span></label>
                            <select class="form-control select2" name="item" id="item" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->id); ?>" <?php if(old('item') == $item->id): ?> selected <?php endif; ?>><?php echo e($item->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_item')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="supplier"><?php echo e(__('field_supplier')); ?> <span>*</span></label>
                            <select class="form-control" name="supplier" id="supplier" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($supplier->id); ?>" <?php if(old('supplier') == $supplier->id): ?> selected <?php endif; ?>><?php echo e($supplier->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_supplier')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="store"><?php echo e(__('field_store')); ?> <span>*</span></label>
                            <select class="form-control" name="store" id="store" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($store->id); ?>" <?php if(old('store') == $store->id): ?> selected <?php endif; ?>><?php echo e($store->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_store')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="quantity"><?php echo e(__('field_quantity')); ?> <span>*</span></label>
                            <input type="number" class="form-control" name="quantity" id="quantity" value="<?php echo e(old('quantity') ?? 1); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_quantity')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="price"><?php echo e(__('field_price')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="price" id="price" value="<?php echo e(old('price')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_price')); ?>

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
                            <label for="payment_method" class="form-label"><?php echo e(__('field_payment_method')); ?> <span>*</span></label>
                            <select class="form-control" name="payment_method" id="payment_method" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <option value="1" <?php if( old('payment_method') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_card')); ?></option>
                                <option value="2" <?php if( old('payment_method') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_cash')); ?></option>
                                <option value="3" <?php if( old('payment_method') == 3 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_cheque')); ?></option>
                                <option value="4" <?php if( old('payment_method') == 4 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_bank')); ?></option>
                                <option value="5" <?php if( old('payment_method') == 5 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_e_wallet')); ?></option>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_payment_method')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description"><?php echo e(__('field_description')); ?></label>
                            <textarea class="form-control" name="description" id="description"><?php echo e(old('description')); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_description')); ?>

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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\item-stock\create.blade.php ENDPATH**/ ?>