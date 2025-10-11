@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4" style="font-size: 1.25rem;">{{ $title }} - {{ isset($feeStructure) ? 'Edit' : 'Create' }}</h1>
    
    <div class="card">
        <div class="card-header">
            <h5>Fee Structure Details</h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($feeStructure) ? route($route.'.update', $feeStructure->id) : route($route.'.store') }}" method="POST">
                @csrf
                @if(isset($feeStructure))
                    @method('PUT')
                @endif
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="faculty_id">Faculty *</label>
                            <select name="faculty_id" id="faculty_id" class="form-control select2" required>
                                <option value="">Select Faculty</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" 
                                        {{ (isset($feeStructure) && $feeStructure->faculty_id == $faculty->id) ? 'selected' : (old('faculty_id') == $faculty->id ? 'selected' : '') }}>
                                        {{ $faculty->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="program_id">Course *</label>
                            <select name="program_id" id="program_id" class="form-control select2" required>
                                <option value="">Select Course</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" 
                                        {{ (isset($feeStructure) && $feeStructure->program_id == $program->id) ? 'selected' : (old('program_id') == $program->id ? 'selected' : '') }}>
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
                                    <option value="{{ $semester->title }}" 
                                        {{ (isset($feeStructure) && $feeStructure->semester == $semester->title) ? 'selected' : (old('semester') == $semester->title ? 'selected' : '') }}>
                                        {{ $semester->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                
                <div class="form-group">
                    <label>Select Fee Types *</label>
                    @error('fee_categories')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">Select</th>
                                    <th width="10%">Fees Type</th>

                                    <th width="15%" class="text-center">Fee Amount</th>
                                    <th width="10%" class="text-center">One-Time Fee</th>
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
                                            @checked(isset($selectedCategories) && in_array($category->id, $selectedCategories))
                                            class="fee-category-checkbox"
                                            data-amount="{{ $category->amount }}"
                                        >
                                    </td>
                                    <td>
                                        <label for="category_{{ $category->id }}">{{ $category->title }}</label>
                                    </td>
                                    
                                    
                                    <td class="text-center">KES {{ number_format($category->amount, 2) }}</td>
                                    <td class="text-center">
                                        <div class="form-check d-flex justify-content-center">
    <input 
        type="checkbox" 
        name="one_time[{{ $category->id }}]"
        class="form-check-input one-time-checkbox"
        value="1"
        @if(isset($feeStructure))
            @php
                $item = $feeStructure->items->where('fees_category_id', $category->id)->first();
            @endphp
            @if($item && $item->is_one_time) checked @endif
        @endif
    >
</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No fee categories available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                
                
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ isset($feeStructure) ? 'Update' : 'Save' }}
                    </button>
                    <a href="{{ route($route.'.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-times"></i> Back to List
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
                    
                    // Restore selected value if editing
                    @if(isset($feeStructure))
                        programSelect.val('{{ $feeStructure->program_id }}').trigger('change');
                    @endif
                },
                error: function() {
                    programSelect.empty().append('<option value="">Error loading programs</option>');
                }
            });
        } else {
            programSelect.empty().append('<option value="">Select Program</option>').prop('disabled', false);
        }
    });

    // Trigger initial calculation
    calculateTotals();

    // Calculate totals when checkboxes change
    $(document).on('change', '.fee-category-checkbox', calculateTotals);

    // Calculation function
    function calculateTotals() {
        let grandTotal = 0;
        let selectedCount = 0;

        $('.fee-category-checkbox:checked').each(function() {
            const amount = parseFloat($(this).data('amount')) || 0;
            grandTotal += amount;
            selectedCount++;
        });

        // Update the displayed total
        $('#total-amount').text('KES ' + grandTotal.toFixed(2));
        
        // Highlight if no categories selected
        if (selectedCount === 0) {
            $('#total-amount').addClass('text-danger');
        } else {
            $('#total-amount').removeClass('text-danger');
        }
    }

    // Form validation
    $('form').submit(function(e) {
        if ($('.fee-category-checkbox:checked').length === 0) {
            e.preventDefault();
            alert('Please select at least one fee category.');
            return false;
        }
    });
});
</script>
@endpush