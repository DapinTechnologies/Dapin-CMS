<!-- Add modal content -->
<div id="addModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel"><?php echo e($title); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- View Start -->
                <div class="">
                    <div class="row">
                        <div class="col-md-6">
                            <p><mark class="text-primary"><?php echo e(__('field_student_id')); ?>:</mark> #<?php echo e($row->student_id); ?></p><hr/>
                            <p><mark class="text-primary"><?php echo e(__('field_name')); ?>:</mark> <?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></p><hr/>
                        </div>
                        <div class="col-md-6">
                            <p><mark class="text-primary"><?php echo e(__('field_program')); ?>:</mark> <?php echo e($row->program->title ?? ''); ?></p><hr/>
                            <p><mark class="text-primary"><?php echo e(__('field_batch')); ?>:</mark> <?php echo e($row->batch->title ?? ''); ?></p><hr/>
                        </div>
                    </div>
                </div>
                <!-- View End -->

                <br/>

                <!-- Form Start -->
                <input type="hidden" name="student_id" value="<?php echo e($row->id); ?>">
                <input type="hidden" name="template_id" value="<?php echo e($selected_template); ?>">
                <div class="clearfix"></div>

                <?php
                    $starting_year = '0000';
                    $ending_year = '0000';
                ?>

                
                <?php $__currentLoopData = $row->studentEnrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    
                    <?php if($loop->first): ?>
                    <?php
                        $starting_year = $item->session->start_date;
                    ?>
                    <?php endif; ?>

                    <?php if($loop->last): ?>
                    <?php
                        $ending_year = $item->session->end_date;
                    ?>
                    <?php endif; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="date"><?php echo e(__('field_date')); ?> <span>*</span></label>
                        <input type="date" class="form-control date" name="date" id="date" value="<?php echo e(date('Y-m-d')); ?>" required>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_date')); ?>

                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="starting_year"><?php echo e(__('field_starting_year')); ?> <span>*</span></label>
                        <input type="number" class="form-control" name="starting_year" id="starting_year" value="<?php echo e(date('Y',strtotime($starting_year))); ?>" required readonly>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_starting_year')); ?>

                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="ending_year"><?php echo e(__('field_ending_year')); ?> <span>*</span></label>
                        <input type="number" class="form-control" name="ending_year" id="ending_year" value="<?php echo e(date('Y',strtotime($ending_year))); ?>" required readonly>

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_ending_year')); ?>

                        </div>
                    </div>
                </div>
                </div>
                <!-- Form End -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_save')); ?></button>
            </div>

          </form>
        </div>
    </div>
</div><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/certificate/create.blade.php ENDPATH**/ ?>