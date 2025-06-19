    <!-- Delete modal -->
    <div class="modal fade" id="deleteModal-<?php echo e($row->id); ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
          <form action="<?php echo e(route($route.'.destroy', [$row->id])); ?>" method="post" class="delete-form">
          <?php echo csrf_field(); ?>
          <?php echo method_field('DELETE'); ?>
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="modal-title" id="deleteModalLabel"><?php echo e(__('modal_are_you_sure')); ?></h5>
                    <p class="text-danger mt-2"><?php echo e(__('modal_delete_warning')); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> <?php echo e(__('btn_delete')); ?></button>
                </div>
            </div><!-- /.modal-content -->
          </form>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal --><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/layouts/inc/delete.blade.php ENDPATH**/ ?>