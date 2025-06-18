@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            @can($access.'-create')
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('btn_create') }} {{ $title }}</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_title') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="amount" class="form-label">{{ __('Amount') }} <span>*</span></label>
                                <input type="number" class="form-control" name="amount" id="amount" value="{{ old('amount') }}" min="0" step="0.01" required>
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('Amount') }}
                                </div>
                            </div>
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            @endcan

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_title') }}</th>
                                        <th>{{ __('field_amount') }}</th>
                                        <th>{{ __('field_status') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->title }}</td>
                                        <td>{{ number_format($row->amount, 2) }}</td>
                                        <td>
                                            @if($row->status == 1)
                                            <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            @endcan

 @can($access.'-delete')
<form action="{{ route($route.'.destroy', $row->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-icon btn-danger btn-sm" title="Delete">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>
@endcan


                                        </td>
                                    </tr>

                                    {{-- Edit Modal --}}
                                    <div class="modal fade" id="editModal-{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $row->id }}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <form method="POST" action="{{ route($route.'.update', $row->id) }}">
                                          @csrf
                                          @method('PUT')
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="editModalLabel-{{ $row->id }}">Update Fee Category</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                              <!-- Title input -->
                                              <div class="form-group">
                                                <label for="title-{{ $row->id }}">{{ __('field_title') }} <span>*</span></label>
                                                <input type="text" class="form-control" id="title-{{ $row->id }}" name="title" value="{{ old('title', $row->title) }}" required>
                                              </div>

                                              <!-- Amount input -->
                                              <div class="form-group mt-3">
                                                <label for="amount-{{ $row->id }}">{{ __('Amount') }} <span>*</span></label>
                                                <input type="number" class="form-control" id="amount-{{ $row->id }}" name="amount" value="{{ old('amount', $row->amount) }}" min="0" step="0.01" required>
                                              </div>

                                              <!-- Status select -->
                                              <div class="form-group mt-3">
                                                <label for="status-{{ $row->id }}">{{ __('field_status') }}</label>
                                                <select name="status" id="status-{{ $row->id }}" class="form-control" required>
                                                  <option value="1" {{ $row->status == 1 ? 'selected' : '' }}>{{ __('status_active') }}</option>
                                                  <option value="0" {{ $row->status == 0 ? 'selected' : '' }}>{{ __('status_inactive') }}</option>
                                                </select>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('btn_close') }}</button>
                                              <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                            </div>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                    {{-- End Edit Modal --}}

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
<!-- End Content -->

@endsection
