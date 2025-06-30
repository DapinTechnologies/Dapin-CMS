@extends('admin.layouts.master')
@section('title', 'Assign Fee Categories')
@section('content')

<h4>Assign Fee Categories</h4>

<form method="POST" action="{{ route('admin.fees-category.store-multiple') }}">
    @csrf

    <!-- Dynamic Categories + Amounts -->
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

<!-- Display Assigned Categories & Amounts -->
@if(session('assignedCategories'))
    <h5>Assigned Categories and Amounts:</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Category</th>
                <th>Amount (Ksh)</th>
            </tr>
        </thead>
        <tbody>
            @foreach(session('assignedCategories') as $category)
                <tr>
                    <td>{{ $category['name'] }}</td>
                    <td>{{ number_format($category['amount'], 2) }}</td>
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
