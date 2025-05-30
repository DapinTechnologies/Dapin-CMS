<!-- resources/views/admin/categories/edit.blade.php -->
@extends('admin.layouts.master')
@section('title', 'Edit Category')
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form class="needs-validation" novalidate action="{{ route('categoriesupdate', $category->id) }}" method="post">
                @csrf

                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Edit Category') }}</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="name" class="form-label">{{ __('Category Name') }} <span>*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $category->name) }}" required>
                                <div class="invalid-feedback">
                                  {{ __('This field is required') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-label">{{ __('Category Description') }}</label>
                                <textarea class="form-control" name="description" id="description">{{ old('description', $category->description) }}</textarea>
                            </div>
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('Update') }}</button>
                            <a href="{{ route('alldigitalbooks') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection
