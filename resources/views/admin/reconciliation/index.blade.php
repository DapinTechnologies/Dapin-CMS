@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Banking Management</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
<div class="row">
    <!-- Pending -->
    <div class="col-md-3 col-sm-6">
        <div class="card statustic-card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">Pending</span>
                    <h4 class="text-warning mb-0">{{ $total_pending }}</h4>
                </div>
                <i class="fas fa-hourglass-half fa-2x text-warning"></i>
            </div>
        </div>
    </div>

    <!-- Reconciled -->
    <div class="col-md-3 col-sm-6">
        <div class="card statustic-card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">Reconciled</span>
                    <h4 class="text-success mb-0">{{ $total_reconciled }}</h4>
                </div>
                <i class="fas fa-circle-check fa-2x text-success"></i>
            </div>
        </div>
    </div>

    <!-- Payable Reconciled -->
    <div class="col-md-3 col-sm-6">
        <div class="card statustic-card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">Payable Reconciled</span>
                    <h4 class="text-danger mb-0">KES {{ number_format($total_expense, 2) }}</h4>
                </div>
                <i class="fas fa-money-bill-wave fa-2x text-danger"></i>
            </div>
        </div>
    </div>

    <!-- Receivable Reconciled -->
    <div class="col-md-3 col-sm-6">
        <div class="card statustic-card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">Receivable Reconciled</span>
                    <h4 class="text-info mb-0">KES {{ number_format($total_income, 2) }}</h4>
                </div>
                <i class="fas fa-hand-holding-usd fa-2x text-info"></i>
            </div>
        </div>
    </div>
</div>


            <!-- Unreconciled Transactions Panel -->
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Automatic Transactions Reconciliation</h5>
                    </div>
                    <div class="card-block">
                        <ul class="nav nav-tabs" id="unreconciledTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="income-tab" data-bs-toggle="tab" href="#income" role="tab" aria-controls="income" aria-selected="true">
                                    Receivable ({{ $unreconciled_incomes->count() }})
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="expense-tab" data-bs-toggle="tab" href="#expense" role="tab" aria-controls="expense" aria-selected="false">
                                    Payable ({{ $unreconciled_expenses->count() }})
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="unreconciledTabsContent">
                            <!-- Income Tab -->
                            <div class="tab-pane fade show active" id="income" role="tabpanel" aria-labelledby="income-tab">
                                <form id="quick-reconcile-income" action="{{ route($route.'.quick-reconcile') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="transaction_type" value="income">
                                    
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="5%">
                                                        <input type="checkbox" id="select-all-income">
                                                    </th>
                                                    <th>Title</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    <th>Bank Amount</th>
                                                    <th>Bank Reference</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($unreconciled_incomes as $income)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="transaction_ids[]" value="{{ $income->id }}" class="income-checkbox">
                                                    </td>
                                                    <td>{{ $income->title }}</td>
                                                    <td>KES {{ number_format($income->amount, 2) }}</td>
                                                    <td>{{ date('Y-m-d', strtotime($income->date)) }}</td>
                                                    <td>
                                                        <input type="number" name="bank_amounts[]" class="form-control form-control-sm" value="{{ $income->amount }}" step="0.01" min="0">
                                                    </td>
                                                    <!-- In both income and expense tabs, update the bank reference input -->
<td>
    <input type="text" name="bank_references[]" class="form-control form-control-sm" placeholder="REF001, REF002" value="{{ $income->reference ?? 'REF-'.time() }}">
</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    @if($unreconciled_incomes->count() > 0)
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check"></i> Quick Reconcile Selected Income
                                        </button>
                                    </div>
                                    @else
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle"></i> No unreconciled income transactions found.
                                    </div>
                                    @endif
                                </form>
                            </div>

                            <!-- Expense Tab -->
                            <div class="tab-pane fade" id="expense" role="tabpanel" aria-labelledby="expense-tab">
                                <form id="quick-reconcile-expense" action="{{ route($route.'.quick-reconcile') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="transaction_type" value="expense">
                                    
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="5%">
                                                        <input type="checkbox" id="select-all-expense">
                                                    </th>
                                                    <th>Title</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    <th>Bank Amount</th>
                                                    <th>Bank Reference</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($unreconciled_expenses as $expense)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="transaction_ids[]" value="{{ $expense->id }}" class="expense-checkbox">
                                                    </td>
                                                    <td>{{ $expense->title }}</td>
                                                    <td>KES {{ number_format($expense->amount, 2) }}</td>
                                                    <td>{{ date('Y-m-d', strtotime($expense->date)) }}</td>
                                                    <td>
                                                        <input type="number" name="bank_amounts[]" class="form-control form-control-sm" value="{{ $expense->amount }}" step="0.01" min="0">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="bank_references[]" class="form-control form-control-sm" value="{{ $expense->reference ?? 'REF-'.time() }}">
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    @if($unreconciled_expenses->count() > 0)
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check"></i> Quick Reconcile Selected Expense
                                        </button>
                                    </div>
                                    @else
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle"></i> No unreconciled expense transactions found.
                                    </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manual Reconciliation Form -->
