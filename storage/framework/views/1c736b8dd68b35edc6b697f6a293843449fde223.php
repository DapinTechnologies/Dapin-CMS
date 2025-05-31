    <!-- Show modal content -->
    <div id="showModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><?php echo e(__('modal_view')); ?> <?php echo e($title); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Details View Start -->
                    <h4><mark class="text-primary"><?php echo e(__('field_title')); ?>:</mark> <?php echo e($row->title); ?></h4>
                    <hr/>
                    <p><mark class="text-primary"><?php echo e(__('field_student')); ?>:</mark> #<?php echo e($row->noteable->student_id ?? ''); ?> - <?php echo e($row->noteable->first_name ?? ''); ?> <?php echo e($row->noteable->last_name ?? ''); ?></p><hr/>
                    
                    <p><mark class="text-primary"><?php echo e(__('field_note')); ?>:</mark> <?php echo $row->description; ?></p>

                    <hr/>
                    <p><mark class="text-primary"><?php echo e(__('field_status')); ?>:</mark> 
                    <?php if( $row->status == 1 ): ?>
                    <span class="badge badge-pill badge-success"><?php echo e(__('status_active')); ?></span>
                    <?php else: ?>
                    <span class="badge badge-pill badge-danger"><?php echo e(__('status_inactive')); ?></span>
                    <?php endif; ?>
                    </p>
                    <!-- Details View End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                </div>
            </div>
        </div>
    </div><?php /**PATH /home7/httpurba/public_html/college/resources/views/admin/student-note/show.blade.php ENDPATH**/ ?>