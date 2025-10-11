@extends('admin.layouts.master')

@section('title', 'Add New Partner')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <form action="{{ route('admin.admin.about-us.partners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-header">
                            <h5>Add New Partner</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Partner Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" class="form-control" name="logo">
                            </div>

                            <div class="form-group">
                                <label for="url">Partner Website URL</label>
                                <input type="text" class="form-control" name="url" placeholder="https://www.partnerwebsite.com" required>
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Save Partner
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
