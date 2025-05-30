    <!-- Cancel modal -->
    <div class="modal fade" id="cancelModal-<?php echo e($row->id); ?>" tabindex="-1" role="dialog" aria-labelledby="CancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
          <form action="<?php echo e(route($route.'.update', $row->id)); ?>" method="post">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="modal-title" id="CancelModalLabel"><?php echo e(__('modal_are_you_sure')); ?></h5>
                    <p class="text-danger mt-2"><?php echo e(__('modal_status_warning')); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-check"></i> <?php echo e(__('btn_confirm')); ?></button>
                </div>
            </div><!-- /.modal-content -->
          </form>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal --><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\application\cancel.blade.php ENDPATH**/ ?>