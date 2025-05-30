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
                                <p><mark class="text-primary"><?php echo e(__('field_invoice_id')); ?>:</mark> <?php echo e($row->invoice_id); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_amount')); ?>:</mark> <?php echo e(round($row->amount, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></p><hr/>
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_date')); ?>:</mark> 
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                                    <?php endif; ?>
                                </p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_reference')); ?>:</mark> <?php echo e($row->reference); ?></p><hr/>
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

                                <p><mark class="text-primary"><?php echo e(__('field_recorded_by')); ?>:</mark> #<?php echo e($row->recordedBy->staff_id ?? ''); ?></p><hr/>
                            </div>
                            <div class="col-md-12">
                                <p><mark class="text-primary"><?php echo e(__('field_note')); ?>:</mark> <?php echo $row->note; ?></p><hr/>
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
    </div><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\expense\show.blade.php ENDPATH**/ ?>