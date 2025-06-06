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
                    <h4><mark class="text-primary"><?php echo e(__('field_name')); ?>:</mark> <?php echo e($row->name); ?></h4>
                    <hr/>
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_father_name')); ?>:</mark> <?php echo e($row->father_name); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_phone')); ?>:</mark> <?php echo e($row->phone); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_email')); ?>:</mark> <?php echo e($row->email); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_persons')); ?>:</mark> <?php echo e($row->persons); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_address')); ?>:</mark> <?php echo e($row->address); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_purpose')); ?>:</mark> <?php echo e($row->purpose); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_note')); ?>:</mark> <?php echo e($row->note); ?></p><hr/>
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_type')); ?>:</mark> <?php echo e($row->type->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_assigned')); ?>:</mark> #<?php echo e($row->user->staff_id ?? ''); ?> - <?php echo e($row->user->first_name ?? ''); ?> <?php echo e($row->user->last_name ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_id_no')); ?>:</mark> <?php echo e($row->id_no); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_date')); ?>:</mark> 
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                                    <?php endif; ?>
                                </p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_in_time')); ?>:</mark> 
                                    <span class="badge badge-pill badge-success">
                                    <?php if(isset($setting->time_format)): ?>
                                    <?php echo e(date($setting->time_format, strtotime($row->in_time))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("h:i A", strtotime($row->in_time))); ?>

                                    <?php endif; ?>
                                    </span>
                                </p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_out_time')); ?>:</mark> 
                                    <?php if(isset($row->out_time)): ?>
                                    <span class="badge badge-pill badge-danger">
                                    <?php if(isset($setting->time_format)): ?>
                                    <?php echo e(date($setting->time_format, strtotime($row->out_time))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("h:i A", strtotime($row->out_time))); ?>

                                    <?php endif; ?>
                                    </span>
                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_status')); ?>:</mark> 
                                <?php if( $row->status == 1 ): ?>
                                <span class="badge badge-pill badge-primary"><?php echo e(__('status_pending')); ?></span>
                                <?php elseif( $row->status == 2 ): ?>
                                <span class="badge badge-pill badge-info"><?php echo e(__('status_progress')); ?></span>
                                <?php elseif( $row->status == 3 ): ?>
                                <span class="badge badge-pill badge-success"><?php echo e(__('status_finished')); ?></span>
                                <?php elseif( $row->status == 0 ): ?>
                                <span class="badge badge-pill badge-danger"><?php echo e(__('status_canceled')); ?></span>
                                <?php endif; ?>
                                </p>

                                <p><mark class="text-primary"><?php echo e(__('field_recorded_by')); ?>:</mark> #<?php echo e($row->recordedBy->staff_id ?? ''); ?></p><hr/>
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
    </div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\meeting\show.blade.php ENDPATH**/ ?>