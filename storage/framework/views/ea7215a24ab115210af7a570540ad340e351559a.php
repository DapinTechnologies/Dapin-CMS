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
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="staff"><?php echo e(__('field_staff_id')); ?> <span>*</span></label>
                                    <select class="form-control select2" name="staff" id="staff" required>
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>" <?php if( $selected_staff == $user->id): ?> selected <?php endif; ?>>
                                        <?php echo e($user->staff_id); ?> - <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_staff_id')); ?>

                                    </div>
                                </div>
                                
                                <div class="form-group col-md-3">
                                    <label for="date"><?php echo e(__('field_date')); ?> <span>*</span></label>
                                    <input type="date" class="form-control date" name="date" id="date" value="<?php echo e($selected_date); ?>" required>

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
                    <?php if(isset($classes)): ?>
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
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(isset($classes)): ?>
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

                        <?php if(isset($classes)): ?>
                        <button type="button" class="btn btn-dark btn-print">
                            <i class="fas fa-print"></i> <?php echo e(__('btn_print')); ?>

                        </button>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>

                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-block">
                        <input type="hidden" name="attendances" class="attendances" value="">

                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover printable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_subject')); ?></th>
                                        <th><?php echo e(__('field_attendance')); ?></th>
                                        <th><?php echo e(__('field_note')); ?></th>
                                        <th><?php echo e(__('field_start_time')); ?></th>
                                        <th><?php echo e(__('field_end_time')); ?></th>
                                        <th><?php echo e(__('field_program')); ?></th>
                                        <th><?php echo e(__('field_semester')); ?></th>
                                        <th><?php echo e(__('field_section')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $unique_id = 0; ?>
                                  <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <input type="text" name="unique_ids[]" value="<?php echo e($unique_id); ?>" hidden>
                                    <?php $unique_id = $unique_id + 1 ?>

                                    <input type="text" name="users[]" value="<?php echo e($class->teacher->id); ?>" hidden>
                                    <input type="text" name="programs[]" value="<?php echo e($class->program_id); ?>" hidden>
                                    <input type="text" name="sessions[]" value="<?php echo e($class->session_id); ?>" hidden>
                                    <input type="text" name="semesters[]" value="<?php echo e($class->semester_id); ?>" hidden>
                                    <input type="text" name="sections[]" value="<?php echo e($class->section_id); ?>" hidden>
                                    <input type="text" name="subjects[]" value="<?php echo e($class->subject_id); ?>" hidden>

                                    <?php if(isset($attendances)): ?>
                                    <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($attendance->user_id == $class->teacher_id && $attendance->subject_id == $class->subject_id && $attendance->session_id == $class->session_id && $attendance->program_id == $class->program_id && $attendance->semester_id == $class->semester_id && $attendance->section_id == $class->section_id): ?>
                                        <?php
                                        $attend = $attendance;
                                        ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <tr>
                                        <td><?php echo e($class->subject->code ?? ''); ?></td>
                                        <td>
                                            <div class="form-group d-inline">
                                                <div class="radio radio-primary d-inline">
                                                    <input class="c-present" type="radio" data_id="<?php echo e($class->teacher->id); ?>"name="attendances-<?php echo e($key); ?>" id="attendance-p-<?php echo e($key); ?>" value="1" 

                                                    <?php if(isset($attend)): ?>
                                                    <?php if($attend->attendance == 1): ?>
                                                            checked 
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    required>
                                                    <label for="attendance-p-<?php echo e($key); ?>" class="cr"><?php echo e(__('attendance_present')); ?></label>
                                                </div>
                                            </div>
                                            <div class="form-group d-inline">
                                                <div class="radio radio-danger d-inline">
                                                    <input class="c-absent" type="radio" data_id="<?php echo e($class->teacher->id); ?>"name="attendances-<?php echo e($key); ?>" id="attendance-a-<?php echo e($key); ?>" value="2" 

                                                    <?php if(isset($attend)): ?>
                                                    <?php if($attend->attendance == 2): ?>
                                                            checked 
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    required>
                                                    <label for="attendance-a-<?php echo e($key); ?>" class="cr"><?php echo e(__('attendance_absent')); ?></label>
                                                </div>
                                            </div>
                                            <div class="form-group d-inline">
                                                <div class="radio radio-success d-inline">
                                                    <input class="c-leave" type="radio" data_id="<?php echo e($class->teacher->id); ?>"name="attendances-<?php echo e($key); ?>" id="attendance-l-<?php echo e($key); ?>" value="3" 

                                                    <?php if(isset($attend)): ?>
                                                    <?php if($attend->attendance == 3): ?>
                                                            checked 
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    required>
                                                    <label for="attendance-l-<?php echo e($key); ?>" class="cr"><?php echo e(__('attendance_leave')); ?></label>
                                                </div>
                                            </div>
                                            <div class="form-group d-inline">
                                                <div class="radio radio-warning d-inline">
                                                    <input class="c-holiday" type="radio" data_id="<?php echo e($class->teacher->id); ?>"name="attendances-<?php echo e($key); ?>" id="attendance-h-<?php echo e($key); ?>" value="4" 

                                                    <?php if(isset($attend)): ?>
                                                    <?php if($attend->attendance == 4): ?>
                                                            checked 
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    required>
                                                    <label for="attendance-h-<?php echo e($key); ?>" class="cr"><?php echo e(__('attendance_holiday')); ?></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="notes[]" id="note-<?php echo e($key); ?>" value="<?php echo e($attend->note ?? ''); ?>" placeholder="<?php echo e(__('field_note')); ?>" style="width: 100px;">
                                        </td>
                                        <td>
                                            <?php if(isset($setting->time_format)): ?>
                                            <?php echo e(date($setting->time_format, strtotime($class->start_time))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("h:i A", strtotime($class->start_time))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(isset($setting->time_format)): ?>
                                            <?php echo e(date($setting->time_format, strtotime($class->end_time))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("h:i A", strtotime($class->end_time))); ?>

                                            <?php endif; ?>
                                        </td>

                                        <input type="time" class="form-control" name="start_time[]" value="<?php echo e($attend->start_time ?? $class->start_time); ?>" hidden required>
                                        <input type="time" class="form-control" name="end_time[]" value="<?php echo e($attend->end_time ?? $class->end_time); ?>" hidden required>
                                        <input type="date" class="form-control" name="date[]" value="<?php echo e($attend->date ?? $selected_date); ?>" hidden required>
                                        
                                        <td><?php echo e($class->program->shortcode ?? ''); ?></td>
                                        <td><?php echo e($class->semester->title ?? ''); ?></td>
                                        <td><?php echo e($class->section->title ?? ''); ?></td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>

                                <caption><?php echo e(date("d F Y", strtotime($selected_date)) ?? ''); ?></caption>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                    <?php if(count($classes) > 0): ?>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success update"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                    </div>
                    <?php endif; ?>
                    </form>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\staff-hourly-attendance\index.blade.php ENDPATH**/ ?>