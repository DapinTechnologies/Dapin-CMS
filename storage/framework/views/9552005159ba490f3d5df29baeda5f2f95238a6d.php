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
                                <fieldset class="row gx-2 scheduler-border">
                                <p><mark class="text-primary"><?php echo e(__('field_library_id')); ?>:</mark> #<?php echo e($row->member->library_id ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_name')); ?>:</mark> <?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_occupation')); ?>:</mark> <?php echo e($row->occupation); ?></p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_father_name')); ?>:</mark> <?php echo e($row->father_name); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_father_occupation')); ?>:</mark> <?php echo e($row->father_occupation); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_mother_name')); ?>:</mark> <?php echo e($row->mother_name); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_mother_occupation')); ?>:</mark> <?php echo e($row->mother_occupation); ?></p><hr/>
                                
                                <p><mark class="text-primary"><?php echo e(__('field_gender')); ?>:</mark> 
                                    <?php if( $row->gender == 1 ): ?>
                                    <?php echo e(__('gender_male')); ?>

                                    <?php elseif( $row->gender == 2 ): ?>
                                    <?php echo e(__('gender_female')); ?>

                                    <?php elseif( $row->gender == 3 ): ?>
                                    <?php echo e(__('gender_other')); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_dob')); ?>:</mark> 
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->dob))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->dob))); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_marital_status')); ?>:</mark> 
                                    <?php if( $row->marital_status == 1 ): ?>
                                    <?php echo e(__('marital_status_single')); ?>

                                    <?php elseif( $row->marital_status == 2 ): ?>
                                    <?php echo e(__('marital_status_married')); ?>

                                    <?php elseif( $row->marital_status == 3 ): ?>
                                    <?php echo e(__('marital_status_widowed')); ?>

                                    <?php elseif( $row->marital_status == 4 ): ?>
                                    <?php echo e(__('marital_status_divorced')); ?>

                                    <?php elseif( $row->marital_status == 5 ): ?>
                                    <?php echo e(__('marital_status_other')); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_blood_group')); ?>:</mark> 
                                    <?php if( $row->blood_group == 1 ): ?>
                                    <?php echo e(__('A+')); ?>

                                    <?php elseif( $row->blood_group == 2 ): ?>
                                    <?php echo e(__('A-')); ?>

                                    <?php elseif( $row->blood_group == 3 ): ?>
                                    <?php echo e(__('B+')); ?>

                                    <?php elseif( $row->blood_group == 4 ): ?>
                                    <?php echo e(__('B-')); ?>

                                    <?php elseif( $row->blood_group == 5 ): ?>
                                    <?php echo e(__('AB+')); ?>

                                    <?php elseif( $row->blood_group == 6 ): ?>
                                    <?php echo e(__('AB-')); ?>

                                    <?php elseif( $row->blood_group == 7 ): ?>
                                    <?php echo e(__('O+')); ?>

                                    <?php elseif( $row->blood_group == 8 ): ?>
                                    <?php echo e(__('O-')); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_religion')); ?>:</mark> <?php echo e($row->religion); ?></p><hr/>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="row gx-2 scheduler-border">
                                <p><mark class="text-primary"><?php echo e(__('field_phone')); ?>:</mark> <?php echo e($row->phone); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_email')); ?>:</mark> <?php echo e($row->email); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_national_id')); ?>:</mark> <?php echo e($row->national_id); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_passport_no')); ?>:</mark> <?php echo e($row->passport_no); ?></p>
                                </fieldset>

                                <fieldset class="row gx-2 scheduler-border">
                                <legend><?php echo e(__('field_present')); ?> <?php echo e(__('field_address')); ?></legend>
                                <p><mark class="text-primary"><?php echo e(__('field_province')); ?>:</mark> <?php echo e($row->presentProvince->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_district')); ?>:</mark> <?php echo e($row->presentDistrict->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_address')); ?>:</mark> <?php echo e($row->present_address); ?></p>
                                </fieldset>

                                <fieldset class="row gx-2 scheduler-border">
                                <legend><?php echo e(__('field_permanent')); ?> <?php echo e(__('field_address')); ?></legend>
                                <p><mark class="text-primary"><?php echo e(__('field_province')); ?>:</mark> <?php echo e($row->permanentProvince->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_district')); ?>:</mark> <?php echo e($row->permanentDistrict->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_address')); ?>:</mark> <?php echo e($row->permanent_address); ?></p>
                                </fieldset>
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
    </div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\library-outsider\show.blade.php ENDPATH**/ ?>