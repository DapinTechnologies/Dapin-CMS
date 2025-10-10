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
            <h3>Total Expense</h3>
            <p style="font-size: 24px; font-weight: bold; color: #dc3545;">
                {{ number_format($total_expense, 2) }} {!! $setting->currency_symbol ?? '$' !!}
            </p>
        </div>
        <div class="card">
            <h3>Total Transactions</h3>
            <p style="font-size: 24px; font-weight: bold; color: #ffc107;">
                {{ $expenses->count() }}
            </p>
        </div>
        <div class="card">
            <h3>Average Expense</h3>
            <p style="font-size: 24px; font-weight: bold; color: #17a2b8;">
                {{ number_format($expenses->avg('amount') ?? 0, 2) }} {!! $setting->currency_symbol ?? '$' !!}
            </p>
        </div>
    </div>

    <!-- Category Summary -->
    <h3>Expense by Category</h3>
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
                <td>{{ number_format($summary['amount'], 2) }} {!! $setting->currency_symbol ?? '$' !!}</td>
                <td>{{ number_format(($summary['amount'] / $total_expense) * 100, 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Payment Method Summary -->
    <h3>Expense by Payment Method</h3>
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
                <td>{{ number_format($summary['amount'], 2) }} {!! $setting->currency_symbol ?? '$' !!}</td>
                <td>{{ number_format(($summary['amount'] / $total_expense) * 100, 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Detailed Transactions -->
    <h3>Detailed Expense Transactions</h3>
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
            @foreach($expenses as $key => $expense)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $expense->title }}</td>
                <td>{{ $expense->category->title ?? 'N/A' }}</td>
                <td>{{ $expense->invoice_id ?? 'N/A' }}</td>
                <td>{{ number_format($expense->amount, 2) }} {!! $setting->currency_symbol !!}</td>
                <td>
                    @if(isset($setting->date_format))
                    {{ date($setting->date_format, strtotime($expense->date)) }}
                    @else
                    {{ date("Y-m-d", strtotime($expense->date)) }}
                    @endif
                </td>
                <td>
                    @if( $expense->payment_method == 1 )
                    {{ __('payment_method_card') }}
                    @elseif( $expense->payment_method == 2 )
                    {{ __('payment_method_cash') }}
                    @elseif( $expense->payment_method == 3 )
                    {{ __('payment_method_cheque') }}
                    @elseif( $expense->payment_method == 4 )
                    {{ __('payment_method_bank') }}
                    @elseif( $expense->payment_method == 5 )
                    {{ __('payment_method_e_wallet') }}
                    @endif
                </td>
                <td>{{ $expense->reference ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-light">
                <th colspan="4" class="text-end">Total:</th>
                <th>{{ number_format($total_expense, 2) }} {!! $setting->currency_symbol !!}</th>
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