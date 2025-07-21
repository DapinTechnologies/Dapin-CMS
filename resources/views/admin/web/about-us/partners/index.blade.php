@extends('admin.layouts.master')

@section('title', 'Manage Partners')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Manage Partners</h5>
                        <div class="float-right">
                            <a href="{{ route('admin.admin.about-us.partners.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add New Partner
                            </a>
                        </div>
                    </div>
                    <div class="card-block">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th style="width: 30%">Description</th>
                                    <th>Logo</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($partners as $partner)
                                    <tr>
                                        <td>{{ $partner->name }}</td>
                                        <td style="word-wrap: break-word; white-space: normal;">
                                            {{ \Illuminate\Support\Str::limit($partner->description, 150) }}
                                            @if(strlen($partner->description) > 150)
                                                <span class="text-muted">...</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($partner->logo)
                                                <img src="{{ asset('uploads/about-us/partners/'.$partner->logo) }}" alt="Logo" style="max-height: 50px; max-width: 100px; object-fit: contain;">
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.admin.about-us.partners.edit', $partner->id) }}" class="btn btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.admin.about-us.partners.destroy', $partner->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this partner?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection