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
                                <p><mark class="text-primary"><?php echo e(__('field_room')); ?> <?php echo e(__('field_no')); ?>:</mark> <?php echo e($row->name); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_hostel')); ?>:</mark> <?php echo e($row->hostel->name ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_type')); ?>:</mark> <?php echo e($row->roomType->title ?? ''); ?></p><hr/>
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_total')); ?> <?php echo e(__('field_bed')); ?>:</mark> <?php echo e($row->bed); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('status_available')); ?>:</mark> <?php echo e($row->bed - $row->hostelMembers->where('status', '1')->count()); ?></p><hr/>
                                

                                <p><mark class="text-primary"><?php echo e(__('field_status')); ?>:</mark> 
                                <?php if( $row->status == 1 ): ?>
                                <span class="badge badge-pill badge-success"><?php echo e(__('status_active')); ?></span>
                                <?php else: ?>
                                <span class="badge badge-pill badge-danger"><?php echo e(__('status_inactive')); ?></span>
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
    </div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\hostel-room\show.blade.php ENDPATH**/ ?>