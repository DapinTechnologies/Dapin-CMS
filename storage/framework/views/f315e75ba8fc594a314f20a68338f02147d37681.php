<!-- Edit modal content -->
<div id="cancelModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <form class="needs-validation" novalidate action="<?php echo e(route($route.'.update', $row->id)); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field("PUT"); ?>

            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="modal-title" id="cancelModalLabel"><?php echo e(__('modal_are_you_sure')); ?></h5>
                    <p class="text-danger mt-2"><?php echo e(__('modal_status_warning')); ?></p>

                    <!-- Form Start -->
                    <input type="hidden" name="member_id" value="<?php echo e($row->member->id); ?>">
                    <input type="hidden" name="status" value="0">
                    <!-- Form End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-check"></i> <?php echo e(__('btn_confirm')); ?></button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div>
</div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\library-staff\cancel.blade.php ENDPATH**/ ?>