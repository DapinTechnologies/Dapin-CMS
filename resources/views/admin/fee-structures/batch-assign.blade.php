@extends('admin.layouts.master')
@section('title', $title)
@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Batch Assign Fee Structures</h1>
    
    <div class="card">
        <div class="card-header">
            <h5>Filter Students</h5>
        </div>
        <div class="card-body">
            <form action="{{ route($route.'.batch-assign') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="faculty">Faculty</label>
                            <select name="faculty" id="faculty" class="form-control">
                                <option value="">All Faculties</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" {{ request('faculty') == $faculty->id ? 'selected' : '' }}>
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
                                <option value="">All Programs</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ request('program') == $program->id ? 'selected' : '' }}>
                                        {{ $program->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <select name="semester" id="semester" class="form-control">
                                <option value="">All Semesters</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->title }}" {{ request('semester') == $semester->title ? 'selected' : '' }}>
                                        {{ $semester->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="academic_year">Academic Year</label>
                            <select name="academic_year" id="academic_year" class="form-control">
                                <option value="">All Years</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year->id }}" {{ request('academic_year') == $year->id ? 'selected' : '' }}>
                                        {{ $year->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(isset($enrollments) && $enrollments->count())
    <div class="card mt-4">
        <div class="card-header">
            <h5>Assign Fee Structure to Selected Students</h5>
        </div>
        <div class="card-body">
            <form action="{{ route($route.'.batch-assign') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fee_structure_id">Fee Structure</label>
                            <select name="fee_structure_id" id="fee_structure_id" class="form-control" required>
                                <option value="">Select Fee Structure</option>
                                @foreach($feeStructures as $structure)
                                    <option value="{{ $structure->id }}">
                                        {{ $structure->faculty->title ?? 'N/A' }} - 
                                        {{ $structure->program->title ?? 'N/A' }} - 
                                        {{ $structure->semester }} - 
                                        {{ number_format($structure->total_amount, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="due_date">Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" required 
                                   min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Faculty</th>
                                <th>Program</th>
                                <th>Semester</th>
                                <th>Academic Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrollments as $enrollment)
                            <tr>
                                <td>
                                    <input type="checkbox" name="enrollments[]" value="{{ $enrollment->id }}" class="enrollment-checkbox">
                                </td>
                                <td>{{ $enrollment->student->student_id ?? 'N/A' }}</td>
                                <td>{{ $enrollment->student->name ?? 'N/A' }}</td>
                                <td>{{ $enrollment->faculty->title ?? 'N/A' }}</td>
                                <td>{{ $enrollment->program->title ?? 'N/A' }}</td>
                                <td>{{ $enrollment->semester }}</td>
                                <td>{{ $enrollment->academicYear->title ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Assign Fee Structure
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
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
                        $('#program').append('<option value="">All Programs</option>');
                        $.each(data, function(key, value) {
                            $('#program').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            } else {
                $('#program').empty();
                $('#program').append('<option value="">All Programs</option>');
            }
        });

        // Select all checkboxes
        $('#select-all').click(function() {
            $('.enrollment-checkbox').prop('checked', this.checked);
        });
    });
</script>
@endsection