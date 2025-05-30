@extends('admin.layouts.master')
@section('title', $title)
@section('content')


<style>
    .btn-icon {
    margin-right: 5px;
}

</style>
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            @can($access.'-create')
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="{{route('filepost')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Create') }} {{ $title }}</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="title" class="form-label">{{ __('File Title') }} <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                                <div class="invalid-feedback">
                                  {{ __('This field is required') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">{{ __('File Description') }}</label>
                                <textarea class="form-control" name="description" id="description">{{ old('description') }}</textarea>
                            </div>

                           <!-- Add Plus Icon and Modal Trigger -->
                           <div class="form-group"> <label for="category_id" class="form-label">{{ __('Category') }} <span>*</span></label>
                             <div class="input-group">
                                 <select class="form-control" name="category_id" id="category_id" required>
                                    @foreach($categories as $category) <option value="{{ $category->id }}">{{ $category->name }}</option>
                                     @endforeach </select> <a href="{{ route('categoriescreate') }}"
                             class="btn btn-primary"> + </a> </div> <div class="invalid-feedback"> {{ __('This field is required') }} </div> </div>


                            <div class="form-group">
                                <label for="file_path" class="form-label">{{ __('Upload File') }} <span>*</span></label>
                                <input type="file" class="form-control" name="file_path" id="file_path" required>
                                <div class="invalid-feedback">
                                  {{ __('This field is required') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="type" class="form-label">{{ __('File Type') }} <span>*</span></label>
                                <select class="form-control" name="type" id="type" required>
                                    <option value="PDF">PDF</option>
                                    <option value="Video">Video</option>
                                    <option value="Doc">Doc</option>
                                    <option value="Image">Image</option>
                                </select>
                                <div class="invalid-feedback">
                                  {{ __('This field is required') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="author" class="form-label">{{ __('Author') }}</label>
                                <input type="text" class="form-control" name="author" id="author" value="{{ old('author') }}">
                            </div>

                            <div class="form-group">
                                <label for="publisher" class="form-label">{{ __('Publisher') }}</label>
                                <input type="text" class="form-control" name="publisher" id="publisher" value="{{ old('publisher') }}">
                            </div>

                            <div class="form-group">
                                <label for="language" class="form-label">{{ __('Language') }}</label>
                                <input type="text" class="form-control" name="language" id="language" value="{{ old('language', 'English') }}">
                            </div>

                            <div class="form-group">
                                <label for="edition" class="form-label">{{ __('Edition') }}</label>
                                <input type="text" class="form-control" name="edition" id="edition" value="{{ old('edition') }}">
                            </div>

                            <div class="form-group">
                                <label for="isbn" class="form-label">{{ __('ISBN') }}</label>
                                <input type="text" class="form-control" name="isbn" id="isbn" value="{{ old('isbn') }}">
                            </div>

                            <div class="form-group">
                                <label for="is_public" class="form-label">{{ __('Public') }}</label>
                                <input type="checkbox" name="is_public" value="1">
                            </div>

                            <div class="form-group">
                                <label for="thumbnail" class="form-label">{{ __('Thumbnail') }} <span>*</span></label>
                                <input type="file" class="form-control" name="thumbnail" id="thumbnail" required>
                                <div class="invalid-feedback">
                                  {{ __('This field is required') }}
                                </div>
                            </div>


                          
<!-- resources/views/admin/files/create.blade.php -->
<div class="form-group"> 
    <label for="is_downloadable" class="form-label">{{ __('Downloadable') }}</label> 
    <input type="checkbox" name="is_downloadable" id="is_downloadable" value="1" {{ old('is_downloadable') ? 'checked' : '' }}>
</div>




                            <!-- Form End -->
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            @endcan
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('List') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Title') }}</th>
                                        {{-- <th>{{ __('Description') }}</th> --}}
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Uploaded By') }}</th>
                                        <th>{{ __('File Path') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($materials as $key => $file)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $file->title }}</td>
                                            {{-- <td>{{ \Illuminate\Support\Str::limit($file->description, 15, '...') }}</td> --}}
                                            <td>{{ $file->category->name }}</td>
                                            <td>{{ $file->uploader->first_name ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ asset($file->file_path) }}" target="_blank">View Material</a>
                                            </td>
                                            <td>
                                                <div style="display: flex; gap: 5px;">
                                                    @can($access.'-show')
                                                        <a href="{{ route('fileshow', $file->id) }}" class="btn btn-icon btn-primary btn-sm">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                    @endcan
                                            
                                                    @can($access.'-edit')
                                                        <a href="{{ route('editfile', $file->id) }}" class="btn btn-icon btn-primary btn-sm">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                    @endcan
                                            
                                                    <form action="{{ route('deletefile', $file->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this material? This action cannot be undone.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-icon btn-danger btn-sm">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
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
 <!-- Delete Modal -->
 <div class="modal fade" id="deleteModal-{{ $file->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $file->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel-{{ $file->id }}">{{ __('Confirm Delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to delete this material? This action cannot be undone.') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form action="{{ route('deletefile', $file->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection