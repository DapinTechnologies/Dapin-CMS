<!-- resources/views/admin/categories/create.blade.php -->
@extends('admin.layouts.master')
@section('title', 'Add Category')
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Categories List') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($categories as $key => $category )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($category->description, 30, '...') }}</td>
                                        <td>
                                            @can('edit-category')
                                            <a href="{{ route('catedit', $category->id) }}" class="btn btn-icon btn-primary btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('delete-category') <form action="{{ route('categdestroy', $category->id) }}" 
                                                method="POST" style="display:inline-block;"> 
                                                @csrf @method('DELETE') 
                                                <button type="submit"
                                                 class="btn btn-icon btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                  <i class="fas fa-trash-alt"></i> </button>
                                                 </form> @endcan
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
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="{{ route('categoriesstore') }}" method="post">
                @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Add New Category') }}</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="name" class="form-label">{{ __('Category Name') }} <span>*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
                                <div class="invalid-feedback">
                                  {{ __('This field is required') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-label">{{ __('Category Description') }}</label>
                                <textarea class="form-control" name="description" id="description">{{ old('description') }}</textarea>
                            </div>
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('Save') }}</button>
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
