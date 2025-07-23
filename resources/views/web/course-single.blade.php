@extends('web.layouts.master')
@section('title', __('navbar_course'))

@section('social_meta_tags')
    @if(isset($setting))
    <meta property="og:type" content="website">
    <meta property='og:site_name' content="{{ $setting->title }}"/>
    <meta property='og:title' content="{{ $course->title }}"/>
    <meta property='og:description' content="{!! str_limit(strip_tags($course->description), 160, ' ...') !!}"/>
    <meta property='og:url' content="{{ route('course.single', ['slug' => $course->slug]) }}"/>
    <meta property='og:image' content="{{ asset('uploads/course/'.$course->attach) }}"/>

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="{!! '@'.str_replace(' ', '', $setting->title) !!}" />
    <meta name="twitter:creator" content="@HiTechParks" />
    <meta name="twitter:url" content="{{ route('course.single', ['slug' => $course->slug]) }}" />
    <meta name="twitter:title" content="{{ $course->title }}" />
    <meta name="twitter:description" content="{!! str_limit(strip_tags($course->description), 160, ' ...') !!}" />
    <meta name="twitter:image" content="{{ asset('uploads/course/'.$course->attach) }}" />
    @endif
@endsection

@section('content')

    <!-- main-area -->
    <main>
       
        <!-- breadcrumb-area -->
        <section class="breadcrumb-area d-flex  p-relative align-items-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-12 col-lg-12">
                        <div class="breadcrumb-wrap text-left">
                            <div class="breadcrumb-title">
                                <h2>{{ __('navbar_course') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="breadcrumb-wrap2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('navbar_home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('navbar_course') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->
        
        <!-- course Detail -->
        <section class="project-detail">
            <div class="container">
                <!-- Lower Content -->
                <div class="lower-content">
                    <div class="row">
                        <div class="text-column col-lg-9 col-md-9 col-sm-12">
                            <h2 style="color: #666;">{{ $course->title }}</h2>  <!-- Light dark color for title -->
                            
                            <div class="upper-box">
                                <div class="single-item-carousel owl-carousel owl-theme">
                                    <figure class="image"><img src="{{ asset('uploads/course/'.$course->attach) }}" alt="Course"></figure>
                                </div>
                            </div>
                            <div class="inner-column">
                                <p style="color: #666;">{!! $course->description !!}</p>  <!-- Light dark color for description -->
                            </div>
                        </div>

                        <!-- Sidebar Section -->
                        <div class="col-lg-3">
                            <aside class="sidebar-widget info-column">
                                <div class="inner-column3">
                                    <h3 style="color: #666;">Course Info</h3>  <!-- Light dark color for "Course Info" title -->
                                    <ul class="project-info clearfix">
                                        <li><strong>Faculty:</strong> <span style="color: #666;">{{ $course->faculty }}</span></li>
                                        <li><strong>Semesters:</strong> <span style="color: #666;">{{ $course->semesters }}</span></li>
                                        <li><strong>Credits:</strong> <span style="color: #666;">{{ $course->credits }}</span></li>
                                        <li><strong>Subjects:</strong> <span style="color: #666;">{{ $course->courses }}</span></li>
                                        <li><strong>Duration:</strong> <span style="color: #666;">{{ $course->duration }}</span></li>
                                        <li><strong>Fee:</strong> <span style="color: #666;">KSH {{ number_format($course->fee, 2) }}</span></li>
                                    </ul>
                                </div>
                            </aside>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!--End course Detail -->
               
    </main>
    <!-- main-area-end -->

@endsection

<!-- Additional Custom Styles for Color -->
<style>
    .project-detail p, .project-info li span {
        color: #666 !important; /* Apply lighter dark color to all descriptions and list items */
    }

    .project-detail h2, .sidebar-widget h3 {
        color: #666 !important; /* Apply lighter dark color to headings */
    }
</style>
