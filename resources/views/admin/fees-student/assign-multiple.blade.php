@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<h4>Assign Multiple Fee Categories</h4>
<!-- Link to Assigned Fees History page -->
<a href="{{ route('admin.fees-student.assigned-history') }}" class="btn btn-info mb-3">
    View Assigned Fees History
</a>
<a href="{{ route('admin.fees-summary') }}" class="btn btn-info mb-3">View School Fees Summary</a>

<form method="POST" action="{{ route('admin.fees-student.store-multiple') }}">
    @csrf

    <!-- Single select student -->
    <div class="form-group">
        <label>Select Student</label>
        <select name="student_id" class="form-control" required>
            <option value="">-- Select Student --</option>
            @foreach($students as $enroll)
                @if($enroll->student)
                <option value="{{ $enroll->id }}">
                    {{ $enroll->student->student_id }} - {{ $enroll->student->first_name }} {{ $enroll->student->last_name }}
                </option>
                @endif
            @endforeach
        </select>
    </div>

    <!-- Categories + Amounts dynamic rows -->
    <div id="category-section">
        <div class="form-group d-flex category-row">
            <select name="categories[]" class="form-control" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                @endforeach
            </select>
            <input type="number" name="amounts[]" class="form-control ml-2" placeholder="Amount" min="0" required>
            <button type="button" class="btn btn-danger ml-2 remove-category-btn" title="Remove Category">&times;</button>
        </div>
    </div>

    <button type="button" class="btn btn-secondary mb-2" id="add-category-btn">+ Add Category</button>
    <button type="submit" class="btn btn-primary">Assign</button>
</form>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('assignedFees') && session('studentEnroll'))
    <h5>Assigned Fees for 
        {{ session('studentEnroll')->student->student_id }} - 
        {{ session('studentEnroll')->student->first_name }} {{ session('studentEnroll')->student->last_name }}
    </h5>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Category</th>
                <th>Amount (Ksh)</th>
                <th>Assigned Date</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach(session('assignedFees') as $fee)
                <tr>
                    <td>{{ $fee->category->title ?? 'N/A' }}</td>
                    <td>{{ number_format($fee->fee_amount, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($fee->assign_date)->format('d-M-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($fee->due_date)->format('d-M-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Add new category + amount row
    $('#add-category-btn').on('click', function() {
        const newRow = `
            <div class="form-group d-flex category-row">
                <select name="categories[]" class="form-control" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                    @endforeach
                </select>
                <input type="number" name="amounts[]" class="form-control ml-2" placeholder="Amount" min="0" required>
                <button type="button" class="btn btn-danger ml-2 remove-category-btn" title="Remove Category">&times;</button>
            </div>`;
        $('#category-section').append(newRow);
    });

    // Remove category + amount row
    $('#category-section').on('click', '.remove-category-btn', function() {
        if ($('.category-row').length > 1) {
            $(this).closest('.category-row').remove();
        } else {
            alert('At least one category is required.');
        }
    });
});
</script>

@endsection
