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
                    <h4><mark class="text-primary"><?php echo e(__('field_title')); ?>:</mark> <?php echo e($row->title); ?></h4>
                    <hr/>
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_category')); ?>:</mark> <?php echo e($row->category->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_reference')); ?>:</mark> <?php echo e($row->reference); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_from')); ?>:</mark> <?php echo e($row->from); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_to')); ?>:</mark> <?php echo e($row->to); ?></p><hr/>
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_type')); ?>:</mark> 
                                    <?php if( $row->type == 1 ): ?>
                                    <span class="badge badge-success"><i class="fas fa-download"></i></span> 
                                    <?php echo e(__('exchange_type_import')); ?>

                                    <?php elseif( $row->type == 2 ): ?>
                                    <span class="badge badge-danger"><i class="fas fa-upload"></i></span> 
                                    <?php echo e(__('exchange_type_export')); ?>

                                    <?php endif; ?>
                                </p><hr/>
                                
                                <p><mark class="text-primary"><?php echo e(__('field_date')); ?>:</mark> 
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_status')); ?>:</mark> 
                                <?php if( $row->status == 1 ): ?>
                                <span class="badge badge-pill badge-primary"><?php echo e(__('status_on_hold')); ?></span>
                                <?php elseif( $row->status == 2 ): ?>
                                <span class="badge badge-pill badge-info"><?php echo e(__('status_progress')); ?></span>
                                <?php elseif( $row->status == 3 ): ?>
                                <span class="badge badge-pill badge-success"><?php echo e(__('status_received')); ?></span>
                                <?php elseif( $row->status == 4 ): ?>
                                <span class="badge badge-pill badge-danger"><?php echo e(__('status_delivered')); ?></span>
                                <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_note')); ?>:</mark> <?php echo $row->note; ?></p><hr/>

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
    </div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\postal-exchange\show.blade.php ENDPATH**/ ?>