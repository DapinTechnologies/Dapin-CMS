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
                            <label for="type"><?php echo e(__('field_type')); ?> <span>*</span></label>
                            <select class="form-control" name="type" id="type" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type->id); ?>" <?php if($row->type_id == $type->id): ?> selected <?php endif; ?>><?php echo e($type->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_type')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="source"><?php echo e(__('field_source')); ?></label>
                            <select class="form-control" name="source" id="source">
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($source->id); ?>" <?php if($row->source_id == $source->id): ?> selected <?php endif; ?>><?php echo e($source->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_source')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name"><?php echo e(__('field_complain_by')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="<?php echo e($row->name); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_complain_by')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="father_name"><?php echo e(__('field_father_name')); ?></label>
                            <input type="text" class="form-control" name="father_name" id="father_name" value="<?php echo e($row->father_name); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_father_name')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="phone"><?php echo e(__('field_phone')); ?></label>
                            <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e($row->phone); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_phone')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="email"><?php echo e(__('field_email')); ?></label>
                            <input type="email" class="form-control" name="email" id="email" value="<?php echo e($row->email); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_email')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="date"><?php echo e(__('field_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="date" id="date" value="<?php echo e($row->date); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="action_taken"><?php echo e(__('field_action_taken')); ?></label>
                            <input type="text" class="form-control" name="action_taken" id="action_taken" value="<?php echo e($row->action_taken); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_action_taken')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="assigned"><?php echo e(__('field_assigned')); ?></label>
                            <select class="form-control select2" name="assigned" id="assigned">
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assigned): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($assigned->id); ?>" <?php if($row->assigned == $assigned->id): ?> selected <?php endif; ?>><?php echo e($assigned->staff_id); ?> - <?php echo e($assigned->first_name); ?> <?php echo e($assigned->last_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_assigned')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="issue"><?php echo e(__('field_issue')); ?></label>
                            <textarea class="form-control" name="issue" id="issue"><?php echo e($row->issue); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_issue')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="note" class="form-label"><?php echo e(__('field_note')); ?></label>
                            <textarea class="form-control" name="note" id="note"><?php echo e($row->note); ?></textarea>
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
                                <option value="1" <?php if( $row->status == 1 ): ?> selected <?php endif; ?>><?php echo e(__('status_pending')); ?></option>
                                <option value="2" <?php if( $row->status == 2 ): ?> selected <?php endif; ?>><?php echo e(__('status_progress')); ?></option>
                                <option value="3" <?php if( $row->status == 3 ): ?> selected <?php endif; ?>><?php echo e(__('status_resolved')); ?></option>
                                <option value="0" <?php if( $row->status == 0 ): ?> selected <?php endif; ?>><?php echo e(__('status_rejected')); ?></option>
                            </select>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\complain\edit.blade.php ENDPATH**/ ?>