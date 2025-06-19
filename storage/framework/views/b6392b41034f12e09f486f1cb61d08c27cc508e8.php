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
                    </div>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="faculty"><?php echo e(__('field_faculty')); ?> <span>*</span></label>
                                    <select class="form-control faculty" name="faculty" id="faculty" required>
                                        <option value="0"><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $faculties->sortBy('title'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($faculty->id); ?>" <?php if( $selected_faculty == $faculty->id ): ?> selected <?php endif; ?>><?php echo e($faculty->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_faculty')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="program"><?php echo e(__('field_program')); ?> <span>*</span></label>
                                    <select class="form-control program" name="program" id="program" required>
                                        <option value="0"><?php echo e(__('all')); ?></option>
                                        <?php if(isset($programs)): ?>
                                        <?php $__currentLoopData = $programs->sortBy('title'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($program->id); ?>" <?php if( $selected_program == $program->id ): ?> selected <?php endif; ?>><?php echo e($program->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>

                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_program')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="subject_type"><?php echo e(__('field_subject_type')); ?></label>
                                    <select class="form-control" name="subject_type" id="subject_type">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <option value="1" <?php if( $selected_subject_type == 1 ): ?> selected <?php endif; ?>><?php echo e(__('subject_type_compulsory')); ?></option>
                                        <option value="2" <?php if( $selected_subject_type == 2 ): ?> selected <?php endif; ?>><?php echo e(__('subject_type_optional')); ?></option>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_subject_type')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="class_type"><?php echo e(__('field_class_type')); ?></label>
                                    <select class="form-control" name="class_type" id="class_type">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <option value="1" <?php if( $selected_class_type == 1 ): ?> selected <?php endif; ?>><?php echo e(__('class_type_theory')); ?></option>
                                        <option value="2" <?php if( $selected_class_type == 2 ): ?> selected <?php endif; ?>><?php echo e(__('class_type_practical')); ?></option>
                                        <option value="3" <?php if( $selected_class_type == 3 ): ?> selected <?php endif; ?>><?php echo e(__('class_type_both')); ?></option>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_class_type')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_filter')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-12">
                <div class="card">        
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_title')); ?></th>
                                        <th><?php echo e(__('field_code')); ?></th>
                                        <th><?php echo e(__('field_credit_hour_short')); ?></th>
                                        <th><?php echo e(__('field_subject_type')); ?></th>
                                        <th><?php echo e(__('field_class_type')); ?></th>
                                        <th><?php echo e(__('field_program')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($row->title); ?></td>
                                        <td><?php echo e($row->code); ?></td>
                                        <td><?php echo e($row->credit_hour); ?></td>
                                        <td>
                                            <?php if( $row->subject_type == 1 ): ?>
                                            <?php echo e(__('subject_type_compulsory')); ?>

                                            <?php elseif( $row->subject_type == 0 ): ?>
                                            <?php echo e(__('subject_type_optional')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if( $row->class_type == 1 ): ?>
                                            <?php echo e(__('class_type_theory')); ?>

                                            <?php elseif( $row->class_type == 2 ): ?>
                                            <?php echo e(__('class_type_practical')); ?>

                                            <?php elseif( $row->class_type == 3 ): ?>
                                            <?php echo e(__('class_type_both')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php $__currentLoopData = $row->programs->sortBy('title'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge badge-info"><?php echo e($program->title); ?></span>
                                                <br/>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td>
                                            <?php if( $row->status == 1 ): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('status_active')); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(__('status_inactive')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-edit')): ?>
                                            <a href="<?php echo e(route($route.'.edit', $row->id)); ?>" class="btn btn-icon btn-primary btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-delete')): ?>
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            <?php echo $__env->make('admin.layouts.inc.delete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
<script type="text/javascript">
"use strict";
$(".faculty").on('change',function(e){
    e.preventDefault();
    var program=$(".program");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type:'POST',
      url: "<?php echo e(route('filter-program')); ?>",
      data:{
        _token:$('input[name=_token]').val(),
        faculty:$(this).val()
      },
      success:function(response){
          // var jsonData=JSON.parse(response);
          $('option', program).remove();
          $('.program').append('<option value="0"><?php echo e(__("all")); ?></option>');
          $.each(response, function(){
            $('<option/>', {
              'value': this.id,
              'text': this.title
            }).appendTo('.program');
          });
        }

    });
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/subject/index.blade.php ENDPATH**/ ?>