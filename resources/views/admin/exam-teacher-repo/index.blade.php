@extends('admin.layouts.master')
@section('title', $title)

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Invigilation Exam Schedule</h5>
                    </div>
                    
                    <div class="card-block">
                        <p style="background-color: #fff8e1; color: #795548; padding: 15px; border-left: 6px solid #ffb300;">
                            <strong>Notice:</strong> Search by teacher name and/or exam date to view schedules.
                        </p>

                        <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>

                        <button type="button" class="btn btn-primary" id="toggle-filter-btn">
                            <i class="fas fa-filter"></i> {{ __('btn_filter') }}
                        </button>
                    </div>

                    <div class="card-block" id="filter-section" style="display: none;">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row">
                                <!-- Teacher Search Fields -->
                                <div class="form-group col-md-6">
                                    <label for="teacher_id">Select Teacher</label>
                                    <select class="form-control select2" name="teacher_id" id="teacher_id">
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" 
                                                
                                                {{ $teacher->first_name }} {{ $teacher->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="exam_date">Exam Date</label>
                                    <input type="date" class="form-control" name="exam_date" id="exam_date" 
                                           value="{{ $request->exam_date ?? '' }}">
                                </div>

                                <div class="form-group col-md-3 align-self-end">
                                    <button type="submit" class="btn btn-info btn-block">
                                        <i class="fas fa-search"></i> {{ __('btn_search') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-block">
                        @if(isset($rows) && count($rows))
                        <div class="table-responsive">
                           <table class="display table table-striped table-hover nowrap" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Invigilitor</th>
            <th>Unit</th>
            {{--<th>Exam Type</th>--}}
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Room</th>
            <th>Program</th>
            <th>Faculty</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $key => $row)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>
                @if($row->users && $row->users->count() > 0)
                    {{ $row->users->map(fn($user) => $user->first_name . ' ' . $user->last_name)->implode(', ') }}
                @else
                    N/A
                @endif
            </td>
            <td>
                @if(isset($row->subject->title))
                    {{ $row->subject->title }}
                    @if(isset($row->subject->name))
                        ({{ $row->subject->id }})
                    @endif
                @elseif(isset($row->subject_title))
                    {{ $row->subject_title }}
                    @if(isset($row->subject_code))
                        ({{ $row->subject_code }})
                    @endif
                @else
                    N/A
                @endif
            </td>
           
    {{-- <td>{{ $row->examType->title ?? 'N/A' }}</td> --}}



            <td>
                @if(isset($row->date))
                    {{ isset($setting->date_format) ? date($setting->date_format, strtotime($row->date)) : date("Y-m-d", strtotime($row->date)) }}
                @else
                    N/A
                @endif
            </td>
            <td>
                @if(isset($row->start_time))
                    {{ date('h:i A', strtotime($row->start_time)) }}
                @else
                    N/A
                @endif
            </td>
            <td>
                @if(isset($row->end_time))
                    {{ date('h:i A', strtotime($row->end_time)) }}
                @else
                    N/A
                @endif
            </td>
            <td>
                                            @foreach($row->rooms as $room)
                                            {{ $room->title }}@if($loop->last) @else , @endif
                                            @endforeach
                                        </td>
            <td>{{ $row->program->title ?? ($row->program_title ?? 'N/A') }}</td>
            <td>{{ $row->program->faculty->title ?? 'N/A' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
                        </div>
                        @else
                            <p class="text-center text-muted">{{ __('No exam schedules found.') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleFilterBtn = document.getElementById('toggle-filter-btn');
        const filterSection = document.getElementById('filter-section');

        toggleFilterBtn.addEventListener('click', function() {
            filterSection.style.display = (filterSection.style.display === 'none') ? 'block' : 'none';
        });

        if (new URLSearchParams(window.location.search).toString() !== '') {
            filterSection.style.display = 'block';
        }

        // Initialize Select2 for teacher dropdown
        $('.select2').select2({
            placeholder: "Select a teacher",
            allowClear: true
        });

        
        // Faculty-Program AJAX
        $('#faculty').change(function() {
            var faculty_id = $(this).val();
            $('#program').html('<option value="0">{{ __("all") }}</option>');
            if (faculty_id != 0) {
                $.ajax({
                    url: "{{ route($route.'.index') }}",
                    type: "GET",
                    data: {
                        faculty_id: faculty_id
                    },
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $("#program").append('<option value="' + value.id + '">' + value.title + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>
@endsection