@extends('web.layouts.master')

@section('content')
<main>
    <section class="materials-list pt-120 pb-120">
        <div class="container">
            <h2>Available Materials</h2>

            @if ($materials->isEmpty())
                <p>No PDF materials available.</p>
            @else
                <div class="row">
                    @foreach ($materials as $material)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $material->title }}</h5>
                                    <p class="card-text">
                                        <strong>Category:</strong> {{ $material->category->name ?? 'Uncategorized' }}<br>
                                        <strong>Author:</strong> {{ $material->author ?? 'N/A' }}<br>
                                        <strong>Language:</strong> {{ $material->language }}
                                    </p>
                                    <a href="{{ route('materials.show', $material->id) }}" class="btn btn-primary">
                                        View Material
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</main>
@endsection
