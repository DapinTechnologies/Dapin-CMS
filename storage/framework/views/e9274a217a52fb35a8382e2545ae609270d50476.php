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
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">

                                <?php echo $__env->make('common.inc.fees_search_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-3">
                                    <label for="category"><?php echo e(__('field_fees_type')); ?> <span>*</span></label>
                                    <select class="form-control" name="category" id="category">
                                        <option value="0"><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php if( $selected_category == $category->id): ?> selected <?php endif; ?>><?php echo e($category->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_fees_type')); ?>

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

            <div class="col-sm-12">
                <div class="card">
                    <?php if(isset($rows)): ?>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_student_id')); ?></th>
                                        <th><?php echo e(__('field_fees_type')); ?></th>
                                        <th><?php echo e(__('field_fee')); ?></th>
                                        <th><?php echo e(__('field_discount')); ?></th>
                                        <th><?php echo e(__('field_fine_amount')); ?></th>
                                        <th><?php echo e(__('field_net_amount')); ?></th>
                                        <th><?php echo e(__('field_due_date')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td>
                                            <?php if(isset($row->studentEnroll->student->student_id)): ?>
                                            <a href="<?php echo e(route('admin.student.show', $row->studentEnroll->student->id)); ?>">
                                            #<?php echo e($row->studentEnroll->student->student_id ?? ''); ?>

                                            </a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->category->title ?? ''); ?></td>
                                        <td>
                                            <?php if(isset($setting->decimal_place)): ?>
                                            <?php echo e(number_format((float)$row->fee_amount, $setting->decimal_place, '.', '')); ?> 
                                            <?php else: ?>
                                            <?php echo e(number_format((float)$row->fee_amount, 2, '.', '')); ?> 
                                            <?php endif; ?> 
                                            <?php echo $setting->currency_symbol; ?>

                                        </td>
                                        <td>
                                            <?php 
                                            $discount_amount = 0;
                                            $today = date('Y-m-d');
                                            ?>

                                            <?php if(isset($row->category)): ?>
                                            <?php $__currentLoopData = $row->category->discounts->where('status', '1'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <?php
                                            $availability = \App\Models\FeesDiscount::availability($discount->id, $row->studentEnroll->student_id);
                                            ?>

                                            <?php if(isset($availability)): ?>
                                            <?php if($discount->start_date <= $today && $discount->end_date >= $today): ?>
                                                <?php if($discount->type == '1'): ?>
                                                    <?php
                                                    $discount_amount = $discount_amount + $discount->amount;
                                                    ?>
                                                <?php else: ?>
                                                    <?php
                                                    $discount_amount = $discount_amount + ( ($row->fee_amount / 100) * $discount->amount);
                                                    ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>


                                            <?php if(isset($setting->decimal_place)): ?>
                                            <?php echo e(number_format((float)$discount_amount, $setting->decimal_place, '.', '')); ?> 
                                            <?php else: ?>
                                            <?php echo e(number_format((float)$discount_amount, 2, '.', '')); ?> 
                                            <?php endif; ?> 
                                            <?php echo $setting->currency_symbol; ?>

                                        </td>
                                        <td>
                                            <?php
                                                $fine_amount = 0;
                                            ?>
                                            <?php if(empty($row->pay_date) || $row->due_date < $row->pay_date): ?>
                                                
                                                <?php
                                                $due_date = strtotime($row->due_date);
                                                $today = strtotime(date('Y-m-d')); 
                                                $days = (int)(($today - $due_date)/86400);
                                                ?>

                                                <?php if($row->due_date < date("Y-m-d")): ?>

                                                <?php if(isset($row->category)): ?>
                                                <?php $__currentLoopData = $row->category->fines->where('status', '1'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($fine->start_day <= $days && $fine->end_day >= $days): ?>
                                                    <?php if($fine->type == '1'): ?>
                                                        <?php
                                                        $fine_amount = $fine_amount + $fine->amount;
                                                        ?>
                                                    <?php else: ?>
                                                        <?php
                                                        $fine_amount = $fine_amount + ( ($row->fee_amount / 100) * $fine->amount);
                                                        ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>


                                            <?php if(isset($setting->decimal_place)): ?>
                                            <?php echo e(number_format((float)$fine_amount, $setting->decimal_place, '.', '')); ?> 
                                            <?php else: ?>
                                            <?php echo e(number_format((float)$fine_amount, 2, '.', '')); ?> 
                                            <?php endif; ?> 
                                            <?php echo $setting->currency_symbol; ?>

                                        </td>
                                        <td>
                                            <?php
                                            $net_amount = ($row->fee_amount - $discount_amount) + $fine_amount;
                                            ?>

                                            <?php if(isset($setting->decimal_place)): ?>
                                            <?php echo e(number_format((float)$net_amount, $setting->decimal_place, '.', '')); ?> 
                                            <?php else: ?>
                                            <?php echo e(number_format((float)$net_amount, 2, '.', '')); ?> 
                                            <?php endif; ?> 
                                            <?php echo $setting->currency_symbol; ?>

                                        </td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->due_date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->due_date))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($row->status == 1): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('status_paid')); ?></span>
                                            <?php elseif($row->status == 2): ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(__('status_canceled')); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-primary"><?php echo e(__('status_pending')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($row->status == 0): ?>
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#payModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <!-- Include Pay modal -->
                                            <?php echo $__env->make($view.'.pay', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-action')): ?>
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" title="<?php echo e(__('status_canceled')); ?>" data-bs-toggle="modal" data-bs-target="#cancelModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <!-- Include Unpay modal -->
                                            <?php echo $__env->make($view.'.cancel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endif; ?>

                                            <?php elseif($row->status == 1): ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-print')): ?>
                                            <?php if(isset($print)): ?>
                                            <a href="<?php echo e(route($route.'.print', ['id' => $row->id])); ?>" target="_blank" class="btn btn-icon btn-dark btn-sm">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-action')): ?>
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" title="<?php echo e(__('status_unpaid')); ?>" data-bs-toggle="modal" data-bs-target="#unpayModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                            <!-- Include Unpay modal -->
                                            <?php echo $__env->make($view.'.unpay', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
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
<?php if(isset($print)): ?>
<?php if(\Session::has('receipt')): ?>
<script type="text/javascript">
    PopupWin('<?php echo e(route($route.'.print', ['id' => \Session::get('receipt')])); ?>', '<?php echo e($title); ?>', 1000, 600);
</script>
<?php endif; ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\fees-student\index.blade.php ENDPATH**/ ?>