@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4" style="font-size: 1.25rem;">{{ $title }}</h1>
    
    <!-- Filter/Search Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Filter/Search Fee Structures</h5>
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
                                <label for="program">Course</label>
                            <select name="program" id="program" class="form-control">
                                <option value="0">All Courses</option>
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
                            <label for="semester">Semester</label>
                            <select name="semester" id="semester" class="form-control">
                                <option value="0">All Semesters</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->title }}" {{ $selected_semester == $semester->title ? 'selected' : '' }}>
                                        {{ $semester->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="category">Fee Types</label>
                            <select name="category" id="category" class="form-control">
                                <option value="0">All FeeTypes</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $selected_category == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
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

    <!-- Fee Structures Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Fee Structures List</h5>
            <div>
                {{-- 
<a href="{{ route($route.'.batch-assign') }}" class="btn btn-info btn-sm">
    <i class="fas fa-users"></i> Batch Assign Fee Structure
</a>
--}}

                @can('create fee structures')
                <a href="{{ route($route.'.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Create Fee Structure
                </a>
                @endcan
                
                @can('export fee structures')
    <a href="{{ route('admin.fee-structures.export') }}" class="btn btn-info btn-sm ml-2" download>
        <i class="fas fa-file-export"></i> Export
    </a>
@endcan
                
                @can('import fee structures')
<button class="btn btn-warning btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#importModal">
    <i class="fas fa-file-import"></i> Import
</button>
@endcan
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%">#</th>
                            <th>Faculty</th>
                            <th>Course</th>
                            <th>Semester</th>
                            <th>Total Amount</th>
                            <th>Fee Items</th>
                            <th>Status</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feeStructures as $key => $feeStructure)
                        
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $feeStructure->faculty->title ?? 'N/A' }}</td>
                                <td>{{ $feeStructure->program->title ?? 'N/A' }}</td>
                                <td>{{ $feeStructure->semester }}</td>
                                <td>{{ number_format($feeStructure->items->sum('amount'), 2) }}</td>
                                <td>
                                    @foreach($feeStructure->items as $item)
                                        <span class="badge badge-info">
                                            {{  $item->fee_category_title  ?? 'Uncategorized' }}: 
                                            {{ number_format($item->amount, 2) }}
                                        </span><br>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="badge badge-{{ $feeStructure->is_active ? 'success' : 'danger' }}">
                                        {{ $feeStructure->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    @can('view fee structures')
                                    <a href="{{ route($route.'.show', $feeStructure->id) }}" class="btn btn-info btn-sm" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endcan
                                    
                                    @can('edit fee structures')
                                    <a href="{{ route($route.'.edit', $feeStructure->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    
                                    <!-- Send Invoice Button -->
@can('create fee structures')
<button type="button" 
        class="btn btn-warning btn-sm" 
        title="Send Invoice to all enrolled students"
        data-bs-toggle="modal" 
        data-bs-target="#sendInvoiceModal-{{ $feeStructure->id }}">
    <i class="fas fa-paper-plane"></i> Send Invoices
</button>

<!-- Send Invoice Modal -->
<div class="modal fade" id="sendInvoiceModal-{{ $feeStructure->id }}" tabindex="-1" aria-labelledby="sendInvoiceModalLabel-{{ $feeStructure->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                
                    <h5 class="modal-title" id="sendInvoiceModalLabel-{{ $feeStructure->id }}">
                    <i class="fas fa-paper-plane me-2"></i> Send Invoices - {{ $feeStructure->program->title ?? 'N/A' }} (Semester {{ $feeStructure->semester }})
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.fee-structures.sendInvoice', $feeStructure->id) }}" method="POST" class="send-invoice-form">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> 
                        This will create invoices for ALL students enrolled in:
                        <strong>{{ $feeStructure->program->title ?? 'N/A' }}</strong> - 
                        Semester <strong>{{ $feeStructure->semester }}</strong>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="due_date-{{ $feeStructure->id }}" class="form-label fw-bold">Due Date</label>
                                <input type="date" 
                                    class="form-control" 
                                    id="due_date-{{ $feeStructure->id }}" 
                                    name="due_date"
                                    min="{{ date('Y-m-d') }}"
                                    value="{{ date('Y-m-d', strtotime('+30 days')) }}"
                                    required>
                                <small class="form-text text-muted">Select the payment due date</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold">Notification Options</label>
                                <div class="form-check">
                                    <input class="form-check-input" 
                                        type="checkbox" 
                                        id="send_sms-{{ $feeStructure->id }}" 
                                        name="send_sms" 
                                        value="1"
                                        checked>
                                    <label class="form-check-label" for="send_sms-{{ $feeStructure->id }}">
                                        Send SMS Notification
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" 
                                        type="checkbox" 
                                        id="send_email-{{ $feeStructure->id }}" 
                                        name="send_email" 
                                        value="1"
                                        checked>
                                    <label class="form-check-label" for="send_email-{{ $feeStructure->id }}">
                                        Send Email Notification
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle me-2"></i> 
    <strong>Warning:</strong> This action cannot be undone, students will receive invoices realtime.
</div>
                    
                    <div class="alert alert-light">
                        <h6 class="fw-bold">Fee Items Summary that will be sent:</h6>
                        <ul class="mb-0">
                            @foreach($feeStructure->items as $item)
                                <li>
                                    {{ $item->fee_category_title ?? 'Uncategorized' }}: 
                                    {{ number_format($item->amount, 2) }}
                                </li>
                            @endforeach
                            <li class="fw-bold mt-2">
                                Total Amount: {{ number_format($feeStructure->items->sum('amount'), 2) }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> Send Invoices
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
                                    
                                    @can('delete fee structures')
    <!-- Delete Button Triggering Modal -->
    <button type="button" class="btn btn-danger btn-sm" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteFeeStructureModal-{{ $feeStructure->id }}">
        <i class="fas fa-trash"></i>
    </button>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteFeeStructureModal-{{ $feeStructure->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route($route.'.destroy', $feeStructure->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Warning:</strong> This action cannot be undone. All related data will be permanently deleted.
                        </div>
                        
                        <div class="mb-3">
                            <label for="deleteReason-{{ $feeStructure->id }}" class="form-label required">
                                <i class="fas fa-comment-dots me-1"></i> Reason for deletion
                            </label>
                            <textarea class="form-control" id="deleteReason-{{ $feeStructure->id }}" 
                                      name="delete_reason" rows="3" required 
                                      placeholder="Please explain why you're deleting this fee structure"></textarea>
                            <div class="invalid-feedback">
                                Please provide a reason for deletion.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Confirm Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No fee structures found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($feeStructures->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $feeStructures->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Import Modal -->
@can('import fee structures')
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fas fa-file-import me-2"></i>Import Fee Structures
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route($route.'.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Import Guidelines</h5>
                        <hr>
                        <ol class="mb-0">
                            <li>Download our template file to ensure proper formatting</li>
                            <li>Keep the first row as header (column names)</li>
                            <li>Ensure all required fields are filled</li>
                            <li>Save your file in CSV, XLS, or XLSX format</li>
                        </ol>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-table me-2"></i>File Format Requirements</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Column</th>
                                            <th>Description</th>
                                            <th>Required</th>
                                            <th>Example</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Faculty</td>
                                            <td>Name of the faculty</td>
                                            <td><span class="badge bg-success">Yes</span></td>
                                            <td>Science and Technology</td>
                                        </tr>
                                        <tr>
                                            <td>Program</td>
                                            <td>Name of the program</td>
                                            <td><span class="badge bg-success">Yes</span></td>
                                            <td>Computer Science</td>
                                        </tr>
                                        <tr>
                                            <td>Semester</td>
                                            <td>Semester name or code</td>
                                            <td><span class="badge bg-success">Yes</span></td>
                                            <td>First Semester</td>
                                        </tr>
                                        <tr>
                                            <td>Fee Categories</td>
                                            <td>Category:Amount pairs (one per column)</td>
                                            <td><span class="badge bg-success">At least one</span></td>
                                            <td>Tuition Fee:50000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route($route.'.import-template') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-file-download me-2"></i>Download Template
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="import_file" class="form-label">
                            <i class="fas fa-file me-2"></i>Select File to Import
                        </label>
                        <input class="form-control" type="file" id="import_file" name="import_file" required>
                        <div class="form-text text-muted">
                            Supported formats: .csv, .xls, .xlsx (Max: 5MB)
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="header_row" name="header_row" checked>
                            <label class="form-check-label" for="header_row">
                                <i class="fas fa-check-square me-2"></i>First row contains column headers
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>Import File
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan

<!-- Send Invoice Modal -->
<div class="modal fade" id="sendInvoiceModal-{{ $feeStructure->id }}" tabindex="-1" aria-labelledby="sendInvoiceModalLabel-{{ $feeStructure->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                
                    <h5 class="modal-title" id="sendInvoiceModalLabel-{{ $feeStructure->id }}">
                    <i class="fas fa-paper-plane me-2"></i> Send Invoices - {{ $feeStructure->program->title ?? 'N/A' }} (Semester {{ $feeStructure->semester }})
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.fee-structures.sendInvoice', $feeStructure->id) }}" method="POST" class="send-invoice-form">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> 
                        This will create invoices for ALL students enrolled in:
                        <strong>{{ $feeStructure->program->title ?? 'N/A' }}</strong> - 
                        Semester <strong>{{ $feeStructure->semester }}</strong>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="due_date-{{ $feeStructure->id }}" class="form-label fw-bold">Due Date</label>
                                <input type="date" 
                                    class="form-control" 
                                    id="due_date-{{ $feeStructure->id }}" 
                                    name="due_date"
                                    min="{{ date('Y-m-d') }}"
                                    value="{{ date('Y-m-d', strtotime('+30 days')) }}"
                                    required>
                                <small class="form-text text-muted">Select the payment due date</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold">Notification Options</label>
                                <div class="form-check">
                                    <input class="form-check-input" 
                                        type="checkbox" 
                                        id="send_sms-{{ $feeStructure->id }}" 
                                        name="send_sms" 
                                        value="1"
                                        checked>
                                    <label class="form-check-label" for="send_sms-{{ $feeStructure->id }}">
                                        Send SMS Notification
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" 
                                        type="checkbox" 
                                        id="send_email-{{ $feeStructure->id }}" 
                                        name="send_email" 
                                        value="1"
                                        checked>
                                    <label class="form-check-label" for="send_email-{{ $feeStructure->id }}">
                                        Send Email Notification
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle me-2"></i> 
    <strong>Warning:</strong> This action cannot be undone, students will receive invoices realtime.
</div>
                    
                    <div class="alert alert-light">
                        <h6 class="fw-bold">Fee Items Summary that will be sent:</h6>
                        <ul class="mb-0">
                            @foreach($feeStructure->items as $item)
                                <li>
                                    {{ $item->fee_category_title ?? 'Uncategorized' }}: 
                                    {{ number_format($item->amount, 2) }}
                                </li>
                            @endforeach
                            <li class="fw-bold mt-2">
                                Total Amount: {{ number_format($feeStructure->items->sum('amount'), 2) }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> Send Invoices
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
    });
</script>

<script>
    $(function() {
        // Debugging - log when button is clicked
        $('[data-target="#importModal"]').click(function() {
            console.log('Import button clicked');
            $('#importModal').modal('show');
        });
        
        // Alternative manual trigger
        $('#importModal').modal({
            show: false
        });
    });
</script>
@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize date pickers
    document.querySelectorAll('input[type="date"]').forEach(function(input) {
        const today = new Date().toISOString().split('T')[0];
        input.min = today;
    });
    
    // Form submission confirmation
    document.querySelectorAll('.send-invoice-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const dueDate = form.querySelector('input[name="due_date"]').value;
            const sendSms = form.querySelector('input[name="send_sms"]').checked;
            const sendEmail = form.querySelector('input[name="send_email"]').checked;
            const program = form.closest('.modal-content').querySelector('.modal-title').textContent.trim();
            
            const message = `You are about to send invoices for:\n${program}\n\nWith these settings:
- Due Date: ${dueDate}
- SMS Notifications: ${sendSms ? 'Yes' : 'No'}
- Email Notifications: ${sendEmail ? 'Yes' : 'No'}

This action will create invoices for all enrolled students.\n\nAre you sure you want to proceed?`;
            
            if(!confirm(message)) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endsection

