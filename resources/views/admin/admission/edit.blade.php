@extends('admin.layouts.master')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Admission Process Step</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.admission.process.update', $step->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ $step->title }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3" required>{{ $step->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Requirements</label>
                                <div id="requirements-container">
                                    @php
                                        $requirements = $step->requirements ? json_decode($step->requirements, true) : [''];
                                    @endphp
                                    
                                    @foreach($requirements as $index => $requirement)
                                    <div class="input-group mb-2 requirement-item">
                                        <input type="text" class="form-control" name="requirements[]" value="{{ $requirement }}" placeholder="Enter requirement" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger remove-requirement" {{ count($requirements) <= 1 ? 'disabled' : '' }}>
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-success btn-sm mt-2" id="add-requirement">
                                    <i class="fas fa-plus"></i> Add Requirement
                                </button>
                                <small class="form-text text-muted">Add multiple requirements using the button above</small>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.admission.process.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add requirement
    document.getElementById('add-requirement').addEventListener('click', function() {
        const container = document.getElementById('requirements-container');
        const newItem = document.createElement('div');
        newItem.className = 'input-group mb-2 requirement-item';
        newItem.innerHTML = `
            <input type="text" class="form-control" name="requirements[]" placeholder="Enter requirement" required>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove-requirement">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        container.appendChild(newItem);
        
        // Enable all remove buttons
        document.querySelectorAll('.remove-requirement').forEach(btn => {
            btn.disabled = false;
        });
    });

    // Remove requirement
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-requirement') || 
            e.target.parentElement.classList.contains('remove-requirement')) {
            
            const btn = e.target.classList.contains('remove-requirement') ? 
                       e.target : e.target.parentElement;
            const item = btn.closest('.requirement-item');
            
            if (document.querySelectorAll('.requirement-item').length > 1) {
                item.remove();
                
                // Disable remove buttons if only one requirement left
                if (document.querySelectorAll('.requirement-item').length === 1) {
                    document.querySelectorAll('.remove-requirement').forEach(btn => {
                        btn.disabled = true;
                    });
                }
            }
        }
    });
});
</script>
@endsection