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
                        <div class="form-group d-inline col-md-4">
                            <label for="field_call_type"><?php echo e(__('field_call_type')); ?> <span>*</span></label>
                            <br/>

                            <div class="radio radio-success d-inline">
                                <input type="radio" name="call_type" value="1" id="incoming-<?php echo e($row->id); ?>" <?php if($row->call_type == 1): ?> checked <?php endif; ?> required>
                                <label for="incoming-<?php echo e($row->id); ?>" class="cr"><?php echo e(__('call_type_incoming')); ?></label>
                            </div>

                            <div class="radio radio-danger d-inline">
                                <input type="radio" name="call_type" value="2" id="outgoing-<?php echo e($row->id); ?>" <?php if($row->call_type == 2): ?> checked <?php endif; ?> required>
                                <label for="outgoing-<?php echo e($row->id); ?>" class="cr"><?php echo e(__('call_type_outgoing')); ?></label>
                            </div>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_call_type')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name" class="form-label"><?php echo e(__('field_name')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="<?php echo e($row->name); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_name')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="phone" class="form-label"><?php echo e(__('field_phone')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e($row->phone); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_phone')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="date" class="form-label"><?php echo e(__('field_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="date" id="date" value="<?php echo e($row->date); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="follow_up_date" class="form-label"><?php echo e(__('field_next_follow_up_date')); ?></label>
                            <input type="date" class="form-control date" name="follow_up_date" id="follow_up_date" value="<?php echo e($row->follow_up_date); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_next_follow_up_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="start_time" class="form-label"><?php echo e(__('field_start_time')); ?> <span>*</span></label>
                            <input type="time" class="form-control time" name="start_time" id="start_time" value="<?php echo e($row->start_time); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_start_time')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="call_duration" class="form-label"><?php echo e(__('field_call_duration')); ?></label>
                            <input type="text" class="form-control" name="call_duration" id="call_duration" value="<?php echo e($row->call_duration); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_call_duration')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="purpose" class="form-label"><?php echo e(__('field_purpose')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="purpose" id="purpose" value="<?php echo e($row->purpose); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_purpose')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="note" class="form-label"><?php echo e(__('field_note')); ?></label>
                            <textarea class="form-control" name="note" id="note"><?php echo e($row->note); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_note')); ?>

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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\phone-log\edit.blade.php ENDPATH**/ ?>