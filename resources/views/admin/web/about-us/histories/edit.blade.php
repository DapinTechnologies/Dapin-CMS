@extends('admin.layouts.master')
@section('title', 'Manage About Us History')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
              <form action="{{ route('admin.histories.update', $history->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
              
                
                <div class="form-group">
                    <!-- Hidden ID for the history item -->
                    <input type="hidden" name="id" value="{{ $history->id }}">

                    <!-- Year -->
                    <label for="year">Year</label>
                    <input type="text" id="year" class="form-control @error('year') is-invalid @enderror" 
                           name="year" value="{{ old('year', $history->year) }}" required>
                    @error('year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <!-- Title -->
                    <label for="title">Title</label>
                    <input type="text" id="title" class="form-control @error('title') is-invalid @enderror" 
                           name="title" value="{{ old('title', $history->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <!-- Order -->
                    <label for="order">Order</label>
                    <input type="number" id="order" class="form-control @error('order') is-invalid @enderror" 
                           name="order" value="{{ old('order', $history->order) }}" required>
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <!-- Description -->
                    <label for="description">Description</label>
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" 
                              name="description" rows="3" required>{{ old('description', $history->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <!-- Image -->
                    <label for="image">Image</label>
                    <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" 
                           name="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <!-- Remove Image Checkbox -->
                    @if($history->image)
                        <div class="form-check mt-2">
                            <input type="checkbox" class="form-check-input" name="remove_image" value="1" id="remove_image">
                            <label class="form-check-label" for="remove_image">Remove Image</label>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update History Item
                </button>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection
