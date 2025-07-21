
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
            <!-- [ Bursary Report ] start -->
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
                                        <label for="reconciled" class="form-label">Reconciliation Status</label>
                                        <select class="form-control" id="reconciled" name="reconciled">
                                            <option value="">All</option>
                                            <option value="1" <?php echo e(request('reconciled') == '1' ? 'selected' : ''); ?>>Reconciled</option>
                                            <option value="0" <?php echo e(request('reconciled') == '0' ? 'selected' : ''); ?>>Not Reconciled</option>
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
                        <h5>Bursary by Faculty</h5>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <canvas id="facultyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Bursary by Type</h5>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <canvas id="typeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Reconciliation Status</h5>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <canvas id="reconciliationChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bursary List -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Bursary Details</h5>
                        <div class="total-bursary">
                            <strong>Total Bursary: KSh <?php echo e(number_format($bursaries->sum('amount'), 2)); ?></strong>
                        </div>
                        <button type="button" class="btn btn-success float-end" onclick="exportToExcel()">
                                        <i class="fas fa-file-excel"></i> Export to Excel
                                    </button>
                    </div>
                    <div class="card-block">
                        <?php if(count($bursaries) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Faculty</th>
                                        <th>Program</th>
                                        <th>Semester</th>
                                        <th>Amount</th>
                                        <th>Bursary Type</th>
                                        <th>Payment Date</th>
                                        <th>Reconciled</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $bursaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $bursary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($bursary->student_id); ?></td>
                                        <td><?php echo e($bursary->first_name); ?> <?php echo e($bursary->last_name); ?></td>
                                        <td><?php echo e($bursary->faculty_title); ?></td>
                                        <td><?php echo e($bursary->program_title); ?></td>
                                        <td><?php echo e($bursary->semester_title); ?></td>
                                        <td>KSh <?php echo e(number_format($bursary->amount, 2)); ?></td>
                                        <td><?php echo e($bursary->bursary_type ?? 'N/A'); ?></td>
                                        <td><?php echo e($bursary->paid_at); ?></td>
                                        <td>
                                            <?php if($bursary->is_reconciled): ?>
                                                <span class="badge bg-success">Yes</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">No</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($bursary->bursary_notes ?? 'N/A'); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-info">No bursary records found matching your criteria.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- [ Bursary Report ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Faculty Chart
    const facultyCtx = document.getElementById('facultyChart').getContext('2d');
    new Chart(facultyCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($bursaryByFaculty->pluck('faculty'), 15, 512) ?>,
            datasets: [{
                label: 'Bursary Amount (KSh)',
                data: <?php echo json_encode($bursaryByFaculty->pluck('total_amount'), 15, 512) ?>,
                backgroundColor: '#04a9f5',
                borderColor: '#038fcf',
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

    // Type Chart
    const typeCtx = document.getElementById('typeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($bursaryByType->pluck('bursary_type'), 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($bursaryByType->pluck('total_amount'), 15, 512) ?>,
                backgroundColor: [
                    '#1de9b6',
                    '#f4c22b',
                    '#f44236',
                    '#a389d4',
                    '#04a9f5'
                ],
                borderColor: [
                    '#14cc9e',
                    '#ecb50c',
                    '#f22012',
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

    // Reconciliation Chart
    const reconCtx = document.getElementById('reconciliationChart').getContext('2d');
    new Chart(reconCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($reconciliationStatus->pluck('status'), 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($reconciliationStatus->pluck('count'), 15, 512) ?>,
                backgroundColor: [
                    '#1de9b6',
                    '#f4c22b'
                ],
                borderColor: [
                    '#14cc9e',
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
                            return `${label}: ${value} (${percentage}%)`;
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

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/bursary-report/index.blade.php ENDPATH**/ ?>