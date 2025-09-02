@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
<!-- Chart.js -->
<script src="{{ asset('dashboard/plugins/chart-chartjs/js/chart.min.js') }}"></script>
<style>
    .chart-container {
        height: 300px;
        width: 100%;
    }
    .search-input {
        max-width: 300px;
        margin-bottom: 15px;
    }
    .total-fees {
        font-size: 1.1rem;
        color: #2e59d9;
    }
</style>
@endsection

@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Fee Collection Report ] start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- Filters -->
                        <form method="GET" action="{{ route($route.'.index') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="faculty" class="form-label">Faculty</label>
                                        <select class="form-control select2" id="faculty" name="faculty">
                                            <option value="">All Faculties</option>
                                            @foreach($faculties as $faculty)
                                                <option value="{{ $faculty->id }}" {{ request('faculty') == $faculty->id ? 'selected' : '' }}>
                                                    {{ $faculty->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="program" class="form-label">Program</label>
                                        <select class="form-control select2" id="program" name="program">
                                            <option value="">All Programs</option>
                                            @foreach($programs as $program)
                                                <option value="{{ $program->id }}" {{ request('program') == $program->id ? 'selected' : '' }}>
                                                    {{ $program->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="semester" class="form-label">Semester</label>
                                        <select class="form-control select2" id="semester" name="semester">
                                            <option value="">All Semesters</option>
                                            @foreach($semesters as $semester)
                                                <option value="{{ $semester->id }}" {{ request('semester') == $semester->id ? 'selected' : '' }}>
                                                    {{ $semester->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="fee_category" class="form-label">Fee Category</label>
                                        <select class="form-control select2" id="fee_category" name="fee_category">
                                            <option value="">All Categories</option>
                                            @foreach($feeCategories as $category)
                                                <option value="{{ $category->id }}" {{ request('fee_category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route($route.'.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Monthly Fee Collection by Category</h5>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <canvas id="monthlyFeeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Faculty Fee Category Distribution</h5>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <canvas id="facultyDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Fee Category Summary</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <div class="mb-3">
                                <input type="text" class="form-control search-input" placeholder="Search fee categories...">
                            </div>
                            <table class="table table-striped table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>Fee Category</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($feeCategorySummary as $category => $amount)
                                    <tr>
                                        <td>{{ $category }}</td>
                                        <td>KSh {{ number_format($amount, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th>KSh {{ number_format(array_sum($feeCategorySummary), 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Semester-wise Collection</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <div class="mb-3">
                                <input type="text" class="form-control search-input" placeholder="Search semesters...">
                            </div>
                            <table class="table table-striped table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>Semester</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($semesterSummary as $semester => $amount)
                                    <tr>
                                        <td>{{ $semester }}</td>
                                        <td>KSh {{ number_format($amount, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th>KSh {{ number_format(array_sum($semesterSummary), 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Faculty-wise Collection Summary -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Faculty-wise Collection Summary</h5>
                        @php
                            $totalAmount = array_sum($facultySummary);
                        @endphp
                        <div class="total-fees">
                            <strong>Total Collected: KSh {{ number_format($totalAmount, 2) }}</strong>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <div class="mb-3">
                                <input type="text" class="form-control search-input" placeholder="Search faculties...">
                            </div>
                            <table class="table table-striped table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>Faculty</th>
                                        <th>Amount</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $grandTotal = array_sum($facultySummary);
                                    @endphp
                                    @foreach($facultySummary as $faculty => $amount)
                                    <tr>
                                        <td>{{ $faculty }}</td>
                                        <td>KSh {{ number_format($amount, 2) }}</td>
                                        <td>{{ $grandTotal > 0 ? number_format(($amount / $grandTotal) * 100, 2) : 0 }}%</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fee Collection Summary (detailed table) -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Detailed Fee Collection Summary</h5>
                        <button type="button" class="btn btn-success" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </button>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <div class="mb-3">
                                <input type="text" class="form-control search-input" placeholder="Search detailed records...">
                            </div>
                            <table class="table table-striped table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>Faculty</th>
                                        <th>Program</th>
                                        <th>Semester</th>
                                        <th>Fee Category</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $detailedTotal = array_sum(array_column($summaryTable, 'collected_amount'));
                                    @endphp
                                    @foreach($summaryTable as $item)
                                    <tr>
                                        <td>{{ $item['faculty'] }}</td>
                                        <td>{{ $item['program'] }}</td>
                                        <td>{{ $item['semester'] }}</td>
                                        <td>{{ $item['fee_category'] }}</td>
                                        <td>KSh {{ number_format($item['collected_amount'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total</th>
                                        <th>KSh {{ number_format($detailedTotal, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Fee Performance Chart - Stacked Bar
    const monthlyCtx = document.getElementById('monthlyFeeChart').getContext('2d');
    const monthlyData = @json($monthlyData);
    const feeCategories = @json($feeCategories->pluck('title'));
    const selectedCategory = @json($selectedCategoryTitle);
    
    // Prepare datasets - if a category is selected, only show that one
    const categoryColors = {};
    let datasets = [];
    
    if (selectedCategory) {
        // Only show the selected category
        categoryColors[selectedCategory] = getRandomColor();
        
        const categoryData = Object.keys(monthlyData).map(month => {
            return monthlyData[month][selectedCategory] || 0;
        });
        
        datasets = [{
            label: selectedCategory,
            data: categoryData,
            backgroundColor: categoryColors[selectedCategory],
            borderColor: '#fff',
            borderWidth: 1
        }];
    } else {
        // Show all categories
        datasets = feeCategories.map(category => {
            categoryColors[category] = getRandomColor();
            
            const categoryData = Object.keys(monthlyData).map(month => {
                return monthlyData[month][category] || 0;
            });
            
            return {
                label: category,
                data: categoryData,
                backgroundColor: categoryColors[category],
                borderColor: '#fff',
                borderWidth: 1
            };
        });
    }
    
    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(monthlyData),
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: !selectedCategory, // Only stack if showing multiple categories
                },
                y: {
                    stacked: !selectedCategory, // Only stack if showing multiple categories
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
                            return context.dataset.label + ': KSh ' + context.raw.toLocaleString();
                        },
                        footer: function(context) {
                            if (selectedCategory) return null; // Don't show total footer for single category
                            
                            let total = 0;
                            context.forEach(item => {
                                total += item.parsed.y;
                            });
                            return 'Total: KSh ' + total.toLocaleString();
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
    
    // Faculty Distribution Chart
    const facultyCtx = document.getElementById('facultyDistributionChart').getContext('2d');
    const facultyData = @json($facultyDistribution);
    
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
                url: "{{ route($route.'.get-programs') }}",
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

    // Add search functionality to all tables
    document.querySelectorAll('.datatable').forEach(table => {
        const searchInput = table.previousElementSibling.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                const rows = table.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        }
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
    window.location.href = "{{ route($route.'.export') }}?" + params.toString();
}
</script>
@endsection