<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

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
                        <!-- Filter Form -->
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route .'.index')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="session"><?php echo e(__('field_session')); ?></label>
                                    <select class="form-control" name="session" id="session">
                                        <option value="0"><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($session->session_id); ?>" 
                                            <?php if($selected_session == $session->session_id): ?> selected <?php endif; ?>>
                                            <?php echo e($session->session->title); ?>

                                        </option>
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
                                        <option value="<?php echo e($semester->semester_id); ?>" 
                                            <?php if($selected_semester == $semester->semester_id): ?> selected <?php endif; ?>>
                                            <?php echo e($semester->semester->title); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_semester')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="category"><?php echo e(__('field_fees_type')); ?></label>
                                    <select class="form-control" name="category" id="category">
                                        <option value="0"><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" 
                                            <?php if($selected_category == $category->id): ?> selected <?php endif; ?>>
                                            <?php echo e($category->title); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_fees_type')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter">
                                        <i class="fas fa-search"></i> <?php echo e(__('btn_filter')); ?>

                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <?php if(!empty($invoices) && $invoices->count()): ?>
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Latest Invoices</h5>
                            <input type="text" id="invoice-search" class="form-control w-50" placeholder="Search by invoice no...">
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="invoice-table">
                                    <thead>
                                        <tr>
                                            
                                            <th>Session</th>
                                            <th>Semester</th>
                                            <th>Fee Categories</th>
                                            <th class="text-right">Total Fee</th>
                                            <th class="text-right">Amount Paid</th>
                                            <th class="text-right">Amount Due</th>
                                            <th>Assign Date</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
    // Calculate total paid amount
    $totalPaid = $invoice->payments->sum('amount');
    $amountDue = max(0, $invoice->total_fee - $totalPaid);
    
    
   
    // Get fees from relationship or direct query
    $fees = $invoice->fees ?? \App\Models\Fee::where('invoice_id', $invoice->id)->get();
    
    // Fallback query if still empty
    if ($fees->isEmpty()) {
        $fees = \App\Models\Fee::where('student_enroll_id', $invoice->student_enroll_id)
            ->where('assign_date', $invoice->assign_date)
            ->where('due_date', $invoice->due_date)
            ->get();
    }

    // Generate HTML for each fee category in separate spans
    $categoryList = $fees->map(function($fee) {
        $categoryTitle = $fee->category->title ?? 'Category #' . $fee->category_id;
        $amount = number_format($fee->category->amount ?? $fee->amount, 2);
        
        return sprintf(
            '<div class="mb-1"><span class="badge badge-info">%s (%s)</span></div>',
            $categoryTitle,
            $amount
        );
    })->implode('');

    if ($fees->isEmpty()) {
        $categoryList = '<span class="text-danger">No fees assigned</span>';
    }


    // Determine status
    if ($totalPaid >= $invoice->total_fee) {
        $status = 'Paid';
        $statusClass = 'success';
    } elseif ($totalPaid > 0) {
        $status = 'Partial';
        $statusClass = 'warning';
    } else {
        $status = 'Unpaid';
        $statusClass = 'danger';
    }
?>

                                        <tr>
                                            
                                            <td><?php echo e($invoice->studentEnroll->session->title ?? ''); ?></td>
                                            <td><?php echo e($invoice->studentEnroll->semester->title ?? ''); ?></td>
                                            <td class="d-flex flex-column">
                                                <?php echo $categoryList; ?>

                                            </td>
                                            <td class="text-right">
                                                <?php echo e(number_format($invoice->total_fee, $setting->decimal_place ?? 2)); ?> 
                                                <?php echo $setting->currency_symbol; ?>

                                            </td>
                                            <td class="text-right">
                                                <?php echo e(number_format($totalPaid, $setting->decimal_place ?? 2)); ?> 
                                                <?php echo $setting->currency_symbol; ?>

                                            </td>
                                            <td class="text-right">
                                                <?php echo e(number_format($amountDue, $setting->decimal_place ?? 2)); ?> 
                                                <?php echo $setting->currency_symbol; ?>

                                            </td>
                                            <td><?php echo e(\Carbon\Carbon::parse($invoice->assign_date)->format('d M Y')); ?></td>
                                            <td><?php echo e(\Carbon\Carbon::parse($invoice->due_date)->format('d M Y')); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($status); ?></span>
                                            </td>
                                            <td>
                                                <?php if($amountDue > 0): ?>
                                                <a href="<?php echo e(route('paymentprocess', $invoice->id)); ?>" 
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-money-bill-alt"></i> Pay
                                                </a>
                                                <?php else: ?>
                                                <span class="badge bg-success">Paid</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="card-body">
                        <div class="alert alert-info" role="alert">
                            No invoices found matching your criteria.
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Invoice search functionality
        $('#invoice-search').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#invoice-table tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/fees/index.blade.php ENDPATH**/ ?>