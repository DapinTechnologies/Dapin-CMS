
<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('page_css'); ?>
<!-- Chart.js -->
<script src="<?php echo e(asset('dashboard/plugins/chart-chartjs/js/chart.min.js')); ?>"></script>
<style>
    .chart-container {
        height: 300px;
        width: 100%;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Fines & Discounts Report ] start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <!-- Filters -->
                        <form method="GET" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="faculty" class="form-label">Faculty</label>
                                        <select class="form-control select2" id="faculty" name="faculty">
                                            <option value="">All Faculties</option>
                                            <?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($faculty->id); ?>" <?php echo e(request('faculty') == $faculty->id ? 'selected' : ''); ?>>
                                                    <?php echo e($faculty->title); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="program" class="form-label">Program</label>
                                        <select class="form-control select2" id="program" name="program">
                                            <option value="">All Programs</option>
                                            <?php if(request('faculty')): ?>
                                                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($program->faculty_id == request('faculty')): ?>
                                                    <option value="<?php echo e($program->id); ?>" <?php echo e(request('program') == $program->id ? 'selected' : ''); ?>>
                                                        <?php echo e($program->title); ?>

                                                    </option>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="semester" class="form-label">Semester</label>
                                        <select class="form-control select2" id="semester" name="semester">
                                            <option value="">All Semesters</option>
                                            <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($semester->id); ?>" <?php echo e(request('semester') == $semester->id ? 'selected' : ''); ?>>
                                                    <?php echo e($semester->title); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="adjustment_type" class="form-label">Adjustment Type</label>
                                        <select class="form-control" id="adjustment_type" name="adjustment_type">
                                            <option value="">All</option>
                                            <option value="discount" <?php echo e(request('adjustment_type') == 'discount' ? 'selected' : ''); ?>>Discounts</option>
                                            <option value="fine" <?php echo e(request('adjustment_type') == 'fine' ? 'selected' : ''); ?>>Fines</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="student_name" class="form-label">Student Name</label>
                                        <input type="text" class="form-control" id="student_name" name="student_name" value="<?php echo e(request('student_name')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="student_id" class="form-label">Student ID</label>
                                        <input type="text" class="form-control" id="student_id" name="student_id" value="<?php echo e(request('student_id')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo e(request('start_date')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo e(request('end_date')); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-secondary">Reset</a>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Discounts vs Fines</h5>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <canvas id="discountsVsFinesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Discounts by Faculty</h5>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <canvas id="discountsByFacultyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Fines by Faculty</h5>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <canvas id="finesByFacultyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice List -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Fines & Discounts Details</h5>
                        <div class="totals">
                            <strong>Total Discounts: KSh <?php echo e(number_format($invoices->sum('discount_amount'), 2)); ?></strong> | 
                            <strong>Total Fines: KSh <?php echo e(number_format($invoices->sum('fine_amount'), 2)); ?></strong>
                        </div>
                        <button type="button" class="btn btn-success float-end" onclick="exportToExcel()">
                                        <i class="fas fa-file-excel"></i> Export to Excel
                                    </button>
                    </div>
                    <div class="card-block">
                        <?php if(count($invoices) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice No</th>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Faculty</th>
                                        <th>Program</th>
                                        <th>Semester</th>
                                        <th>Total Fee</th>
                                        <th>Discount</th>
                                        <th>Fine</th>
                                        <th>Adjustment Type</th>
                                        <th>Notes</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($invoice->invoice_no); ?></td>
                                        <td><?php echo e($invoice->student_id); ?></td>
                                        <td><?php echo e($invoice->first_name); ?> <?php echo e($invoice->last_name); ?></td>
                                        <td><?php echo e($invoice->faculty_title); ?></td>
                                        <td><?php echo e($invoice->program_title); ?></td>
                                        <td><?php echo e($invoice->semester_title); ?></td>
                                        <td>KSh <?php echo e(number_format($invoice->total_fee, 2)); ?></td>
                                        <td class="<?php echo e($invoice->discount_amount > 0 ? 'text-success' : ''); ?>">
                                            KSh <?php echo e(number_format($invoice->discount_amount, 2)); ?>

                                        </td>
                                        <td class="<?php echo e($invoice->fine_amount > 0 ? 'text-danger' : ''); ?>">
                                            KSh <?php echo e(number_format($invoice->fine_amount, 2)); ?>

                                        </td>
                                        <td>
                                            <?php if($invoice->adjustment_type): ?>
                                                <span class="badge bg-<?php echo e($invoice->adjustment_type == 'discount' ? 'success' : 'danger'); ?>">
                                                    <?php echo e(ucfirst($invoice->adjustment_type)); ?>

                                                </span>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($invoice->adjustment_notes ?? 'N/A'); ?></td>
                                        <td><?php echo e($invoice->assign_date); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-info">No records found matching your criteria.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- [ Fines & Discounts Report ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Discounts vs Fines Chart
    const dvfCtx = document.getElementById('discountsVsFinesChart').getContext('2d');
    new Chart(dvfCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($discountsVsFines->pluck('type'), 15, 512) ?>,
            datasets: [{
                label: 'Amount (KSh)',
                data: <?php echo json_encode($discountsVsFines->pluck('total_amount'), 15, 512) ?>,
                backgroundColor: [
                    '#1de9b6',
                    '#f44236'
                ],
                borderColor: [
                    '#14cc9e',
                    '#f22012'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'KSh ' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'KSh ' + context.raw.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Discounts by Faculty Chart
    const dbfCtx = document.getElementById('discountsByFacultyChart').getContext('2d');
    new Chart(dbfCtx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($discountsByFaculty->pluck('faculty'), 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($discountsByFaculty->pluck('total_amount'), 15, 512) ?>,
                backgroundColor: [
                    '#1de9b6',
                    '#04a9f5',
                    '#a389d4',
                    '#f4c22b'
                ],
                borderColor: [
                    '#14cc9e',
                    '#038fcf',
                    '#8e6cc4',
                    '#ecb50c'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: KSh ${value.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Fines by Faculty Chart
    const fbfCtx = document.getElementById('finesByFacultyChart').getContext('2d');
    new Chart(fbfCtx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($finesByFaculty->pluck('faculty'), 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($finesByFaculty->pluck('total_amount'), 15, 512) ?>,
                backgroundColor: [
                    '#f44236',
                    '#f4c22b',
                    '#a389d4',
                    '#04a9f5'
                ],
                borderColor: [
                    '#f22012',
                    '#ecb50c',
                    '#8e6cc4',
                    '#038fcf'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: KSh ${value.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Faculty change event
    $('#faculty').change(function() {
        const facultyId = $(this).val();
        if (facultyId) {
            $.ajax({
                url: "<?php echo e(route($route.'.get-programs')); ?>",
                type: "GET",
                data: { faculty_id: facultyId },
                success: function(data) {
                    $('#program').empty();
                    $('#program').append('<option value="">All Programs</option>');
                    $.each(data, function(key, value) {
                        $('#program').append('<option value="'+key+'">'+value+'</option>');
                    });
                }
            });
        } else {
            $('#program').empty();
            $('#program').append('<option value="">All Programs</option>');
        }
    });
});

function exportToExcel() {
    // Get the filters
    const params = new URLSearchParams(window.location.search);
    
    // Redirect to export route with same filters
    window.location.href = "<?php echo e(route($route.'.export')); ?>?" + params.toString();
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/fines-discounts-report/index.blade.php ENDPATH**/ ?>