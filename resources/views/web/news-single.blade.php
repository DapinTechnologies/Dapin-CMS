@extends('web.layouts.master')
@section('title', __('navbar_news'))

<style>
    .dark-text p {
        color: black; 
    }
    
    .news-date {
        color: #2c3e50 !important;
        font-weight: 600;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }
    
    .sidebar-news {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .sidebar-title {
        color: #2c3e50;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid #007bff;
        position: relative;
    }
    
    .sidebar-title:after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 50px;
        height: 3px;
        background: #0056b3;
    }
    
    .news-sidebar-item {
        display: block;
        padding: 15px;
        margin-bottom: 15px;
        background: white;
        border-radius: 8px;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
        text-decoration: none;
        color: inherit;
    }
    
    .news-sidebar-item:hover {
        transform: translateX(-5px);
        border-left-color: #007bff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        text-decoration: none;
        color: inherit;
    }
    
    .news-sidebar-item:last-child {
        margin-bottom: 0;
    }
    
    .sidebar-news-title {
        font-weight: 600;
        color: #2c3e50;
        font-size: 1rem;
        line-height: 1.4;
        margin-bottom: 0.5rem;
    }
    
    .sidebar-news-date {
        color: #6c757d;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .sidebar-news-date i {
        color: #007bff;
    }
    
    .news-thumbnail {
        width: 60px;
        height: 60px;
        border-radius: 6px;
        object-fit: cover;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .news-item-content {
        flex: 1;
    }
    
    @media (max-width: 991px) {
        .sidebar-news {
            margin-top: 40px;
        }
        
        .news-sidebar-item {
            padding: 12px;
        }
        
        .sidebar-title {
            font-size: 1.3rem;
        }
    }
    
    @media (max-width: 768px) {
        .sidebar-news {
            padding: 20px;
        }
        
        .news-thumbnail {
            width: 50px;
            height: 50px;
        }
        
        .sidebar-news-title {
            font-size: 0.95rem;
        }
    }
</style>

@section('social_meta_tags')
    @if(isset($setting))
    <meta property="og:type" content="website">
    <meta property='og:site_name' content="{{ $setting->title }}"/>
    <meta property='og:title' content="{{ $news->title }}"/>
    <meta property='og:description' content="{!! str_limit(strip_tags($news->description), 160, ' ...') !!}"/>
    <meta property='og:url' content="{{ route('news.single', ['id' => $news->id, 'slug' => $news->slug]) }}"/>
    <meta property='og:image' content="{{ asset('uploads/news/'.$news->attach) }}"/>

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="{!! '@'.str_replace(' ', '', $setting->title) !!}" />
    <meta name="twitter:creator" content="@Unimediaafrica" />
    <meta name="twitter:url" content="{{ route('news.single', ['id' => $news->id, 'slug' => $news->slug]) }}" />
    <meta name="twitter:title" content="{{ $news->title }}" />
    <meta name="twitter:description" content="{!! str_limit(strip_tags($news->description), 160, ' ...') !!}" />
    <meta name="twitter:image" content="{{ asset('uploads/news/'.$news->attach) }}" />
    @endif
@endsection

@section('content')

    <!-- main-area -->
    <main>

        <!-- breadcrumb-area -->
        <section class="breadcrumb-area d-flex p-relative align-items-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-12 col-lg-12">
                        <div class="breadcrumb-wrap text-left">
                            <div class="breadcrumb-title">
                                <h2>{{ __('navbar_news') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="breadcrumb-wrap2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('navbar_home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('navbar_news') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->
          
        <!-- inner-blog -->
        <section class="inner-blog b-details-p pt-120 pb-120">
            <div class="container">
                <div class="row">
                    <!-- Main News Content -->
                    <div class="col-lg-8">
                        <div class="blog-details-wrap">
                            <div class="details__content pb-30">
                                <h2 class="dark-white-text">{{ $news->title }}</h2>
                                
                                <!-- Date with dark color -->
                                <div class="news-date">
                                    <i class="far fa-calendar-alt me-2"></i>
                                    {{ date("d F, Y", strtotime($news->date)) }}
                                </div>

                                @if($news->attach)
                                    <div class="details__content-img mt-4">
                                        <img src="{{ asset('uploads/news/'.$news->attach) }}" 
                                             alt="{{ $news->title }}" 
                                             class="img-fluid rounded">
                                    </div>
                                @endif
                                
                                <div class="dark-text mt-4">
                                    {!! $news->description !!}
                                </div>
                                
                            </div>
                        </div>
                    </div>

                  
                   <!-- Sidebar with Recent News - Now on the right -->
<div class="col-lg-4">
    <div class="sidebar-news">
        <h3 class="sidebar-title">{{ __('Recent News') }}</h3>
        
        @php
            $allRecentNews = App\Models\News::where('status', 1)
                                            ->where('id', '!=', $news->id)
                                            ->orderBy('date', 'desc')
                                            ->orderBy('created_at', 'desc')
                                            ->take(10)
                                            ->get();
        @endphp
        
        @if($allRecentNews->count() > 0)
            @foreach($allRecentNews as $recent)
                <a href="{{ route('news.single', ['id' => $recent->id, 'slug' => $recent->slug]) }}" 
                   class="news-sidebar-item d-flex align-items-start">
                    @if($recent->attach)
                        <img src="{{ asset('uploads/news/'.$recent->attach) }}" 
                             alt="{{ $recent->title }}" 
                             class="news-thumbnail">
                    @else
                        <div class="news-thumbnail d-flex align-items-center justify-content-center bg-light text-muted">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    @endif
                    <div class="news-item-content">
                        <h4 class="sidebar-news-title">{{ Str::limit($recent->title, 60) }}</h4>
                        <div class="sidebar-news-date">
                            <i class="far fa-calendar-alt"></i>
                            {{ date("d M, Y", strtotime($recent->date)) }}
                        </div>
                    </div>
                </a>
            @endforeach
        @else
            <div class="text-center text-muted py-3">
                <i class="far fa-newspaper fa-2x mb-2"></i>
                <p>No recent news available</p>
                
                <!-- Debug info -->
                <small class="text-danger">
                    Total news in database: {{ App\Models\News::count() }}<br>
                    Published news: {{ App\Models\News::where('status', 1)->count() }}
                </small>
            </div>
        @endif
    </div>
</div>
                </div>
            </div>
        </section>
        <!-- inner-blog-end -->
     
    </main>
    <!-- main-area-end -->

@endsection