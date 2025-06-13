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
                        <h5><?php echo e($title); ?> <?php echo e(__('list')); ?></h5>
                    </div>
                    <div class="card-block">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-create')): ?>
                        <a href="<?php echo e(route($route.'.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> <?php echo e(__('btn_add_new')); ?></a>
                        <?php endif; ?>

                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-import')): ?>
                        <a href="<?php echo e(route($route.'.import')); ?>" class="btn btn-dark"><i class="fas fa-upload"></i> <?php echo e(__('btn_import')); ?></a>
                        <?php endif; ?>

                        <?php if(isset($rows)): ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-password-print')): ?>
                        <form class="needs-validation d-inline" novalidate method="get" action="<?php echo e(route($route.'.password-multiprint')); ?>" target="_blank">
                            <input type="hidden" name="students" class="students" value="">
                            <button type="submit" class="btn btn-sm btn-dark print-btn"><i class="fas fa-print"></i> <?php echo e(__('field_password')); ?></button>
                        </form>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">
                                <?php echo $__env->make('common.inc.student_search_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-3">
                                    <label for="status"><?php echo e(__('field_status')); ?></label>
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="0"><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status->id); ?>" <?php if( $selected_status == $status->id): ?> selected <?php endif; ?>><?php echo e($status->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_status')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="student_id"><?php echo e(__('field_student_id')); ?></label>
                                    <input type="text" class="form-control" name="student_id" id="student_id" value="<?php echo e($selected_student_id); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_student_id')); ?>

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

           <?php if(isset($rows)): ?>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">

                           <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
    <thead>
        <tr>
            <th># 
                <div class="checkbox checkbox-success d-inline">
                    <input type="checkbox" id="checkbox" class="all_select">
                    <label for="checkbox" class="cr" style="margin-bottom: 0px;"></label>
                </div>
            </th>
            <th><?php echo e(__('field_student_id')); ?></th>
            <th><?php echo e(__('field_name')); ?></th>
            <th><?php echo e(__('field_program')); ?></th>
            <th><?php echo e(__('field_session')); ?></th>
            <th><?php echo e(__('field_semester')); ?></th>
            <th><?php echo e(__('field_section')); ?></th>
            <th><?php echo e(__('field_status')); ?></th>
            <th><?php echo e(__('field_action')); ?></th>
        </tr>
    </thead>
    <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
        <thead>
            <tr>
                <th># 
                    <div class="checkbox checkbox-success d-inline">
                        <input type="checkbox" id="checkbox" class="all_select">
                        <label for="checkbox" class="cr" style="margin-bottom: 0px;"></label>
                    </div>
                </th>
                <th><?php echo e(__('field_student_id')); ?></th>
                <th><?php echo e(__('field_name')); ?></th>
                <th><?php echo e(__('field_program')); ?></th>
                <th><?php echo e(__('field_session')); ?></th>
                <th><?php echo e(__('field_semester')); ?></th>
                <th><?php echo e(__('field_section')); ?></th>
                <th><?php echo e(__('field_status')); ?></th>
                <th><?php echo e(__('field_action')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $enroll = \App\Models\Student::enroll($row->id);
            ?>
            <tr class="<?php echo e($loop->first ? 'table-success' : ''); ?>"> <!-- Highlight the latest entry -->
                <td>
                    <?php echo e($key + 1); ?>

                    <div class="checkbox checkbox-primary d-inline">
                        <input type="checkbox" data_id="<?php echo e($row->id); ?>" id="checkbox-<?php echo e($row->id); ?>" value="<?php echo e($row->id); ?>">
                        <label for="checkbox-<?php echo e($row->id); ?>" class="cr"></label>
                    </div>
                </td>
                <td>
                    <a href="<?php echo e(route($route.'.show', $row->id)); ?>">
                        #<?php echo e($row->student_id); ?>

                    </a>
                </td>
                <td><?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></td>
                <td><?php echo e($row->program->shortcode ?? ''); ?></td>
                <td><?php echo e($enroll->session->title ?? ''); ?></td>
                <td><?php echo e($enroll->semester->title ?? ''); ?></td>
                <td><?php echo e($enroll->section->title ?? ''); ?></td>
                <td>
                    <?php $__currentLoopData = $row->statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="badge badge-primary"><?php echo e($status->title); ?></span><br>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td>
                    <a href="<?php echo e(route($route.'.show', $row->id)); ?>" class="btn btn-icon btn-success btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-edit')): ?>
                    <a href="<?php echo e(route($route.'.edit', $row->id)); ?>" class="btn btn-icon btn-primary btn-sm">
                        <i class="far fa-edit"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-delete')): ?>
                    <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-<?php echo e($row->id); ?>">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <?php echo $__env->make('admin.layouts.inc.delete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    
</table>

                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
            </div>
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
    $(document).ready(function() {
        $(".print-btn").on('click',function(e){

            var numberOfChecked = $("input[data_id]:checked").length;
            if(numberOfChecked <= 0){
                e.preventDefault();
                alert("<?php echo e(__('select')); ?> <?php echo e(__('field_student')); ?>");
            }

            var students = [];
            $.each($("input[data_id]:checked"), function(){
                students.push($(this).val());
            });

            $(".students").val( students.join(',') );
        });
    });

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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/student/index.blade.php ENDPATH**/ ?>