@extends('web.layouts.master')
@section('title', $material->title)

@section('content')

<main>
    <section class="material-view pt-120 pb-120">
        <div class="container">
            <h2>{{ $material->title }}</h2>

            <!-- Viewing the Material -->
            <div class="material-viewer text-center">
                @if ($material->type === 'PDF')
                    <!-- Embed the PDF without toolbar, navigation, and scrollbar -->
                    <iframe 
                        src="{{ asset($material->file_path) }}#toolbar=0&navpanes=0&scrollbar=0" 
                        width="100%" 
                        height="600px">
                    </iframe>
                @else
                    <p>{{ __('Preview not available for this file type.') }}</p>
                @endif
            </div>
        </div>
    </section>
</main>

@endsection
