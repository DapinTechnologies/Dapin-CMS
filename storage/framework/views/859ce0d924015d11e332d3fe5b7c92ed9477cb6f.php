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
                                <p><mark class="text-primary"><?php echo e(__('field_isbn')); ?>:</mark> <?php echo e($row->isbn); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_category')); ?>:</mark> <?php echo e($row->category->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_author')); ?>:</mark> <?php echo e($row->author); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_publisher')); ?>:</mark> <?php echo e($row->publisher); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_edition')); ?>:</mark> <?php echo e($row->edition); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_publish_year')); ?>:</mark> <?php echo e($row->publish_year); ?></p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_location')); ?>:</mark> <?php echo e(__('field_rack')); ?>: <?php echo e($row->section); ?> | <?php echo e(__('field_column')); ?>: <?php echo e($row->column); ?> | <?php echo e(__('field_row')); ?>: <?php echo e($row->row); ?></p><hr/>
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_language')); ?>:</mark> <?php echo e($row->language); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_price')); ?>:</mark> <?php echo e(round($row->price, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_quantity')); ?>:</mark> <?php echo e($row->quantity); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_issue')); ?>:</mark> <?php echo e($row->issues->where('status', '1')->count()); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_lost')); ?>:</mark> <?php echo e($row->issues->where('status', '0')->count()); ?></p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_status')); ?>:</mark> 
                                <?php if( $row->status == 1 ): ?>
                                <span class="badge badge-pill badge-success"><?php echo e(__('status_available')); ?></span>
                                <?php elseif( $row->status == 2 ): ?>
                                <span class="badge badge-pill badge-warning"><?php echo e(__('status_damage')); ?></span>
                                <?php else: ?>
                                <span class="badge badge-pill badge-danger"><?php echo e(__('status_lost')); ?></span>
                                <?php endif; ?>
                                </p><hr/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><mark class="text-primary"><?php echo e(__('field_description')); ?>:</mark> <?php echo $row->description; ?></p><hr/>
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
    </div><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\book\show.blade.php ENDPATH**/ ?>