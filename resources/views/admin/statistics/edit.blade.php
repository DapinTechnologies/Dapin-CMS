@extends('admin.layouts.master')

@section('title', 'Edit Statistic')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Edit Statistic</h2>

    <form action="{{ route('admin.statistics.update', $statistic->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" name="type" value="{{ $statistic->type }}" required>
        </div>

        <div class="form-group">
            <label for="count">Count</label>
            <input type="number" class="form-control" name="count" value="{{ $statistic->count }}" required>
        </div>
 <div class="form-group">
            <label for="icon">Icon</label>
            <select class="form-control" name="icon" required>
                @foreach(\App\Models\Statistic::iconOptions() as $value => $label)
                    <option value="{{ $value }}" {{ $statistic->icon == $value ? 'selected' : '' }}>
                        {{ $label }} ({{ $value }})
                    </option>
                @endforeach
            </select>
        </div>

 <div class="form-group">
            <label for="icon_color">Icon Color</label>
            <select class="form-control" name="icon_color" required>
                @foreach(\App\Models\Statistic::colorOptions() as $value => $label)
                    <option value="{{ $value }}" {{ $statistic->icon_color == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update Statistic</button>
    </form>
</div>
@endsection
