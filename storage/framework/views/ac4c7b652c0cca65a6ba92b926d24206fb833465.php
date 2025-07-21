
<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('page_css'); ?>
<!-- Chart.js -->
<script src="<?php echo e(asset('dashboard/plugins/chart-chartjs/js/chart.min.js')); ?>"></script>
<style>
    .chart-container {
        height: 300px;
        width: 100%;
    }
    .search-input {
        max-width: 300px;
        margin-bottom: 15px;
    }
    .summary-card {
        margin-bottom: 20px;
    }
    .summary-value {
        font-size: 24px;
        font-weight: bold;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Outstanding Fees Report ] start -->
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
                                        <label for="fee_category" class="form-label">Fee Category</label>
                                        <select class="form-control select2" id="fee_category" name="fee_category">
                                            <option value="">All Categories</option>
                                            <?php $__currentLoopData = $feeCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>" <?php echo e(request('fee_category') == $category->id ? 'selected' : ''); ?>>
                                                    <?php echo e($category->title); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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

            <!-- Faculty Outstanding Summary -->
            <div class="col-md-6">
                <div class="card summary-card">
                    <div class="card-header">
                        <h5>Outstanding Fees by Faculty</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Faculty</th>
                                        <th>Outstanding Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $totalOutstanding = 0;
                                    ?>
                                    <?php $__currentLoopData = $facultyOutstanding; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty => $amount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($faculty); ?></td>
                                        <td>KSh <?php echo e(number_format($amount, 2)); ?></td>
                                    </tr>
                                    <?php
                                        $totalOutstanding += $amount;
                                    ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="table-primary">
                                        <td><strong>Total</strong></td>
                                        <td><strong>KSh <?php echo e(number_format($totalOutstanding, 2)); ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Outstanding Fees Distribution by Faculty</h5>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <canvas id="facultyDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Outstanding Fees -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Detailed Outstanding Fees</h5>
                        <div>
                            <button type="button" class="btn btn-success" onclick="exportToExcel()">
                                <i class="fas fa-file-excel"></i> Export to Excel
                            </button>
                            
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="mb-3">
                            <input type="text" class="form-control search-input" id="searchTable" placeholder="Search this table...">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="outstandingTable">
                                <thead>
                                    <tr>
                                        <th>Faculty</th>
                                        <th>Program</th>
                                        <th>Semester</th>
                                        <th>Fee Category</th>
                                        <th>Amount Invoiced</th>
                                        <th>Outstanding Amount</th>
                                        <th>Percentage Remaining</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $detailedOutstanding; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item['faculty']); ?></td>
                                        <td><?php echo e($item['program']); ?></td>
                                        <td><?php echo e($item['semester']); ?></td>
                                        <td><?php echo e($item['fee_category']); ?></td>
                                        <td>KSh <?php echo e(number_format($item['amount_invoiced'], 2)); ?></td>
                                        <td>KSh <?php echo e(number_format($item['outstanding_amount'], 2)); ?></td>
                                        <td><?php echo e($item['percentage_remaining']); ?>%</td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Outstanding Fees Report ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Faculty Distribution Chart
    const facultyCtx = document.getElementById('facultyDistributionChart').getContext('2d');
    const facultyData = <?php echo json_encode($facultyOutstanding, 15, 512) ?>;
    
    const facultyLabels = Object.keys(facultyData);
    const facultyValues = Object.values(facultyData);
    const facultyColors = facultyLabels.map(() => getRandomColor());
    
    new Chart(facultyCtx, {
        type: 'pie',
        data: {
            labels: facultyLabels,
            datasets: [{
                data: facultyValues,
                backgroundColor: facultyColors,
                borderColor: '#fff',
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
                },
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Faculty change event
    $('#faculty').change(function() {
        const facultyId = $(this).val();
        if (facultyId) {
            $.ajax({
                url: "<?php echo e(route('admin.get-programs')); ?>",
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

    // Search functionality
    $('#searchTable').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('#outstandingTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

function getRandomColor() {
    const colors = [
        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
        '#5a5c69', '#858796', '#dddfeb', '#3a3b45', '#2e59d9',
        '#17a673', '#2c9faf', '#dda20a', '#be2617', '#6f707e'
    ];
    return colors[Math.floor(Math.random() * colors.length)];
}

function exportToExcel() {
    // Get the filters
    const params = new URLSearchParams(window.location.search);
    
    // Redirect to export route with same filters
    window.location.href = "<?php echo e(route($route.'.export')); ?>?" + params.toString();
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/outstanding-fees/index.blade.php ENDPATH**/ ?>