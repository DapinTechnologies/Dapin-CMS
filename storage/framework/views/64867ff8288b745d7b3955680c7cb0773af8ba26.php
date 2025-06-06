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
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-4">
                            <label for="name" class="form-label"><?php echo e(__('field_room')); ?> <?php echo e(__('field_no')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="<?php echo e($row->name); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_room')); ?> <?php echo e(__('field_no')); ?>

                            </div>
                        </div>
                    
                        <div class="form-group col-md-4">
                            <label for="hostel"><?php echo e(__('field_hostel')); ?> <span>*</span></label>
                            <select class="form-control" name="hostel" id="hostel" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $hostels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hostel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($hostel->id); ?>" <?php if($row->hostel_id == $hostel->id): ?> selected <?php endif; ?>><?php echo e($hostel->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_hostel')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="room_type"><?php echo e(__('field_type')); ?> <span>*</span></label>
                            <select class="form-control" name="room_type" id="room_type" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $room_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($room_type->id); ?>" <?php if($row->room_type_id == $room_type->id): ?> selected <?php endif; ?>><?php echo e($room_type->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_type')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="bed"><?php echo e(__('field_bed')); ?> <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="bed" id="bed" value="<?php echo e($row->bed); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_bed')); ?>

                            </div>
                        </div>

                        

                        <div class="form-group col-md-4">
                            <label for="status" class="form-label"><?php echo e(__('select_status')); ?></label>
                            <select class="form-control" name="status" id="status">
                                <option value="1" <?php if( $row->status == 1 ): ?> selected <?php endif; ?>><?php echo e(__('status_active')); ?></option>
                                <option value="0" <?php if( $row->status == 0 ): ?> selected <?php endif; ?>><?php echo e(__('status_inactive')); ?></option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description"><?php echo e(__('field_description')); ?></label>
                            <textarea class="form-control" name="description" id="description"><?php echo e($row->description); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_description')); ?>

                            </div>
                        </div>
                        <!-- Form End -->
                      </div>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\hostel-room\edit.blade.php ENDPATH**/ ?>