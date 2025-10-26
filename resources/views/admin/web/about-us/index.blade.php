@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- Navigation Buttons -->
            <div class="col-sm-12 mb-3">
                <div class="float-right">
                    <a href="{{ route('admin.histories.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-history"></i> Manage History
                    </a>
                    <a href="{{ route('admin.admin.about-us.partners') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-handshake"></i> Manage Partners
                    </a>
                    <a href="{{ route('admin.admin.about-us.accreditations') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-certificate"></i> Manage Accreditations
                    </a>
                    <a href="{{ route('admin.core-values.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-certificate"></i> Manage Core Values
                    </a>
                </div>
            </div>

            <div class="col-sm-12">
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- Main Form -->
                <form action="{{ route('admin.about-us.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input name="id" type="hidden" value="{{ isset($row->id) ? $row->id : -1 }}">

                    <div class="card">
                        <div class="card-header">
                            <h5>About Us Content</h5>
                            <div class="float-right">
                                @if(isset($row) && $row->id)
                                    <span class="badge badge-success">Editing Existing Content</span>
                                @else
                                    <span class="badge badge-primary">Creating New Content</span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Main Form Fields -->
                        <div class="card-block">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="label">Label <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('label') is-invalid @enderror" 
                                           name="label" id="label" 
                                           value="{{ old('label', $row->label ?? '') }}" required>
                                    @error('label')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           name="title" id="title" 
                                           value="{{ old('title', $row->title ?? '') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="short_desc">Short Description <span class="text-danger">*</span></label>
                                    <textarea name="short_desc" id="short_desc" class="form-control @error('short_desc') is-invalid @enderror" 
                                              rows="3" required>{{ old('short_desc', $row->short_desc ?? '') }}</textarea>
                                    @error('short_desc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="description">Full Description <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                                              rows="6" required>{{ old('description', $row->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="button_text">Button Text</label>
                                    <input type="text" class="form-control @error('button_text') is-invalid @enderror" 
                                           name="button_text" id="button_text" 
                                           value="{{ old('button_text', $row->button_text ?? '') }}">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="video_id">Video ID</label>
                                    <input type="text" class="form-control @error('video_id') is-invalid @enderror" 
                                           name="video_id" id="video_id" 
                                           value="{{ old('video_id', $row->video_id ?? '') }}">
                                    <small class="form-text text-muted">YouTube video ID only</small>
                                    @error('video_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="attach">Featured Image</label>
                                    
                                    @if(isset($row->attach) && $row->attach)
                                        <div class="mb-3">
                                            <img src="{{ asset('uploads/'.$path.'/'.$row->attach) }}" 
                                                 class="img-fluid rounded border" 
                                                 style="max-height: 200px; max-width: 100%;" 
                                                 alt="Current image">
                                            <div class="mt-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" 
                                                           name="remove_attach" id="remove_attach" value="1">
                                                    <label class="form-check-label text-danger" for="remove_attach">
                                                        <i class="fas fa-trash"></i> Remove current image
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <input type="file" class="form-control @error('attach') is-invalid @enderror" 
                                           name="attach" id="attach" 
                                           accept="image/jpeg,image/png,image/jpg,image/gif">
                                    <small class="form-text text-muted">
                                        Recommended size: 800px height, any width. Formats: JPEG, PNG, JPG, GIF. Max: 2MB
                                    </small>
                                    @error('attach')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="mission_title">Mission Title</label>
                                    <input type="text" class="form-control @error('mission_title') is-invalid @enderror" 
                                           name="mission_title" id="mission_title" 
                                           value="{{ old('mission_title', $row->mission_title ?? '') }}">
                                    @error('mission_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="vision_title">Vision Title</label>
                                    <input type="text" class="form-control @error('vision_title') is-invalid @enderror" 
                                           name="vision_title" id="vision_title" 
                                           value="{{ old('vision_title', $row->vision_title ?? '') }}">
                                    @error('vision_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="mission_desc">Mission Description</label>
                                    <textarea name="mission_desc" id="mission_desc" class="form-control @error('mission_desc') is-invalid @enderror" 
                                              rows="4">{{ old('mission_desc', $row->mission_desc ?? '') }}</textarea>
                                    @error('mission_desc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="vision_desc">Vision Description</label>
                                    <textarea name="vision_desc" id="vision_desc" class="form-control @error('vision_desc') is-invalid @enderror" 
                                              rows="4">{{ old('vision_desc', $row->vision_desc ?? '') }}</textarea>
                                    @error('vision_desc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> 
                                {{ isset($row) && $row->id ? 'Update' : 'Save' }} About Us Content
                            </button>
                            
                            @if(isset($row) && $row->id)
                                <a href="{{ route('admin.about-us.index') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create New
                                </a>
                            @endif
                            
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Reset Form
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    // Form validation - Only validate required fields
    $('form').submit(function(e) {
        let isValid = true;
        $('input[required], textarea[required]').each(function() {
            if (!$(this).val().trim()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill all required fields');
            return false;
        }
        
        return true;
    });
});
</script>
@endsection