    <!-- UnPay modal -->
    <div class="modal fade" id="cancelModal-<?php echo e($row->id); ?>" tabindex="-1" role="dialog" aria-labelledby="CancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
          <form action="<?php echo e(route($route.'.cancel', $row->id)); ?>" method="post">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="modal-title" id="CancelModalLabel"><?php echo e(__('modal_are_you_sure')); ?></h5>
                    <p class="text-danger mt-2"><?php echo e(__('modal_action_warning')); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-check"></i> <?php echo e(__('btn_confirm')); ?></button>
                </div>
            </div><!-- /.modal-content -->
          </form>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal --><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/fees-student/cancel.blade.php ENDPATH**/ ?>