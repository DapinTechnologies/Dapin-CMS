
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
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.create')); ?>">
                            <div class="row gx-2">
                                <?php echo $__env->make('common.inc.fees_search_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_filter')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php if(isset($rows)): ?>
            <div class="col-sm-12">
                <form action="<?php echo e(route($route.'.store')); ?>" class="needs-validation" novalidate method="post">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-block">
                        <input type="hidden" name="faculty" value="<?php echo e($selected_faculty); ?>">
                        <input type="hidden" name="program" value="<?php echo e($selected_program); ?>">
                        <input type="hidden" name="session" value="<?php echo e($selected_session); ?>">
                        <input type="hidden" name="semester" value="<?php echo e($selected_semester); ?>">
                        <input type="hidden" name="section" value="<?php echo e($selected_section); ?>">

                        <!-- Fee Structure Information -->
                        <?php if(isset($feeStructure) && $feeStructure): ?>
                        <div class="alert alert-info" id="fee-structure-info">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5>Fee Structure: <?php echo e($feeStructure->program->title ?? ''); ?> - Semester <?php echo e($feeStructure->semester); ?></h5>
                                    <ul class="mb-0">
                                        <?php $__currentLoopData = $feeStructure->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <?php echo e($item->category->title); ?>: 
                                            <?php echo $setting->currency_symbol; ?><?php echo e(number_format($item->amount, 2)); ?>

                                            <?php if($item->is_one_time): ?>
                                            <span class="badge bg-primary">One-Time</span>
                                            <?php endif; ?>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <li class="font-weight-bold mt-2">
                                            Total Amount: 
                                            <?php echo $setting->currency_symbol; ?><?php echo e(number_format($feeStructure->total_amount, 2)); ?>

                                        </li>
                                    </ul>
                                </div>
                                <div class="text-end">
                                    <div class="mb-2">
                                        <span class="fw-bold">Selected Students:</span> 
                                        <span id="selected-count"><?php echo e(count($rows)); ?></span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Estimated Total:</span> 
                                        <?php echo $setting->currency_symbol; ?><span id="estimated-total"><?php echo e(number_format($feeStructure->total_amount * count($rows), 2)); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php elseif($selected_program && $selected_semester): ?>
                        <div class="alert alert-warning">
                            No fee structure found for the selected program and semester.
                        </div>
                        <?php endif; ?>

                        <?php if(count($rows) > 0): ?>
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="checkbox checkbox-success d-inline">
                                                <input type="checkbox" id="checkbox" class="all_select" checked>
                                                <label for="checkbox" class="cr" style="margin-bottom: 0px;"></label>
                                            </div>
                                        </th>
                                        <th><?php echo e(__('field_student_id')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <th><?php echo e(__('field_amount')); ?></th>
                                        <th><?php echo e(__('field_program')); ?></th>
                                        <th><?php echo e(__('field_session')); ?></th>
                                        <th><?php echo e(__('field_semester')); ?></th>
                                        <th><?php echo e(__('field_section')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="checkbox checkbox-primary d-inline">
                                                <input type="checkbox" name="students[]" id="checkbox-<?php echo e($row->id); ?>" value="<?php echo e($row->id); ?>" checked class="student-checkbox">
                                                <label for="checkbox-<?php echo e($row->id); ?>" class="cr"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.student.show', $row->student->id)); ?>">
                                            #<?php echo e($row->student->student_id ?? ''); ?>

                                            </a>
                                        </td>
                                        <td>
                                            <?php echo e($row->student->first_name ?? ''); ?> <?php echo e($row->student->last_name ?? ''); ?>

                                        </td>
                                        <td class="amount-cell">
                                            <?php echo $setting->currency_symbol; ?> 
                                            <span class="amount-display">
                                                <?php if(isset($feeStructure) && $feeStructure): ?>
                                                <?php echo e(number_format($feeStructure->total_amount, 2)); ?>

                                                <?php else: ?>
                                                0.00
                                                <?php endif; ?>
                                            </span>
                                        </td>
                                        <td><?php echo e($row->program->shortcode ?? ''); ?></td>
                                        <td><?php echo e($row->session->title ?? ''); ?></td>
                                        <td><?php echo e($row->semester->title ?? ''); ?></td>
                                        <td><?php echo e($row->section->title ?? ''); ?></td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                        <?php else: ?>
                        <div class="alert alert-danger">
                            No students found matching the selected criteria.
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if(count($rows) > 0): ?>
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                          <!-- Hidden field for fee structure ID -->
                          <?php if(isset($feeStructure) && $feeStructure): ?>
                          <input type="hidden" name="fee_structure_id" value="<?php echo e($feeStructure->id); ?>">
                          <?php endif; ?>

                          <div class="form-group col-md-3">
                            <label for="assign_date" class="form-label"><?php echo e(__('field_assign')); ?> <?php echo e(__('field_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control" name="assign_date" id="assign_date" value="<?php echo e(date('Y-m-d')); ?>" required>

                            <div class="invalid-feedback">
                                <?php echo e(__('required_field')); ?> <?php echo e(__('field_assign')); ?> <?php echo e(__('field_date')); ?>

                            </div>
                          </div>

                          <div class="form-group col-md-3">
                            <label for="due_date" class="form-label"><?php echo e(__('field_due_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="due_date" id="due_date" value="<?php echo e(date('Y-m-d', strtotime('+1 month'))); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_due_date')); ?>

                            </div>
                          </div>

                          <div class="form-group col-md-3">
                            <label for="total_amount" class="form-label"><?php echo e(__('Total Amount')); ?> (<?php echo $setting->currency_symbol; ?>)</label>
                            <input type="text" class="form-control" name="total_amount" id="total_amount" 
                                value="<?php if(isset($feeStructure) && $feeStructure): ?><?php echo e(number_format($feeStructure->total_amount, 2)); ?><?php else: ?><?php echo e('0.00'); ?><?php endif; ?>" readonly>
                          </div>

                          <div class="form-group col-md-3">
                            <label class="form-label"><?php echo e(__('Notification')); ?></label>
                            <div class="checkbox checkbox-primary d-inline">
                                <input type="checkbox" name="send_notification" id="send_notification" value="1" checked>
                                <label for="send_notification" class="cr"><?php echo e(__('Send SMS Notification')); ?></label>
                            </div>
                          </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success" <?php if(!isset($feeStructure) || !$feeStructure): ?> disabled <?php endif; ?>>
                            <i class="fas fa-check"></i> <?php echo e(__('btn_assign')); ?>

                        </button>
                    </div>
                </div>
                <?php endif; ?>
                </form>
            </div>
            <?php endif; ?>
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
    // checkbox all-check-button selector
    $(".all_select").on('click',function(e){
        if($(this).is(":checked")){
            // check all checkbox
            $(".student-checkbox").prop('checked', true);
        }
        else if($(this).is(":not(:checked)")){
            // uncheck all checkbox
            $(".student-checkbox").prop('checked', false);
        }
        updateSelectionCount();
    });

    // Update count when individual checkboxes change
    $(".student-checkbox").change(function() {
        updateSelectionCount();
    });

    function updateSelectionCount() {
        const selectedCount = $(".student-checkbox:checked").length;
        const unitAmount = parseFloat($("#total_amount").val().replace(/,/g, '')) || 0;
        const estimatedTotal = (selectedCount * unitAmount).toFixed(2);
        
        $("#selected-count").text(selectedCount);
        $("#estimated-total").text(estimatedTotal.toLocaleString());
        
        // Enable/disable submit button based on selection
        if(selectedCount > 0 && unitAmount > 0) {
            $('button[type="submit"]').prop('disabled', false);
        } else {
            $('button[type="submit"]').prop('disabled', true);
        }
    }

    // Initialize select2
    $('.select2').select2();

    // AJAX to load fee structure when program/semester changes
    $('#program, #semester').on('change', function() {
    const programId = $('#program').val();
    const semesterId = $('#semester').val();
    const facultyId = $('#faculty').val();
    const sessionId = $('#session').val();
    const sectionId = $('#section').val();
    
    if(programId && semesterId) {
        $.ajax({
            url: "<?php echo e(route($route.'.getFeeStructure')); ?>",
            type: "GET",
            dataType: 'json',
            data: {
                program_id: programId,
                semester_id: semesterId,
                // These are only used for student count, not fee structure
                faculty_id: facultyId,
                session_id: sessionId,
                section_id: sectionId
            },
            beforeSend: function() {
                $('#fee-structure-info').html(`
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `);
            },
            success: function(response) {
                if(response.success) {
                    updateFeeStructureUI(response.fee_structure, response.categories, 
                                      response.total_amount, response.student_count, 
                                      response.estimated_total);
                } else {
                    showAlert('warning', response.message || 'No fee structure found for selected program and semester');
                    resetFeeStructureUI();
                }
            },
            error: function(xhr) {
                showAlert('danger', 'Failed to load fee structure. Please try again.');
                resetFeeStructureUI();
            }
        });
    } else {
        resetFeeStructureUI();
    }
});

function updateFeeStructureUI(feeStructure, categories, totalAmount, studentCount, estimatedTotal) {
    const currencySymbol = "<?php echo $setting->currency_symbol; ?>";
    
    // Update the total amount display
    $('#total_amount').val(parseFloat(totalAmount).toFixed(2));
    $('.amount-display').text(parseFloat(totalAmount).toFixed(2));
    
    // Build fee items HTML
    let feeItemsHtml = '';
    categories.forEach(function(item) {
        feeItemsHtml += `<li>${item.title}: ${currencySymbol}${item.amount.toFixed(2)}`;
        if(item.is_one_time) {
            feeItemsHtml += ` <span class="badge bg-primary">One-Time</span>`;
        }
        feeItemsHtml += `</li>`;
    });
    
    // Update the fee structure info box
    $('#fee-structure-info').html(`
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5>Fee Structure: ${feeStructure.program.title} - Semester ${feeStructure.semester}</h5>
                <ul class="mb-0">
                    ${feeItemsHtml}
                    <li class="font-weight-bold mt-2">
                        Total Amount: ${currencySymbol}${parseFloat(totalAmount).toFixed(2)}
                    </li>
                </ul>
            </div>
            <div class="text-end">
                <div class="mb-2">
                    <span class="fw-bold">Selected Students:</span> 
                    <span id="selected-count">${studentCount}</span>
                </div>
                <div>
                    <span class="fw-bold">Estimated Total:</span> 
                    ${currencySymbol}${parseFloat(estimatedTotal).toFixed(2)}
                </div>
            </div>
        </div>
    `);
    
    // Enable the submit button if we have students
    if(studentCount > 0) {
        $('button[type="submit"]').prop('disabled', false);
    }
}

    function updateFeeStructureUI(feeStructure, categories, totalAmount, studentCount, estimatedTotal) {
        // Format currency
        const currencySymbol = "<?php echo $setting->currency_symbol; ?>";
        
        // Update the total amount display
        $('#total_amount').val(parseFloat(totalAmount).toFixed(2));
        $('.amount-display').text(parseFloat(totalAmount).toFixed(2));
        
        // Build fee items HTML
        let feeItemsHtml = '';
        categories.forEach(function(item) {
            feeItemsHtml += `<li>${item.title}: ${currencySymbol}${item.amount.toFixed(2)}`;
            if(item.is_one_time) {
                feeItemsHtml += ` <span class="badge bg-primary">One-Time</span>`;
            }
            feeItemsHtml += `</li>`;
        });
        
        // Update the fee structure info box
        $('#fee-structure-info').html(`
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Fee Structure: ${feeStructure.program.title} - Semester ${feeStructure.semester}</h5>
                    <ul class="mb-0">
                        ${feeItemsHtml}
                        <li class="font-weight-bold mt-2">
                            Total Amount: ${currencySymbol}${parseFloat(totalAmount).toFixed(2)}
                        </li>
                    </ul>
                </div>
                <div class="text-end">
                    <div class="mb-2">
                        <span class="fw-bold">Selected Students:</span> 
                        <span id="selected-count">${studentCount}</span>
                    </div>
                    <div>
                        <span class="fw-bold">Estimated Total:</span> 
                        ${currencySymbol}${parseFloat(estimatedTotal).toFixed(2)}
                    </div>
                </div>
            </div>
        `);
        
        // Enable the submit button if we have students
        if(studentCount > 0) {
            $('button[type="submit"]').prop('disabled', false);
        }
    }

    function resetFeeStructureUI() {
        // Reset the total amount display
        $('#total_amount').val('0.00');
        $('.amount-display').text('0.00');
        
        // Reset counters
        $('#selected-count').text('0');
        $('#estimated-total').text('0.00');
        
        // Disable the submit button
        $('button[type="submit"]').prop('disabled', true);
    }

    function showAlert(type, message) {
        // Remove any existing alerts first
        $('.alert-dismissible').alert('close');
        
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Prepend alert to the card block
        $('.card-block').prepend(alertHtml);
        
        // Auto-remove alert after 5 seconds
        setTimeout(() => {
            $('.alert-dismissible').alert('close');
        }, 5000);
    }

    // Validate date inputs
    $('#assign_date, #due_date').on('change', function() {
        const assignDate = new Date($('#assign_date').val());
        const dueDate = new Date($('#due_date').val());
        
        if(assignDate && dueDate && assignDate > dueDate) {
            showAlert('warning', 'Due date must be after or equal to assign date');
            $('#due_date').val('');
        }
    });

    // Initial count update
    updateSelectionCount();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/fees-master/create.blade.php ENDPATH**/ ?>