<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .summary { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .summary-item { flex: 1; text-align: center; padding: 10px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 10px; }
        .table th, .table td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        .table th { background-color: #f5f5f5; }
        .text-right { text-align: right; }
        .bg-gray { background-color: #f8f9fa; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; }
        .page-break { page-break-after: always; }
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
    <div class="summary">
        <div class="summary-item">
            <h3>Total Expense</h3>
            <p style="font-size: 18px; font-weight: bold; color: #dc3545;">
                {{ number_format($total_expense, 2) }} {!! $setting->currency_symbol ?? '$' !!}
            </p>
        </div>
        <div class="summary-item">
            <h3>Total Transactions</h3>
            <p style="font-size: 18px; font-weight: bold; color: #ffc107;">
                {{ $expenses->count() }}
            </p>
        </div>
        <div class="summary-item">
            <h3>Average Expense</h3>
            <p style="font-size: 18px; font-weight: bold; color: #17a2b8;">
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
                <td class="text-right">{{ number_format($summary['amount'], 2) }} {!! $setting->currency_symbol ?? '$' !!}</td>
                <td class="text-right">{{ number_format(($summary['amount'] / $total_expense) * 100, 1) }}%</td>
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
                <td class="text-right">{{ number_format($summary['amount'], 2) }} {!! $setting->currency_symbol ?? '$' !!}</td>
                <td class="text-right">{{ number_format(($summary['amount'] / $total_expense) * 100, 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

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
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $key => $expense)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ Str::limit($expense->title, 30) }}</td>
                <td>{{ $expense->category->title ?? 'N/A' }}</td>
                <td>{{ $expense->invoice_id ?? 'N/A' }}</td>
                <td class="text-right">{{ number_format($expense->amount, 2) }} {!! $setting->currency_symbol !!}</td>
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
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-gray">
                <th colspan="4" class="text-right">Total:</th>
                <th class="text-right">{{ number_format($total_expense, 2) }} {!! $setting->currency_symbol !!}</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the system.</p>
    </div>
</body>
</html>