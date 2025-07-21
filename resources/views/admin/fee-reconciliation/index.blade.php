@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4" style="font-size: 1.25rem;">{{ $title }}</h1>
    
    <!-- Filter/Search Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Filter/Search Payments</h5>
        </div>
        <div class="card-body">
            <form action="{{ route($route.'.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="faculty">Faculty</label>
                            <select name="faculty" id="faculty" class="form-control">
                                <option value="0">All Faculties</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" {{ $selected_faculty == $faculty->id ? 'selected' : '' }}>
                                        {{ $faculty->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="program">Program</label>
                            <select name="program" id="program" class="form-control">
                                <option value="0">All Programs</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ $selected_program == $program->id ? 'selected' : '' }}>
                                        {{ $program->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-control">
                                <option value="">All Methods</option>
                                <option value="mpesa" {{ $selected_payment_method == 'mpesa' ? 'selected' : '' }}>M-Pesa</option>
                                <option value="bank" {{ $selected_payment_method == 'bank' ? 'selected' : '' }}>Bank</option>
                                <option value="cash" {{ $selected_payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Payment Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ $selected_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $selected_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="failed" {{ $selected_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="partial" {{ $selected_status == 'partial' ? 'selected' : '' }}>Partial</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="reconciled">Reconciliation Status</label>
                            <select name="reconciled" id="reconciled" class="form-control">
                                <option value="">All</option>
                                <option value="yes" {{ $selected_reconciled == 'yes' ? 'selected' : '' }}>Reconciled</option>
                                <option value="no" {{ $selected_reconciled == 'no' ? 'selected' : '' }}>Not Reconciled</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Search (ID/Name/Reference)</label>
                            <input type="text" name="search" id="search" class="form-control" value="{{ $search_term }}" placeholder="Student ID/Name/Reference">
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="{{ route($route.'.index') }}" class="btn btn-secondary">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            
             <!-- Left side - Summary Stats -->
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <h5 class="mb-0 me-3">Real-Time Payment Records</h5>
            
            <!-- Summary Cards - Horizontal Layout -->
            <div class="d-flex reconciliation-stats">
                <!-- Completed -->
                <div class="stat-card me-3">
                    <div class="stat-content bg-success bg-opacity-10 p-2 rounded-3 border-start border-4 border-success">
                        <div class="stat-title text-muted small">Completed</div>
                        <div class="stat-value text-black fw-bold">{{ $payments->where('is_reconciled', 1)->count() }}</div>
                    </div>
                </div>
                
                <!-- Not Reconciled -->
                <div class="stat-card me-3">
                    <div class="stat-content bg-warning bg-opacity-10 p-2 rounded-3 border-start border-4 border-warning">
                        <div class="stat-title text-muted small">Pending</div>
                        <div class="stat-value text-black fw-bold">{{ $payments->where('is_reconciled', 0)->count() }}</div>
                    </div>
                </div>
                
                <!-- To Check -->
                <div class="stat-card">
                    <div class="stat-content bg-danger bg-opacity-10 p-2 rounded-3 border-start border-4 border-danger">
                        <div class="stat-title text-muted small">To Check</div>
                        <div class="stat-value text-dark fw-bold">{{ $payments->where('is_reconciled', 2)->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
            <div>
                <button type="button" class="btn btn-primary btn-sm" id="batchReconcileBtn" data-bs-toggle="modal" data-bs-target="#batchReconcileModal">
                    <i class="fas fa-check-double"></i> Batch Reconcile
                </button>
                 
                 @can('export fee reconciliation')
                        <a href="{{ route($route.'.export') }}?{{ http_build_query(request()->query()) }}" class="btn btn-info ml-2">
                            <i class="fas fa-file-export"></i> Export
                        </a>
                        @endcan
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="paymentsTable">
                    <thead class="thead-light blue">
                        <tr>
                            <th width="3%">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th width="5%">#</th>
                            <th>Student Name</th>
                            <th>Course / Faculty</th>
                            <th>Semester</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Reference Code</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Reconciled</th>
                           
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $key => $payment)
                            <tr>
                                <td>
                                    <input type="checkbox" class="payment-checkbox" value="{{ $payment->id }}" {{ $payment->is_reconciled ? 'disabled' : '' }}>
                                </td>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $payment->studentEnroll->student->full_name ?? 'N/A' }}
                                    <br>
                                    <small class="text-muted">ID: {{ $payment->studentEnroll->student->student_id ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    {{ $payment->studentEnroll->program->title ?? 'N/A' }}
                                    <br>
                                    <small class="text-muted">{{ $payment->studentEnroll->program->faculty->title ?? '' }}</small>
                                </td>
                                <td>{{ $payment->studentEnroll->semester_id ?? 'N/A' }}</td>
                                <td>{{ number_format($payment->amount, 2) }}</td>
                                <td>
                                
    @if($payment->is_bursary)
        <span class="badge bg-info">BURSARY</span>
        @if($payment->bursary_type)
            <br><small class="text-muted">{{ $payment->bursary_type }}</small>
        @endif
    @else
        <span class="badge bg-{{ $payment->payment_method == 'mpesa' ? 'success' : ($payment->payment_method == 'bank' ? 'primary' : 'warning') }}">
            {{ strtoupper($payment->payment_method) }}
        </span>
    @endif

                                </td>
                                <td>
                                    @if($payment->payment_method == 'mpesa')
                                        {{ $payment->transaction_id }}
                                    @else
                                        {{ $payment->reference_number }}
                                    @endif
                                </td>
                                <td>
                                    @if($payment->payment_date)
                                        {{ $payment->payment_date->format('d M Y') }}<br>
                                        {{ $payment->payment_date->format('h:i A') }}
                                    @elseif($payment->created_at)
                                        {{ $payment->created_at->format('d M Y') }}<br>
                                        {{ $payment->created_at->format('h:i A') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($payment->is_installment)
                                        <span class="badge bg-info">Partial - {{ $payment->installment_number }}</span>
                                    @else
                                        <span class="badge bg-primary">Full Payment</span>
                                    @endif
                                </td>
                                <td>
    @if($payment->is_reconciled === 1)
        <span class="badge bg-success">Completed</span>
        <br>
        {{-- <small>By: {{ $payment->reconciled_by }}</small> --}}
        <br>
        <small>
            @if($payment->reconciled_at)
                {{ \Carbon\Carbon::parse($payment->reconciled_at)->format('d M Y H:i') }}
            @else
                N/A
            @endif
        </small>
    @elseif($payment->is_reconciled === 2)
        <span class="badge bg-danger">To Check</span>
        <br>
        {{-- <small>By: {{ $payment->reconciled_by }}</small> --}}
        <br>
        <small>
            @if($payment->reconciled_at)
                {{ \Carbon\Carbon::parse($payment->reconciled_at)->format('d M Y H:i') }}
            @else
                N/A
            @endif
        </small>
    @else
        <span class="badge bg-warning">Not Reconciled</span>
    @endif
</td>
                                
<td>
    @if(!$payment->is_reconciled || $payment->is_reconciled === 2)
        <button type="button" 
                class="btn btn-success btn-sm reconcile-btn" 
                data-bs-toggle="modal" 
                data-bs-target="#reconcileModal-{{ $payment->id }}"
                title="Reconcile Payment">
            <i class="fas fa-check-circle"></i> Reconcile
        </button>
    @else
        <span class="text-muted"><i class="fas fa-check-circle"></i> Reconciled</span>
        <br>
        {{-- <small>By: {{ $payment->reconciled_by }}</small> --}}
    @endif
</td>
                            </tr>

                            <!-- Reconcile Modal -->
                            <div class="modal fade" id="reconcileModal-{{ $payment->id }}" tabindex="-1" aria-labelledby="reconcileModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="reconcileModalLabel">
                                                <i class="fas fa-check-circle me-2"></i> Reconcile Payment
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route($route.'.reconcile', $payment->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="alert alert-info">
                                                    <h6>Received Payment Details Overview</h6>
                                                    <hr>
                                                    <p><strong>Student Name:</strong> {{ $payment->studentEnroll->student->full_name ?? 'N/A' }}</p>
                                                    <p><strong>Amount Paid:</strong> {{ number_format($payment->amount, 2) }}</p>
                                                    <p><strong>Payment Method:</strong> <p><strong>Payment Method:</strong> 
    @if($payment->is_bursary)
        BURSARY
        @if($payment->bursary_type)
            ({{ $payment->bursary_type }})
        @endif
    @else
        {{ strtoupper($payment->payment_method) }}
    @endif
</p>
                                                    <p><strong>Payment Reference Number:</strong> 
                                                        @if($payment->payment_method == 'mpesa')
                                        {{ $payment->transaction_id }}
                                    @else
                                        {{ $payment->reference_number }}
                                    @endif
                                                    </p>
                                                    <p><strong>Payment Receipt Code:</strong> {{ $payment->transaction_id ?? $payment->reference_number ?? 'N/A' }}</p>
                                                    <p><strong>Date of Payment:</strong> @if($payment->payment_date)
        {{ $payment->payment_date->format('d M Y') }}
    @elseif($payment->created_at)
        {{ $payment->created_at->format('d M Y') }} 
    @else
        N/A
    @endif</p>
                                                </div>

                                                <div class="form-group mb-3">
    <label for="reconciliation_status-{{ $payment->id }}" class="fw-bold">Reconciliation Status</label>
    <select name="reconciliation_status" id="reconciliation_status-{{ $payment->id }}" class="form-control" required>
        <option value="1">Completed</option>
        <option value="2">To Check</option>
    </select>
</div>

                                                <div class="form-group mb-3">
                                                    <label for="confirmation_date-{{ $payment->id }}" class="fw-bold">Confirmation Date</label>
                                                    <input type="date" 
                                                           name="confirmation_date" 
                                                           id="confirmation_date-{{ $payment->id }}" 
                                                           class="form-control" 
                                                           value="{{ date('Y-m-d') }}" 
                                                           max="{{ date('Y-m-d') }}"
                                                           required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="confirmation_time-{{ $payment->id }}" class="fw-bold">Confirmation Time</label>
                                                    <input type="time" 
                                                           name="confirmation_time" 
                                                           id="confirmation_time-{{ $payment->id }}" 
                                                           class="form-control" 
                                                           value="{{ date('H:i') }}"
                                                           required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="reconciliation_notes-{{ $payment->id }}" class="fw-bold">Reconciliation Notes</label>
                                                    <textarea name="reconciliation_notes" 
                                                              id="reconciliation_notes-{{ $payment->id }}" 
                                                              class="form-control" 
                                                              rows="3" 
                                                              placeholder="Any notes about this reconciliation"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-1"></i> Cancel
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-check-circle me-1"></i> Confirm Reconciliation
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center">No payment records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($payments->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $payments->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Batch Reconcile Modal -->
<div class="modal fade" id="batchReconcileModal" tabindex="-1" aria-labelledby="batchReconcileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="batchReconcileModalLabel">
                    <i class="fas fa-check-double me-2"></i> Batch Reconcile Payments
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route($route.'.batch-reconcile') }}" method="POST" id="batchReconcileForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> You are about to reconcile <span id="selectedCount">0</span> payments.
                    </div>

                    <div class="mb-3">
                        <label for="batch_status" class="fw-bold">Reconciliation Status</label>
                        <select name="status" id="batch_status" class="form-control" required>
                            <option value="completed">Completed</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="batch_confirmation_date" class="fw-bold">Confirmation Date</label>
                        <input type="date" 
                               name="confirmation_date" 
                               id="batch_confirmation_date" 
                               class="form-control" 
                               value="{{ date('Y-m-d') }}" 
                               max="{{ date('Y-m-d') }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="batch_confirmation_time" class="fw-bold">Confirmation Time</label>
                        <input type="time" 
                               name="confirmation_time" 
                               id="batch_confirmation_time" 
                               class="form-control" 
                               value="{{ date('H:i') }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="batch_reconciliation_notes" class="fw-bold">Reconciliation Notes</label>
                        <textarea name="reconciliation_notes" 
                                id="batch_reconciliation_notes" 
                                class="form-control" 
                                rows="3" 
                                placeholder="Any notes about this reconciliation"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-double me-1"></i> Confirm Batch Reconciliation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Faculty-Program dependency
    $('#faculty').change(function() {
        var facultyId = $(this).val();
        if(facultyId) {
            $.ajax({
                url: '/admin/get-programs/' + facultyId,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('#program').empty();
                    $('#program').append('<option value="0">All Programs</option>');
                    $.each(data, function(key, value) {
                        $('#program').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        } else {
            $('#program').empty();
            $('#program').append('<option value="0">All Programs</option>');
        }
    });

    // Select all checkboxes
    $('#selectAll').click(function() {
        $('.payment-checkbox:not(:disabled)').prop('checked', $(this).prop('checked'));
        updateBatchReconcileButton();
    });

    // Update batch reconcile button when checkboxes change
    $(document).on('change', '.payment-checkbox', function() {
        updateBatchReconcileButton();
    });

    function updateBatchReconcileButton() {
        var checkedCount = $('.payment-checkbox:checked').length;
        $('#batchReconcileBtn').prop('disabled', checkedCount === 0);
        $('#selectedCount').text(checkedCount);
        
        // Update hidden inputs for selected payments
        $('#batchReconcileForm').find('input[name="payment_ids[]"]').remove();
        $('.payment-checkbox:checked').each(function() {
            $('#batchReconcileForm').append(
                $('<input>').attr({
                    type: 'hidden',
                    name: 'payment_ids[]',
                    value: $(this).val()
                })
            );
        });
    }

    // Initialize date pickers
    $('input[type="date"]').each(function() {
        $(this).attr('max', new Date().toISOString().split('T')[0]);
    });
});
</script>
@endsection