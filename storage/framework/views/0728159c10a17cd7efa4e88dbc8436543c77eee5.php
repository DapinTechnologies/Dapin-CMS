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
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.hostel')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="hostel"><?php echo e(__('field_hostel')); ?></label>
                                    <select class="form-control" name="hostel" id="hostel">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $hostels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hostel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($hostel->id); ?>" <?php if($selected_hostel == $hostel->id): ?> selected <?php endif; ?>><?php echo e($hostel->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_hostel')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="member"><?php echo e(__('field_member')); ?></label>
                                    <select class="form-control" name="member" id="member">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <option value="1" <?php if($selected_member == 1): ?> selected <?php endif; ?>><?php echo e(__('field_student')); ?></option>
                                        <option value="2" <?php if($selected_member == 2): ?> selected <?php endif; ?>><?php echo e(__('field_staff')); ?></option>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_member')); ?>

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
                    <?php if(isset($rows)): ?>                
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="report-table" class="display table nowrap table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_member')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <th><?php echo e(__('field_hostel')); ?></th>
                                        <th><?php echo e(__('field_room')); ?> <?php echo e(__('field_no')); ?></th>
                                        <th><?php echo e(__('field_fee')); ?></th>
                                        <th><?php echo e(__('field_gender')); ?></th>
                                        <th><?php echo e(__('field_phone')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $total_fee = 0;
                                  ?>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <?php
                                            $total_fee = $total_fee + round($row->room->roomType->fee ?? 0, $setting->decimal_place ?? 2);
                                        ?>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td>
                                            <?php if(isset($row->hostelable->student_id)): ?>
                                            <?php echo e(__('field_student_id')); ?> : 
                                            #<?php echo e($row->hostelable->student_id ?? ''); ?>

                                            <?php endif; ?>
                                            <?php if(isset($row->hostelable->staff_id)): ?>
                                            <?php echo e(__('field_staff_id')); ?> : 
                                            #<?php echo e($row->hostelable->staff_id ?? ''); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->hostelable->first_name ?? ''); ?> <?php echo e($row->hostelable->last_name ?? ''); ?></td>
                                        <td><?php echo e($row->room->hostel->name ?? ''); ?></td>
                                        <td><?php echo e($row->room->name ?? ''); ?> (<?php echo e($row->room->roomType->title ?? ''); ?>)</td>
                                        <td><?php echo e(number_format((float)$row->room->roomType->fee ?? 0, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
                                        <td>
                                            <?php if( $row->hostelable->gender == 1 ): ?>
                                            <?php echo e(__('gender_male')); ?>

                                            <?php elseif( $row->hostelable->gender == 2 ): ?>
                                            <?php echo e(__('gender_female')); ?>

                                            <?php elseif( $row->hostelable->gender == 3 ): ?>
                                            <?php echo e(__('gender_other')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->hostelable->phone ?? ''); ?></td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><?php echo e(__('field_grand_total')); ?></th>
                                        <th><?php echo e(number_format((float)$total_fee, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
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
    <?php echo $__env->make('admin.report.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\report\hostel.blade.php ENDPATH**/ ?>