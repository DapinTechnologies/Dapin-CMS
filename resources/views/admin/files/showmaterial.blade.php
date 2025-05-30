@extends('admin.layouts.master')
@section('title', 'View Material')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $material->title }}</h5>
                    </div>
                    <div class="card-body">
                        <!-- Thumbnail -->
                        <div class="form-group text-center">
                            <img src="{{ asset($material->thumbnail) }}" alt="Thumbnail" class="img-thumbnail" style="max-height: 200px;">
                        </div>

                        <!-- Material Details -->
                        <div class="form-group">
                            <label><strong>Description:</strong></label>
                            <p>{{ $material->description }}</p>
                        </div>

                        <div class="form-group">
                            <label><strong>Category:</strong></label>
                            <p>{{ $material->category->name ?? 'N/A' }}</p>
                        </div>

                        <div class="form-group">
                            <label><strong>Type:</strong></label>
                            <p>{{ $material->type }}</p>
                        </div>

                        <div class="form-group">
                            <label><strong>Author:</strong></label>
                            <p>{{ $material->author ?? 'N/A' }}</p>
                        </div>

                        <div class="form-group">
                            <label><strong>Publisher:</strong></label>
                            <p>{{ $material->publisher ?? 'N/A' }}</p>
                        </div>

                        <div class="form-group">
                            <label><strong>Language:</strong></label>
                            <p>{{ $material->language ?? 'N/A' }}</p>
                        </div>

                        <div class="form-group">
                            <label><strong>Edition:</strong></label>
                            <p>{{ $material->edition ?? 'N/A' }}</p>
                        </div>

                        <div class="form-group">
                            <label><strong>ISBN:</strong></label>
                            <p>{{ $material->isbn ?? 'N/A' }}</p>
                        </div>

                        <div class="form-group">
                            <label><strong>Public:</strong></label>
                            <p>{{ $material->is_public ? 'Yes' : 'No' }}</p>
                        </div>

                        <!-- Download File (Conditional) -->
                        @if($material->is_downloadable) 
                            <div class="form-group text-center">
                                <a href="{{ asset($material->file_path) }}" class="btn btn-primary" download>
                                    <i class="fas fa-download"></i> Download File
                                </a>
                            </div>
                        @else
                            <div class="form-group text-center">
                                <p>This material is not available for download.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
