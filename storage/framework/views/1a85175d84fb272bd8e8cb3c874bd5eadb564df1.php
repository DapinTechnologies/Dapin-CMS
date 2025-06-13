
<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- Program Performance Summary -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Program Performance Summary</h5>
                    </div>
                    <div class="card-block">
                        <div class="row">
                           <!-- Current Average -->
<div class="col-md-4">
    <div class="card bg-info text-white"> <!-- Changed bg-primary to bg-info -->
        <div class="card-body">
            <h6 class="card-title text-white">Current Average</h6>
<h2 class="card-text text-white">
    <?php echo e($current_average); ?>% 
    <i class="fas fa-arrow-up text-white"></i>
</h2>

            <p class="card-text">Latest semester performance</p>
        </div>
    </div>
</div>

                            <!-- Historical Average -->
                            <div class="col-md-4">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h6 class="card-title text-white">Historical Average</h6>
<h2 class="card-text text-white"><?php echo e($historical_average); ?>%</h2>
<p class="card-text text-white">All semesters combined</p>

                                    </div>
                                </div>
                            </div>

                            <!-- Last Three Results -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Last Three Results</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <?php $__currentLoopData = $last_three_results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <?php echo e($result['semester']); ?>

                                                <span class="badge bg-primary rounded-pill"><?php echo e($result['average']); ?>%</span>
                                            </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           <!-- Top Performing Students -->
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5>Top Performing Students</h5>
        </div>
        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Program</th> <!-- Added Program Column -->
                            <th>Total Marks</th>
                            <th>Average Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $top_students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td><?php echo e($student->student_id); ?></td>
                            <td><?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></td>
                            <td><?php echo e($student->program ?? 'N/A'); ?></td> <!-- Display program or fallback to 'N/A' -->
                            <td><?php echo e($student->total_marks); ?></td>
                            <td><?php echo e(round($student->avg_percentage, 2)); ?>%</td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

            <!-- Performance Graphs -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Performance Analytics</h5>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <!-- Program Performance Graph -->
                            <div class="col-md-6">
                                <div class="chart-container" style="position: relative; height:400px;">
                                    <canvas id="programPerformanceChart"></canvas>
                                </div>
                            </div>

                            <!-- Grade Distribution Graph -->
                            <div class="col-md-6">
                                <div class="chart-container" style="position: relative; height:400px;">
                                    <canvas id="gradeDistributionChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Program Performance Chart
    const programCtx = document.getElementById('programPerformanceChart').getContext('2d');
    const programChart = new Chart(programCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($program_performance_data['labels'], 15, 512) ?>,
            datasets: [{
                label: 'Average Performance (%)',
                data: <?php echo json_encode($program_performance_data['data'], 15, 512) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Average Score (%)'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Program Performance Comparison'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw + '%';
                        }
                    }
                }
            }
        }
    });

    // Grade Distribution Chart
    const gradeCtx = document.getElementById('gradeDistributionChart').getContext('2d');
    const gradeChart = new Chart(gradeCtx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($average_grades_data['labels'], 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($average_grades_data['data'], 15, 512) ?>,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Grade Distribution'
                },
                legend: {
                    position: 'right',
                },
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
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/result3-repo/index.blade.php ENDPATH**/ ?>