<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing - {{ $row->billing_no }}</title>
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
            .page-break {
                page-break-before: always;
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
        .billing-info {
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
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            text-align: center;
            width: 45%;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
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
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
        }
        .active {
            background-color: #d4edda;
            color: #155724;
        }
        .inactive {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <!-- Print Button (Hidden when printing) -->
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button class="print-btn" onclick="window.print()">
            <i class="fas fa-print"></i> Print Billing
        </button>
        <button class="print-btn" onclick="window.close()" style="background: #6c757d;">
            <i class="fas fa-times"></i> Close
        </button>
    </div>

    <div class="header">
        <h1>BILLING STATEMENT</h1>
    </div>

    <div class="company-info">
        <h3>{{ $setting->site_name ?? 'Company Name' }}</h3>
        <p>{{ $setting->site_address ?? 'Company Address' }}</p>
        <p>Phone: {{ $setting->phone ?? 'N/A' }} | Email: {{ $setting->email ?? 'N/A' }}</p>
    </div>

    <div class="billing-info">
        <div class="info-section">
            <div class="info-column">
                <h4>Bill To:</h4>
                <p><strong>{{ $row->supplier->title ?? 'N/A' }}</strong></p>
                <p>{{ $row->supplier->address ?? '' }}</p>
                <p>Phone: {{ $row->supplier->phone ?? 'N/A' }}</p>
                <p>Email: {{ $row->supplier->email ?? 'N/A' }}</p>
            </div>
            <div class="info-column">
                <h4>Billing Details:</h4>
                <p><strong>Billing No:</strong> {{ $row->billing_no }}</p>
                <p><strong>Date:</strong> {{ date($setting->date_format ?? 'Y-m-d', strtotime($row->date)) }}</p>
                @if($row->due_date)
                <p><strong>Due Date:</strong> {{ date($setting->date_format ?? 'Y-m-d', strtotime($row->due_date)) }}</p>
                @endif
                <p><strong>Status:</strong> 
                    <span class="status-badge {{ $row->status == 1 ? 'active' : 'inactive' }}">
                        {{ $row->status == 1 ? 'Active' : 'Inactive' }}
                    </span>
                </p>
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
            @if($row->description)
            <tr>
                <td colspan="2">
                    <strong>Additional Notes:</strong><br>
                    {{ $row->description }}
                </td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align: right;">Total Amount</th>
                <th style="text-align: right;">{{ number_format($row->amount, $setting->decimal_place ?? 2) }} {!! $setting->currency_symbol !!}</th>
            </tr>
        </tfoot>
    </table>

    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line"></div>
            <p>Prepared By</p>
            <p><strong>{{ $row->createdBy->first_name ?? '' }} {{ $row->createdBy->last_name ?? '' }}</strong></p>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <p>Authorized Signature</p>
        </div>
    </div>

    <div class="footer">
        <p>Generated on: {{ date($setting->date_format ?? 'Y-m-d H:i:s') }}</p>
        <p>This is a computer generated document. No signature is required.</p>
    </div>

    <script>
        // Auto-print if needed (optional)
        // window.onload = function() {
        //     window.print();
        // }
        
        // Close window after print (optional)
        window.onafterprint = function() {
            // window.close();
        };
    </script>
</body>
</html>