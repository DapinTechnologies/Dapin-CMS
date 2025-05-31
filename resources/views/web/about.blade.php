@extends('web.layouts.master')
@section('title', __('About Us'))

@section('social_meta_tags')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    @if(isset($setting))
        <meta property="og:type" content="website">
        <meta property='og:site_name' content="{{ $setting->title }}"/>
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="{!! '@'.str_replace(' ', '', $setting->title) !!}" />
        <meta name="twitter:creator" content="@HiTechParks" />
    @endif
@endsection

@section('content')

<main>
    <!-- Hero Section -->
    <section class="breadcrumb-area py-5 bg-light border-bottom">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col">
                    <h1 class="display-5 fw-bold">{{ __('About Us') }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('navbar_home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('About') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- About Content Section -->
    <section class="py-5">
        <div class="container">
            @if($about)
            <div class="row g-5 align-items-center">
                <!-- Left: Text -->
                <div class="col-lg-6">
                    <h2 class="fw-bold">{{ $about->title }}</h2>
                    <p class="lead text-muted">{{ $about->short_desc }}</p>
                    <div class="mb-3">{!! $about->description !!}</div>
                    @if($about->attach)
                        <div class="mt-3">
                            <h6 class="fw-bold">Attached Image:</h6>
                            <img src="{{ asset('uploads/about/' . $about->attach) }}" class="img-fluid rounded shadow-sm" alt="Attachment">
                        </div>
                        <a href="{{ asset('uploads/about/' . $about->attach) }}" class="btn btn-outline-primary mt-3" download>
                            <i class="bi bi-download"></i> {{ $about->button_text ?? 'Download Attachment' }}
                        </a>
                    @endif
                </div>

                <!-- Right: YouTube video -->
                <div class="col-lg-6 text-center">
                    @if($about->video_id)
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/{{ $about->video_id }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Features -->
            @if($about->features)
            <div class="mt-5">
                <h3 class="fw-semibold">Features</h3>
                <ul class="list-group list-group-flush">
                    @foreach(json_decode($about->features, true) ?? [] as $feature)
                        <li class="list-group-item">
                            <i class="bi bi-check-circle-fill text-success me-2"></i> {{ $feature }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Mission Section -->
            <div class="row mt-5 align-items-center">
                <div class="col-md-6">
                    <h4 class="fw-bold">{{ $about->mission_title }}</h4>
                    <p class="text-muted">{{ $about->mission_desc }}</p>
                </div>
                <div class="col-md-6 text-center">
                    @if($about->mission_image)
                        <img src="{{ asset('uploads/about/' . $about->mission_image) }}" class="img-fluid rounded" alt="Mission">
                    @endif
                </div>
            </div>

            <!-- Vision Section -->
            <div class="row mt-5 align-items-center flex-md-row-reverse">
                <div class="col-md-6">
                    <h4 class="fw-bold">{{ $about->vision_title }}</h4>
                    <p class="text-muted">{{ $about->vision_desc }}</p>
                </div>
                <div class="col-md-6 text-center">
                    @if($about->vision_image)
                        <img src="{{ asset('uploads/about/' . $about->vision_image) }}" class="img-fluid rounded" alt="Vision">
                    @endif
                </div>
            </div>

            @else
                <div class="alert alert-warning mt-5">
                    {{ __('No about us content available.') }}
                </div>
            @endif
        </div>
    </section>
</main>

@endsection
