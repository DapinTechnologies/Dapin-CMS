    <!-- Show modal content -->
    <div id="showModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><?php echo e(__('modal_view')); ?> <?php echo e($title); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Details View Start -->
                    <h4><mark class="text-primary"><?php echo e(__('field_name')); ?>:</mark> <?php echo e($row->student->first_name); ?> <?php echo e($row->student->last_name); ?></h4>
                    <hr/>
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_start_date')); ?>:</mark> 
                                <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->from_date))); ?>

                                <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->from_date))); ?>

                                <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_end_date')); ?>:</mark> 
                                <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->to_date))); ?>

                                <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->to_date))); ?>

                                <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_days')); ?>:</mark> 
                                    <?php echo e((int)((strtotime($row->to_date) - strtotime($row->from_date))/86400) + 1); ?>

                                </p><hr/>
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_review_by')); ?>:</mark> <?php echo e($row->reviewBy->first_name ?? ''); ?> <?php echo e($row->reviewBy->last_name ?? ''); ?></p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_apply_date')); ?>:</mark> 
                                <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->apply_date))); ?>

                                <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->apply_date))); ?>

                                <?php endif; ?></p><hr/>
                                
                                <p><mark class="text-primary"><?php echo e(__('field_status')); ?>:</mark> 
                                    <?php if( $row->status == 1 ): ?>
                                    <span class="badge badge-pill badge-success"><?php echo e(__('status_approved')); ?></span>
                                    <?php elseif( $row->status == 2 ): ?>
                                    <span class="badge badge-pill badge-danger"><?php echo e(__('status_rejected')); ?></span>
                                    <?php else: ?>
                                    <span class="badge badge-pill badge-primary"><?php echo e(__('status_pending')); ?></span>
                                    <?php endif; ?>
                                </p><hr/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                               <p><mark class="text-primary"><?php echo e(__('field_leave_subject')); ?>:</mark> <?php echo e($row->subject); ?></p><hr/>

                               <p><mark class="text-primary"><?php echo e(__('field_reason')); ?>:</mark> <?php echo e($row->reason); ?></p><hr/>

                               <?php if(!empty($row->note)): ?>
                               <p><mark class="text-primary"><?php echo e(__('field_note')); ?>:</mark> <?php echo e($row->note); ?></p><hr/>
                               <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Details View End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                </div>
            </div>
        </div>
    </div><?php /**PATH /home7/httpurba/public_html/college/resources/views/student/leave/show.blade.php ENDPATH**/ ?>