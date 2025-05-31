    <!-- Show modal content -->
    <div id="showModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><?php echo e(__('modal_view')); ?> <?php echo e($title); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Details View Start -->
                    
                    <div class="template-container" style="border-image: url('<?php echo e(asset('uploads/'.$path.'/'.$certificate->template->background)); ?>') 30 stretch; width: <?php echo e($certificate->template->width); ?>; height: <?php echo e($certificate->template->height); ?>;">
                      <div class="template-inner">
                        <!-- Header Section -->
                        <table class="table-no-border">
                            <tbody>
                                <tr>
                                    <td class="temp-logo">
                                      <div class="inner">
                                        <?php if(is_file('uploads/'.$path.'/'.$certificate->template->logo_left)): ?>
                                        <img src="<?php echo e(asset('uploads/'.$path.'/'.$certificate->template->logo_left)); ?>" alt="Logo">
                                        <?php endif; ?>
                                      </div>
                                    </td>
                                    <td class="temp-title">
                                      <div class="inner">
                                        <h2><?php echo e($setting->title ?? ''); ?></h2>
                                      </div>
                                    </td>
                                    <td class="temp-logo last">
                                      <div class="inner">
                                        <?php if($certificate->template->student_photo == 1): ?>
                                        <?php if(is_file('uploads/student/'.$row->photo)): ?>
                                        <img src="<?php echo e(asset('uploads/student/'.$row->photo)); ?>" alt="Student">
                                        <?php endif; ?>
                                        <?php endif; ?>
                                      </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table-no-border">
                            <tbody>
                                <tr>
                                    <td class="main-title">
                                        <h4><?php echo e($certificate->template->title ?? ''); ?></h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Header Section -->

                        <!-- Header Section -->
                        <table class="table-no-border">
                            <tbody>
                                <tr>
                                    <td class="meta-data">
                                        <div class="inner"><?php echo e(__('field_no')); ?>: <?php echo e($certificate->serial_no); ?></div>
                                    </td>
                                    <td class="meta-data last">
                                        <div class="inner"><?php echo e(__('field_date')); ?>: 
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($certificate->date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($certificate->date))); ?>

                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Header Section -->

                        <!-- Header Section -->
                        <table class="table-no-border">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="temp-body">
                                        <?php if(isset($setting->date_format)): ?>
                                        <?php
                                            $student_dob = date($setting->date_format, strtotime($certificate->student->dob));
                                        ?>
                                        <?php else: ?>
                                        <?php
                                            $student_dob = date("Y-m-d", strtotime($certificate->student->dob));
                                        ?>
                                        <?php endif; ?>


                                        <?php if($certificate->student->gender == 1): ?>
                                        <?php
                                            $student_gender = __('gender_male');
                                        ?>
                                        <?php elseif($certificate->student->gender == 2): ?>
                                        <?php
                                            $student_gender = __('gender_female');
                                        ?>
                                        <?php elseif($certificate->student->gender == 3): ?>
                                        <?php
                                            $student_gender = __('gender_other');
                                        ?>
                                        <?php endif; ?>


                                        <?php
                                            $grade_point = '';
                                        ?>
                                        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($certificate->point >= $grade->point): ?>
                                        <?php
                                            $grade_point = $grade->title;
                                        ?>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php
                                            $first_name = $certificate->student->first_name ?? '';
                                            $last_name = $certificate->student->last_name ?? '';
                                            $student_id = $certificate->student->student_id ?? '';
                                            $batch = $certificate->student->batch->title ?? '';
                                            $program = $certificate->student->program->title ?? '';
                                            $faculty = $certificate->student->program->faculty->title ?? '';
                                            $father_name = $certificate->student->father_name ?? '';
                                            $mother_name = $certificate->student->mother_name ?? '';
                                            $email = $certificate->student->email ?? '';
                                            $phone = $certificate->student->phone ?? '';
                                            $starting_session = $certificate->student->firstEnroll->session->title ?? '';
                                            $ending_session = $certificate->student->lastEnroll->session->title ?? '';
                                        ?>
                                        <?php
                                        $search = array('[first_name]', '[last_name]', '[dob]', '[gender]', '[student_id]', '[batch]', '[program]', '[faculty]', '[father_name]', '[mother_name]', '[starting_year]', '[ending_year]', '[starting_session]', '[ending_session]', '[credits]', '[cgpa]', '[grade]', '[email]', '[phone]');

                                        $replace = array('<span>'.$first_name.'</span>', '<span>'.$last_name.'</span>', '<span>'.$student_dob.'</span>', '<span>'.$student_gender.'</span>', '<span>'.$student_id.'</span>', '<span>'.$batch.'</span>', '<span>'.$program.'</span>', '<span>'.$faculty.'</span>', '<span>'.$father_name.'</span>', '<span>'.$mother_name.'</span>', '<span>'.date('Y',strtotime($certificate->starting_year)).'</span>', '<span>'.date('Y',strtotime($certificate->ending_year)).'</span>', '<span>'.$starting_session.'</span>', '<span>'.$ending_session.'</span>', '<span>'.round($certificate->credits, 2).'</span>', '<span>'.number_format((float)$certificate->point, 2, '.', '').'</span>', '<span>'.$grade_point.'</span>', '<span>'.$email.'</span>', '<span>'.$phone.'</span>');

                                        $string = $certificate->template->body;
                                        ?>

                                        <?php echo str_replace($search, $replace, $string); ?>

                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Header Section -->

                        <!-- Header Section -->
                        <?php if($certificate->template->barcode == 1): ?>
                        <table class="table-no-border">
                            <tbody>
                                <tr>
                                    <td style="width: 33.33%; text-align: center;"></td>
                                    <td style="width: 33.33%; text-align: center; font-family: 'IDAHC39M Code 39 Barcode', Times, serif;">
                                        <?php echo DNS1D::getBarcodeSVG($certificate->barcode, 'C39', 1, 33, '#000', false); ?>

                                    </td>
                                    <td style="width: 33.33%; text-align: center;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php endif; ?>
                        <table class="table-no-border">
                            <tbody>
                                <tr>
                                    <td class="temp-footer">
                                      <div class="inner">
                                        <p><?php echo $certificate->template->footer_left; ?></p>
                                      </div>
                                    </td>
                                    <td class="temp-footer">
                                      <div class="inner">
                                        <p><?php echo $certificate->template->footer_center; ?></p>
                                      </div>
                                    </td>
                                    <td class="temp-footer">
                                      <div class="inner">
                                        <p><?php echo $certificate->template->footer_right; ?></p>
                                      </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Header Section -->
                      </div>
                    </div>

                    <!-- Details View End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                </div>
            </div>
        </div>
    </div><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\certificate\show.blade.php ENDPATH**/ ?>