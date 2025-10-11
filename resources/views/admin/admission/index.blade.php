@extends('admin.layouts.master')

@section('content')


<h1>Admission Process Steps</h1>

    <a href="{{ route('admin.admission.process.create') }}" class="btn btn-primary mb-3">Add New Process Step</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($steps as $step)
                <tr>
                    <td>{{ $step->title }}</td>
                    <td>{{ $step->description }}</td>
                    <td>
                        <a href="{{ route('admin.admission.process.edit', $step->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.admission.process.destroy', $step->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
















@endsection
