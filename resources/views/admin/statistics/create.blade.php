@extends('admin.layouts.master')

@section('title', 'Add New Statistic')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Add New Statistic</h2>

    <form action="{{ route('admin.statistics.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" name="type" required>
        </div>

        <div class="form-group">
            <label for="count">Count</label>
            <input type="number" class="form-control" name="count" required>
        </div>

         <div class="form-group">
            <label for="icon">Icon</label>
            <select class="form-control" name="icon" required>
                @foreach(\App\Models\Statistic::iconOptions() as $value => $label)
                    <option value="{{ $value }}">{{ $label }} ({{ $value }})</option>
                @endforeach
            </select>
        </div>

           <div class="form-group">
            <label for="icon_color">Icon Color</label>
            <select class="form-control" name="icon_color" required>
                @foreach(\App\Models\Statistic::colorOptions() as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Statistic</button>
    </form>
</div>
@endsection
