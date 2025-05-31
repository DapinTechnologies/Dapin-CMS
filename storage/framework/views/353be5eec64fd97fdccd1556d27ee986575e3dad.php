<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e($title); ?></h5>
                        </div>
                        <div class="card-block">
                          <div class="row">
                            <!-- Form Start -->
                            <div class="table-responsive">
                                <table class="table nowrap table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Field Title')); ?></th>
                                            <th><?php echo e(__('field_status')); ?></th>
                                        </tr>
                                    </thead>
                                    <?php
                                        function field($slug){
                                            return \App\Models\Field::field($slug);
                                        }
                                    ?>
                                    <tbody>
                                        <?php
                                            $field = field('application_father_name');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_father_name')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_mother_name');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_mother_name')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_father_occupation');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_father_occupation')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_mother_occupation');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_mother_occupation')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_emergency_phone');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_emergency_phone')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_religion');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_religion')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_caste');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_caste')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_mother_tongue');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_mother_tongue')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_nationality');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_nationality')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_marital_status');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_marital_status')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_blood_group');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_blood_group')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_national_id');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_national_id')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_passport_no');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_passport_no')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_address');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('Address Details')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_school_info');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('O Level Exam Info')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_collage_info');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('A Level Exam Info')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_school_transcript');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_school_transcript')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_school_certificate');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_school_certificate')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_collage_transcript');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_collage_transcript')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_collage_certificate');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_collage_certificate')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_photo');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_photo')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('application_signature');
                                        ?>
                                        <tr>
                                            <td><?php echo e(__('field_signature')); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Form End -->
                          </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\field\application.blade.php ENDPATH**/ ?>