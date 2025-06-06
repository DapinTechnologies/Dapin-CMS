<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(__('modal_add')); ?> <?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                        <a href="<?php echo e(route($route.'.create')); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.create')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="student"><?php echo e(__('field_student_id')); ?> <span>*</span></label>
                                    <select class="form-control select2" name="student" id="student" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($student->student_id); ?>" <?php if($selected_student == $student->student_id): ?> selected <?php endif; ?>><?php echo e($student->student_id); ?> - <?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_student_id')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-block">
                        <?php if(isset($row)): ?>
                        <?php
                            $enroll = \App\Models\Student::enroll($row->id);
                        ?>

                        <?php
                            $total_credits = 0;
                            $total_cgpa = 0;
                        ?>
                        <?php $__currentLoopData = $row->studentEnrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

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

                        <!-- Transfer Form -->
                        <?php if($row->status == '3'): ?>
                        <div class="text-center text-danger mb-5"><?php echo e(__('msg_the_student_already_transfered')); ?>!</div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="row gx-2 scheduler-border">
                                    <legend><?php echo e(__('field_personal_info')); ?></legend>
                                    <p><mark class="text-primary"><?php echo e(__('field_student_id')); ?>:</mark> #<?php echo e($row->student_id); ?></p>
                                    <hr/>

                                    <p><mark class="text-primary"><?php echo e(__('field_name')); ?>:</mark> <?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></p>
                                    <hr/>

                                    <p><mark class="text-primary"><?php echo e(__('field_gender')); ?>:</mark> 
                                        <?php if( $row->gender == 1 ): ?>
                                        <?php echo e(__('gender_male')); ?>

                                        <?php elseif( $row->gender == 2 ): ?>
                                        <?php echo e(__('gender_female')); ?>

                                        <?php elseif( $row->gender == 3 ): ?>
                                        <?php echo e(__('gender_other')); ?>

                                        <?php endif; ?>
                                    </p><hr/>

                                    <p><mark class="text-primary"><?php echo e(__('field_total_credit_hour')); ?>:</mark> <?php echo e(round($total_credits, 2)); ?></p>
                                    <hr/>

                                    <p><mark class="text-primary"><?php echo e(__('field_cumulative_gpa')); ?>:</mark> 
                                        <?php
                                        if($total_credits <= 0){
                                            $total_credits = 1;
                                        }
                                        $com_gpa = $total_cgpa / $total_credits;
                                        echo number_format((float)$com_gpa, 2, '.', '');
                                        ?>
                                    </p>
                                    <hr/>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="row gx-2 scheduler-border">
                                    <legend><?php echo e(__('field_academic_information')); ?></legend>
                                    <p><mark class="text-primary"><?php echo e(__('field_batch')); ?>:</mark> <?php echo e($row->batch->title ?? ''); ?></p><hr/>

                                    <p><mark class="text-primary"><?php echo e(__('field_program')); ?>:</mark> <?php echo e($row->program->title ?? ''); ?></p><hr/>

                                    <p><mark class="text-primary"><?php echo e(__('field_session')); ?>:</mark> <?php echo e($enroll->session->title ?? ''); ?></p><hr/>

                                    <p><mark class="text-primary"><?php echo e(__('field_semester')); ?>:</mark> <?php echo e($enroll->semester->title ?? ''); ?></p><hr/>

                                    <p><mark class="text-primary"><?php echo e(__('field_section')); ?>:</mark> <?php echo e($enroll->section->title ?? ''); ?></p><hr/>
                                </fieldset>
                            </div>
                        </div>

                        <?php if($row->status != 3): ?>
                        <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="student"><?php echo e(__('field_student_id')); ?> <span>*</span></label>
                                    <input type="text" class="form-control" name="student" id="student" value="<?php echo e($row->student_id); ?>" readonly required>

                                    <div class="invalid-feedback">
                                    <?php echo e(__('required_field')); ?> <?php echo e(__('field_student_id')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="transfer_id"><?php echo e(__('field_transfer_id')); ?> <span>*</span></label>
                                    <input type="text" class="form-control autonumber" name="transfer_id" id="transfer_id" value="<?php echo e(old('transfer_id')); ?>" required>

                                    <div class="invalid-feedback">
                                    <?php echo e(__('required_field')); ?> <?php echo e(__('field_transfer_id')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="university_name"><?php echo e(__('field_university_name')); ?> <span>*</span></label>
                                    <input type="text" class="form-control" name="university_name" id="university_name" value="<?php echo e(old('university_name')); ?>" required>

                                    <div class="invalid-feedback">
                                    <?php echo e(__('required_field')); ?> <?php echo e(__('field_university_name')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="date"><?php echo e(__('field_date')); ?> <span>*</span></label>
                                    <input type="date" class="form-control date" name="date" id="date" value="<?php echo e(date('Y-m-d')); ?>" required>

                                    <div class="invalid-feedback">
                                    <?php echo e(__('required_field')); ?> <?php echo e(__('field_date')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="status"><?php echo e(__('field_status')); ?></label>
                                    <select class="form-control select2" name="statuses[]" id="status" multiple required>
                                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status->id); ?>" <?php $__currentLoopData = $row->statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($stat->id == $status->id ? 'selected' : ''); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>><?php echo e($status->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                    <?php echo e(__('required_field')); ?> <?php echo e(__('field_status')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="note"><?php echo e(__('field_note')); ?></label>
                                    <textarea class="form-control" name="note" id="note" value="<?php echo e(__('note')); ?>"></textarea>

                                    <div class="invalid-feedback">
                                    <?php echo e(__('required_field')); ?> <?php echo e(__('field_note')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                        <i class="fas fa-check"></i> <?php echo e(__('btn_save')); ?>

                                    </button>
                                    <!-- Include Confirm modal -->
                                    <?php echo $__env->make($view.'.confirm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        </form>
                        <?php endif; ?>

                        <?php else: ?>
                        <?php if(isset($selected_student)): ?>
                        <div class="text-center text-danger mb-5"><?php echo e(__('msg_student_id_does_not_match')); ?></div>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\student-transfer-out\create.blade.php ENDPATH**/ ?>