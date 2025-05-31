<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-4">
                <div class="card user-card user-card-1">
                    <div class="card-body pb-0">
                        <?php $user = $row; ?>

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
                                <?php if(isset($row->staff_id)): ?>
                                <p class="mb-0 text-muted">#<?php echo e($row->staff_id); ?></p>
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
                            <span class="f-w-500"><i class="fas fa-university m-r-10"></i><?php echo e(__('field_department')); ?> : </span>
                            <span class="float-end"><?php echo e($row->department->title ?? ''); ?></span>
                        </li>
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="fas fa-user-tag m-r-10"></i><?php echo e(__('field_designation')); ?> : </span>
                            <span class="float-end"><?php echo e($row->designation->title ?? ''); ?></span>
                        </li>
                        <li class="list-group-item border-bottom-0">
                            <span class="f-w-500"><i class="fas fa-user-cog m-r-10"></i><?php echo e(__('field_role')); ?> : </span>
                            <span class="float-end">
                                <?php $__currentLoopData = $row->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($role->name); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </span>
                        </li>
                    </ul>
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
                                    <?php if(field('user_father_name')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_father_name')); ?>:</mark> <?php echo e($row->father_name); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('user_mother_name')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_mother_name')); ?>:</mark> <?php echo e($row->mother_name); ?></p><hr/>
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

                                    <?php if(field('user_emergency_phone')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_emergency_phone')); ?>:</mark> <?php echo e($row->emergency_phone); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('user_religion')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_religion')); ?>:</mark> <?php echo e($row->religion); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('user_caste')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_caste')); ?>:</mark> <?php echo e($row->caste); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('user_mother_tongue')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_mother_tongue')); ?>:</mark> <?php echo e($row->mother_tongue); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('user_nationality')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_nationality')); ?>:</mark> <?php echo e($row->nationality); ?></p><hr/>
                                    <?php endif; ?>

                                    <?php if(field('user_marital_status')->status == 1): ?>
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

                                    <?php if(field('user_blood_group')->status == 1): ?>
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

                                    <?php if(field('user_national_id')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_national_id')); ?>:</mark> <?php echo e($row->national_id); ?></p><hr/>
                                    <?php endif; ?>
                                    <?php if(field('user_passport_no')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_passport_no')); ?>:</mark> <?php echo e($row->passport_no); ?></p>
                                    <?php endif; ?>

                                    <?php if(field('user_joining_date')->status == 1): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_joining_date')); ?>:</mark> 
                                        <?php if(isset($setting->date_format)): ?>
                                        <?php echo e(date($setting->date_format, strtotime($row->joining_date))); ?>

                                        <?php else: ?>
                                        <?php echo e(date("Y-m-d", strtotime($row->joining_date))); ?>

                                        <?php endif; ?>
                                    </p><hr/>
                                    <?php endif; ?>

                                    <?php if(field('user_ending_date')->status == 1): ?>
                                    <?php if(isset($row->ending_date)): ?>
                                    <p><mark class="text-primary"><?php echo e(__('field_ending_date')); ?>:</mark> 
                                        <?php if(isset($setting->date_format)): ?>
                                        <?php echo e(date($setting->date_format, strtotime($row->ending_date))); ?>

                                        <?php else: ?>
                                        <?php echo e(date("Y-m-d", strtotime($row->ending_date))); ?>

                                        <?php endif; ?>
                                    </p><hr/>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <?php if(field('user_address')->status == 1): ?>
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
                                <a class="nav-link active" id="pills-payroll-tab" data-bs-toggle="pill" href="#pills-payroll" role="tab" aria-controls="pills-payroll" aria-selected="true"><?php echo e(trans_choice('module_payroll_report', 2)); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-leave-tab" data-bs-toggle="pill" href="#pills-leave" role="tab" aria-controls="pills-leave" aria-selected="false"><?php echo e(__('tab_leave')); ?></a>
                            </li>
                            <?php if(field('user_education')->status == 1): ?>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-educational-tab" data-bs-toggle="pill" href="#pills-educational" role="tab" aria-controls="pills-educational" aria-selected="false"><?php echo e(__('tab_educational_info')); ?></a>
                            </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-payroll-info-tab" data-bs-toggle="pill" href="#pills-payroll-info" role="tab" aria-controls="pills-payroll-info" aria-selected="false"><?php echo e(__('tab_payroll_details')); ?></a>
                            </li>
                            <?php if(field('user_bank_account')->status == 1): ?>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-bank-tab" data-bs-toggle="pill" href="#pills-bank" role="tab" aria-controls="pills-bank" aria-selected="false"><?php echo e(__('tab_bank_info')); ?></a>
                            </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-notes-tab" data-bs-toggle="pill" href="#pills-notes" role="tab" aria-controls="pills-notes" aria-selected="false"><?php echo e(__('tab_notes')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-documents-tab" data-bs-toggle="pill" href="#pills-documents" role="tab" aria-controls="pills-documents" aria-selected="false"><?php echo e(__('tab_documents')); ?></a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-payroll" role="tabpanel" aria-labelledby="pills-payroll-tab">
                                <!-- [ Data table ] start -->
                                <div class="table-responsive">
                                    <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__('field_basic_salary')); ?></th>
                                                <th><?php echo e(__('field_total_earning')); ?></th>
                                                <th><?php echo e(__('field_total_allowance')); ?></th>
                                                <th><?php echo e(__('field_total_deduction')); ?></th>
                                                <th><?php echo e(__('field_gross_salary')); ?></th>
                                                <th><?php echo e(__('field_tax')); ?></th>
                                                <th><?php echo e(__('field_net_salary')); ?></th>
                                                <th><?php echo e(__('field_status')); ?></th>
                                                <th><?php echo e(__('field_pay_date')); ?></th>
                                                <th><?php echo e(__('field_payment_method')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $user->payrolls->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $payroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <?php echo e(round($payroll->basic_salary, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?> / 

                                                    <?php if( $payroll->salary_type == 1 ): ?>
                                                    <?php echo e(__('salary_type_fixed')); ?>

                                                    <?php elseif( $payroll->salary_type == 2 ): ?>
                                                    <?php echo e(__('salary_type_hourly')); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e(round($payroll->total_earning, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
                                                <td><?php echo e(round($payroll->total_allowance, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
                                                <td><?php echo e(round($payroll->total_deduction, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
                                                <td><?php echo e(round($payroll->gross_salary, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
                                                <td><?php echo e(round($payroll->tax, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
                                                <td><?php echo e(round($payroll->net_salary, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
                                                <td>
                                                    <?php if($payroll->status == 1): ?>
                                                    <span class="badge badge-pill badge-success"><?php echo e(__('status_paid')); ?></span>
                                                    <?php else: ?>
                                                    <span class="badge badge-pill badge-danger"><?php echo e(__('status_unpaid')); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($payroll->status == 1): ?>
                                                    <?php if(isset($setting->date_format)): ?>
                                                    <?php echo e(date($setting->date_format, strtotime($payroll->pay_date))); ?>

                                                    <?php else: ?>
                                                    <?php echo e(date("Y-m-d", strtotime($payroll->pay_date))); ?>

                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if( $payroll->payment_method == 1 ): ?>
                                                    <?php echo e(__('payment_method_card')); ?>

                                                    <?php elseif( $payroll->payment_method == 2 ): ?>
                                                    <?php echo e(__('payment_method_cash')); ?>

                                                    <?php elseif( $payroll->payment_method == 3 ): ?>
                                                    <?php echo e(__('payment_method_cheque')); ?>

                                                    <?php elseif( $payroll->payment_method == 4 ): ?>
                                                    <?php echo e(__('payment_method_bank')); ?>

                                                    <?php elseif( $payroll->payment_method == 5 ): ?>
                                                    <?php echo e(__('payment_method_e_wallet')); ?>

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
                                    <table id="basic-table2" class="display table nowrap table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__('field_leave_type')); ?></th>
                                                <th><?php echo e(__('field_pay_type')); ?></th>
                                                <th><?php echo e(__('field_leave_date')); ?></th>
                                                <th><?php echo e(__('field_days')); ?></th>
                                                <th><?php echo e(__('field_apply_date')); ?></th>
                                                <th><?php echo e(__('field_status')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $user->leaves->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($leave->leaveType->title ?? ''); ?></td>
                                                <td>
                                                    <?php if($leave->pay_type == 1): ?>
                                                    <span class="badge badge-pill badge-success"><?php echo e(__('field_paid_leave')); ?></span>
                                                    <?php elseif($leave->pay_type == 2): ?>
                                                    <span class="badge badge-pill badge-danger"><?php echo e(__('field_unpaid_leave')); ?></span>
                                                    <?php endif; ?>
                                                </td>
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
                            <?php if(field('user_education')->status == 1): ?>
                            <div class="tab-pane fade" id="pills-educational" role="tabpanel" aria-labelledby="pills-educational-tab">
                                <fieldset class="scheduler-border">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><mark class="text-primary"><?php echo e(__('field_education_level')); ?>:</mark> <?php echo e($row->education_level); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_graduation_academy')); ?>:</mark> <?php echo e($row->graduation_academy); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_year_of_graduation')); ?>:</mark> <?php echo e($row->year_of_graduation); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_graduation_field')); ?>:</mark> <?php echo e($row->graduation_field); ?></p><hr/>
                                    </div>
                                    <div class="col-md-6">
                                        <p><mark class="text-primary"><?php echo e(__('field_experience')); ?>:</mark> <?php echo e($row->experience); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_note')); ?>:</mark> <?php echo e($row->note); ?></p><hr/>

                                        
                                    </div>
                                </div>
                                </fieldset>
                            </div>
                            <?php endif; ?>
                            <div class="tab-pane fade" id="pills-payroll-info" role="tabpanel" aria-labelledby="pills-payroll-info-tab">
                                <fieldset class="scheduler-border">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><mark class="text-primary"><?php echo e(__('field_contract_type')); ?>:</mark> 
                                            <?php if( $row->contract_type == 1 ): ?>
                                            <?php echo e(__('contract_type_full_time')); ?>

                                            <?php elseif( $row->contract_type == 2 ): ?>
                                            <?php echo e(__('contract_type_part_time')); ?>

                                            <?php endif; ?>
                                        </p><hr/>

                                        <p><mark class="text-primary"><?php echo e(__('field_work_shift')); ?>:</mark> <?php echo e($row->workShift->title ?? ''); ?></p><hr/>

                                        <?php if(field('user_epf_no')->status == 1): ?>
                                        <p><mark class="text-primary"><?php echo e(__('field_epf_no')); ?>:</mark> <?php echo e($row->epf_no); ?></p><hr/>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <p><mark class="text-primary"><?php echo e(__('field_salary_type')); ?>:</mark> 
                                            <?php if( $row->salary_type == 1 ): ?>
                                            <?php echo e(__('salary_type_fixed')); ?>

                                            <?php elseif( $row->salary_type == 2 ): ?>
                                            <?php echo e(__('salary_type_hourly')); ?>

                                            <?php endif; ?>
                                        </p><hr/>
                                        
                                        <p><mark class="text-primary"><?php if($row->salary_type == 1): ?> <?php echo e(__('salary_type_fixed')); ?> <?php else: ?> <?php echo e(__('salary_type_hourly')); ?> <?php endif; ?> <?php echo e(__('field_salary')); ?>:</mark>
                                            <?php echo e(round($row->basic_salary, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?>

                                        </p><hr/>
                                    </div>
                                </div>
                                </fieldset>
                            </div>
                            <?php if(field('user_bank_account')->status == 1): ?>
                            <div class="tab-pane fade" id="pills-bank" role="tabpanel" aria-labelledby="pills-bank-tab">
                                <fieldset class="scheduler-border">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><mark class="text-primary"><?php echo e(__('field_bank_account_name')); ?>:</mark> <?php echo e($row->bank_account_name); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_bank_account_no')); ?>:</mark> <?php echo e($row->bank_account_no); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_bank_name')); ?>:</mark> <?php echo e($row->bank_name); ?></p><hr/>
                                    </div>
                                    <div class="col-md-6">
                                        <p><mark class="text-primary"><?php echo e(__('field_ifsc_code')); ?>:</mark> <?php echo e($row->ifsc_code); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_bank_brach')); ?>:</mark> <?php echo e($row->bank_brach); ?></p><hr/>
                                        <p><mark class="text-primary"><?php echo e(__('field_tin_no')); ?>:</mark> <?php echo e($row->tin_no); ?></p><hr/>
                                    </div>
                                </div>
                                </fieldset>
                            </div>
                            <?php endif; ?>
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
                                            <?php $__currentLoopData = $user->notes->where('status', 1)->sortBy('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                            <tr>
                                                <td><?php echo e(__('field_photo')); ?></td>
                                                <td>
                                                <?php if(is_file('uploads/'.$path.'/'.$user->photo)): ?>
                                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$user->photo)); ?>" class="img-fluid field-image" onerror="this.src='<?php echo e(asset('dashboard/images/user/avatar-2.jpg')); ?>';">
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php if(field('user_signature')->status == 1): ?>
                                            <tr>
                                                <td><?php echo e(__('field_signature')); ?></td>
                                                <td>
                                                <?php if(is_file('uploads/'.$path.'/'.$user->signature)): ?>
                                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$user->signature)); ?>" class="img-fluid field-image" onerror="this.src='<?php echo e(asset('dashboard/images/user/avatar-2.jpg')); ?>';">
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if(field('user_resume')->status == 1): ?>
                                            <tr>
                                                <td><?php echo e(__('field_resume')); ?></td>
                                                <td>
                                                <?php if(is_file('uploads/'.$path.'/'.$row->resume)): ?>
                                                <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->resume)); ?>" class="btn btn-sm btn-icon btn-dark" download><i class="fas fa-download"></i></a>
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if(field('user_joining_letter')->status == 1): ?>
                                            <tr>
                                                <td><?php echo e(__('field_joining_letter')); ?></td>
                                                <td>
                                                <?php if(is_file('uploads/'.$path.'/'.$row->joining_letter)): ?>
                                                <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->joining_letter)); ?>" class="btn btn-sm btn-icon btn-dark" download><i class="fas fa-download"></i></a>
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if(field('user_documents')->status == 1): ?>
                                            <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($document->title); ?></td>
                                                <td>
                                                <?php if(is_file('uploads/'.$path.'/'.$document->attach)): ?>
                                                <a target="__blank" href="<?php echo e(asset('uploads/'.$path.'/'.$document->attach)); ?>" class="btn btn-sm btn-icon btn-dark" download><i class="fas fa-download"></i></a>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home7/httpurba/public_html/college/resources/views/admin/user/show.blade.php ENDPATH**/ ?>