@extends('admin.layouts.master')
@section('title', $title)
@section('content')
@flasher_render 
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    
                    <!-- Success or Error Alert -->
                    @if(session('success'))
                        <script>
                            toastr.success("{{ session('success') }}", "Success", {
                                "positionClass": "toast-top-right",
                                "closeButton": true,
                                "progressBar": true
                            });
                        </script>
                    @elseif(session('error'))
                        <script>
                            toastr.error("{{ session('error') }}", "Error", {
                                "positionClass": "toast-top-right",
                                "closeButton": true,
                                "progressBar": true
                            });
                        </script>
                    @endif

                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-2">
                                    <label for="program">{{ __('field_program') }}</label>
                                    <select class="form-control" name="program" id="program">
                                        <option value="0">{{ __('all') }}</option>
                                        @foreach( $programs as $program )
                                            <option value="{{ $program->id }}" @if( $selected_program == $program->id) selected @endif>{{ $program->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="status">{{ __('field_status') }}</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="">{{ __('all') }}</option>
                                        <option value="1" @if( $selected_status == 1 ) selected @endif>{{ __('status_pending') }}</option>
                                        <option value="2" @if( $selected_status == 2 ) selected @endif>{{ __('status_approved') }}</option>
                                        <option value="0" @if( $selected_status == 0 ) selected @endif>{{ __('status_rejected') }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="start_date">{{ __('field_from_date') }}</label>
                                    <input type="date" class="form-control date" name="start_date" id="start_date" value="{{ $selected_start_date }}" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="end_date">{{ __('field_to_date') }}</label>
                                    <input type="date" class="form-control date" name="end_date" id="end_date" value="{{ $selected_end_date }}" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="registration_no">{{ __('field_registration_no') }}</label>
                                    <input type="text" class="form-control" name="registration_no" id="registration_no" value="{{ $selected_registration_no }}">
                                </div>
                                <div class="form-group col-md-2">
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
                                        <th>#</th>
                                        <th>{{ __('field_registration_no') }}</th>
                                        <th>{{ __('field_name') }}</th>
                                        <th>{{ __('field_gender') }}</th>
                                        <th>{{ __('field_program') }}</th>
                                        <th>{{ __('field_apply_date') }}</th>
                                        <th>{{ __('field_status') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a href="{{ route($route.'.show', $row->id) }}">#{{ $row->registration_no }}</a>
                                        </td>
                                        <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                                        <td>{{ $row->gender == 1 ? __('gender_male') : ($row->gender == 2 ? __('gender_female') : __('gender_other')) }}</td>
                                        <td>{{ $row->program->title ?? '' }}</td>
                                        <td>{{ date("Y-m-d", strtotime($row->apply_date)) }}</td>
                                        <td>
                                            @if( $row->status == 1 )
                                            <span class="badge badge-pill badge-primary">{{ __('status_pending') }}</span>
                                            @elseif( $row->status == 2 )
                                            <span class="badge badge-pill badge-success">{{ __('status_approved') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-danger">{{ __('status_rejected') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route($route.'.show', $row->id) }}" class="btn btn-icon btn-success btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if( $row->status == 1 )
                                            @can($access.'-create')
                                            <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-icon btn-primary btn-sm">
                                                <i class="fa-solid fa-right-from-bracket"></i>
                                            </a>
                                            @endcan

                                            @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" title="{{ __('status_rejected') }}" data-bs-toggle="modal" data-bs-target="#cancelModal-{{ $row->id }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <!-- Include Cancel modal -->
                                            @include($view.'.cancel')
                                            @endcan

                                            @elseif( $row->status == 0 )
                                            @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-success btn-sm" title="{{ __('status_pending') }}" data-bs-toggle="modal" data-bs-target="#cancelModal-{{ $row->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <!-- Include Cancel modal -->
                                            @include($view.'.cancel')
                                            @endcan
                                            @endif
                                            
                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')
                                            @endcan
                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>
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

<script type="text/javascript">
    @if(session('success'))
        toastr.success("{{ session('success') }}", "Success", {
            "positionClass": "toast-top-right",
            "closeButton": true,
            "progressBar": true
        });
    @elseif(session('error'))
        toastr.error("{{ session('error') }}", "Error", {
            "positionClass": "toast-top-right",
            "closeButton": true,
            "progressBar": true
        });
    @endif
</script>

@endsection
