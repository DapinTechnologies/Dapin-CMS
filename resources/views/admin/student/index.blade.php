@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        @can($access.'-create')
                        <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan

                        <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>

                        @can($access.'-import')
                        <a href="{{ route($route.'.import') }}" class="btn btn-dark"><i class="fas fa-upload"></i> {{ __('btn_import') }}</a>
                        @endcan

                        @isset($rows)
                        @can($access.'-password-print')
                        <form class="needs-validation d-inline" novalidate method="get" action="{{ route($route.'.password-multiprint') }}" target="_blank">
                            <input type="hidden" name="students" class="students" value="">
                            <button type="submit" class="btn btn-sm btn-dark print-btn"><i class="fas fa-print"></i> {{ __('field_password') }}</button>
                        </form>
                        @endcan
                        @endisset
                    </div>
                    
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row gx-2">
                                @include('common.inc.student_search_filter')

                                <div class="form-group col-md-3">
                                    <label for="status">{{ __('field_status') }}</label>
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="0">{{ __('all') }}</option>
                                        @foreach( $statuses as $status )
                                        <option value="{{ $status->id }}" @if( $selected_status == $status->id) selected @endif>{{ $status->title }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_status') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="student_id">{{ __('field_student_id') }}</label>
                                    <input type="text" class="form-control" name="student_id" id="student_id" value="{{ $selected_student_id }}">

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_student_id') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

           @isset($rows)
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">

                           <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
    <thead>
        <tr>
            <th># 
                <div class="checkbox checkbox-success d-inline">
                    <input type="checkbox" id="checkbox" class="all_select">
                    <label for="checkbox" class="cr" style="margin-bottom: 0px;"></label>
                </div>
            </th>
            <th>{{ __('field_student_id') }}</th>
            <th>{{ __('field_name') }}</th>
            <th>{{ __('field_program') }}</th>
            <th>{{ __('field_session') }}</th>
            <th>{{ __('field_semester') }}</th>
            <th>{{ __('field_section') }}</th>
            <th>{{ __('field_status') }}</th>
            <th>{{ __('field_action') }}</th>
        </tr>
    </thead>
    <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
        <thead>
            <tr>
                <th># 
                    <div class="checkbox checkbox-success d-inline">
                        <input type="checkbox" id="checkbox" class="all_select">
                        <label for="checkbox" class="cr" style="margin-bottom: 0px;"></label>
                    </div>
                </th>
                <th>{{ __('field_student_id') }}</th>
                <th>{{ __('field_name') }}</th>
                <th>{{ __('field_program') }}</th>
                <th>{{ __('field_session') }}</th>
                <th>{{ __('field_semester') }}</th>
                <th>{{ __('field_section') }}</th>
                <th>{{ __('field_status') }}</th>
                <th>{{ __('field_action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $key => $row)
            @php
                $enroll = \App\Models\Student::enroll($row->id);
            @endphp
            <tr class="{{ $loop->first ? 'table-success' : '' }}"> <!-- Highlight the latest entry -->
                <td>
                    {{ $key + 1 }}
                    <div class="checkbox checkbox-primary d-inline">
                        <input type="checkbox" data_id="{{ $row->id }}" id="checkbox-{{ $row->id }}" value="{{ $row->id }}">
                        <label for="checkbox-{{ $row->id }}" class="cr"></label>
                    </div>
                </td>
                <td>
                    <a href="{{ route($route.'.show', $row->id) }}">
                        #{{ $row->student_id }}
                    </a>
                </td>
                <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                <td>{{ $row->program->shortcode ?? '' }}</td>
                <td>{{ $enroll->session->title ?? '' }}</td>
                <td>{{ $enroll->semester->title ?? '' }}</td>
                <td>{{ $enroll->section->title ?? '' }}</td>
                <td>
                    @foreach($row->statuses as $status)
                    <span class="badge badge-primary">{{ $status->title }}</span><br>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route($route.'.show', $row->id) }}" class="btn btn-icon btn-success btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                    @can($access.'-edit')
                    <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-icon btn-primary btn-sm">
                        <i class="far fa-edit"></i>
                    </a>
                    @endcan
                    @can($access.'-delete')
                    <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    @include('admin.layouts.inc.delete')
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</table>

                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
            </div>
           @endisset
            
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')
<script type="text/javascript">
    "use strict";
    $(document).ready(function() {
        $(".print-btn").on('click',function(e){

            var numberOfChecked = $("input[data_id]:checked").length;
            if(numberOfChecked <= 0){
                e.preventDefault();
                alert("{{ __('select') }} {{ __('field_student') }}");
            }

            var students = [];
            $.each($("input[data_id]:checked"), function(){
                students.push($(this).val());
            });

            $(".students").val( students.join(',') );
        });
    });

    // checkbox all-check-button selector
    $(".all_select").on('click',function(e){
        if($(this).is(":checked")){
            // check all checkbox
            $("input:checkbox").prop('checked', true);
        }
        else if($(this).is(":not(:checked)")){
            // uncheck all checkbox
            $("input:checkbox").prop('checked', false);
        }
    });
</script>
@endsection