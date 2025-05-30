@extends('admin.layouts.master')
@section('title', 'Edit Material')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form class="needs-validation" action="{{ route('materialsupdate', $material->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Material</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="title">{{ __('File Title') }} <span>*</span></label>
                                <input type="text" class="form-control" name="title" value="{{ $material->title }}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">{{ __('File Description') }}</label>
                                <textarea class="form-control" name="description">{{ $material->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="category_id">{{ __('Category') }} <span>*</span></label>
                                <select class="form-control" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $material->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="type">{{ __('File Type') }} <span>*</span></label>
                                <select class="form-control" name="type" required>
                                    <option value="PDF" {{ $material->type == 'PDF' ? 'selected' : '' }}>PDF</option>
                                    <option value="Video" {{ $material->type == 'Video' ? 'selected' : '' }}>Video</option>
                                    <option value="Doc" {{ $material->type == 'Doc' ? 'selected' : '' }}>Doc</option>
                                    <option value="Image" {{ $material->type == 'Image' ? 'selected' : '' }}>Image</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="file_path">{{ __('Upload New File') }}</label>
                                <input type="file" class="form-control" name="file_path">
                            </div>

                            <div class="form-group">
                                <label for="thumbnail">{{ __('Upload New Thumbnail') }}</label>
                                <input type="file" class="form-control" name="thumbnail">
                            </div>

                            <div class="form-group">
                                <label for="author">{{ __('Author') }}</label>
                                <input type="text" class="form-control" name="author" value="{{ $material->author }}">
                            </div>

                            <div class="form-group">
                                <label for="publisher">{{ __('Publisher') }}</label>
                                <input type="text" class="form-control" name="publisher" value="{{ $material->publisher }}">
                            </div>

                            <div class="form-group">
                                <label for="language">{{ __('Language') }}</label>
                                <input type="text" class="form-control" name="language" value="{{ $material->language }}">
                            </div>

                            <div class="form-group">
                                <label for="edition">{{ __('Edition') }}</label>
                                <input type="text" class="form-control" name="edition" value="{{ $material->edition }}">
                            </div>

                            <div class="form-group">
                                <label for="isbn">{{ __('ISBN') }}</label>
                                <input type="text" class="form-control" name="isbn" value="{{ $material->isbn }}">
                            </div>

                            <div class="form-group">
                                <label for="is_public">{{ __('Public') }}</label>
                                <input type="checkbox" name="is_public" value="1" {{ $material->is_public ? 'checked' : '' }}>
                            </div>

                            

                           
                            
<div class="form-group"> 
    <label for="is_downloadable" class="form-label">{{ __('Downloadable') }}</label> 
    <input type="checkbox" name="is_downloadable" id="is_downloadable" value="1" {{ old('is_downloadable', $material->is_downloadable) ? 'checked' : '' }}>
</div>





                            <!-- Form End -->
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Update Material</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
