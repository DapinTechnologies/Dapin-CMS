    <!-- Show modal content -->
    <div id="editModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <form class="needs-validation" novalidate action="<?php echo e(route($route.'.update', $row->id)); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><?php echo e(__('modal_view')); ?> <?php echo e($title); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Details View Start -->
                    <h4><mark class="text-primary"><?php echo e(__('field_name')); ?>:</mark> <?php echo e($row->student->first_name ?? ''); ?> <?php echo e($row->student->last_name ?? ''); ?></h4>
                    <hr/>
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_program')); ?>:</mark> <?php echo e($row->student->program->title ?? ''); ?></p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_batch')); ?>:</mark> <?php echo e($row->student->batch->title ?? ''); ?></p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_apply_date')); ?>:</mark> 
                                <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->apply_date))); ?>

                                <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->apply_date))); ?>

                                <?php endif; ?></p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_review_by')); ?>:</mark> #<?php echo e($row->reviewBy->staff_id ?? ''); ?> - <?php echo e($row->reviewBy->first_name ?? ''); ?> <?php echo e($row->reviewBy->last_name ?? ''); ?></p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_leave_subject')); ?>:</mark> <?php echo e($row->subject); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_reason')); ?>:</mark> <?php echo e($row->reason); ?></p><hr/>
                                <br/><br/>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="from_date"><?php echo e(__('field_start_date')); ?> <span>*</span></label>
                                    <input type="date" class="form-control date" name="from_date" id="from_date" value="<?php echo e($row->from_date); ?>" required>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_start_date')); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="to_date"><?php echo e(__('field_end_date')); ?> <span>*</span></label>
                                    <input type="date" class="form-control date" name="to_date" id="to_date" value="<?php echo e($row->to_date); ?>" required>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_end_date')); ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="note"><?php echo e(__('field_note')); ?></label>
                                    <textarea class="form-control" name="note" id="note"><?php echo e($row->note); ?></textarea>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_note')); ?>

                                    </div>
                                </div>

                                <div class="form-group d-inline">
                                    <label for="status"><?php echo e(__('field_status')); ?></label> 
                                    <span>*</span> 

                                    <div class="radio radio-primary d-inline">
                                        <input type="radio" name="status" value="0" id="pending-<?php echo e($row->id); ?>" <?php if($row->status == 0): ?> checked <?php endif; ?> required>
                                        <label for="pending-<?php echo e($row->id); ?>" class="cr"><?php echo e(__('status_pending')); ?></label>
                                    </div>

                                    <div class="radio radio-success d-inline">
                                        <input type="radio" name="status" value="1" id="approved-<?php echo e($row->id); ?>" <?php if($row->status == 1): ?> checked <?php endif; ?> required>
                                        <label for="approved-<?php echo e($row->id); ?>" class="cr"><?php echo e(__('status_approved')); ?></label>
                                    </div>

                                    <div class="radio radio-danger d-inline">
                                        <input type="radio" name="status" value="2" id="rejected-<?php echo e($row->id); ?>" <?php if($row->status == 2): ?> checked <?php endif; ?> required>
                                        <label for="rejected-<?php echo e($row->id); ?>" class="cr"><?php echo e(__('status_rejected')); ?></label>
                                    </div>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_status')); ?>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Details View End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                </div>

              </form>
            </div>
        </div>
    </div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\student-leave-manage\edit.blade.php ENDPATH**/ ?>