
<?php $__env->startSection('title', 'School Fee Summary'); ?>
<?php $__env->startSection('content'); ?>

<h4>School Fee Breakdown Summary</h4>

<canvas id="feeChart" width="600" height="400"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('feeChart').getContext('2d');

const data = {
    labels: ['Assigned Fees', 'Paid Fees', 'Due Fees'],
    datasets: [{
        label: 'Ksh',
        data: [<?php echo e($totalAssigned); ?>, <?php echo e($totalPaid); ?>, <?php echo e($totalDue); ?>],
        backgroundColor: [
            'rgba(54, 162, 235, 0.7)',    // Assigned - Blue
            'rgba(75, 192, 192, 0.7)',    // Paid - Greenish
            'rgba(255, 99, 132, 0.7)'     // Due - Red
        ],
        borderColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(255, 99, 132, 1)'
        ],
        borderWidth: 1
    }]
};

const feeChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\fees-student\fees-summary.blade.php ENDPATH**/ ?>