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
                                <p><mark class="text-primary"><?php echo e(__('field_type')); ?>:</mark> <?php echo e($row->type->title ?? ''); ?></p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_date')); ?>:</mark> 
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_status')); ?>:</mark> 
                                <?php if( $row->status == 1 ): ?>
                                <span class="badge badge-pill badge-success"><?php echo e(__('status_active')); ?></span>
                                <?php else: ?>
                                <span class="badge badge-pill badge-danger"><?php echo e(__('status_inactive')); ?></span>
                                <?php endif; ?>
                                <hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_recorded_by')); ?>:</mark> #<?php echo e($row->recordedBy->staff_id ?? ''); ?></p><hr/>
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_faculty')); ?>:</mark> 
                                    <?php if($row->faculty_id == 0): ?>
                                    <?php echo e(__('all')); ?>

                                    <?php endif; ?>
                                    <?php if(isset($row->faculty->title)): ?>
                                    <?php echo e($row->faculty->title ?? ''); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_program')); ?>:</mark> 
                                    <?php if($row->program_id == 0): ?>
                                    <?php echo e(__('all')); ?>

                                    <?php endif; ?>
                                    <?php if(isset($row->program->title)): ?>
                                    <?php echo e($row->program->title ?? ''); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_session')); ?>:</mark> 
                                    <?php if($row->session_id == 0): ?>
                                    <?php echo e(__('all')); ?>

                                    <?php endif; ?>
                                    <?php if(isset($row->session->title)): ?>
                                    <?php echo e($row->session->title ?? ''); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_semester')); ?>:</mark> 
                                    <?php if($row->semester_id == 0): ?>
                                    <?php echo e(__('all')); ?>

                                    <?php endif; ?>
                                    <?php if(isset($row->semester->title)): ?>
                                    <?php echo e($row->semester->title ?? ''); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_section')); ?>:</mark> 
                                    <?php if($row->section_id == 0): ?>
                                    <?php echo e(__('all')); ?>

                                    <?php endif; ?>
                                    <?php if(isset($row->section->title)): ?>
                                    <?php echo e($row->section->title ?? ''); ?>

                                    <?php endif; ?>
                                </p><hr/>
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
    </div><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\content\show.blade.php ENDPATH**/ ?>