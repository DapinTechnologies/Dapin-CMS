@extends('admin.layouts.master')
@section('title', 'Manage History Timeline')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                     <div class="float-right">
    <a href="{{ route('admin.about-us.index') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-history"></i> Manage About
</a>
    <a href="{{ route('admin.admin.about-us.partners') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-handshake"></i> Manage Partners
</a>

    <a href="{{route('admin.admin.about-us.accreditations')}}" class="btn btn-primary btn-sm">
        <i class="fas fa-certificate"></i> Manage Accreditations
    </a>
      <a href="{{route('admin.core-values.index')}}" class="btn btn-primary btn-sm">
        <i class="fas fa-certificate"></i> Manage Core Values
    </a>
</div>
                    <div class="card-header">
                        <h5>Manage History Timeline</h5>
                        
                        <div class="float-right">
                            <a href="{{ route('admin.histories.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add New
                            </a>
                        </div>
                    </div>
                    <div class="card-block">
                        @if($histories->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="80">Year</th>
                                            <th width="150">Title</th>
                                            <th>Description</th>
                                            <th width="80">Order</th>
                                            <th width="120">Image</th>
                                            <th width="150">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($histories as $history)
                                        <tr>
                                            <td class="text-center">{{ $history->year }}</td>
                                            <td>{{ $history->title }}</td>
                                            <td style="word-wrap: break-word; white-space: normal;">
                                                {{ \Illuminate\Support\Str::limit($history->description, 100) }}
                                                @if(strlen($history->description) > 100)
                                                    <span class="text-muted">...</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $history->order }}</td>
                                            <td class="text-center">
                                                @if($history->image)
                                                    <img src="{{ asset('uploads/about-us/history/'.$history->image) }}" 
                                                         alt="History Image" 
                                                         style="max-height: 50px; max-width: 100px; object-fit: contain;">
                                                @else
                                                    <span class="badge badge-secondary">No Image</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.histories.edit', $history->id) }}" class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.histories.destroy', $history->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this item?')">
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
                        @else
                            <div class="alert alert-info">No history items found.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection