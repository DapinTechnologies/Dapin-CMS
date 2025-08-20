@extends('admin.layouts.master')

@section('title', 'Manage Accreditations')


<style>
    .modern-card {
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: none;
    }
    
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }
    
    .modern-table thead th {
        background-color: #f8fafc;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border: none;
        padding: 12px 15px;
    }
    
    .modern-table tbody tr {
        background-color: white;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .modern-table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }
    
    .modern-table td {
        padding: 15px;
        vertical-align: middle;
        border-top: none;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .compact-text {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 300px;
        line-height: 1.4;
    }
    
    .logo-cell {
        width: 70px; /* Reduced width for 50px images */
    }
    
    .logo-img {
        height: 50px;
        width: 50px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #f1f5f9;
    }
    
    .action-btns {
        white-space: nowrap;
    }
    
    .btn-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .empty-state {
        padding: 40px 0;
        text-align: center;
        color: #64748b;
    }
    
    @media (max-width: 768px) {
        .modern-table thead {
            display: none;
        }
        
        .modern-table tbody tr {
            display: block;
            margin-bottom: 15px;
        }
        
        .modern-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-bottom: none;
        }
        
        .modern-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #64748b;
            margin-right: 15px;
            flex: 1;
        }
        
        .modern-table td .content {
            flex: 2;
            text-align: right;
        }
        
        .action-btns {
            justify-content: flex-end;
        }
        
        .logo-img {
            height: 40px;
            width: 40px;
        }
    }
</style>


@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
             <div class="float-right">
    <a href="{{ route('admin.histories.index') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-history"></i> Manage History
</a>
    <a href="{{ route('admin.admin.about-us.partners') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-handshake"></i> Manage Partners
</a>

    <a href="{{route('admin.about-us.index')}}" class="btn btn-primary btn-sm">
        <i class="fas fa-certificate"></i> Manage About
    </a>
      <a href="{{route('admin.core-values.index')}}" class="btn btn-primary btn-sm">
        <i class="fas fa-certificate"></i> Manage Core Values
    </a>
</div>
            <div class="col-sm-12">
                <div class="card modern-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Manage Accreditations</h5>
                        <a href="{{ route('admin.admin.about-us.accreditations.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i> Add New
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if($accreditations->isEmpty())
                            <div class="empty-state">
                                <i class="fas fa-certificate fa-3x mb-3 text-light"></i>
                                <h5>No Accreditations Found</h5>
                                <p>Get started by adding your first accreditation</p>
                                <a href="{{ route('admin.admin.about-us.accreditations.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus mr-1"></i> Add Accreditation
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th class="logo-cell">Logo</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($accreditations as $accreditation)
                                            <tr>
                                                <td data-label="Name">
                                                    <div class="font-weight-600">{{ $accreditation->name }}</div>
                                                </td>
                                                <td data-label="Description">
                                                    <div class="compact-text">{{ $accreditation->description }}</div>
                                                </td>
                                                <td data-label="Logo" class="logo-cell">
                                                    @if($accreditation->logo)
                                                        <img src="{{ asset('uploads/about-us/accreditations/'.$accreditation->logo) }}" 
                                                             alt="{{ $accreditation->name }} Logo" 
                                                             class="logo-img"
                                                             loading="lazy">
                                                    @else
                                                        <div class="logo-img bg-light d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td data-label="Actions" class="action-btns">
                                                    <div class="d-flex">
                                                        <a href="{{ route('admin.admin.about-us.accreditations.edit', $accreditation->id) }}" 
                                                           class="btn btn-warning btn-icon btn-sm mr-2"
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.admin.about-us.accreditations.destroy', $accreditation->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-danger btn-icon btn-sm"
                                                                    title="Delete"
                                                                    onclick="return confirm('Are you sure you want to delete this accreditation?')">
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection