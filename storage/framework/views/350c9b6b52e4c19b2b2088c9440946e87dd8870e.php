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
                        <h5><?php echo e(__('modal_edit')); ?> <?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                        <a href="<?php echo e(route($route.'.edit', $row->id)); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.update', $row->id)); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="card-block">
                    <fieldset class="row scheduler-border">
                    <div class="row">
                        <input type="text" name="student_id" value="<?php echo e($row->student->id); ?>" hidden>

                        <div class="form-group col-md-6">
                            <label for="student"><?php echo e(__('field_student_id')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="student" id="student" value="<?php echo e($row->student->student_id); ?>" readonly>

                            <div class="invalid-feedback">
                            <?php echo e(__('required_field')); ?> <?php echo e(__('field_student_id')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="transfer_id"><?php echo e(__('field_transfer_id')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="transfer_id" id="transfer_id" value="<?php echo e($row->transfer_id); ?>" required>

                            <div class="invalid-feedback">
                            <?php echo e(__('required_field')); ?> <?php echo e(__('field_transfer_id')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="university_name"><?php echo e(__('field_university_name')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="university_name" id="university_name" value="<?php echo e($row->university_name); ?>" required>

                            <div class="invalid-feedback">
                            <?php echo e(__('required_field')); ?> <?php echo e(__('field_university_name')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="date"><?php echo e(__('field_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="date" id="date" value="<?php echo e($row->date); ?>" required>

                            <div class="invalid-feedback">
                            <?php echo e(__('required_field')); ?> <?php echo e(__('field_date')); ?>

                            </div>
                        </div>
  
                        <div class="form-group col-md-12">
                            <label for="note"><?php echo e(__('field_note')); ?></label>
                            <textarea class="form-control" name="note" id="note"><?php echo e($row->note); ?></textarea>

                            <div class="invalid-feedback">
                            <?php echo e(__('required_field')); ?> <?php echo e(__('field_note')); ?>

                            </div>
                        </div>
                    </div>
                    </fieldset>

                    <fieldset class="row scheduler-border">
                    <legend><?php echo e(__('field_transfer_credits')); ?></legend>
                    <div class="container-fluid">

                    <?php $__currentLoopData = $row->student->transferCreadits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $creadit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="text" name="t_creadit_id[]" value="<?php echo e($creadit->id); ?>" hidden>
                    <input type="text" name="t_programs[]" value="<?php echo e($row->student->program_id); ?>" hidden>
                    <div class="row">
                        <!-- Form End -->
                        <div class="form-group col-md-4">
                            <label for="t_sessions" class="form-label"><?php echo e(__('field_session')); ?> <span>*</span></label>
                            <select class="form-control select2" name="t_sessions[]" id="t_sessions" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($session->id); ?>" <?php echo e($creadit->session_id == $session->id ? 'selected' : ''); ?>><?php echo e($session->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                            <?php echo e(__('required_field')); ?> <?php echo e(__('field_session')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="t_semesters" class="form-label"><?php echo e(__('field_semester')); ?> <span>*</span></label>
                            <select class="form-control select2" name="t_semesters[]" id="t_semesters" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($semester->id); ?>" <?php echo e($creadit->semester_id == $semester->id ? 'selected' : ''); ?>><?php echo e($semester->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                            <?php echo e(__('required_field')); ?> <?php echo e(__('field_semester')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                          <label for="t_subjects" class="form-label"><?php echo e(__('field_subject')); ?> <span>*</span></label>
                            <select class="form-control select2" name="t_subjects[]" id="t_subjects" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($subject->id); ?>" <?php echo e($creadit->subject_id == $subject->id ? 'selected' : ''); ?>><?php echo e($subject->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_subject')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="marks" class="form-label"><?php echo e(__('field_mark')); ?> <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="marks[]" id="marks" value="<?php echo e(round($creadit->marks, 2)); ?>" data-v-max="999" data-v-min="0" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_mark')); ?>

                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div id="newTField" class="clearfix"></div>
                    <div class="form-group">
                        <button id="addField" type="button" class="btn btn-info"><i class="fas fa-plus"></i> <?php echo e(__('btn_add_new')); ?></button>
                    </div>

                    </div>
                    </fieldset>
                    <!-- Form End -->
                    </div>
                    <div class="card-footer float-right">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
<script type="text/javascript">
    (function ($) {
        "use strict";
        // add Field
        $(document).on('click', '#addField', function () {
            var html = '';
            html += '<hr/>';
            html += '<div id="inputTFormField" class="row">';
            html += '<input type="text" name="t_programs[]" value="<?php echo e($row->student->program_id); ?>" hidden>';
            html += '<div class="form-group col-md-4"><label for="t_sessions" class="form-label"><?php echo e(__('field_session')); ?> <span>*</span></label><select class="form-control select2" name="t_sessions[]" id="t_sessions" required><option value=""><?php echo e(__('select')); ?></option> <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($session->id); ?>"><?php echo e($session->title); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select> <div class="invalid-feedback"> <?php echo e(__('required_field')); ?> <?php echo e(__('field_session')); ?> </div> </div>';
            html += '<div class="form-group col-md-4"> <label for="t_semesters" class="form-label"><?php echo e(__('field_semester')); ?> <span>*</span></label> <select class="form-control select2" name="t_semesters[]" id="t_semesters" required> <option value=""><?php echo e(__('select')); ?></option> <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($semester->id); ?>"><?php echo e($semester->title); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select> <div class="invalid-feedback"> <?php echo e(__('required_field')); ?> <?php echo e(__('field_semester')); ?> </div> </div>';
            html += '<div class="form-group col-md-4"> <label for="t_subjects" class="form-label"><?php echo e(__('field_subject')); ?> <span>*</span></label> <select class="form-control select2" name="t_subjects[]" id="t_subjects" required> <option value=""><?php echo e(__('select')); ?></option> <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->title); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select> <div class="invalid-feedback"> <?php echo e(__('required_field')); ?> <?php echo e(__('field_subject')); ?></div></div>';
            html += '<div class="form-group col-md-4"> <label for="marks" class="form-label"><?php echo e(__('field_mark')); ?> <span>*</span></label><input type="text" class="form-control autonumber" name="marks[]" id="marks" value="<?php echo e(old('marks')); ?>" data-v-max="999" data-v-min="0" required> <div class="invalid-feedback"> <?php echo e(__('required_field')); ?> <?php echo e(__('field_mark')); ?> </div> </div>';
            html += '<div class="form-group col-md-4"><button id="removeTField" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> <?php echo e(__('btn_remove')); ?></button></div>';
            html += '</div>';

            $('#newTField').append(html);

            // [ Single Select ] start
            $(".select2").select2();
        });

        // remove Field
        $(document).on('click', '#removeTField', function () {
            $(this).closest('#inputTFormField').remove();

            // [ Single Select ] start
            $(".select2").select2();
        });
    }(jQuery));
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\student-transfer-in\edit.blade.php ENDPATH**/ ?>