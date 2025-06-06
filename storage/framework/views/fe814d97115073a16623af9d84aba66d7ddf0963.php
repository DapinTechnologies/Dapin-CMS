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
                    <h4><mark class="text-primary"><?php echo e(__('field_supplier')); ?>:</mark> <?php echo e($row->title); ?></h4>
                    <hr/>
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_phone')); ?>:</mark> <?php echo e($row->phone); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_email')); ?>:</mark> <?php echo e($row->email); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_address')); ?>:</mark> <?php echo e($row->address); ?></p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_status')); ?>:</mark> 
                                <?php if( $row->status == 1 ): ?>
                                <span class="badge badge-pill badge-success"><?php echo e(__('status_active')); ?></span>
                                <?php else: ?>
                                <span class="badge badge-pill badge-danger"><?php echo e(__('status_inactive')); ?></span>
                                <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="scheduler-border">
                                <legend><?php echo e(__('field_contact_person')); ?></legend>

                                <p><mark class="text-primary"><?php echo e(__('field_name')); ?>:</mark> <?php echo e($row->contact_person); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_designation')); ?>:</mark> <?php echo e($row->designation); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_phone')); ?>:</mark> <?php echo e($row->contact_person_phone); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_email')); ?>:</mark> <?php echo e($row->contact_person_email); ?></p><hr/>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
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
    </div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\item-supplier\show.blade.php ENDPATH**/ ?>