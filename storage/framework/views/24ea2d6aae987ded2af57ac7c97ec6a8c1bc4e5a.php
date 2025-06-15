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
                        <h5><?php echo e($title); ?></h5>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-import')): ?>
                        <a href="<?php echo e(route($route.'.import')); ?>" class="btn btn-dark btn-sm float-right"><i class="fas fa-upload"></i> <?php echo e(__('btn_import')); ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">
                                <?php echo $__env->make('common.inc.subject_search_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-3">
                                    <label for="date"><?php echo e(__('field_date')); ?> <span>*</span></label>
                                    <input type="date" class="form-control date" name="date" value="<?php echo e($selected_date); ?>" required>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_date')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <?php if(isset($rows)): ?>
                    <?php if(count($rows) > 0): ?>
                    <div class="card-block">
                        <?php if(isset($attendances)): ?>
                            <?php if(count($attendances) > 0): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo e(__('attendance_taken')); ?>

                            </div>
                            <?php else: ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo e(__('attendance_not_taken')); ?>

                            </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo e(__('attendance_not_taken')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($rows)): ?>
                    <?php if(count($rows) > 0): ?>
                    <div class="card-header">
                        <div class="form-group d-inline">
                            <div class="radio radio-primary d-inline">
                                <input type="radio" name="all_check" id="attendance-p" class="all_present">
                                <label for="attendance-p" class="cr"><?php echo e(__('all')); ?> <?php echo e(__('attendance_present')); ?></label>
                            </div>
                        </div>
                        <div class="form-group d-inline">
                            <div class="radio radio-danger d-inline">
                                <input type="radio" name="all_check" id="attendance-a" class="all_absent">
                                <label for="attendance-a" class="cr"><?php echo e(__('all')); ?> <?php echo e(__('attendance_absent')); ?></label>
                            </div>
                        </div>
                        <div class="form-group d-inline">
                            <div class="radio radio-success d-inline">
                                <input type="radio" name="all_check" id="attendance-l" class="all_leave">
                                <label for="attendance-l" class="cr"><?php echo e(__('all')); ?> <?php echo e(__('attendance_leave')); ?></label>
                            </div>
                        </div>
                        <div class="form-group d-inline">
                            <div class="radio radio-warning d-inline">
                                <input type="radio" name="all_check" id="attendance-h" class="all_holiday">
                                <label for="attendance-h" class="cr"><?php echo e(__('all')); ?> <?php echo e(__('attendance_holiday')); ?></label>
                            </div>
                        </div>

                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>

                        <?php if(isset($rows)): ?>
                        <button type="button" class="btn btn-dark btn-print">
                            <i class="fas fa-print"></i> <?php echo e(__('btn_print')); ?>

                        </button>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>

                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-block">
                        <input type="hidden" name="subject" value="<?php echo e($selected_subject); ?>">
                        <input type="hidden" name="date" value="<?php echo e($selected_date); ?>">
                        <input type="hidden" name="attendances" class="attendances" value="">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover printable">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_student_id')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <th><?php echo e(__('field_attendance')); ?></th>
                                        <th><?php echo e(__('field_note')); ?></th>
                                        <th><?php echo e(__('field_semester')); ?></th>
                                        <th><?php echo e(__('field_section')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <input type="hidden" name="students[]" value="<?php echo e($row->id); ?>">
                                    <tr>
                                        <td>
                                            <?php if(isset($row->student->student_id)): ?>
                                            <a href="<?php echo e(route('admin.student.show', $row->student->id)); ?>">
                                            #<?php echo e($row->student->student_id ?? ''); ?>

                                            </a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->student->first_name ?? ''); ?> <?php echo e($row->student->last_name ?? ''); ?></td>
                                        <td>
                                            <div class="form-group d-inline">
                                                <div class="radio radio-primary d-inline">
                                                    <input class="c-present" type="radio" data_id="<?php echo e($row->id); ?>"name="attendances-<?php echo e($key); ?>" id="attendance-p-<?php echo e($key); ?>" value="1"

                                                    <?php if(isset($attendances)): ?>
                                                    <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($attendance->student_enroll_id == $row->id && $attendance->attendance == 1): ?>
                                                            checked
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                     required>
                                                    <label for="attendance-p-<?php echo e($key); ?>" class="cr"><?php echo e(__('attendance_present')); ?></label>
                                                </div>
                                            </div>
                                            <div class="form-group d-inline">
                                                <div class="radio radio-danger d-inline">
                                                    <input class="c-absent" type="radio" data_id="<?php echo e($row->id); ?>"name="attendances-<?php echo e($key); ?>" id="attendance-a-<?php echo e($key); ?>" value="2" 

                                                    <?php if(isset($attendances)): ?>
                                                    <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($attendance->student_enroll_id == $row->id && $attendance->attendance == 2): ?>
                                                            checked
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                     required>
                                                    <label for="attendance-a-<?php echo e($key); ?>" class="cr"><?php echo e(__('attendance_absent')); ?></label>
                                                </div>
                                            </div>
                                            <div class="form-group d-inline">
                                                <div class="radio radio-success d-inline">
                                                    <input class="c-leave" type="radio" data_id="<?php echo e($row->id); ?>"name="attendances-<?php echo e($key); ?>" id="attendance-l-<?php echo e($key); ?>" value="3"

                                                    <?php if(isset($attendances)): ?>
                                                    <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($attendance->student_enroll_id == $row->id && $attendance->attendance == 3): ?>
                                                            checked
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                     required>
                                                    <label for="attendance-l-<?php echo e($key); ?>" class="cr"><?php echo e(__('attendance_leave')); ?></label>
                                                </div>
                                            </div>
                                            <div class="form-group d-inline">
                                                <div class="radio radio-warning d-inline">
                                                    <input class="c-holiday" type="radio" data_id="<?php echo e($row->id); ?>"name="attendances-<?php echo e($key); ?>" id="attendance-h-<?php echo e($key); ?>" value="4"

                                                    <?php if(isset($attendances)): ?>
                                                    <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($attendance->student_enroll_id == $row->id && $attendance->attendance == 4): ?>
                                                            checked
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                     required>
                                                    <label for="attendance-h-<?php echo e($key); ?>" class="cr"><?php echo e(__('attendance_holiday')); ?></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100px;" class="form-control" name="notes[]" id="note-<?php echo e($key); ?>" 
                                            <?php if(isset($attendances)): ?>
                                            <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($attendance->student_enroll_id == $row->id): ?>
                                                    value="<?php echo e($attendance->note); ?>"
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>>
                                        </td>
                                        <td><?php echo e($row->semester->title ?? ''); ?></td>
                                        <td><?php echo e($row->section->title ?? ''); ?></td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>

                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($subject_code->id == $selected_subject): ?>
                                <?php
                                    $cur_subject = $subject_code->code;
                                ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <caption><?php echo e($cur_subject ?? ''); ?> - <?php echo e(date("d F Y", strtotime($selected_date)) ?? ''); ?></caption>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success update"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                    </div>
                    </form>
                    <?php endif; ?>

                    <?php if(count($rows) < 1): ?>
                    <div class="card-block">
                        <h5><?php echo e(__('no_result_found')); ?></h5>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
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
    "use strict";
    $(document).ready(function() {
        $(".update").on('click',function(e){
            var attendances = [];
            $.each($("input[data_id]:checked"), function(){
                attendances.push($(this).val());
            });

            $(".attendances").val( attendances.join(',') );
        });
    });


    // checkbox all-check-button selector
    $(".all_present").on('click',function(e){
        if($(this).is(":checked")){
            // check all checkbox
            $(".c-present").prop('checked', true);
        }
        else if($(this).is(":not(:checked)")){
            // uncheck all checkbox
            $(".c-present").prop('checked', false);
        }
    });
    $(".all_absent").on('click',function(e){
        if($(this).is(":checked")){
            // check all checkbox
            $(".c-absent").prop('checked', true);
        }
        else if($(this).is(":not(:checked)")){
            // uncheck all checkbox
            $(".c-absent").prop('checked', false);
        }
    });
    $(".all_leave").on('click',function(e){
        if($(this).is(":checked")){
            // check all checkbox
            $(".c-leave").prop('checked', true);
        }
        else if($(this).is(":not(:checked)")){
            // uncheck all checkbox
            $(".c-leave").prop('checked', false);
        }
    });
    $(".all_holiday").on('click',function(e){
        if($(this).is(":checked")){
            // check all checkbox
            $(".c-holiday").prop('checked', true);
        }
        else if($(this).is(":not(:checked)")){
            // uncheck all checkbox
            $(".c-holiday").prop('checked', false);
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/student-attendance/index.blade.php ENDPATH**/ ?>