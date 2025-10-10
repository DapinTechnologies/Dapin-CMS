<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - {{ $row->id }}</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 20px;
                font-family: Arial, sans-serif;
                color: #000;
            }
            .no-print {
                display: none !important;
            }
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .company-info {
            margin-bottom: 30px;
            text-align: center;
        }
        .receipt-info {
            margin-bottom: 30px;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .info-column {
            width: 48%;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .total-section {
            text-align: right;
            margin-bottom: 30px;
            font-size: 18px;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .payment-method {
            margin-top: 20px;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
        }
        .paid {
            background-color: #d4edda;
            color: #155724;
        }
        .print-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .print-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Print Button (Hidden when printing) -->
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button class="print-btn" onclick="window.print()">
            <i class="fas fa-print"></i> Print Receipt
        </button>
        <button class="print-btn" onclick="window.close()" style="background: #6c757d;">
            <i class="fas fa-times"></i> Close
        </button>
    </div>

    <div class="header">
        <h1>PAYMENT RECEIPT</h1>
    </div>

    <div class="company-info">
        <h3>{{ $setting->site_name ?? 'Company Name' }}</h3>
        <p>{{ $setting->site_address ?? 'Company Address' }}</p>
        <p>Phone: {{ $setting->phone ?? 'N/A' }} | Email: {{ $setting->email ?? 'N/A' }}</p>
    </div>

    <div class="receipt-info">
        <div class="info-section">
            <div class="info-column">
                <h4>Payment Details:</h4>
                <p><strong>Receipt No:</strong> RC-{{ str_pad($row->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Payment Date:</strong> {{ date($setting->date_format ?? 'Y-m-d', strtotime($row->date)) }}</p>
                <p><strong>Category:</strong> {{ $row->category->title ?? '' }}</p>
            </div>
            <div class="info-column">
                <h4>Reference:</h4>
                <p><strong>Title:</strong> {{ $row->title }}</p>
                @if($row->receivableInvoice)
                <p><strong>Invoice No:</strong> {{ $row->receivableInvoice->invoice_no }}</p>
                @endif
                @if($row->invoice_id)
                <p><strong>Invoice ID:</strong> {{ $row->invoice_id }}</p>
                @endif
                @if($row->reference)
                <p><strong>Reference:</strong> {{ $row->reference }}</p>
                @endif
            </div>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Description</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $row->title }}</td>
                <td style="text-align: right;">{{ number_format($row->amount, $setting->decimal_place ?? 2) }} {!! $setting->currency_symbol !!}</td>
            </tr>
            @if($row->note)
            <tr>
                <td colspan="2">
                    <strong>Notes:</strong><br>
                    {{ $row->note }}
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="total-section">
        Total Received: {{ number_format($row->amount, $setting->decimal_place ?? 2) }} {!! $setting->currency_symbol !!}
    </div>

    <div class="payment-method">
        <p><strong>Payment Method:</strong> 
            @if($row->payment_method == 1) Card
            @elseif($row->payment_method == 2) Cash
            @elseif($row->payment_method == 3) Cheque
            @elseif($row->payment_method == 4) Bank Transfer
            @elseif($row->payment_method == 5) E-Wallet
            @endif
        </p>
        <p><strong>Status:</strong> <span class="status-badge paid">RECEIVED</span></p>
    </div>

    <div class="footer">
        <p>Generated on: {{ date($setting->date_format ?? 'Y-m-d H:i:s') }}</p>
        <p>This receipt is computer generated and valid without signature.</p>
        <p>Thank you for your payment!</p>
    </div>

    <script>
        // Auto-print if needed (optional)
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>
</html>