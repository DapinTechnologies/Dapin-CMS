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
                                            <th><?php echo e(__('Sidebar Navs')); ?></th>
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
                                            $field = field('panel_class_routine');
                                        ?>
                                        <tr>
                                            <td><?php echo e(trans_choice('module_class_routine', 2)); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('panel_exam_routine');
                                        ?>
                                        <tr>
                                            <td><?php echo e(trans_choice('module_exam_routine', 2)); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('panel_attendance');
                                        ?>
                                        <tr>
                                            <td><?php echo e(trans_choice('module_attendance', 2)); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('panel_leave');
                                        ?>
                                        <tr>
                                            <td><?php echo e(trans_choice('module_apply_leave', 2)); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('panel_fees_report');
                                        ?>
                                        <tr>
                                            <td><?php echo e(trans_choice('module_fees_report', 2)); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('panel_library');
                                        ?>
                                        <tr>
                                            <td><?php echo e(trans_choice('module_library', 2)); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('panel_notice');
                                        ?>
                                        <tr>
                                            <td><?php echo e(trans_choice('module_notice', 2)); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('panel_assignment');
                                        ?>
                                        <tr>
                                            <td><?php echo e(trans_choice('module_assignment', 2)); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('panel_download');
                                        ?>
                                        <tr>
                                            <td><?php echo e(trans_choice('module_download', 2)); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('panel_transcript');
                                        ?>
                                        <tr>
                                            <td><?php echo e(trans_choice('module_transcript', 1)); ?></td>
                                            <td>
                                                <input name="ids[]" type="hidden" value="<?php echo e($field->id); ?>">

                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-<?php echo e($field->id); ?>" name="statuses[<?php echo e($field->id); ?>]" value="1" <?php if($field->status == 1): ?> checked <?php endif; ?>>
                                                    <label for="status-<?php echo e($field->id); ?>" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                            $field = field('panel_profile');
                                        ?>
                                        <tr>
                                            <td><?php echo e(trans_choice('module_profile', 2)); ?></td>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\field\panel.blade.php ENDPATH**/ ?>