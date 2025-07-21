@extends('admin.layouts.master')
@section('title', 'Edit Invoice')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Invoice #{{ $invoice->invoice_no }}</h5>
                    </div>

                    <form action="{{ route('admin.fees-student.update', $invoice->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-block">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Student Name</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $invoice->studentEnroll->student->full_name }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Student ID</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $invoice->studentEnroll->student->student_id }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Invoice No</label>
                                    <input type="text" class="form-control" name="invoice_no" 
                                           value="{{ $invoice->invoice_no }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Assign Date</label>
                                    <input type="date" class="form-control" name="assign_date" 
                                           value="{{ $invoice->assign_date }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Due Date</label>
                                    <input type="date" class="form-control" name="due_date" 
                                           value="{{ $invoice->due_date }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Fee Categories</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="feeCategoriesTable">
                                        <thead>
                                            <tr>
                                                <th width="50%">Category</th>
                                                <th width="30%">Amount</th>
                                                <th width="20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="feeCategoriesBody">
                                            @foreach($invoice->fees as $fee)
                                            <tr data-category-id="{{ $fee->category_id }}">
                                                <td>
                                                    {{ $fee->category->title }}
                                                    <input type="hidden" name="fees[{{ $fee->category_id }}][category_id]" 
                                                           value="{{ $fee->category_id }}">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control fee-amount" 
                                                           name="fees[{{ $fee->category_id }}][amount]" 
                                                           value="{{ $fee->amount }}" step="0.01" min="0" required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger remove-category-btn">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>
                                                    <select class="form-select" id="availableCategories">
                                                        <option value="">Select a category</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" 
                                                                    data-amount="{{ $category->amount }}">
                                                                {{ $category->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" id="categoryAmount" step="0.01" min="0">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary" id="addCategoryBtn">Add</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end">
                                                    <strong>Total: <span id="totalAmount">{{ number_format($invoice->total_fee, 2) }}</span></strong>
                                                    <input type="hidden" name="total_fee" id="totalAmountInput" value="{{ $invoice->total_fee }}">
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Invoice</button>
                            <a href="{{ route('admin.fees-student.show', $invoice->id) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Add category
    $('#addCategoryBtn').click(function() {
        const categoryId = $('#availableCategories').val();
        const categoryText = $('#availableCategories option:selected').text();
        const defaultAmount = parseFloat($('#availableCategories option:selected').data('amount')) || 0;
        const customAmount = parseFloat($('#categoryAmount').val()) || defaultAmount;
        
        if (!categoryId) {
            alert('Please select a category');
            return;
        }
        
        // Check if category already exists
        if ($(`#feeCategoriesBody tr[data-category-id="${categoryId}"]`).length) {
            alert('This category is already added');
            return;
        }
        
        // Add new row
        $('#feeCategoriesBody').append(`
            <tr data-category-id="${categoryId}">
                <td>
                    ${categoryText}
                    <input type="hidden" name="fees[${categoryId}][category_id]" value="${categoryId}">
                </td>
                <td>
                    <input type="number" class="form-control fee-amount" 
                           name="fees[${categoryId}][amount]" 
                           value="${customAmount.toFixed(2)}" step="0.01" min="0" required>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-category-btn">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);
        
        // Update total
        updateTotalAmount();
        
        // Reset inputs
        $('#availableCategories').val('');
        $('#categoryAmount').val('');
    });
    
    // Remove category
    $(document).on('click', '.remove-category-btn', function() {
        $(this).closest('tr').remove();
        updateTotalAmount();
    });
    
    // Update amount when changed
    $(document).on('change', '.fee-amount', function() {
        updateTotalAmount();
    });
    
    // Auto-fill amount when category selected
    $('#availableCategories').change(function() {
        const amount = parseFloat($(this).find('option:selected').data('amount')) || 0;
        $('#categoryAmount').val(amount.toFixed(2));
    });
    
    // Function to update total amount
    function updateTotalAmount() {
        let total = 0;
        $('.fee-amount').each(function() {
            const amount = parseFloat($(this).val()) || 0;
            total += amount;
        });
        
        $('#totalAmount').text(total.toFixed(2));
        $('#totalAmountInput').val(total.toFixed(2));
    }
});
</script>
@endpush