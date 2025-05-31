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

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-import')): ?>
                        <a href="<?php echo e(route('admin.exam-attendance.import')); ?>" class="btn btn-dark btn-sm float-right"><i class="fas fa-upload"></i> <?php echo e(__('btn_import')); ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">
                                <?php echo $__env->make('common.inc.subject_search_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-3">
                                    <label for="type"><?php echo e(__('field_type')); ?> <span>*</span></label>
                                    <select class="form-control" name="type" id="type" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->id); ?>" <?php if( $selected_type == $type->id): ?> selected <?php endif; ?>><?php echo e($type->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_type')); ?>

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
                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <?php if(isset($rows)): ?>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover printable">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_student_id')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <?php if(isset($rows)): ?>
                                        <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($loop->first): ?>
                                        <?php
                                            $max_marks = $row->type->marks;
                                        ?>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <th>
                                            <?php echo e(__('field_max_marks')); ?>

                                            <?php if(isset($max_marks)): ?>
                                             (<?php echo e(round($max_marks, 2)); ?>)
                                            <?php endif; ?>
                                        </th>
                                        <th><?php echo e(__('field_note')); ?></th>
                                        
                                        
                                        <th><?php echo e(__('field_semester')); ?></th>
                                        <th><?php echo e(__('field_section')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <input type="hidden" name="exams[<?php echo e($key); ?>]" value="<?php echo e($row->id); ?>">
                                    <tr>
                                        <td>
                                            <?php if(isset($row->studentEnroll->student->student_id)): ?>
                                            <a href="<?php echo e(route('admin.student.show', $row->studentEnroll->student->id)); ?>">
                                            #<?php echo e($row->studentEnroll->student->student_id ?? ''); ?>

                                            </a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->studentEnroll->student->first_name ?? ''); ?> <?php echo e($row->studentEnroll->student->last_name ?? ''); ?></td>
                                        <td>
                                            <input type="text" class="form-control" name="marks[<?php echo e($key); ?>]" id="marks" value="<?php echo e($row->achieve_marks ? round($row->achieve_marks, 2) : ''); ?>" style="width: 100px;" data-v-max="<?php echo e($max_marks); ?>" data-v-min="0">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="notes[<?php echo e($key); ?>]" id="notes" value="<?php echo e($row->note); ?>" style="width: 100px;">
                                        </td>
                                        
                                        
                                        <td><?php echo e($row->studentEnroll->semester->title ?? ''); ?></td>
                                        <td><?php echo e($row->studentEnroll->section->title ?? ''); ?></td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>

                                <caption><?php echo e($row->subject->code ?? ''); ?> - <?php echo e($row->type->title ?? ''); ?> - <?php echo e($row->studentEnroll->session->title ?? ''); ?></caption>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>

                    <?php if(count($rows) > 0): ?>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success update"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                    </div>
                    <?php endif; ?>

                    <?php if(count($rows) < 1): ?>
                    <div class="card-block">
                        <h5><?php echo e(__('no_result_found')); ?></h5>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\exam\marking.blade.php ENDPATH**/ ?>