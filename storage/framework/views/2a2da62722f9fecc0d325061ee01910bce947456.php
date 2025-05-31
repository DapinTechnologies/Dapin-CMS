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
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-print')): ?>
                        <form class="needs-validation d-inline" novalidate method="get" action="<?php echo e(route($route.'.multitoken.print')); ?>" target="_blank">
                            <input type="hidden" name="books" class="books" value="">
                            <button type="submit" class="btn btn-sm btn-dark print-btn"><i class="fas fa-print"></i> <?php echo e(__('btn_print')); ?> <?php echo e(__('field_selected')); ?></button>
                        </form>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="category"><?php echo e(__('field_category')); ?></label>
                                    <select class="form-control" name="category" id="category">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php if($selected_category == $category->id): ?> selected <?php endif; ?>><?php echo e($category->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_category')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="title"><?php echo e(__('field_title')); ?></label>
                                    <input type="text" class="form-control" name="title" id="title" value="<?php echo e($selected_title); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

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
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="checkbox checkbox-success d-inline">
                                                <input type="checkbox" id="checkbox" class="all_select">
                                                <label for="checkbox" class="cr" style="margin-bottom: 0px;"></label>
                                            </div>
                                        </th>
                                        <th><?php echo e(__('field_title')); ?></th>
                                        <th><?php echo e(__('field_isbn')); ?></th>
                                        <th><?php echo e(__('field_category')); ?></th>
                                        <th><?php echo e(__('field_author')); ?></th>
                                        <th><?php echo e(__('field_location')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="checkbox checkbox-primary d-inline">
                                                <input type="checkbox" data_id="<?php echo e($row->id); ?>" id="checkbox-<?php echo e($row->id); ?>" value="<?php echo e($row->id); ?>">
                                                <label for="checkbox-<?php echo e($row->id); ?>" class="cr"></label>
                                            </div>
                                        </td>
                                        <td><?php echo e($row->title); ?></td>
                                        <td><?php echo e($row->isbn); ?></td>
                                        <td><?php echo e($row->category->title ?? ''); ?></td>
                                        <td><?php echo e($row->author); ?></td>
                                        <td>
                                            <?php echo e(__('field_rack')); ?>: <?php echo e($row->section); ?> <br> <?php echo e(__('field_column')); ?>: <?php echo e($row->column); ?> <br> <?php echo e(__('field_row')); ?>: <?php echo e($row->row); ?>

                                        </td>
                                        <td>
                                            <?php if( $row->status == 1 ): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('status_available')); ?></span>
                                            <?php elseif( $row->status == 2 ): ?>
                                            <span class="badge badge-pill badge-warning"><?php echo e(__('status_damage')); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(__('status_lost')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-print')): ?>
                                            <a href="#" class="btn btn-dark btn-sm" onclick="PopupWin('<?php echo e(route($route.'.token.print', $row->id)); ?>', '<?php echo e($title); ?>', 800, 500);">
                                                <i class="fas fa-print"></i> <?php echo e(__('field_token')); ?>

                                            </a>
                                            <?php endif; ?>
                                            
                                            <button type="button" class="btn btn-icon btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#showModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <!-- Include Show modal -->
                                            <?php echo $__env->make($view.'.show', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
    $(document).ready(function() {
        $(".print-btn").on('click',function(e){

            var numberOfChecked = $("input[data_id]:checked").length;
            if(numberOfChecked <= 0){
                e.preventDefault();
                alert("<?php echo e(__('select')); ?> <?php echo e(__('field_book')); ?>");
            }

            var books = [];
            $.each($("input[data_id]:checked"), function(){
                books.push($(this).val());
            });

            $(".books").val( books.join(',') );
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\book\index.blade.php ENDPATH**/ ?>