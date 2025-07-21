@extends('admin.layouts.master')
@section('title', 'Add New History Item')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <form action="{{ route('admin.histories.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="card">
                        <div class="card-header">
                            <h5>Add New History Item</h5>
                            <div class="float-right">
                                 <a href="{{ route('admin.histories.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to History
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-block">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <div class="form-group">
                                <label>Year</label>
                                <input type="text" class="form-control" name="year" value="{{ old('year') }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Order</label>
                                <input type="number" class="form-control" name="order" value="{{ old('order') }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                            
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Save Item
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection