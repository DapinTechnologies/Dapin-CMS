<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('page_css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('dashboard/plugins/lightbox2-master/css/lightbox.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-4">
                <div class="card user-card user-card-1">
                    <div class="card-body pb-0">
                        <?php $student = $row; ?>
                        <?php
                            $curr_enroll = \App\Models\Student::enroll($row->id);
                        ?>

                        <div class="media user-about-block align-items-center mt-0 mb-3">
                            <div class="position-relative d-inline-block">
                                <?php if(is_file('uploads/'.$path.'/'.$row->photo)): ?>
                                <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->photo)); ?>" class="img-radius img-fluid wid-80" alt="<?php echo e(__('field_photo')); ?>" onerror="this.src='<?php echo e(asset('dashboard/images/user/avatar-2.jpg')); ?>';">
                                <?php else: ?>
                                <img src="<?php echo e(asset('dashboard/images/user/avatar-2.jpg')); ?>" class="img-radius img-fluid wid-80" alt="<?php echo e(__('field_photo')); ?>">
                                <?php endif; ?>
                                <div class="certificated-badge">
                                    <i class="fas fa-certificate text-primary bg-icon"></i>
                                    <i class="fas fa-check front-icon text-white"></i>
                                </div>
                            </div>
                            <div class="media-body ms-3">
                                <h6 class="mb-1"><?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></h6>
                                <?php if(isset($row->student_id)): ?>
                                <p class="mb-0 text-muted">#<?php echo e($row->student_id); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="far fa-envelope m-r-10"></i><?php echo e(__('field_email')); ?> : </span>
                            <span class="float-end"><?php echo e($row->email); ?></span>
                        </li>
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="fas fa-phone-alt m-r-10"></i><?php echo e(__('field_phone')); ?> : </span>
                            <span class="float-end"><?php echo e($row->phone); ?></span>
                        </li>
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="fas fa-users m-r-10"></i><?php echo e(__('field_batch')); ?> : </span>
                            <span class="float-end"><?php echo e($row->batch->title ?? ''); ?></span>
                        </li>
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="fas fa-graduation-cap m-r-10"></i><?php echo e(__('field_program')); ?> : </span>
                            <span class="float-end"><?php echo e($row->program->title ?? ''); ?></span>
                        </li>
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="far fa-calendar-alt m-r-10"></i><?php echo e(__('field_admission_date')); ?> : </span>
                            <span class="float-end">
                                <?php if(isset($setting->date_format)): ?>
                                <?php echo e(date($setting->date_format, strtotime($row->admission_date))); ?>

                                <?php else: ?>
                                <?php echo e(date("Y-m-d", strtotime($row->admission_date))); ?>

                                <?php endif; ?>
                            </span>
                        </li>
                        <?php if(isset($row->registration_no)): ?>
                        <li class="list-group-item border-bottom-0">
                            <span class="f-w-500"><i class="far fa-question-circle m-r-10"></i><?php echo e(__('field_registration_no')); ?> : </span>
                            <span class="float-end">#<?php echo e($row->registration_no); ?></span>
                        </li>
                        <?php endif; ?>
                    </ul>

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
                    <div class="card-body">
                        <div class="row text-center">
                            
                            
                        </div>
                    </div>
                </div>
            </div>

            <?php
                function field($slug){
                    return \App\Models\Field::field($slug);
                }
            ?>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-block">
                        <div class="">
                            <div class="row">
                                <div class="col-md-6">
                                    <fieldset class="row gx-2 scheduler-border">
                                    <?php if(field('student_father_name')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_father_name')); ?>:</mark> <?php echo e($row->father_name); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('student_father_occupation')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_father_occupation')); ?>:</mark> <?php echo e($row->father_occupation); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('student_mother_name')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_mother_name')); ?>:</mark> <?php echo e($row->mother_name); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('student_mother_occupation')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_mother_occupation')); ?>:</mark> <?php echo e($row->mother_occupation); ?></p><hr/>
                                    <?php endif; ?>

                                    <p><mark class="text-primary"><?php echo e(__('field_gender')); ?>:</mark> 
                                        <?php if( $row->gender == 1 ): ?>
                                        <?php echo e(__('gender_male')); ?>

                                        <?php elseif( $row->gender == 2 ): ?>
                                        <?php echo e(__('gender_female')); ?>

                                        <?php elseif( $row->gender == 3 ): ?>
                                        <?php echo e(__('gender_other')); ?>

                                        <?php endif; ?>
                                    </p><hr/>

                                    <p><mark class="text-primary"><?php echo e(__('field_dob')); ?>:</mark> 
                                        <?php if(isset($setting->date_format)): ?>
                                        <?php echo e(date($setting->date_format, strtotime($row->dob))); ?>

                                        <?php else: ?>
                                        <?php echo e(date("Y-m-d", strtotime($row->dob))); ?>

                                        <?php endif; ?>
                                    </p><hr/>

                                    <?php if(field('student_emergency_phone')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_emergency_phone')); ?>:</mark> <?php echo e($row->emergency_phone); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('student_religion')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_religion')); ?>:</mark> <?php echo e($row->religion); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('student_caste')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_caste')); ?>:</mark> <?php echo e($row->caste); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('student_mother_tongue')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_mother_tongue')); ?>:</mark> <?php echo e($row->mother_tongue); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('student_nationality')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_nationality')); ?>:</mark> <?php echo e($row->nationality); ?></p><hr/>
                                    <?php endif; ?>

                                    <?php if(field('student_marital_status')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_marital_status')); ?>:</mark> 
                                        <?php if( $row->marital_status == 1 ): ?>
                                        <?php echo e(__('marital_status_single')); ?>

                                        <?php elseif( $row->marital_status == 2 ): ?>
                                        <?php echo e(__('marital_status_married')); ?>

                                        <?php elseif( $row->marital_status == 3 ): ?>
                                        <?php echo e(__('marital_status_widowed')); ?>

                                        <?php elseif( $row->marital_status == 4 ): ?>
                                        <?php echo e(__('marital_status_divorced')); ?>

                                        <?php elseif( $row->marital_status == 5 ): ?>
                                        <?php echo e(__('marital_status_other')); ?>

                                        <?php endif; ?>
                                    </p><hr/>
                                    <?php endif; ?>

                                    <?php if(field('student_blood_group')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_blood_group')); ?>:</mark> 
                                        <?php if( $row->blood_group == 1 ): ?>
                                        <?php echo e(__('A+')); ?>

                                        <?php elseif( $row->blood_group == 2 ): ?>
                                        <?php echo e(__('A-')); ?>

                                        <?php elseif( $row->blood_group == 3 ): ?>
                                        <?php echo e(__('B+')); ?>

                                        <?php elseif( $row->blood_group == 4 ): ?>
                                        <?php echo e(__('B-')); ?>

                                        <?php elseif( $row->blood_group == 5 ): ?>
                                        <?php echo e(__('AB+')); ?>

                                        <?php elseif( $row->blood_group == 6 ): ?>
                                        <?php echo e(__('AB-')); ?>

                                        <?php elseif( $row->blood_group == 7 ): ?>
                                        <?php echo e(__('O+')); ?>

                                        <?php elseif( $row->blood_group == 8 ): ?>
                                        <?php echo e(__('O-')); ?>

                                        <?php endif; ?>
                                    </p><hr/>
                                    <?php endif; ?>

                                    <?php if(field('student_national_id')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_national_id')); ?>:</mark> <?php echo e($row->national_id); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('student_passport_no')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_passport_no')); ?>:</mark> <?php echo e($row->passport_no); ?></p>
                                    <?php endif; ?>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <?php if(field('student_address')->status == 1): ?>
                                    <fieldset class="row gx-2 scheduler-border">
                                    <legend><?php echo e(__('field_present')); ?> <?php echo e(__('field_address')); ?></legend>
                                    <p><mark class="text-primary"><?php echo e(__('field_province')); ?>:</mark> <?php echo e($row->presentProvince->title ?? ''); ?></p><hr/>
                                    <p><mark class="text-primary"><?php echo e(__('field_district')); ?>:</mark> <?php echo e($row->presentDistrict->title ?? ''); ?></p><hr/>
                                    <p><mark class="text-primary"><?php echo e(__('field_address')); ?>:</mark> <?php echo e($row->present_address); ?></p>
                                    </fieldset>

                                    <fieldset class="row gx-2 scheduler-border">
                                    <legend><?php echo e(__('field_permanent')); ?> <?php echo e(__('field_address')); ?></legend>
                                    <p><mark class="text-primary"><?php echo e(__('field_province')); ?>:</mark> <?php echo e($row->permanentProvince->title ?? ''); ?></p><hr/>
                                    <p><mark class="text-primary"><?php echo e(__('field_district')); ?>:</mark> <?php echo e($row->permanentDistrict->title ?? ''); ?></p><hr/>
                                    <p><mark class="text-primary"><?php echo e(__('field_address')); ?>:</mark> <?php echo e($row->permanent_address); ?></p>
                                    </fieldset>
                                    <?php endif; ?>

                                    <fieldset class="row gx-2 scheduler-border">
                                    <p><mark class="text-primary"><?php echo e(__('field_hostel')); ?>:</mark> <?php echo e($row->hostelRoom->room->hostel->name ?? ''); ?></p><hr/>
                                    <p><mark class="text-primary"><?php echo e(__('field_room')); ?>:</mark> <?php echo e($row->hostelRoom->room->name ?? ''); ?></p><hr/>
                                    </fieldset>
                                    <fieldset class="row gx-2 scheduler-border">
                                    <p><mark class="text-primary"><?php echo e(__('field_route')); ?>:</mark> <?php echo e($row->transport->transportRoute->title ?? ''); ?></p><hr/>
                                    <p><mark class="text-primary"><?php echo e(__('field_vehicle')); ?>:</mark> <?php echo e($row->transport->transportVehicle->number ?? ''); ?></p>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-transcript-tab" data-bs-toggle="pill" href="#pills-transcript" role="tab" aria-controls="pills-transcript" aria-selected="true"><?php echo e(__('tab_transcript')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-educational-tab" data-bs-toggle="pill" href="#pills-educational" role="tab" aria-controls="pills-educational" aria-selected="false"><?php echo e(__('tab_educational_info')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-fees-tab" data-bs-toggle="pill" href="#pills-fees" role="tab" aria-controls="pills-fees" aria-selected="false"><?php echo e(__('tab_fees_assign')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-book-tab" data-bs-toggle="pill" href="#pills-book" role="tab" aria-controls="pills-book" aria-selected="false"><?php echo e(__('tab_book_issues')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-notes-tab" data-bs-toggle="pill" href="#pills-notes" role="tab" aria-controls="pills-notes" aria-selected="false"><?php echo e(__('tab_notes')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-leave-tab" data-bs-toggle="pill" href="#pills-leave" role="tab" aria-controls="pills-leave" aria-selected="false"><?php echo e(__('tab_leave')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-documents-tab" data-bs-toggle="pill" href="#pills-documents" role="tab" aria-controls="pills-documents" aria-selected="false"><?php echo e(__('tab_documents')); ?></a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-transcript" role="tabpanel" aria-labelledby="pills-transcript-tab">
                                <?php
                                    $semesters_check = 0;
                                    $semester_items = array();
                                ?>

                                <?php $__currentLoopData = $row->studentEnrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $enroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($semesters_check != $enroll->session->title): ?>
                                <?php
                                    array_push($semester_items, array($enroll->session->title, $enroll->semester->title, $enroll->section->title));
                                    $semesters_check = $enroll->session->title;
                                ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $semester_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $semester_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="clearfix"></div>
                                <div class="table-responsive">
                                    <div class="card-header">
                                        <h5><?php echo e($semester_item[0]); ?> | <?php echo e($semester_item[1]); ?> | <?php echo e($semester_item[2]); ?></h5>
                                    </div>
                                    <!-- [ Data table ] start -->
                                    <div class="table-responsive">
                                        <table class="display table table-striped">
                                            <thead>
                                                <tr>
                                                    <th><?php echo e(__('field_code')); ?></th>
                                                    <th><?php echo e(__('field_subject')); ?></th>
                                                    <th><?php echo e(__('field_credit_hour')); ?></th>
                                                    <th><?php echo e(__('field_point')); ?></th>
                                                    <th><?php echo e(__('field_grade')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $semester_credits = 0;
                                                    $semester_cgpa = 0;
                                                ?>
                                                <?php $__currentLoopData = $row->studentEnrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($semester_item[1] == $item->semester->title && $semester_item[0] == $item->session->title): ?>

                                                <?php $__currentLoopData = $item->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $semester_credits = $semester_credits + $subject->credit_hour;
                                                    $subject_grade = null;
                                                ?>
                                                
                                                <tr>
                                                    <td><?php echo e($subject->code); ?></td>
                                                    <td>
                                                        <?php echo e($subject->title); ?>

                                                        <?php if($subject->subject_type == 0): ?>
                                                         (<?php echo e(__('subject_type_optional')); ?>)
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e(round($subject->credit_hour, 2)); ?></td>
                                                    <td>
                                                        <?php if(isset($item->subjectMarks)): ?>
                                                        <?php $__currentLoopData = $item->subjectMarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($mark->subject_id == $subject->id): ?>
                                                            <?php if((date('Y-m-d', strtotime($mark->publish_date)) == date('Y-m-d') && date('H:i:s', strtotime($mark->publish_time)) <= date('H:i:s')) || date('Y-m-d', strtotime($mark->publish_date)) < date('Y-m-d')): ?>

                                                            <?php
                                                            $marks_per = round($mark->total_marks);
                                                            ?>

                                                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($marks_per >= $grade->min_mark && $marks_per <= $grade->max_mark): ?>
                                                            <?php echo e(number_format((float)$grade->point * $subject->credit_hour, 2, '.', '')); ?>

                                                            <?php
                                                            $semester_cgpa = $semester_cgpa + ($grade->point * $subject->credit_hour);
                                                            $subject_grade = $grade->title;
                                                            ?>
                                                            <?php break; ?>
                                                            <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            <?php endif; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e($subject_grade ?? ''); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2"><?php echo e(__('field_term_total')); ?></th>
                                                    <th><?php echo e($semester_credits); ?></th>
                                                    <th><?php echo e(number_format((float)$semester_cgpa, 2, '.', '')); ?></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- [ Data table ] end -->
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="tab-pane fade" id="pills-educational" role="tabpanel" aria-labelledby="pills-educational-tab">
                                <div class="row">
                                    <div class="col-md-4">
                                        <fieldset class="row gx-2 scheduler-border">
                                        <p><mark class="text-primary"><?php echo e(__('field_batch')); ?>:</mark> <?php echo e($row->batch->title ?? ''); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_program')); ?>:</mark> <?php echo e($row->program->title ?? ''); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_session')); ?>:</mark> <?php echo e($curr_enroll->session->title ?? ''); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_semester')); ?>:</mark> <?php echo e($curr_enroll->semester->title ?? ''); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_section')); ?>:</mark> <?php echo e($curr_enroll->section->title ?? ''); ?></p><hr/>

                                        <p><mark class="text-primary"><?php echo e(__('field_status')); ?>:</mark> 
                                        <?php $__currentLoopData = $row->statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge badge-primary"><?php echo e($status->title); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </p><hr/>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-4">
                                        <?php if(field('student_school_info')->status == 1): ?>
                                        <fieldset class="row gx-2 scheduler-border">
                                        <legend><?php echo e(__('field_school_information')); ?></legend>
                                        <p><mark class="text-primary"><?php echo e(__('field_school_name')); ?>:</mark> <?php echo e($row->school_name); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_exam_id')); ?>:</mark> <?php echo e($row->school_exam_id); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_graduation_year')); ?>:</mark> <?php echo e($row->school_graduation_year); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_graduation_point')); ?>:</mark> <?php echo e($row->school_graduation_point); ?></p><hr/>
                                        </fieldset>
                                        <?php endif; ?>
                                        
                                        <?php if(field('student_collage_info')->status == 1): ?>
                                        <fieldset class="row gx-2 scheduler-border">
                                        <legend><?php echo e(__('field_college_information')); ?></legend>
                                        <p><mark class="text-primary"><?php echo e(__('field_collage_name')); ?>:</mark> <?php echo e($row->collage_name); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_exam_id')); ?>:</mark> <?php echo e($row->collage_exam_id); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_graduation_year')); ?>:</mark> <?php echo e($row->collage_graduation_year); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_graduation_point')); ?>:</mark> <?php echo e($row->collage_graduation_point); ?></p><hr/>
                                        </fieldset>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php if(field('student_relatives')->status == 1): ?>
                                        <?php $__currentLoopData = $row->relatives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $relative): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <fieldset class="row gx-2 scheduler-border">
                                        <legend><?php echo e(__('field_guardians_information')); ?>-<?php echo e($key + 1); ?></legend>
                                        <p><mark class="text-primary"><?php echo e(__('field_relation')); ?>:</mark> <?php echo e($relative->relation); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_name')); ?>:</mark> <?php echo e($relative->name); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_occupation')); ?>:</mark> <?php echo e($relative->occupation); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_phone')); ?>:</mark> <?php echo e($relative->phone); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_address')); ?>:</mark> <?php echo e($relative->address); ?></p><hr/>
                                        </fieldset>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-fees" role="tabpanel" aria-labelledby="pills-fees-tab">
                                <!-- [ Data table ] start -->
                                <?php if(isset($fees)): ?>
                                <div class="table-responsive">
                                    <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo e(__('field_session')); ?></th>
                                                <th><?php echo e(__('field_semester')); ?></th>
                                                <th><?php echo e(__('field_fees_type')); ?></th>
                                                <th><?php echo e(__('field_fee')); ?></th>
                                                <th><?php echo e(__('field_discount')); ?></th>
                                                <th><?php echo e(__('field_fine_amount')); ?></th>
                                                <th><?php echo e(__('field_net_amount')); ?></th>
                                                <th><?php echo e(__('field_due_date')); ?></th>
                                                <th><?php echo e(__('field_status')); ?></th>
                                                <th><?php echo e(__('field_pay_date')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php $__currentLoopData = $fees->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <?php if($row->status == 0): ?>
                                            <tr>
                                                <td><?php echo e($key + 1); ?></td>
                                                <td><?php echo e($row->studentEnroll->session->title ?? ''); ?></td>
                                                <td><?php echo e($row->studentEnroll->semester->title ?? ''); ?></td>
                                                <td><?php echo e($row->category->title ?? ''); ?></td>
                                                <td>
                                                    <?php if(isset($setting->decimal_place)): ?>
                                                    <?php echo e(number_format((float)$row->fee_amount, $setting->decimal_place, '.', '')); ?> 
                                                    <?php else: ?>
                                                    <?php echo e(number_format((float)$row->fee_amount, 2, '.', '')); ?> 
                                                    <?php endif; ?> 
                                                    <?php echo $setting->currency_symbol; ?>

                                                </td>
                                                <td>
                                                    <?php 
                                                    $discount_amount = 0;
                                                    $today = date('Y-m-d');
                                                    ?>

                                                    <?php if(isset($row->category)): ?>
                                                    <?php $__currentLoopData = $row->category->discounts->where('status', '1'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <?php
                                                    $availability = \App\Models\FeesDiscount::availability($discount->id, $row->studentEnroll->student_id);
                                                    ?>

                                                    <?php if(isset($availability)): ?>
                                                    <?php if($discount->start_date <= $today && $discount->end_date >= $today): ?>
                                                        <?php if($discount->type == '1'): ?>
                                                            <?php
                                                            $discount_amount = $discount_amount + $discount->amount;
                                                            ?>
                                                        <?php else: ?>
                                                            <?php
                                                            $discount_amount = $discount_amount + ( ($row->fee_amount / 100) * $discount->amount);
                                                            ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>


                                                    <?php if(isset($setting->decimal_place)): ?>
                                                    <?php echo e(number_format((float)$discount_amount, $setting->decimal_place, '.', '')); ?> 
                                                    <?php else: ?>
                                                    <?php echo e(number_format((float)$discount_amount, 2, '.', '')); ?> 
                                                    <?php endif; ?> 
                                                    <?php echo $setting->currency_symbol; ?>

                                                </td>
                                                <td>
                                                    <?php
                                                        $fine_amount = 0;
                                                    ?>
                                                    <?php if(empty($row->pay_date) || $row->due_date < $row->pay_date): ?>
                                                        
                                                        <?php
                                                        $due_date = strtotime($row->due_date);
                                                        $today = strtotime(date('Y-m-d')); 
                                                        $days = (int)(($today - $due_date)/86400);
                                                        ?>

                                                        <?php if($row->due_date < date("Y-m-d")): ?>
                                                        <?php if(isset($row->category)): ?>
                                                        <?php $__currentLoopData = $row->category->fines->where('status', '1'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($fine->start_day <= $days && $fine->end_day >= $days): ?>
                                                            <?php if($fine->type == '1'): ?>
                                                                <?php
                                                                $fine_amount = $fine_amount + $fine->amount;
                                                                ?>
                                                            <?php else: ?>
                                                                <?php
                                                                $fine_amount = $fine_amount + ( ($row->fee_amount / 100) * $fine->amount);
                                                                ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>


                                                    <?php if(isset($setting->decimal_place)): ?>
                                                    <?php echo e(number_format((float)$fine_amount, $setting->decimal_place, '.', '')); ?> 
                                                    <?php else: ?>
                                                    <?php echo e(number_format((float)$fine_amount, 2, '.', '')); ?> 
                                                    <?php endif; ?> 
                                                    <?php echo $setting->currency_symbol; ?>

                                                </td>
                                                <td>
                                                    <?php
                                                    $net_amount = ($row->fee_amount - $discount_amount) + $fine_amount;
                                                    ?>

                                                    <?php if(isset($setting->decimal_place)): ?>
                                                    <?php echo e(number_format((float)$net_amount, $setting->decimal_place, '.', '')); ?> 
                                                    <?php else: ?>
                                                    <?php echo e(number_format((float)$net_amount, 2, '.', '')); ?> 
                                                    <?php endif; ?> 
                                                    <?php echo $setting->currency_symbol; ?>

                                                </td>
                                                <td>
                                                    <?php if(isset($setting->date_format)): ?>
                                                    <?php echo e(date($setting->date_format, strtotime($row->due_date))); ?>

                                                    <?php else: ?>
                                                    <?php echo e(date("Y-m-d", strtotime($row->due_date))); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($row->status == 1): ?>
                                                    <span class="badge badge-pill badge-success"><?php echo e(__('status_paid')); ?></span>
                                                    <?php elseif($row->status == 2): ?>
                                                    <span class="badge badge-pill badge-danger"><?php echo e(__('status_canceled')); ?></span>
                                                    <?php else: ?>
                                                    <span class="badge badge-pill badge-primary"><?php echo e(__('status_pending')); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td></td>
                                            </tr>

                                          <?php elseif($row->status == 1): ?>

                                            <tr>
                                                <td><?php echo e($key + 1); ?></td>
                                                <td><?php echo e($row->studentEnroll->session->title ?? ''); ?></td>
                                                <td><?php echo e($row->studentEnroll->semester->title ?? ''); ?></td>
                                                <td><?php echo e($row->category->title ?? ''); ?></td>
                                                <td>
                                                    <?php if(isset($setting->decimal_place)): ?>
                                                    <?php echo e(number_format((float)$row->fee_amount, $setting->decimal_place, '.', '')); ?> 
                                                    <?php else: ?>
                                                    <?php echo e(number_format((float)$row->fee_amount, 2, '.', '')); ?> 
                                                    <?php endif; ?> 
                                                    <?php echo $setting->currency_symbol; ?>

                                                </td>
                                                <td>
                                                    <?php if(isset($setting->decimal_place)): ?>
                                                    <?php echo e(number_format((float)$row->discount_amount, $setting->decimal_place, '.', '')); ?> 
                                                    <?php else: ?>
                                                    <?php echo e(number_format((float)$row->discount_amount, 2, '.', '')); ?> 
                                                    <?php endif; ?> 
                                                    <?php echo $setting->currency_symbol; ?>

                                                </td>
                                                <td>
                                                    <?php if(isset($setting->decimal_place)): ?>
                                                    <?php echo e(number_format((float)$row->fine_amount, $setting->decimal_place, '.', '')); ?> 
                                                    <?php else: ?>
                                                    <?php echo e(number_format((float)$row->fine_amount, 2, '.', '')); ?> 
                                                    <?php endif; ?> 
                                                    <?php echo $setting->currency_symbol; ?>

                                                </td>
                                                <td>
                                                    <?php if(isset($setting->decimal_place)): ?>
                                                    <?php echo e(number_format((float)$row->paid_amount, $setting->decimal_place, '.', '')); ?> 
                                                    <?php else: ?>
                                                    <?php echo e(number_format((float)$row->paid_amount, 2, '.', '')); ?> 
                                                    <?php endif; ?> 
                                                    <?php echo $setting->currency_symbol; ?>

                                                </td>
                                                <td>
                                                    <?php if(isset($setting->date_format)): ?>
                                                    <?php echo e(date($setting->date_format, strtotime($row->due_date))); ?>

                                                    <?php else: ?>
                                                    <?php echo e(date("Y-m-d", strtotime($row->due_date))); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($row->status == 1): ?>
                                                    <span class="badge badge-pill badge-success"><?php echo e(__('status_paid')); ?></span>
                                                    <?php elseif($row->status == 2): ?>
                                                    <span class="badge badge-pill badge-danger"><?php echo e(__('status_canceled')); ?></span>
                                                    <?php else: ?>
                                                    <span class="badge badge-pill badge-primary"><?php echo e(__('status_pending')); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if(isset($setting->date_format)): ?>
                                                    <?php echo e(date($setting->date_format, strtotime($row->pay_date))); ?>

                                                    <?php else: ?>
                                                    <?php echo e(date("Y-m-d", strtotime($row->pay_date))); ?>

                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                          <?php endif; ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php endif; ?>
                                <!-- [ Data table ] end -->
                            </div>
                            <div class="tab-pane fade" id="pills-book" role="tabpanel" aria-labelledby="pills-book-tab">
                                <!-- [ Data table ] start -->
                                <div class="table-responsive">
                                    <table id="basic-table2" class="display table nowrap table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo e(__('field_isbn')); ?></th>
                                                <th><?php echo e(__('field_book')); ?></th>
                                                <th><?php echo e(__('field_issue_date')); ?></th>
                                                <th><?php echo e(__('field_due_return_date')); ?></th>
                                                <th><?php echo e(__('field_return_date')); ?></th>
                                                <th><?php echo e(__('field_status')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php if(isset($student->member)): ?>
                                          <?php $__currentLoopData = $student->member->issuReturn->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($key + 1); ?></td>
                                                <td><?php echo e($row->book->isbn ?? ''); ?></td>
                                                <td><?php echo e($row->book->title ?? ''); ?></td>
                                                <td>
                                                    <?php if(isset($setting->date_format)): ?>
                                                    <?php echo e(date($setting->date_format, strtotime($row->issue_date))); ?>

                                                    <?php else: ?>
                                                    <?php echo e(date("Y-m-d", strtotime($row->issue_date))); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if(isset($setting->date_format)): ?>
                                                    <?php echo e(date($setting->date_format, strtotime($row->due_date))); ?>

                                                    <?php else: ?>
                                                    <?php echo e(date("Y-m-d", strtotime($row->due_date))); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if(!empty($row->return_date)): ?>
                                                    <?php if(isset($setting->date_format)): ?>
                                                        <?php echo e(date($setting->date_format, strtotime($row->return_date))); ?>

                                                    <?php else: ?>
                                                        <?php echo e(date("Y-m-d", strtotime($row->return_date))); ?>

                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if( $row->status == 0 ): ?>
                                                    <span class="badge badge-pill badge-danger"><?php echo e(__('status_lost')); ?></span>

                                                    <?php elseif( $row->status == 1 ): ?>
                                                    <?php if($row->due_date < date("Y-m-d")): ?>
                                                    <span class="badge badge-pill badge-danger"><?php echo e(__('status_delay')); ?></span>
                                                    <?php else: ?>
                                                    <span class="badge badge-pill badge-primary"><?php echo e(__('status_issued')); ?></span>
                                                    <?php endif; ?>

                                                    <?php elseif( $row->status == 2 ): ?>
                                                    <span class="badge badge-pill badge-success"><?php echo e(__('status_returned')); ?></span>
                                                    <?php if($row->due_date < $row->return_date): ?>
                                                    <span class="badge badge-pill badge-danger"><?php echo e(__('status_delayed')); ?></span>
                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- [ Data table ] end -->
                            </div>
                            <div class="tab-pane fade" id="pills-notes" role="tabpanel" aria-labelledby="pills-notes-tab">
                                <!-- [ Data table ] start -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__('field_date')); ?></th>
                                                <th><?php echo e(__('field_title')); ?></th>
                                                <th><?php echo e(__('field_note')); ?></th>
                                                <th><?php echo e(__('field_attach')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $student->notes->where('status', 1)->sortBy('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                <?php if(isset($setting->date_format)): ?>
                                                <?php echo e(date($setting->date_format, strtotime($note->created_at))); ?>

                                                <?php else: ?>
                                                <?php echo e(date("Y-m-d", strtotime($note->created_at))); ?>

                                                <?php endif; ?>
                                                </td>
                                                <td><?php echo e($note->title); ?></td>
                                                <td><?php echo e($note->description); ?></td>
                                                <td>
                                                <?php if(is_file('uploads/note/'.$note->attach)): ?>
                                                <a href="<?php echo e(asset('uploads/note/'.$note->attach)); ?>" class="btn btn-sm btn-icon btn-dark" download><i class="fas fa-download"></i></a>
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- [ Data table ] end -->
                            </div>
                            <div class="tab-pane fade" id="pills-leave" role="tabpanel" aria-labelledby="pills-leave-tab">
                                <!-- [ Data table ] start -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__('field_leave_date')); ?></th>
                                                <th><?php echo e(__('field_days')); ?></th>
                                                <th><?php echo e(__('field_apply_date')); ?></th>
                                                <th><?php echo e(__('field_status')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $student->leaves->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <?php if(isset($setting->date_format)): ?>
                                                        <?php echo e(date($setting->date_format, strtotime($leave->from_date))); ?>

                                                    <?php else: ?>
                                                        <?php echo e(date("Y-m-d", strtotime($leave->from_date))); ?>

                                                    <?php endif; ?>
                                                    -
                                                    <?php if(isset($setting->date_format)): ?>
                                                        <?php echo e(date($setting->date_format, strtotime($leave->to_date))); ?>

                                                    <?php else: ?>
                                                        <?php echo e(date("Y-m-d", strtotime($leave->to_date))); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e((int)((strtotime($leave->to_date) - strtotime($leave->from_date))/86400) + 1); ?></td>
                                                <td>
                                                    <?php if(isset($setting->date_format)): ?>
                                                        <?php echo e(date($setting->date_format, strtotime($leave->apply_date))); ?>

                                                    <?php else: ?>
                                                        <?php echo e(date("Y-m-d", strtotime($leave->apply_date))); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if( $leave->status == 1 ): ?>
                                                    <span class="badge badge-pill badge-success"><?php echo e(__('status_approved')); ?></span>
                                                    <?php elseif( $leave->status == 2 ): ?>
                                                    <span class="badge badge-pill badge-danger"><?php echo e(__('status_rejected')); ?></span>
                                                    <?php else: ?>
                                                    <span class="badge badge-pill badge-primary"><?php echo e(__('status_pending')); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- [ Data table ] end -->
                            </div>
                            <div class="tab-pane fade" id="pills-documents" role="tabpanel" aria-labelledby="pills-documents-tab">
                                <!-- [ Data table ] start -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__('field_title')); ?></th>
                                                <th><?php echo e(__('field_document')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(field('student_photo')->status == 1): ?>
                                            <tr>
                                                <td><?php echo e(__('field_photo')); ?></td>
                                                <td>
                                                <?php if(is_file('uploads/'.$path.'/'.$student->photo)): ?>
                                                <a href="<?php echo e(asset('uploads/'.$path.'/'.$student->photo)); ?>" data-lightbox="gallery">
                                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$student->photo)); ?>" class="img-fluid field-image">
                                                </a>
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if(field('student_signature')->status == 1): ?>
                                            <tr>
                                                <td><?php echo e(__('field_signature')); ?></td>
                                                <td>
                                                <?php if(is_file('uploads/'.$path.'/'.$student->signature)): ?>
                                                <a href="<?php echo e(asset('uploads/'.$path.'/'.$student->signature)); ?>" data-lightbox="gallery">
                                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$student->signature)); ?>" class="img-fluid field-image">
                                                </a>
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if(field('student_school_transcript')->status == 1): ?>
                                            <tr>
                                                <td><?php echo e(__('field_school_transcript')); ?></td>
                                                <td>
                                                <?php if(is_file('uploads/'.$path.'/'.$student->school_transcript)): ?>
                                                <a href="<?php echo e(asset('uploads/'.$path.'/'.$student->school_transcript)); ?>" data-lightbox="gallery">
                                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$student->school_transcript)); ?>" class="img-fluid field-image">
                                                </a>
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if(field('student_school_certificate')->status == 1): ?>
                                            <tr>
                                                <td><?php echo e(__('field_school_certificate')); ?></td>
                                                <td>
                                                <?php if(is_file('uploads/'.$path.'/'.$student->school_certificate)): ?>
                                                <a href="<?php echo e(asset('uploads/'.$path.'/'.$student->school_certificate)); ?>" data-lightbox="gallery">
                                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$student->school_certificate)); ?>" class="img-fluid field-image">
                                                </a>
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if(field('student_collage_transcript')->status == 1): ?>
                                            <tr>
                                                <td><?php echo e(__('field_collage_transcript')); ?></td>
                                                <td>
                                                <?php if(is_file('uploads/'.$path.'/'.$student->collage_transcript)): ?>
                                                <a href="<?php echo e(asset('uploads/'.$path.'/'.$student->collage_transcript)); ?>" data-lightbox="gallery">
                                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$student->collage_transcript)); ?>" class="img-fluid field-image">
                                                </a>
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if(field('student_collage_certificate')->status == 1): ?>
                                            <tr>
                                                <td><?php echo e(__('field_collage_certificate')); ?></td>
                                                <td>
                                                <?php if(is_file('uploads/'.$path.'/'.$student->collage_certificate)): ?>
                                                <a href="<?php echo e(asset('uploads/'.$path.'/'.$student->collage_certificate)); ?>" data-lightbox="gallery">
                                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$student->collage_certificate)); ?>" class="img-fluid field-image">
                                                </a>
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php $__currentLoopData = $student->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($document->title); ?></td>
                                                <td>
                                                <?php if(is_file('uploads/'.$path.'/'.$document->attach)): ?>
                                                <a target="__blank" href="<?php echo e(asset('uploads/'.$path.'/'.$document->attach)); ?>" class="btn btn-sm btn-icon btn-dark" download><i class="fas fa-download"></i></a>
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- [ Data table ] end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
<script src="<?php echo e(asset('dashboard/plugins/lightbox2-master/js/lightbox.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/student/show.blade.php ENDPATH**/ ?>