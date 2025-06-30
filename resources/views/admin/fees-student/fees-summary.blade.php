@extends('admin.layouts.master')
@section('title', 'School Fee Summary')
@section('content')

<h4>School Fee Breakdown Summary</h4>

<canvas id="feeChart" width="600" height="400"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('feeChart').getContext('2d');

const data = {
    labels: ['Assigned Fees', 'Paid Fees', 'Due Fees'],
    datasets: [{
        label: 'Ksh',
        data: [{{ $totalAssigned }}, {{ $totalPaid }}, {{ $totalDue }}],
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

@endsection
