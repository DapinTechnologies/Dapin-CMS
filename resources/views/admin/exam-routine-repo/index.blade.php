@extends('admin.layouts.master')
@section('title', $title)

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>All Exam Timetables</h5>
                    </div>
                    
                    <div class="card-block">
                        <p style="background-color: #fff8e1; color: #795548; padding: 15px; border-left: 6px solid #ffb300;">
                            <strong>Notice:</strong> Use the filter to narrow down the exam report listings.
                        </p>

                        <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>

                        <button type="button" class="btn btn-primary" id="toggle-filter-btn">
                            <i class="fas fa-filter"></i> {{ __('btn_filter') }}
                        </button>
                    </div>

                    <div class="card-block" id="filter-section" style="display: none;">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row">

                                {{-- Faculty Filter --}}
                                <div class="form-group col-md-3">
                                    <label for="faculty">{{ __('field_faculty') }} <span>*</span></label>
                                    <select class="form-control" name="faculty" id="faculty" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($faculties as $faculty)
                                            <option value="{{ $faculty->id }}" @if($selected_faculty == $faculty->id) selected @endif>
                                                {{ $faculty->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                               

                               
                               


                                {{-- Exam Type Filter --}}
                                <div class="form-group col-md-3">
                                    <label for="type">{{ __('field_type') }} <span>*</span></label>
                                    <select class="form-control" name="type" id="type" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" @if($selected_type == $type->id) selected @endif>
                                                {{ $type->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3 align-self-end">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-search"></i> {{ __('btn_filter') }}
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
                                        <th>{{ __('field_faculty') }}</th>
                                        
                                        
                                        <th>{{ __('field_type') }}</th>
                                        <th>{{ __('field_start_date') }}</th>
                                        <th>{{ __('field_end_date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->faculty_title ?? 'N/A' }}</td>
                                        
                                        <td>{{ $row->exam_type_title ?? 'N/A' }}</td>
                                        <td>{{ isset($setting->date_format) ? date($setting->date_format, strtotime($row->date)) : date("Y-m-d", strtotime($row->date)) }}</td>
                                        <td>{{ isset($setting->date_format) 
                                                ? date($setting->date_format, strtotime($row->end_date ?? $row->date)) 
                                                : date("Y-m-d", strtotime($row->end_date ?? $row->date)) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <p class="text-center text-muted">{{ __('No data found.') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

       
    });
</script>
@endsection
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr for notifications (if you're using it) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endsection