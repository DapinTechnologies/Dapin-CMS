@extends('admin.layouts.master')

@section('title', 'Core Values')

@section('content')
<div class="container mt-5">
     <div class="float-right">
    <a href="{{ route('admin.histories.index') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-history"></i> Manage History
</a>
    <a href="{{ route('admin.admin.about-us.partners') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-handshake"></i> Manage Partners
</a>

    <a href="{{route('admin.admin.about-us.accreditations')}}" class="btn btn-primary btn-sm">
        <i class="fas fa-certificate"></i> Manage Accreditations
    </a>
      <a href="{{ route('admin.about-us.index') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-history"></i> Manage About
</a>
</div>
    <h2 class="text-center">Core Values</h2>

     
    <div class="mb-4 text-right">
       
        <a href="{{ route('admin.core-values.create') }}" class="btn btn-success">Add New Core Value</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Icon</th>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($values as $value)
                <tr>
                     
                    <td><i class="bi bi-{{ $value->icon }} fs-1 text-dark"></i></td>
                    <td>{{ $value->title }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($value->description, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.core-values.edit', $value->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.core-values.destroy', $value->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
