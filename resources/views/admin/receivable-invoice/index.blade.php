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
                        <h5>Receivable Invoice {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        @can($access.'-create')
                        <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan

                        <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-4">
                                    <label for="payer_type">{{ __('field_payer_type') }}</label>
                                    <select class="form-control" name="payer_type" id="payer_type">
                                        <option value="">{{ __('all') }}</option>
                                        <option value="student" @if($selected_payer_type == 'student') selected @endif>{{ __('field_student') }}</option>
                                        <option value="staff" @if($selected_payer_type == 'staff') selected @endif>{{ __('field_staff') }}</option>
                                        <option value="outsider" @if($selected_payer_type == 'outsider') selected @endif>{{ __('field_outsider') }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="status">{{ __('field_status') }}</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="">{{ __('all') }}</option>
                                        <option value="1" @if($selected_status === '1') selected @endif>{{ __('status_active') }}</option>
                                        <option value="0" @if($selected_status === '0') selected @endif>{{ __('status_inactive') }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <button type="submit" class="btn btn-info btn-filter mt-4"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
                  
            <div class="col-sm-12">
                <div class="card">  
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_invoice_no') }}</th>
                                        <th>{{ __('field_payer_type') }}</th>
                                        <th>{{ __('field_payer') }}</th>
                                        <th>{{ __('field_title') }}</th>
                                        <th>{{ __('field_amount') }}</th>
                                        <th>{{ __('field_date') }}</th>
                                        <th>{{ __('field_due_date') }}</th>
                                        <th>{{ __('field_status') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->invoice_no }}</td>
                                        <td>
                                            @if($row->payer_type == 'student')
                                            <span class="badge badge-pill badge-primary">{{ __('field_student') }}</span>
                                            @elseif($row->payer_type == 'staff')
                                            <span class="badge badge-pill badge-info">{{ __('field_staff') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-secondary">{{ __('field_outsider') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($row->payer_type == 'student' && $row->student)
                                                {{ $row->student->first_name }} {{ $row->student->last_name }}
                                                <br><small class="text-muted">{{ $row->student->student_id }}</small>
                                            @elseif($row->payer_type == 'staff' && $row->staff)
                                                {{ $row->staff->first_name }} {{ $row->staff->last_name }}
                                                <br><small class="text-muted">{{ $row->staff->staff_id }}</small>
                                            @else
                                                {{ $row->payer_name }}
                                                @if($row->payer_email)
                                                <br><small class="text-muted">{{ $row->payer_email }}</small>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{!! str_limit($row->title, 30, ' ...') !!}</td>
                                        <td>{{ round($row->amount, $setting->decimal_place ?? 2) }} {!! $setting->currency_symbol !!}</td>
                                        <td>
                                            @if(isset($setting->date_format))
                                            {{ date($setting->date_format, strtotime($row->date)) }}
                                            @else
                                            {{ date("Y-m-d", strtotime($row->date)) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($row->due_date)
                                                @if(isset($setting->date_format))
                                                {{ date($setting->date_format, strtotime($row->due_date)) }}
                                                @else
                                                {{ date("Y-m-d", strtotime($row->due_date)) }}
                                                @endif
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if($row->status == 1)
                                            <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#showModal-{{ $row->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <!-- Include Show modal -->
                                            @include($view.'.show')

                                            @can($access.'-edit')
                                            <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-icon btn-primary btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan

                                            <a href="{{ route($route.'.print', $row->id) }}" class="btn btn-icon btn-dark btn-sm" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>

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
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection