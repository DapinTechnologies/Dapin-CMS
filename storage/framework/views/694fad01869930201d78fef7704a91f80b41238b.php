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
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_item')); ?>:</mark> <?php echo e($row->item->name ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_supplier')); ?>:</mark> <?php echo e($row->supplier->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_store')); ?>:</mark> <?php echo e($row->store->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_quantity')); ?>:</mark> <?php echo e($row->quantity); ?></p><hr/>
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_price')); ?>:</mark> <?php echo e(round($row->price, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_date')); ?>:</mark> 
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                                    <?php endif; ?>
                                </p><hr/>
                                
                                <p><mark class="text-primary"><?php echo e(__('field_payment_method')); ?>:</mark> 
                                    <?php if( $row->payment_method == 1 ): ?>
                                    <?php echo e(__('payment_method_card')); ?>

                                    <?php elseif( $row->payment_method == 2 ): ?>
                                    <?php echo e(__('payment_method_cash')); ?>

                                    <?php elseif( $row->payment_method == 3 ): ?>
                                    <?php echo e(__('payment_method_cheque')); ?>

                                    <?php elseif( $row->payment_method == 4 ): ?>
                                    <?php echo e(__('payment_method_bank')); ?>

                                    <?php elseif( $row->payment_method == 5 ): ?>
                                    <?php echo e(__('payment_method_e_wallet')); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_status')); ?>:</mark> 
                                <?php if( $row->status == 1 ): ?>
                                <span class="badge badge-pill badge-success"><?php echo e(__('status_received')); ?></span>
                                <?php else: ?>
                                <span class="badge badge-pill badge-danger"><?php echo e(__('status_returned')); ?></span>
                                <?php endif; ?>
                                <hr/>
                            </div>
                            <div class="col-md-12">
                                <p><mark class="text-primary"><?php echo e(__('field_description')); ?>:</mark> <?php echo $row->description; ?></p><hr/>
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
    </div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\item-stock\show.blade.php ENDPATH**/ ?>