@extends('admin.layouts.master')

@section('title', 'Edit Accreditation')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <form action="{{ route('admin.admin.about-us.accreditations.update', $accreditation->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Accreditation</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Accreditation Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $accreditation->name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" required>{{ $accreditation->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" class="form-control" name="logo">
                                @if($accreditation->logo)
                                    <img src="{{ asset('uploads/about-us/accreditations/'.$accreditation->logo) }}" alt="Logo" style="max-height: 50px;">
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
