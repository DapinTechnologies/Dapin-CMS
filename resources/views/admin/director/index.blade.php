@extends('admin.layouts.master')
@section('title', 'Director Management')
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            @can('director-create')
            <div class="col-md-4">
                <form class="needs-validation" novalidate 
                    action="{{ isset($director) ? route('directors.update', $director->id) : route('directors.store') }}" 
                    method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($director))
                    @method('PUT')
                @endif

                    <div class="card">
                        <div class="card-header">
                            <h5>{{ isset($director) ? __('Edit Director') : __('Add Director') }}</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="name">{{ __('Director Name') }} <span>*</span></label>
                                <input type="text" class="form-control" name="name" id="name" 
                                    value="{{ old('name', $director->name ?? '') }}" required>

                                <div class="invalid-feedback">
                                    {{ __('This field is required') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title">{{ __('Position/Title') }} <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" 
                                    value="{{ old('title', $director->title ?? '') }}" required>

                                <div class="invalid-feedback">
                                    {{ __('This field is required') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message">{{ __('Message from Director') }} <span>*</span></label>
                                <textarea class="form-control" name="message" id="message" rows="4" required>{{ old('message', $director->message ?? '') }}</textarea>

                                <div class="invalid-feedback">
                                    {{ __('This field is required') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="image">{{ __('Director Image') }}</label>
                                <input type="file" class="form-control" name="image" id="image" accept="image/*">

                                <small class="text-muted">Max size: 2MB | Formats: jpeg, png, jpg, gif</small>
                            </div>

                            @if(isset($director) && $director->image)
                            <div class="mt-3">
                                <label>{{ __('Current Image') }}</label>
                                <div>
                                    <img src="{{ asset($director->image) }}" alt="Director Image" width="80">
                                </div>
                            </div>
                        @endif
                        
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> {{ isset($director) ? __('Update') : __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @endcan

            <!-- Director Information Display -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Director Details') }}</h5>
                    </div>
                    <div class="card-block">
                        @if(isset($director))
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <td>{{ $director->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <td>{{ $director->title }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Message') }}</th>
                                    <td>{{ $director->message }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Image') }}</th>
                                    <td>
                                        @if($director->image)
                                            <img src="{{ asset($director->image) }}" alt="Director Image" width="100">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    
                                </tr>
                            </table>
                        </div>
                        @else
                        <p class="text-muted text-center">No Director Information Available</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection
