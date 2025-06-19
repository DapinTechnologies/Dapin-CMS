<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <!-- Notification for Bank Payment Details -->
                      

                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route .'.index')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="session"><?php echo e(__('field_session')); ?></label>
                                    <select class="form-control" name="session" id="session">
                                        <option value="0"><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($session->session_id); ?>" <?php if( $selected_session == $session->session_id): ?> selected <?php endif; ?>><?php echo e($session->session->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_session')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="semester"><?php echo e(__('field_semester')); ?></label>
                                    <select class="form-control" name="semester" id="semester">
                                        <option value="0"><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($semester->semester_id); ?>" <?php if( $selected_semester == $semester->semester_id): ?> selected <?php endif; ?>><?php echo e($semester->semester->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_semester')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="category"><?php echo e(__('field_fees_type')); ?></label>
                                    <select class="form-control" name="category" id="category" required>
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
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_filter')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-block">
                        
                        <!-- [ Data table ] start -->
                        <?php if(isset($rows)): ?>
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center"><?php echo e(__('field_session')); ?></th>
                                        <th class="text-center"><?php echo e(__('field_semester')); ?></th>
                                        <th class="text-center"><?php echo e(__('field_fees_type')); ?></th>
                                        <th class="text-right"><?php echo e(__('field_fee')); ?></th>
                                        <th class="text-right"><?php echo e(__('field_paid_amount')); ?></th>
                                        <th class="text-right"><?php echo e(__('Due Amount')); ?></th>
                                        <th class="text-center"><?php echo e(__('field_due_date')); ?></th>
                                        <th class="text-center"><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <!-- Serial Number -->
                                        <td class="text-center"><?php echo e($key + 1); ?></td>
                            
                                        <!-- Session and Semester -->
                                        <td class="text-center"><?php echo e($row->studentEnroll->session->title ?? ''); ?></td>
                                        <td class="text-center"><?php echo e($row->studentEnroll->semester->title ?? ''); ?></td>
                            
                                        <!-- Fees Type -->
                                        <td class="text-center"><?php echo e($row->category->title ?? ''); ?></td>
                            
                                        <!-- Total Fee -->
                                        <td class="text-right">
                                            <?php echo e(number_format((float)$row->fee_amount, $setting->decimal_place ?? 2, '.', '')); ?> <?php echo $setting->currency_symbol; ?>

                                        </td>
                            
                                        <!-- Paid Amount -->
                                        <td class="text-right">
                                            <?php echo e(number_format($row->paid_amount, $setting->decimal_place ?? 2, '.', '')); ?> <?php echo $setting->currency_symbol; ?>

                                        </td>
                            
                                        <!-- Due Amount -->
                                        <td class="text-right">
                                            <?php
                                                $dueAmount = max(0, $row->fee_amount - $row->paid_amount);
                                            ?>
                                            <?php echo e(number_format($dueAmount, $setting->decimal_place ?? 2, '.', '')); ?> <?php echo $setting->currency_symbol; ?>

                                        </td>
                            
                                        <!-- Due Date -->
                                        <td class="text-center">
                                            <?php if($row->due_date != '1970-01-01'): ?>
                                                <?php echo e(date($setting->date_format ?? "Y-m-d", strtotime($row->due_date))); ?>

                                            <?php endif; ?>
                                        </td>
                            
                                        <!-- Action -->
                                        <td class="text-center">
                                            <?php
                                            $queryData = [
                                                'fee_id' => $row->id,
                                                'student_id' => Auth::user()->id,
                                                'fee_category_id' => $row->category->id ?? '',
                                                'due_date' => $row->due_date ?? '',
                                                'fee_amount' => $row->fee_amount,
                                                'paid_amount' => $row->paid_amount ?? 0,
                                                'phone_number' => Auth::user()->phone,
                                            ];
                                            $queryString = http_build_query($queryData);
                                        ?>
                                        
                                        <a href="<?php echo e(route('paymentprocess', $row->id)); ?>?<?php echo e($queryString); ?>" 
                                           class="btn btn-success" 
                                           style="padding: 4px 8px; font-size: 12px;">
                                            <i class="fas fa-money-bill-alt"></i> <?php echo e(__('Pay')); ?>

                                        </a>
                                        
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            
                            
                            
                                
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#basic-table').DataTable();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/fees/index.blade.php ENDPATH**/ ?>