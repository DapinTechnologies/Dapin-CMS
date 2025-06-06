<!-- Show modal content -->
<div id="showModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
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
                        <div class="col-md-12">
                            <p><mark class="text-primary"><?php echo e(__('field_designation')); ?>:</mark> <?php echo e($row->designation); ?></p><hr/>

                            <p><mark class="text-primary"><?php echo e(__('field_description')); ?>:</mark> <?php echo e($row->description); ?></p><hr/>

                            <p><mark class="text-primary"><?php echo e(__('field_status')); ?>:</mark>
                                <?php if( $row->status == 1 ): ?>
                                <span class="badge badge-pill badge-success"><?php echo e(__('status_active')); ?></span>
                                <?php else: ?>
                                <span class="badge badge-pill badge-danger"><?php echo e(__('status_inactive')); ?></span>
                                <?php endif; ?>
                            </p>
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
</div>
<?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\web\testimonial\show.blade.php ENDPATH**/ ?>