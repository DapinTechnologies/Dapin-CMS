<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .summary-cards { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .card { border: 1px solid #ddd; padding: 15px; margin: 10px; flex: 1; text-align: center; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f5f5f5; }
        .text-end { text-align: right; }
        .bg-light { background-color: #f8f9fa; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Generated on: {{ $print_date }}</p>
        
        @if($filters['category'] != 'all' || $filters['payment_method'] != 'all')
        <div class="filters">
            <strong>Filters Applied:</strong>
            @if($filters['category'] != 'all')
            <span>Category: {{ $filters['category_name'] ?? 'All' }}</span>
            @endif
            @if($filters['payment_method'] != 'all')
            <span> | Payment Method: {{ $filters['payment_method_name'] ?? 'All' }}</span>
            @endif
            <span> | Date Range: {{ $filters['start_date'] }} to {{ $filters['end_date'] }}</span>
        </div>
        @endif
    </div>

    <!-- Summary Section -->
    <div class="summary-cards">
        <div class="card">
            <h3>Total Income</h3>
            <p style="font-size: 24px; font-weight: bold; color: #28a745;">
                {{ number_format($total_income, 2) }}
            </p>
        </div>
        <div class="card">
            <h3>Total Transactions</h3>
            <p style="font-size: 24px; font-weight: bold; color: #007bff;">
                {{ $incomes->count() }}
            </p>
        </div>
        <div class="card">
            <h3>Average Income</h3>
            <p style="font-size: 24px; font-weight: bold; color: #17a2b8;">
                {{ number_format($incomes->avg('amount') ?? 0, 2) }}
            </p>
        </div>
    </div>

    <!-- Category Summary -->
    <h3>Income by Category</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Transactions</th>
                <th>Amount</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
            @foreach($category_summary as $summary)
            <tr>
                <td>{{ $summary['name'] }}</td>
                <td>{{ $summary['count'] }}</td>
                <td>{{ number_format($summary['amount'], 2) }}</td>
                <td>{{ number_format(($summary['amount'] / $total_income) * 100, 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Payment Method Summary -->
    <h3>Income by Payment Method</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Payment Method</th>
                <th>Transactions</th>
                <th>Amount</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payment_summary as $summary)
            <tr>
                <td>{{ $summary['name'] }}</td>
                <td>{{ $summary['count'] }}</td>
                <td>{{ number_format($summary['amount'], 2) }}</td>
                <td>{{ number_format(($summary['amount'] / $total_income) * 100, 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Detailed Transactions -->
    <h3>Detailed Income Transactions</h3>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Category</th>
                <th>Invoice ID</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Payment Method</th>
                <th>Reference</th>
            </tr>
        </thead>
        <tbody>
            @foreach($incomes as $key => $income)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $income->title }}</td>
                <td>{{ $income->category->title ?? 'N/A' }}</td>
                <td>{{ $income->invoice_id ?? 'N/A' }}</td>
                <td>{{ number_format($income->amount, 2) }}</td>
                <td>{{ date('M d, Y', strtotime($income->date)) }}</td>
                <td>
                    @switch($income->payment_method)
                        @case(1) Card @break
                        @case(2) Cash @break
                        @case(3) Cheque @break
                        @case(4) Bank Transfer @break
                        @case(5) E-Wallet @break
                        @default Unknown
                    @endswitch
                </td>
                <td>{{ $income->reference ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-light">
                <th colspan="4" class="text-end">Total:</th>
                <th>{{ number_format($total_income, 2) }}</th>
                <th colspan="3"></th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the system.</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>