<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(__('modal_add')); ?> / <?php echo e(__('modal_edit')); ?> <?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.create')); ?>">
                            <div class="row gx-2">
                                <?php echo $__env->make('common.inc.common_search_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_filter')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <?php if(isset($rows)): ?>
                    <?php
                    $weekdays = array('1', '2', '3', '4', '5', '6', '7');
                    ?>
                    <ul class="nav nav-pills mb-3 card-block" id="myTab" role="tablist">

                        <?php $__currentLoopData = $weekdays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $weekday): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if($weekday == 1): ?> active <?php endif; ?> text-uppercase" id="day<?php echo e($weekday); ?>-tab" data-bs-toggle="tab" href="#day<?php echo e($weekday); ?>" role="tab" aria-controls="day<?php echo e($weekday); ?>" aria-selected="true">
                                <?php if( $weekday == 1 ): ?>
                                <?php echo e(__('day_saturday')); ?>

                                <?php elseif( $weekday == 2 ): ?>
                                    <?php echo e(__('day_sunday')); ?>

                                <?php elseif( $weekday == 3 ): ?>
                                    <?php echo e(__('day_monday')); ?>

                                <?php elseif( $weekday == 4 ): ?>
                                    <?php echo e(__('day_tuesday')); ?>

                                <?php elseif( $weekday == 5 ): ?>
                                    <?php echo e(__('day_wednesday')); ?>

                                <?php elseif( $weekday == 6 ): ?>
                                    <?php echo e(__('day_thursday')); ?>

                                <?php elseif( $weekday == 7 ): ?>
                                    <?php echo e(__('day_friday')); ?>

                                <?php endif; ?>
                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>
                    <div class="tab-content" id="myTabContent">

                        <?php $__currentLoopData = $weekdays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $weekday): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="tab-pane fade <?php if($weekday == 1): ?> show active <?php endif; ?>" id="day<?php echo e($weekday); ?>" role="tabpanel" aria-labelledby="day<?php echo e($weekday); ?>-tab">
                            <div class="">
                                <div class="row">
                                    <div class="col-md-12">
                                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" id="fields" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <input type="text" name="program" value="<?php echo e($selected_program); ?>" hidden>
                                    <input type="text" name="session" value="<?php echo e($selected_session); ?>" hidden>
                                    <input type="text" name="semester" value="<?php echo e($selected_semester); ?>" hidden>
                                    <input type="text" name="section" value="<?php echo e($selected_section); ?>" hidden>
                                    <input type="text" name="day" value="<?php echo e($weekday); ?>" hidden>
                                    <?php $__empty_1 = true; $__currentLoopData = $rows->where('day', $weekday); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php echo $__env->make('admin.class-routine.form_edit_field', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php echo $__env->make('admin.class-routine.form_field', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endif; ?>
                                    <div id="newField-tab-<?php echo e($weekday); ?>" class="clearfix"></div>
                                    <div class="card-block">
                                        <button id="addField" type="button" class="btn btn-info" data-bs-tab="tab-<?php echo e($weekday); ?>"><i class="fas fa-plus"></i> <?php echo e(__('btn_add_new')); ?></button>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_save')); ?></button>
                                    </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- [ Card ] end -->
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
            var tab = $(this).attr('data-bs-tab');
            var html = '';
            html += '<hr/>';
            html += '<div id="inputFormField" class="card-block">';
            html += '<div class="row">';
            html += '<div class="form-group col-md-2"><label for="subject"><?php echo e(__('field_subject')); ?> <span>*</span></label><select class="form-control select2" name="subject[]" id="subject" required><option value=""><?php echo e(__('select')); ?></option> <?php if(isset($subjects)): ?> <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->code); ?> - <?php echo e($subject->title); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?> </select> <div class="invalid-feedback"> <?php echo e(__('required_field')); ?> <?php echo e(__('field_subject')); ?></div></div>';
            html += '<div class="form-group col-md-2"><label for="teacher"><?php echo e(__('field_teacher')); ?> <span>*</span></label> <select class="form-control select2" name="teacher[]" id="teacher"><option value=""><?php echo e(__('select')); ?></option> <?php if(isset($teachers)): ?> <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->staff_id); ?> - <?php echo e($teacher->first_name); ?> <?php echo e($teacher->last_name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?> </select> <div class="invalid-feedback"> <?php echo e(__('required_field')); ?> <?php echo e(__('field_teacher')); ?> </div> </div>';
            html += '<div class="form-group col-md-2"> <label for="room"><?php echo e(__('field_room')); ?> <?php echo e(__('field_no')); ?> <span>*</span></label> <select class="form-control select2" name="room[]" id="room" required> <option value=""><?php echo e(__('select')); ?></option> <?php if(isset($rooms)): ?> <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($room->id); ?>"><?php echo e($room->title); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?> </select> <div class="invalid-feedback"> <?php echo e(__('required_field')); ?> <?php echo e(__('field_room')); ?> <?php echo e(__('field_no')); ?> </div> </div>';
            html += '<div class="form-group col-md-2"> <label for="start_time"><?php echo e(__('field_time')); ?> <?php echo e(__('field_from')); ?> <span>*</span></label><input type="time" class="form-control time" name="start_time[]" id="start_time" required><div class="invalid-feedback"> </div></div>';
            html += '<div class="form-group col-md-2"> <label for="end_time"><?php echo e(__('field_time')); ?> <?php echo e(__('field_to')); ?> <span>*</span></label> <input type="time" class="form-control time" name="end_time[]" id="end_time" required> <div class="invalid-feedback"> <?php echo e(__('required_field')); ?> <?php echo e(__('field_time')); ?> <?php echo e(__('field_to')); ?> </div> </div>';
            html += '<div class="form-group col-md-2"><button id="removeField" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> <?php echo e(__('btn_remove')); ?></button></div>';
            html += '</div>';

            $('#newField-'+tab).append(html);

            // Time Picker
            $('.time').bootstrapMaterialDatePicker({
                date: false,
                shortTime: true,
                format: 'HH:mm'
            });
        });

        // remove Field
        $(document).on('click', '#removeField', function () {
            $(this).closest('#inputFormField').remove();

            // Time Picker
            $('.time').bootstrapMaterialDatePicker({
                date: false,
                shortTime: true,
                format: 'HH:mm'
            });
        });
    }(jQuery));


    // Delete Routine
    function deleteRoutine(id) {
        $("#deleteRoutine-"+id).hide();
        $("#delete_routine-"+id).attr("checked", "checked");
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/class-routine/create.blade.php ENDPATH**/ ?>