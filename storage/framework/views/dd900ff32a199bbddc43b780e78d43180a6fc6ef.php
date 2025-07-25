
<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('page_css'); ?>
    <!-- Wizard css -->
    <link rel="stylesheet" href="<?php echo e(asset('dashboard/css/pages/wizard.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
use App\Models\Session;
use App\Models\Semester;
use App\Models\Section;

// Get all sessions, semesters, and sections directly here
$sessions = Session::where('status', 1)->get();
$semesters = Semester::where('status', 1)->get();
$sections = Section::where('status', 1)->get();
?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(__('modal_edit')); ?> <?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>
                        <a href="<?php echo e(route($route.'.edit', $row->id)); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <div class="wizard-sec-bg">
                    <form id="wizard-advanced-form" class="needs-validation" novalidate action="<?php echo e(route($route.'.update', $row->id)); ?>" method="post" enctype="multipart/form-data" style="display: none;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                        <input type="hidden" name="registration_no" value="<?php echo e($row->registration_no); ?>">

                        <h3><?php echo e(__('tab_basic_info')); ?></h3>
                        <content class="form-step">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="row scheduler-border">
                                        <div class="form-group col-md-6">
                                            <label for="first_name"><?php echo e(__('field_first_name')); ?> <span>*</span></label>
                                            <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo e(old('first_name', $row->first_name)); ?>" required>
                                            <div class="invalid-feedback">
                                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_first_name')); ?>

                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="last_name"><?php echo e(__('field_last_name')); ?> <span>*</span></label>
                                            <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo e(old('last_name', $row->last_name)); ?>" required>
                                            <div class="invalid-feedback">
                                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_last_name')); ?>

                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="phone"><?php echo e(__('field_phone')); ?> <span>*</span></label>
                                            <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e(old('phone', $row->phone)); ?>" required>
                                            <div class="invalid-feedback">
                                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_phone')); ?>

                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="email"><?php echo e(__('field_email')); ?> <span>*</span></label>
                                            <input type="email" class="form-control" name="email" id="email" value="<?php echo e(old('email', $row->email)); ?>" required>
                                            <div class="invalid-feedback">
                                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_email')); ?>

                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="gender"><?php echo e(__('field_gender')); ?> <span>*</span></label>
                                            <select class="form-control" name="gender" id="gender" required>
                                                <option value=""><?php echo e(__('select')); ?></option>
                                                <option value="1" <?php if(old('gender', $row->gender) == 1): ?> selected <?php endif; ?>><?php echo e(__('gender_male')); ?></option>
                                                <option value="2" <?php if(old('gender', $row->gender) == 2): ?> selected <?php endif; ?>><?php echo e(__('gender_female')); ?></option>
                                                <option value="3" <?php if(old('gender', $row->gender) == 3): ?> selected <?php endif; ?>><?php echo e(__('gender_other')); ?></option>
                                            </select>
                                            <div class="invalid-feedback">
                                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_gender')); ?>

                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="dob"><?php echo e(__('field_dob')); ?> <span>*</span></label>
                                            <input type="date" class="form-control date" name="dob" id="dob" value="<?php echo e(old('dob', $row->dob)); ?>" required>
                                            <div class="invalid-feedback">
                                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_dob')); ?>

                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="admission_date"><?php echo e(__('field_admission_date')); ?> <span>*</span></label>
                                            <input type="date" class="form-control date" name="admission_date" id="admission_date" value="<?php echo e(old('admission_date', $row->admission_date ?? date('Y-m-d'))); ?>" required>
                                            <div class="invalid-feedback">
                                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_admission_date')); ?>

                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </content>

                        <h3><?php echo e(__('tab_educational_info')); ?></h3>
                        <content class="form-step">
                            <fieldset class="row scheduler-border">
                                <legend><?php echo e(__('field_academic_information')); ?></legend>
                                <div class="form-group col-md-6">
                                    <label for="student_id"><?php echo e(__('field_student_id')); ?> <span>*</span></label>
                                    <input type="text" class="form-control" name="student_id" id="student_id" value="<?php echo e(old('student_id', $row->student_id)); ?>" required>
                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_student_id')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="batch"><?php echo e(__('field_batch')); ?> <span>*</span></label>
                                    <select class="form-control" name="batch" id="batch" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($batch->id); ?>" <?php if(old('batch', $row->batch_id) == $batch->id): ?> selected <?php endif; ?>><?php echo e($batch->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_batch')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="program"><?php echo e(__('field_program')); ?> <span>*</span></label>
                                    <select class="form-control" name="program" id="program" required>
                                      <option value=""><?php echo e(__('select')); ?></option>
                                      <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($program->id); ?>" <?php if(old('program', $row->program_id) == $program->id): ?> selected <?php endif; ?>><?php echo e($program->title); ?></option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_program')); ?>

                                    </div>
                                </div>

                                <!-- Section Field -->
                                <div class="form-group col-md-6">
                                    <label for="section"><?php echo e(__('field_section')); ?> <span>*</span></label>
                                    <select class="form-control" name="section" id="section" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($section->id); ?>" <?php if(old('section', $row->section_id) == $section->id): ?> selected <?php endif; ?>><?php echo e($section->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_section')); ?>

                                    </div>
                                </div>

                                <!-- Semester Field -->
                                <div class="form-group col-md-6">
                                    <label for="semester"><?php echo e(__('field_semester')); ?> <span>*</span></label>
                                    <select class="form-control" name="semester" id="semester" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($semester->id); ?>" <?php if(old('semester', $row->semester_id) == $semester->id): ?> selected <?php endif; ?>><?php echo e($semester->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_semester')); ?>

                                    </div>
                                </div>

                                <!-- Session Field -->
                                <div class="form-group col-md-6">
                                    <label for="session"><?php echo e(__('field_session')); ?> <span>*</span></label>
                                    <select class="form-control" name="session" id="session" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($session->id); ?>" <?php if(old('session', $row->session_id) == $session->id): ?> selected <?php endif; ?>><?php echo e($session->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_session')); ?>

                                    </div>
                                </div>
                            </fieldset>
                        </content>

                        <h3><?php echo e(__('KCSE Results')); ?></h3>
                        <content class="form-step">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="kcse_index_no"><?php echo e(__('KCSE Index Number')); ?> <span>*</span></label>
                                    <input type="text" class="form-control" name="kcse_index_no" id="kcse_index_no" value="<?php echo e(old('kcse_index_no', $row->kcse_index_no)); ?>" required>
                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('KCSE Index Number')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="kcse_year"><?php echo e(__('KCSE Year')); ?> <span>*</span></label>
                                    <input type="text" class="form-control" name="kcse_year" id="kcse_year" value="<?php echo e(old('kcse_year', $row->kcse_year)); ?>" required>
                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('KCSE Year')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="kcse_grade"><?php echo e(__('KCSE Grade')); ?> <span>*</span></label>
                                    <input type="text" class="form-control" name="kcse_grade" id="kcse_grade" value="<?php echo e(old('kcse_grade', $row->kcse_grade)); ?>" required>
                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('KCSE Grade')); ?>

                                    </div>
                                </div>
<?php if($row->status == 1): ?> 
    <input type="hidden" name="is_approval" value="1">
<?php endif; ?>
                                <div class="form-group col-md-6">
                                    <label for="kcse_certificate"><?php echo e(__('KCSE Certificate')); ?></label>
                                    <input type="file" class="form-control" name="kcse_certificate" id="kcse_certificate">
                                    <?php if($row->kcse_certificate): ?>
                                        <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->kcse_certificate)); ?>" target="_blank"><?php echo e(__('View Current Certificate')); ?></a>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="kcse_result_slip"><?php echo e(__('KCSE Result Slip')); ?></label>
                                    <input type="file" class="form-control" name="kcse_result_slip" id="kcse_result_slip">
                                    <?php if($row->kcse_result_slip): ?>
                                        <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->kcse_result_slip)); ?>" target="_blank"><?php echo e(__('View Current Result Slip')); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </content>

                        <h3><?php echo e(__('Location')); ?></h3>
                        <content class="form-step">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="county"><?php echo e(__('County')); ?> <span>*</span></label>
                                    <select class="form-control" name="county" id="county" required>
                                        <option value=""><?php echo e(__('Select County')); ?></option>
                                        <?php $__currentLoopData = $counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $county): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($county->CountyID); ?>" <?php if(old('county', $row->county_id) == $county->CountyID): ?> selected <?php endif; ?>><?php echo e($county->CountyName); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('County')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="sub_county"><?php echo e(__('Sub-County')); ?> <span>*</span></label>
                                    <select class="form-control" name="sub_county" id="sub_county" required>
                                        <option value=""><?php echo e(__('Select Sub-County')); ?></option>
                                        <?php $__currentLoopData = $sub_counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCounty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($subCounty->SubCountyID); ?>" <?php if(old('sub_county', $row->sub_county_id) == $subCounty->SubCountyID): ?> selected <?php endif; ?>><?php echo e($subCounty->SubCountyName); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('Sub-County')); ?>

                                    </div>
                                </div>

<?php
    // Initialize selected statuses safely
    $selectedStatuses = [];
    
    // Check if student exists and has statusTypes relationship
    if (isset($student) && $student) {
        // Load statusTypes if not already loaded
        if (!$student->relationLoaded('statusTypes')) {
            $student->load('statusTypes');
        }
        $selectedStatuses = $student->statusTypes->pluck('id')->toArray();
    }
?>

<div class="form-group col-md-6">
    <label for="status_types"><?php echo e(__('field_status')); ?></label>
    <select class="form-control select2" name="status_types[]" id="status_types" multiple>
        <?php $__currentLoopData = $statusTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($status->id); ?>" 
                <?php if(in_array($status->id, $selectedStatuses)): ?> selected <?php endif; ?>>
                <?php echo e($status->title); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    
    <?php if($statusTypes->isEmpty()): ?>
        <small class="text-danger">No status types available. Please add status types first.</small>
    <?php endif; ?>
</div>
                                <div class="form-group col-md-6">
                                    <label for="mode_of_education"><?php echo e(__('Mode of Study')); ?> <span>*</span></label>
                                    <select class="form-control" name="mode_of_education" id="mode_of_education" required>
                                        <option value=""><?php echo e(__('Select Mode of Study')); ?></option>
                                        <option value="Physical" <?php if(old('mode_of_education', $row->mode_of_education) == 'Physical'): ?> selected <?php endif; ?>>Physical</option>
                                        <option value="Online" <?php if(old('mode_of_education', $row->mode_of_education) == 'Online'): ?> selected <?php endif; ?>>Online</option>
                                        <option value="Hybrid" <?php if(old('mode_of_education', $row->mode_of_education) == 'Hybrid'): ?> selected <?php endif; ?>>Hybrid</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('Mode of Study')); ?>

                                    </div>
                                </div>
                            </div>
                        </content>
                    </form>
                    </div>
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
    <!-- validate Js -->
    <script src="<?php echo e(asset('dashboard/plugins/jquery-validation/js/jquery.validate.min.js')); ?>"></script>

    <!-- Wizard Js -->
    <script src="<?php echo e(asset('dashboard/js/pages/jquery.steps.js')); ?>"></script>

    <script type="text/javascript">
        "use strict";
        var form = $("#wizard-advanced-form").show();

        form.steps({
            headerTag: "h3",
            bodyTag: "content",
            transitionEffect: "slideLeft",
            labels: 
            {
                finish: "<?php echo e(__('btn_finish')); ?>",
                next: "<?php echo e(__('btn_next')); ?>",
                previous: "<?php echo e(__('btn_previous')); ?>",
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                if (currentIndex > newIndex)
                {
                    return true;
                }
                if (currentIndex < newIndex)
                {
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                
            },
            onFinishing: function (event, currentIndex)
            {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                $("#wizard-advanced-form").submit();
            }
        }).validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {

            }
        });

        // County and Sub-county dynamic filtering
        $(document).ready(function() {
            $('#county').on('change', function() {
                var countyId = $(this).val();
                if (countyId) {
                    $.ajax({
                        type: "GET",
                        url: "<?php echo e(url('admin/filter/sub-counties')); ?>/" + countyId,
                        success: function (response) {
                            $('#sub_county').empty();
                            $('#sub_county').append('<option value=""><?php echo e(__("select")); ?></option>');
                            $.each(response, function(key, value) {
                                $('#sub_county').append('<option value="'+ value.SubCountyID +'">'+ value.SubCountyName +'</option>');
                            });
                        }
                    });
                } else {
                    $('#sub_county').empty();
                    $('#sub_county').append('<option value=""><?php echo e(__("select")); ?></option>');
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/application/edit.blade.php ENDPATH**/ ?>