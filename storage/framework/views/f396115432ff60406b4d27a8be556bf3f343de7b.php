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
                                <p><mark class="text-primary"><?php echo e(__('field_fees_type')); ?>:</mark> <?php echo e($row->category->title ?? ''); ?></p><hr/>
                                
                                <p><mark class="text-primary"><?php echo e(__('field_amount')); ?>:</mark> 
                                    <?php if(isset($setting->decimal_place)): ?>
                                    <?php echo e(number_format((float)$row->amount, $setting->decimal_place, '.', '')); ?> 
                                    <?php else: ?>
                                    <?php echo e(number_format((float)$row->amount, 2, '.', '')); ?> 
                                    <?php endif; ?> 
                                    <?php echo $setting->currency_symbol; ?>


                                    <?php if($row->type == 1): ?>
                                    <span class="badge badge-pill badge-primary"><?php echo e(__('amount_type_fixed')); ?></span>
                                    <?php elseif($row->type == 2): ?>
                                    <span class="badge badge-pill badge-dark"><?php echo e(__('amount_type_per_credit')); ?></span>
                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_assign')); ?> <?php echo e(__('field_date')); ?>:</mark> 
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->assign_date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->assign_date))); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_due_date')); ?>:</mark> 
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->due_date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->due_date))); ?>

                                    <?php endif; ?>
                                </p><hr/>
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_faculty')); ?>:</mark> 
                                    <?php if($row->faculty_id == 0): ?>
                                    <?php echo e(__('all')); ?>

                                    <?php endif; ?>
                                    <?php if(isset($row->faculty->title)): ?>
                                    <?php echo e($row->faculty->title); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_program')); ?>:</mark> 
                                    <?php if($row->program_id == 0): ?>
                                    <?php echo e(__('all')); ?>

                                    <?php endif; ?>
                                    <?php if(isset($row->program->title)): ?>
                                    <?php echo e($row->program->title); ?>

                                    <?php endif; ?>
                                </p><hr/>
                                
                                <p><mark class="text-primary"><?php echo e(__('field_session')); ?>:</mark> 
                                    <?php if($row->session_id == 0): ?>
                                    <?php echo e(__('all')); ?>

                                    <?php endif; ?>
                                    <?php if(isset($row->session->title)): ?>
                                    <?php echo e($row->session->title); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_semester')); ?>:</mark> 
                                    <?php if($row->semester_id == 0): ?>
                                    <?php echo e(__('all')); ?>

                                    <?php endif; ?>
                                    <?php if(isset($row->semester->title)): ?>
                                    <?php echo e($row->semester->title); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_section')); ?>:</mark> 
                                    <?php if($row->section_id == 0): ?>
                                    <?php echo e(__('all')); ?>

                                    <?php endif; ?>
                                    <?php if(isset($row->section->title)): ?>
                                    <?php echo e($row->section->title); ?>

                                    <?php endif; ?>
                                </p><hr/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><mark class="text-primary"><?php echo e(__('field_student')); ?> <?php echo e(__('list')); ?>:</mark> 
                                    <?php $__currentLoopData = $row->studentEnrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('admin.student.show', $student->student->id)); ?>" target="_blank">
                                      <span class="badge badge-pill badge-primary">#<?php echo e($student->student->student_id); ?></span>
                                    </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p><hr/>
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
    </div><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\fees-master\show.blade.php ENDPATH**/ ?>