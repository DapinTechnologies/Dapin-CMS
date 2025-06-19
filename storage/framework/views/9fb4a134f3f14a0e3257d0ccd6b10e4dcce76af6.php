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
                        <a href="<?php echo e(route('admin.exam-attendance.import')); ?>" class="btn btn-dark btn-sm float-right"><i class="fas fa-upload"></i> <?php echo e(__('btn_import')); ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">
                                <?php echo $__env->make('common.inc.subject_search_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-3">
                                    <label for="type"><?php echo e(__('field_type')); ?> <span>*</span></label>
                                    <select class="form-control" name="type" id="type" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->id); ?>" <?php if( $selected_type == $type->id): ?> selected <?php endif; ?>><?php echo e($type->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_type')); ?>

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
                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

<?php if(isset($rows)): ?>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover printable">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_student_id')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <?php if(isset($rows)): ?>
                                        <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($loop->first): ?>
                                        <?php
                                            $max_marks = $row->type->marks;
                                            $type_title = $row->type->title ?? '';
                                            // Set max marks based on specific types
                                            if (in_array($type_title, ['CAT 1', 'CAT 2'])) {
                                                $max_allowed = 30;
                                            } elseif ($type_title == 'Mock Exam') {
                                                $max_allowed = 40;
                                            } else {
                                                $max_allowed = $max_marks; // fallback to whatever is in database
                                            }
                                        ?>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <th>
                                            <?php echo e(__('field_max_marks')); ?>

                                            <?php if(isset($max_marks)): ?>
                                             (<?php echo e(round($max_allowed, 2)); ?>)
                                            <?php endif; ?>
                                        </th>
                                        <th><?php echo e(__('field_note')); ?></th>
                                        <th><?php echo e(__('field_semester')); ?></th>
                                        <th><?php echo e(__('field_section')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <input type="hidden" name="exams[<?php echo e($key); ?>]" value="<?php echo e($row->id); ?>">
                                    <tr>
                                        <td>
                                            <?php if(isset($row->studentEnroll->student->student_id)): ?>
                                            <a href="<?php echo e(route('admin.student.show', $row->studentEnroll->student->id)); ?>">
                                            #<?php echo e($row->studentEnroll->student->student_id ?? ''); ?>

                                            </a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->studentEnroll->student->first_name ?? ''); ?> <?php echo e($row->studentEnroll->student->last_name ?? ''); ?></td>
                                        <td>
                                            <input type="number" class="form-control marks-input" 
                                                   name="marks[<?php echo e($key); ?>]" 
                                                   id="marks_<?php echo e($key); ?>" 
                                                   value="<?php echo e($row->achieve_marks ? round($row->achieve_marks, 2) : ''); ?>" 
                                                   style="width: 100px;" 
                                                   min="0" 
                                                   <?php if(isset($type_title)): ?>
                                                       <?php if(in_array($type_title, ['CAT 1', 'CAT 2'])): ?>
                                                           max="30" 
                                                           data-max-message="CAT exams cannot exceed 30 marks"
                                                       <?php elseif($type_title == 'Mock Exam'): ?>
                                                           max="40"
                                                           data-max-message="Mock Exam cannot exceed 40 marks"
                                                       <?php else: ?>
                                                           max="<?php echo e($max_marks); ?>"
                                                           data-max-message="Marks cannot exceed <?php echo e($max_marks); ?>"
                                                       <?php endif; ?>
                                                   <?php endif; ?>
                                                   step="0.01" required>
                                            <div class="invalid-feedback">
                                                Please enter valid marks (0 - <?php if(isset($type_title)): ?><?php echo e(in_array($type_title, ['CAT 1', 'CAT 2']) ? 30 : ($type_title == 'Mock Exam' ? 40 : $max_marks)); ?><?php endif; ?>)
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="notes[<?php echo e($key); ?>]" id="notes" value="<?php echo e($row->note); ?>" style="width: 100px;">
                                        </td>
                                        <td><?php echo e($row->studentEnroll->semester->title ?? ''); ?></td>
                                        <td><?php echo e($row->studentEnroll->section->title ?? ''); ?></td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <caption><?php echo e($row->subject->code ?? ''); ?> - <?php echo e($row->type->title ?? ''); ?> - <?php echo e($row->studentEnroll->session->title ?? ''); ?></caption>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>

                    <?php if(count($rows) > 0): ?>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success update"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                    </div>
                    <?php endif; ?>

                    <?php if(count($rows) < 1): ?>
                    <div class="card-block">
                        <h5><?php echo e(__('no_result_found')); ?></h5>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->startSection('page_js'); ?>
<script type="text/javascript">
$(document).ready(function() {
    // Style for the error popup
    const popupStyle = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        background-color: #ff4444;
        color: white;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        z-index: 9999;
        display: none;
        font-weight: bold;
        animation: fadeIn 0.3s;
    `;
    
    // Add the popup to the body
    $('body').append(`<div id="marksErrorPopup" style="${popupStyle}"></div>`);
    
    // Client-side validation for marks input
    $('.marks-input').on('input', function() {
        var max = parseFloat($(this).attr('max'));
        var value = parseFloat($(this).val()) || 0;
        
        if (value > max) {
            $(this).val(max);
            showErrorPopup(`Maximum allowed marks for this type is ${max}`);
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Form validation
    $('form').on('submit', function(e) {
        var valid = true;
        var firstInvalidField = null;
        
        $('.marks-input').each(function() {
            var max = parseFloat($(this).attr('max'));
            var value = parseFloat($(this).val()) || 0;
            
            if (value > max) {
                valid = false;
                $(this).addClass('is-invalid');
                if (!firstInvalidField) {
                    firstInvalidField = this;
                }
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!valid) {
            e.preventDefault();
            showErrorPopup('One or more marks exceed the maximum allowed value');
            
            // Scroll to the first invalid field
            if (firstInvalidField) {
                $('html, body').animate({
                    scrollTop: $(firstInvalidField).offset().top - 100
                }, 500);
            }
            
            return false;
        }
    });
    
    function showErrorPopup(message) {
        const popup = $('#marksErrorPopup');
        popup.text(message).fadeIn();
        
        // Hide after 3 seconds
        setTimeout(() => {
            popup.fadeOut();
        }, 3000);
    }
});

// CSS animation for the popup
document.head.insertAdjacentHTML('beforeend', `
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .is-invalid {
        border-color: #ff4444 !important;
        background-color: #fff6f6 !important;
    }
    
    .is-invalid + .invalid-feedback {
        display: block;
        color: #ff4444;
        font-size: 0.85em;
    }
</style>
`);
</script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/exam/marking.blade.php ENDPATH**/ ?>