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
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.transport')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="route"><?php echo e(__('field_route')); ?></label>
                                    <select class="form-control" name="route" id="route">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $transportRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transportRoute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($transportRoute->id); ?>" <?php if($selected_route == $transportRoute->id): ?> selected <?php endif; ?>><?php echo e($transportRoute->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_route')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="vehicle"><?php echo e(__('field_vehicle')); ?></label>
                                    <select class="form-control" name="vehicle" id="vehicle">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $transportVehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transportVehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($transportVehicle->id); ?>" <?php if($selected_vehicle == $transportVehicle->id): ?> selected <?php endif; ?>><?php echo e($transportVehicle->number); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_vehicle')); ?>

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
                                        <th><?php echo e(__('field_route')); ?></th>
                                        <th><?php echo e(__('field_vehicle')); ?></th>
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
                                            $total_fee = $total_fee + round($row->transportRoute->fee ?? 0, $setting->decimal_place ?? 2);
                                        ?>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td>
                                            <?php if(isset($row->transportable->student_id)): ?>
                                            <?php echo e(__('field_student_id')); ?> : 
                                            #<?php echo e($row->transportable->student_id ?? ''); ?>

                                            <?php endif; ?>
                                            <?php if(isset($row->transportable->staff_id)): ?>
                                            <?php echo e(__('field_staff_id')); ?> : 
                                            #<?php echo e($row->transportable->staff_id ?? ''); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->transportable->first_name ?? ''); ?> <?php echo e($row->transportable->last_name ?? ''); ?></td>
                                        <td><?php echo e($row->transportRoute->title ?? ''); ?></td>
                                        <td><?php echo e($row->transportVehicle->number ?? ''); ?></td>
                                        <td><?php echo e(number_format((float)$row->transportRoute->fee ?? 0, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
                                        <td>
                                            <?php if( $row->transportable->gender == 1 ): ?>
                                            <?php echo e(__('gender_male')); ?>

                                            <?php elseif( $row->transportable->gender == 2 ): ?>
                                            <?php echo e(__('gender_female')); ?>

                                            <?php elseif( $row->transportable->gender == 3 ): ?>
                                            <?php echo e(__('gender_other')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->transportable->phone ?? ''); ?></td>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\report\transport.blade.php ENDPATH**/ ?>