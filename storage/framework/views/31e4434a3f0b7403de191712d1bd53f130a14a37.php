    <!-- Edit modal content -->
    <div id="editModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <form class="needs-validation" novalidate action="<?php echo e(route($route.'.update', $certificate->id)); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><?php echo e(__('modal_edit')); ?> <?php echo e($title); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- View Start -->
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_student_id')); ?>:</mark> #<?php echo e($row->student_id); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_name')); ?>:</mark> <?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></p><hr/>
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_program')); ?>:</mark> <?php echo e($row->program->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_batch')); ?>:</mark> <?php echo e($row->batch->title ?? ''); ?></p><hr/>
                            </div>
                        </div>
                    </div>
                    <!-- View End -->

                    <br/>
                    
                    <input type="hidden" name="student_id" value="<?php echo e($row->id); ?>">

                    <!-- Form Start -->
                    <?php
                        $total_credits = 0;
                        $total_cgpa = 0;
                        $starting_year = '0000';
                        $ending_year = '0000';
                    ?>

                    
                    <?php $__currentLoopData = $row->studentEnrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        
                        <?php if($loop->first): ?>
                        <?php
                            $starting_year = $item->session->start_date;
                        ?>
                        <?php endif; ?>

                        <?php if($loop->last): ?>
                        <?php
                            $ending_year = $item->session->end_date;
                        ?>
                        <?php endif; ?>

                        <?php if(isset($item->subjectMarks)): ?>
                        <?php $__currentLoopData = $item->subjectMarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php
                            $marks_per = round($mark->total_marks);
                            ?>

                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($marks_per >= $grade->min_mark && $marks_per <= $grade->max_mark): ?>
                            <?php
                            if($grade->point > 0){
                            $total_cgpa = $total_cgpa + ($grade->point * $mark->subject->credit_hour);
                            $total_credits = $total_credits + $mark->subject->credit_hour;
                            }
                            ?>
                            <?php break; ?>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <div class="">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="date"><?php echo e(__('field_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="date" id="date" value="<?php echo e($certificate->date); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="starting_year"><?php echo e(__('field_starting_year')); ?> <span>*</span></label>
                            <input type="number" class="form-control" name="starting_year" id="starting_year" value="<?php echo e(date('Y',strtotime($starting_year))); ?>" required readonly>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_starting_year')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="ending_year"><?php echo e(__('field_ending_year')); ?> <span>*</span></label>
                            <input type="number" class="form-control" name="ending_year" id="ending_year" value="<?php echo e(date('Y',strtotime($ending_year))); ?>" required readonly>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_ending_year')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="credits"><?php echo e(__('field_total_credit_hour')); ?> <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="credits" id="credits" value="<?php echo e(round($total_credits, 2)); ?>" required readonly>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_total_credit_hour')); ?>

                            </div>
                        </div>

                        <?php
                            if($total_credits <= 0){
                                $total_credits = 1;
                            }
                            $com_gpa = $total_cgpa / $total_credits;
                        ?>
                        <div class="form-group col-md-4">
                            <label for="point"><?php echo e(__('field_cumulative_gpa')); ?> <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="point" id="point" value="<?php echo e(number_format((float)$com_gpa, 2, '.', '')); ?>" required readonly>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_cumulative_gpa')); ?>

                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Form End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                </div>
              </form>
            </div>
        </div>
    </div><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\certificate\edit.blade.php ENDPATH**/ ?>