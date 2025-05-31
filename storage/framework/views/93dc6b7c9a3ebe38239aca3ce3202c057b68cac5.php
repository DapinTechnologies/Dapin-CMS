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
            <?php if(count($rows) > 0): ?>
            <div class="col-sm-12">
                <form action="<?php echo e(route($route.'.store')); ?>" class="needs-validation" novalidate method="post">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-block">
                        <input type="text" name="faculty" value="<?php echo e($selected_faculty); ?>" hidden>
                        <input type="text" name="program" value="<?php echo e($selected_program); ?>" hidden>
                        <input type="text" name="session" value="<?php echo e($selected_session); ?>" hidden>
                        <input type="text" name="semester" value="<?php echo e($selected_semester); ?>" hidden>
                        <input type="text" name="section" value="<?php echo e($selected_section); ?>" hidden>


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
                                        <th><?php echo e(__('field_credit_hour_short')); ?></th>
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
                                                <input type="checkbox" name="students[]" id="checkbox-<?php echo e($row->id); ?>" value="<?php echo e($row->id); ?>" checked>
                                                <label for="checkbox-<?php echo e($row->id); ?>" class="cr"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.student.show', $row->student->id)); ?>">
                                            #<?php echo e($row->student->student_id ?? ''); ?>

                                            </a>
                                        </td>
                                        <td>
                                            <?php
                                                $total_credits = 0;
                                                foreach($row->subjects as $subject){
                                                    $total_credits = $total_credits + $subject->credit_hour;
                                                }
                                            ?>
                                            <?php echo e($total_credits); ?>

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
                    </div>
                </div>

                <div class="card">
                    <div class="card-block">
                        <div class="row">
                          <div class="form-group col-md-4">
                            <label for="category"><?php echo e(__('field_fees_type')); ?> <span>*</span></label>
                            <select class="form-control" name="category" id="category" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php if(old('category') == $category->id): ?> selected <?php endif; ?>><?php echo e($category->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_fees_type')); ?>

                            </div>
                          </div>

                          <div class="form-group col-md-4">
                            <label for="assign_date" class="form-label"><?php echo e(__('field_assign')); ?> <?php echo e(__('field_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control" name="assign_date" id="assign_date" value="<?php echo e(date('Y-m-d')); ?>" readonly required>

                            <div class="invalid-feedback">
                                <?php echo e(__('required_field')); ?> <?php echo e(__('field_assign')); ?> <?php echo e(__('field_date')); ?>

                            </div>
                          </div>

                          <div class="form-group col-md-4">
                            <label for="due_date" class="form-label"><?php echo e(__('field_due_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="due_date" id="due_date" value="<?php echo e(date('Y-m-d')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_due_date')); ?>

                            </div>
                          </div>

                          <div class="form-group col-md-4">
                            <label for="amount" class="form-label"><?php echo e(__('field_amount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="amount" id="amount" value="<?php echo e(old('amount')); ?>" required>

                            <div class="invalid-feedback">
                                <?php echo e(__('required_field')); ?> <?php echo e(__('field_amount')); ?>

                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label><?php echo e(__('field_amount_type')); ?></label><br/>
                            <div class="radio d-inline">
                                <input type="radio" name="type" id="type_fixed" value="1" <?php if( old('type') == null ): ?> checked <?php elseif( old('type') == 1 ): ?>  checked <?php endif; ?>>
                                <label for="type_fixed" class="cr"><?php echo e(__('amount_type_fixed')); ?></label>
                            </div>
                            <div class="radio d-inline">
                                <input type="radio" name="type" id="type_per_credit" value="2" <?php if( old('type') == 2 ): ?> checked <?php endif; ?>>
                                <label for="type_per_credit" class="cr"><?php echo e(__('amount_type_per_credit')); ?></label>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal">
                            <i class="fas fa-check"></i> <?php echo e(__('btn_assign')); ?>

                        </button>
                        <!-- Include Confirm modal -->
                        <?php echo $__env->make($view.'.confirm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                </form>
            </div>
            <?php endif; ?>
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
// checkbox all-check-button selector
$(".all_select").on('click',function(e){
    if($(this).is(":checked")){
        // check all checkbox
        $("input:checkbox").prop('checked', true);
    }
    else if($(this).is(":not(:checked)")){
        // uncheck all checkbox
        $("input:checkbox").prop('checked', false);
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\fees-master\create.blade.php ENDPATH**/ ?>