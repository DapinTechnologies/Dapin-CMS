    <!-- Confirm modal -->
    <div class="modal fade" id="confirmModal-<?php echo e($row->id); ?>" tabindex="-1" role="dialog" aria-labelledby="ConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
          <form action="<?php echo e(route($route.'.status', $row->id)); ?>" method="get">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="modal-title" id="ConfirmModalLabel"><?php echo e(__('modal_are_you_sure')); ?></h5>
                    <p class="text-danger mt-2"><?php echo e(__('modal_status_warning')); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-check"></i> <?php echo e(__('btn_confirm')); ?></button>
                </div>
            </div><!-- /.modal-content -->
          </form>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal --><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/user/confirm.blade.php ENDPATH**/ ?>