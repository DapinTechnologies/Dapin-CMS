@extends('admin.layouts.master')

@section('title', 'Edit Partner')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <form action="{{ route('admin.admin.about-us.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Partner</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Partner Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $partner->name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" required>{{ $partner->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" class="form-control" name="logo">
                                @if($partner->logo)
                                    <img src="{{ asset('uploads/about-us/partners/'.$partner->logo) }}" alt="Logo" style="max-height: 50px;">
                                    <input type="checkbox" name="remove_logo" value="1"> Remove Logo
                                @endif
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
