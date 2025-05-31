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
                                <p><mark class="text-primary"><?php echo e(__('field_phone')); ?>:</mark> <?php echo e($row->phone); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_date')); ?>:</mark> 
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                                    <?php endif; ?>
                                </p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_next_follow_up_date')); ?>:</mark> 
                                    <?php if(isset($row->follow_up_date)): ?>
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->follow_up_date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->follow_up_date))); ?>

                                    <?php endif; ?>
                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_purpose')); ?>:</mark> <?php echo $row->purpose; ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_note')); ?>:</mark> <?php echo $row->note; ?></p><hr/>
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_start_time')); ?>:</mark> 
                                    <?php if(isset($row->start_time)): ?>
                                    <?php if(isset($setting->time_format)): ?>
                                    <?php echo e(date($setting->time_format, strtotime($row->start_time))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("h:i A", strtotime($row->start_time))); ?>

                                    <?php endif; ?>
                                    <?php endif; ?>
                                </p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_call_duration')); ?>:</mark> <?php echo e($row->call_duration); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_call_type')); ?>:</mark> 
                                    <?php if( $row->call_type == 1 ): ?>
                                    <span class="badge badge-pill badge-success"><?php echo e(__('call_type_incoming')); ?></span>
                                    <?php else: ?>
                                    <span class="badge badge-pill badge-danger"><?php echo e(__('call_type_outgoing')); ?></span>
                                    <?php endif; ?>
                                </p><hr/>

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
    </div><?php /**PATH /home7/httpurba/public_html/college/resources/views/admin/phone-log/show.blade.php ENDPATH**/ ?>