@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4" style="font-size: 1.25rem;">{{ $title }} - Create</h1>
    
    <div class="card">
        <div class="card-header">
            <h5>Fee Structure Details</h5>
        </div>
        <div class="card-body">
            <form action="{{ route($route.'.store') }}" method="POST" id="fee-structure-form">
                @csrf
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="faculty_id">Faculty *</label>
                            <select name="faculty_id" id="faculty_id" class="form-control select2" required>
                                <option value="">Select Faculty</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                        {{ $faculty->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="program_id">Program *</label>
                            <select name="program_id" id="program_id" class="form-control select2" required>
                                <option value="">Select Program</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                        {{ $program->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="semester">Semester *</label>
                            <select name="semester" id="semester" class="form-control" required>
                                <option value="">Select Semester</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->title }}" {{ old('semester') == $semester->title ? 'selected' : '' }}>
                                        {{ $semester->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="form-group">
                    <label>Select Fee Categories *</label>
                    @error('fee_categories')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">Select</th>
                                    <th width="25%">Category</th>
                                    <th width="15%" class="text-center">Amount</th>
                                    <th width="15%" class="text-center">One-Time Fee</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                <tr>
                                    <td class="text-center">
                                        <input 
                                            type="checkbox" 
                                            name="fee_categories[]" 
                                            value="{{ $category->id }}"
                                            id="category_{{ $category->id }}"
                                            class="fee-category-checkbox"
                                            data-amount="{{ $category->amount }}"
                                            @checked(is_array(old('fee_categories')) && in_array($category->id, old('fee_categories')))
                                        >
                                    </td>
                                    <td>
                                        <label for="category_{{ $category->id }}">{{ $category->title }}</label>
                                        @if($category->description)
                                            <p class="text-muted mb-0">{{ $category->description }}</p>
                                        @endif
                                    </td>
                                    <td class="text-center">KES {{ number_format($category->amount, 2) }}</td>
                                    <td class="text-center">
                                        <div class="form-check d-flex justify-content-center">
                                            <input 
                                                type="checkbox" 
                                                name="one_time[{{ $category->id }}]"
                                                class="form-check-input one-time-checkbox"
                                                value="1"
                                                @checked(old('one_time.'.$category->id))
                                            >
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No fee categories available</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                <!-- Bulk Assignment Section - Updated Format -->
<div class="card mt-4">
    <div class="card-header">
        <h5>Bulk Student Invoice Assignment</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="assign_to_students" 
                            id="assign_to_students" value="1" {{ old('assign_to_students') ? 'checked' : '' }}>
                        <label class="form-check-label" for="assign_to_students">
                            Assign to all enrolled students
                        </label>
                    </div>
                    <small class="text-muted">Will create invoices for all currently enrolled students</small>
                </div>
            </div>
        </div>

        <div id="assignment-options" style="{{ old('assign_to_students') ? '' : 'display: none;' }}">
           
        </div>
    </div>
</div>
 <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="due_date">Due Date *</label>
                        <input type="date" name="due_date" id="due_date" 
                            class="form-control" 
                            value="{{ old('due_date', \Carbon\Carbon::today()->addDays(30)->format('Y-m-d')) }}"
                            min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                            required>
                        <small class="text-muted">Date when payment is due</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Notification Options</label>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="notify_students" 
                                id="notify_students" value="1" {{ old('notify_students') ? 'checked' : '' }}>
                            <label class="form-check-label" for="notify_students">
                                Send SMS notifications
                            </label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="send_invoices" 
                                id="send_invoices" value="1" {{ old('send_invoices') ? 'checked' : '' }}>
                            <label class="form-check-label" for="send_invoices">
                                Email invoice copies
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i> This will create invoices for approximately 
                <span id="estimated-students-count"></span> All students, Kindly Confirm with fees due module
                
            </div>
        </div>
    </div>
</div>
                
                <div class="form-group text-right mt-4">
                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        <i class="fas fa-save"></i> Create Fee Structure
                    </button>
                    <a href="{{ route($route.'.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    // Initialize select2
    $('.select2').select2({ 
        width: '100%',
        placeholder: "Select an option",
        allowClear: true
    });

    // Faculty-Program dependency
    $('#faculty_id').change(function () {
        let facultyId = $(this).val();
        let programSelect = $('#program_id');
        
        programSelect.prop('disabled', true).empty().append('<option value="">Loading...</option>');
        
        if (facultyId) {
            $.ajax({
                url: '/admin/get-programs/' + facultyId,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    programSelect.empty().append('<option value="">Select Program</option>');
                    $.each(data, function (key, value) {
                        programSelect.append($('<option>', {
                            value: key,
                            text: value
                        }));
                    });
                    programSelect.prop('disabled', false);
                },
                error: function() {
                    programSelect.empty().append('<option value="">Error loading programs</option>');
                }
            });
        } else {
            programSelect.empty().append('<option value="">Select Program</option>').prop('disabled', false);
        }
    });

    // Toggle assignment options
    $('#assign_to_students').change(function() {
        if ($(this).is(':checked')) {
            $('#assignment-options').slideDown();
            estimateStudents();
        } else {
            $('#assignment-options').slideUp();
        }
    });

    // Calculate totals when checkboxes change
    $(document).on('change', '.fee-category-checkbox', function() {
        calculateTotals();
        if ($('#assign_to_students').is(':checked')) {
            estimateStudents();
        }
    });

    // Calculate total amount
    function calculateTotals() {
        let total = 0;
        $('.fee-category-checkbox:checked').each(function() {
            total += parseFloat($(this).data('amount')) || 0;
        });
        $('#total-amount').text('KES ' + total.toFixed(2));
        return total;
    }

    // Estimate number of students and total value
    function estimateStudents() {
        const facultyId = $('#faculty_id').val();
        const programId = $('#program_id').val();
        const semester = $('#semester').val();
        const totalAmount = calculateTotals();

        if (facultyId && programId && semester && totalAmount > 0) {
            $.ajax({
                url: '/admin/estimate-students',
                type: "GET",
                data: {
                    faculty_id: facultyId,
                    program_id: programId,
                    semester: semester
                },
                success: function (response) {
                    $('#estimated-students-count').text(response.count);
                    $('#estimated-total').text('KES ' + (response.count * totalAmount).toFixed(2));
                },
                error: function() {
                    $('#estimated-students-count').text('N/A');
                    $('#estimated-total').text('KES N/A');
                }
            });
        } else {
            $('#estimated-students-count').text('0');
            $('#estimated-total').text('KES 0.00');
        }
    }

    // Form validation
    $('#fee-structure-form').submit(function(e) {
        const $submitBtn = $('#submit-btn');
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

        // Validate at least one category is selected
        if ($('.fee-category-checkbox:checked').length === 0) {
            e.preventDefault();
            alert('Please select at least one fee category.');
            $submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Create Fee Structure');
            return false;
        }

        // Validate due date if assigning to students
        if ($('#assign_to_students').is(':checked') && !$('#due_date').val()) {
            e.preventDefault();
            alert('Please select a due date when assigning to students.');
            $submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Create Fee Structure');
            return false;
        }

        // Confirm bulk operation
        if ($('#assign_to_students').is(':checked')) {
            const studentCount = parseInt($('#estimated-students-count').text()) || 0;
            if (studentCount > 50) {
                const confirmed = confirm(`You are about to create invoices for ${studentCount} students. This may take some time. Continue?`);
                if (!confirmed) {
                    e.preventDefault();
                    $submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Create Fee Structure');
                    return false;
                }
            }
        }
    });

    // Trigger change events when page loads with old input
    @if(old('assign_to_students'))
        $('#assign_to_students').trigger('change');
    @endif

    // Initial calculations
    calculateTotals();
});
</script>
@endpush