<div class="col-lg-6 col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>Manual Transactions Reconciliation</h5>
        </div>
        <div class="card-block">
            <form action="{{ route($route.'.store') }}" method="POST" id="manual-reconciliation-form">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="transaction_type">Transaction Type *</label>
                        <select class="form-control" name="transaction_type" id="transaction_type" required>
                            <option value="">Select Type</option>
                            <option value="income">Receivable</option>
                            <option value="expense">Payable</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="transaction_id">Transaction *</label>
                        <select class="form-control" name="transaction_id" id="transaction_id" required disabled>
                            <option value="">Select Transaction Type First</option>
                        </select>
                        <small class="form-text text-muted" id="transaction-help">
                            Select transaction type first to see available transactions
                        </small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="bank_amount">Bank Amount (KES) *</label>
                        <input type="number" class="form-control" name="bank_amount" id="bank_amount" step="0.01" min="0" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="bank_reference">Bank Reference(s) *</label>
                        <input type="text" class="form-control" name="bank_reference" id="bank_reference" placeholder="REF001, REF002, REF003" required>
                        <small class="form-text text-muted">
                            Enter multiple reference codes separated by commas
                        </small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="value_date">Value Date *</label>
                        <input type="date" class="form-control" name="value_date" id="value_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" name="notes" id="notes" rows="2"></textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Reconciliation
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

            <!-- Reconciliation List -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Reconciliation History</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-2">
                                    <label for="type">Type</label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="all" {{ $selected_type == 'all' ? 'selected' : '' }}>All Types</option>
                                        <option value="income" {{ $selected_type == 'income' ? 'selected' : '' }}>Receivable</option>
                                        <option value="expense" {{ $selected_type == 'expense' ? 'selected' : '' }}>Payable</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="all" {{ $selected_status == 'all' ? 'selected' : '' }}>All Status</option>
                                        <option value="pending" {{ $selected_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="reconciled" {{ $selected_status == 'reconciled' ? 'selected' : '' }}>Reconciled</option>
                                        <option value="discrepancy" {{ $selected_status == 'discrepancy' ? 'selected' : '' }}>Discrepancy</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="start_date">{{ __('field_from_date') }}</label>
                                    <input type="date" class="form-control date" name="start_date" id="start_date" value="{{ $selected_start_date }}" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="end_date">{{ __('field_to_date') }}</label>
                                    <input type="date" class="form-control date" name="end_date" id="end_date" value="{{ $selected_end_date }}" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-info btn-filter mt-4"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                                </div>
                            </div>
                        </form>

                        <!-- [ Data table ] start -->
                        <div class="table-responsive mt-3">
                            <form id="bulk-form" action="{{ route($route.'.bulk-reconcile') }}" method="POST">
                                @csrf
                                <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">
                                                <input type="checkbox" id="select-all-reconciliation">
                                            </th>
                                            <th>#</th>
                                            <th>Reconciliation No</th>
                                            <th>Type</th>
                                            <th>Transaction</th>
                                            <th>Amount (KES)</th>
                                            <th>Bank Amount</th>
                                            <th>Difference</th>
                                            <th>Bank Ref</th>
                                            <th>Value Date</th>
                                            <th>Status</th>
                                            <th>{{ __('field_action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($rows as $key => $row)
                                        <tr>
                                            <td>
                                                @if($row->status == 'pending')
                                                <input type="checkbox" name="reconciliations[]" value="{{ $row->id }}" class="reconciliation-checkbox">
                                                @endif
                                            </td>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->reconciliation_no }}</td>
                                            <td>
                                                <span class="badge bg-{{ $row->type == 'income' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($row->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($row->transaction)
                                                {{ $row->transaction->title ?? 'N/A' }}
                                                @else
                                                <span class="text-danger">Deleted</span>
                                                @endif
                                            </td>
                                            <td>KES {{ number_format($row->amount, 2) }}</td>
                                            <td>KES {{ number_format($row->bank_amount, 2) }}</td>
                                            <td>
                                                <span class="text-{{ $row->difference == 0 ? 'success' : ($row->difference > 0 ? 'info' : 'danger') }}">
                                                    KES {{ number_format($row->difference, 2) }}
                                                </span>
                                            </td>
                                            <td>
    @if(str_contains($row->bank_reference, ','))
        <span title="{{ $row->bank_reference }}">
            {{ Str::limit(explode(',', $row->bank_reference)[0], 15) }}...
        </span>
    @else
        {{ $row->bank_reference }}
    @endif
</td>
                                            <td>
                                                @if(isset($setting->date_format))
                                                {{ date($setting->date_format, strtotime($row->value_date)) }}
                                                @else
                                                {{ date("Y-m-d", strtotime($row->value_date)) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($row->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                                @elseif($row->status == 'reconciled')
                                                <span class="badge bg-success">Reconciled</span>
                                                @if($row->is_auto_matched)
                                                <small class="d-block">Auto-matched</small>
                                                @endif
                                                @elseif($row->status == 'discrepancy')
                                                <span class="badge bg-danger">Discrepancy</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-icon btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#showModal-{{ $row->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                @if($row->status == 'pending')
                                                <button type="button" class="btn btn-icon btn-primary btn-sm" onclick="reconcileItem({{ $row->id }})">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-icon btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#discrepancyModal-{{ $row->id }}">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                </button>
                                                @endif

                                            </td>
                                        </tr>

                                        <!-- Show Modal -->
                                        <div class="modal fade" id="showModal-{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="showModalLabel">Reconciliation Details - {{ $row->reconciliation_no }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p><strong>Transaction:</strong> {{ $row->transaction->title ?? 'N/A' }}</p>
                                                                <p><strong>Type:</strong> {{ ucfirst($row->type) }}</p>
                                                                <p><strong>Amount:</strong> KES {{ number_format($row->amount, 2) }}</p>
                                                                <p><strong>Bank Amount:</strong> KES {{ number_format($row->bank_amount, 2) }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p><strong>Difference:</strong> KES {{ number_format($row->difference, 2) }}</p>
                                                                <p><strong>Bank Reference:</strong> {{ $row->bank_reference }}</p>
                                                                <p><strong>Value Date:</strong> {{ date('d/m/Y', strtotime($row->value_date)) }}</p>
                                                                <p><strong>Status:</strong> 
                                                                    @if($row->status == 'pending')
                                                                    <span class="badge bg-warning">Pending</span>
                                                                    @elseif($row->status == 'reconciled')
                                                                    <span class="badge bg-success">Reconciled</span>
                                                                    @else
                                                                    <span class="badge bg-danger">Discrepancy</span>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                        @if($row->notes)
                                                        <div class="row mt-3">
                                                            <div class="col-12">
                                                                <strong>Notes:</strong>
                                                                <p>{{ $row->notes }}</p>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if($row->discrepancy_reason)
                                                        <div class="row mt-3">
                                                            <div class="col-12">
                                                                <strong>Discrepancy Reason:</strong>
                                                                <p class="text-danger">{{ $row->discrepancy_reason }}</p>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Discrepancy Modal -->
                                        <div class="modal fade" id="discrepancyModal-{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route($route.'.discrepancy', $row->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Mark as Discrepancy</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="discrepancy_reason">Reason for Discrepancy *</label>
                                                                <textarea class="form-control" name="discrepancy_reason" id="discrepancy_reason" rows="3" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-warning">Mark as Discrepancy</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                      @endforeach
                                    </tbody>
                                </table>

                                @if($rows->where('status', 'pending')->count() > 0)
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check-double"></i> Reconcile Selected ({{ $rows->where('status', 'pending')->count() }})
                                    </button>
                                </div>
                                @endif
                            </form>
                        </div>
                        <!-- [ Data table ] end -->
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
    // Define transaction data in a cleaner way
    const transactionData = {
        income: [
            @foreach($unreconciled_incomes as $income)
            {
                id: "{{ $income->id }}",
                title: "{{ addslashes($income->title) }}",
                amount: "{{ $income->amount }}",
                formattedAmount: "{{ number_format($income->amount, 2) }}",
                date: "{{ date('Y-m-d', strtotime($income->date)) }}"
            },
            @endforeach
        ],
        expense: [
            @foreach($unreconciled_expenses as $expense)
            {
                id: "{{ $expense->id }}",
                title: "{{ addslashes($expense->title) }}",
                amount: "{{ $expense->amount }}",
                formattedAmount: "{{ number_format($expense->amount, 2) }}",
                date: "{{ date('Y-m-d', strtotime($expense->date)) }}"
            },
            @endforeach
        ]
    };

    // Load transactions based on type
    document.getElementById('transaction_type').addEventListener('change', function() {
        const type = this.value;
        const transactionSelect = document.getElementById('transaction_id');
        const transactionHelp = document.getElementById('transaction-help');
        
        // Clear existing options
        transactionSelect.innerHTML = '';
        transactionSelect.disabled = true;
        
        if (!type) {
            transactionSelect.innerHTML = '<option value="">Select Transaction Type First</option>';
            transactionHelp.textContent = 'Select transaction type first to see available transactions';
            transactionHelp.className = 'form-text text-muted';
            return;
        }
        
        // Create default option
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'Select a Transaction';
        transactionSelect.appendChild(defaultOption);
        
        // Get transactions for selected type
        const transactions = transactionData[type] || [];
        
        if (transactions.length > 0) {
            // Add transaction options
            transactions.forEach(transaction => {
                const option = document.createElement('option');
                option.value = transaction.id;
                option.textContent = `${transaction.title} - KES ${transaction.formattedAmount}`;
                option.dataset.amount = transaction.amount;
                transactionSelect.appendChild(option);
            });
            
            transactionSelect.disabled = false;
            transactionHelp.textContent = `Found ${transactions.length} unreconciled ${type} transactions`;
            transactionHelp.className = 'form-text text-success';
        } else {
            transactionSelect.innerHTML = '<option value="">No transactions available</option>';
            transactionHelp.textContent = `No unreconciled ${type} transactions found`;
            transactionHelp.className = 'form-text text-danger';
        }
    });

    // Auto-fill bank amount when transaction is selected
document.getElementById('transaction_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption && selectedOption.value && selectedOption.dataset.amount) {
        document.getElementById('bank_amount').value = selectedOption.dataset.amount;
        
        // Auto-generate bank references (multiple)
        const timestamp = new Date().getTime();
        const random1 = Math.floor(Math.random() * 1000);
        const random2 = Math.floor(Math.random() * 1000);
        document.getElementById('bank_reference').value = `REF-${timestamp}-${random1}, REF-${timestamp}-${random2}`;
    } else {
        document.getElementById('bank_amount').value = '';
        document.getElementById('bank_reference').value = '';
    }
});

    // Form validation
    document.getElementById('manual-reconciliation-form').addEventListener('submit', function(e) {
        const transactionType = document.getElementById('transaction_type').value;
        const transactionId = document.getElementById('transaction_id').value;
        const bankAmount = document.getElementById('bank_amount').value;
        const bankReference = document.getElementById('bank_reference').value;
        
        if (!transactionType || !transactionId || !bankAmount || !bankReference) {
            e.preventDefault();
            alert('Please fill all required fields.');
            return false;
        }
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum date for value date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('value_date').min = today;
        
        // Initialize transaction data
        console.log('Income transactions:', transactionData.income);
        console.log('Expense transactions:', transactionData.expense);
    });
</script>
@endsection