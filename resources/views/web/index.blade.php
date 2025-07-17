<style>
  @import url('https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,500;0,600;0,700;0,800;1,500;1,600;1,700;1,800&display=swap');
  
  body, h1, h2, h3, h4, h5, h6, p, a, button, input, textarea, .course-title, .course-info, .fee {
    font-family: 'Jost', sans-serif !important;
  }
</style>


@extends('web.layouts.master')
@section('title', __('navbar_home'))

@section('social_meta_tags')
    @if(isset($setting))
    <meta property="og:type" content="website">
    <meta property='og:site_name' content="{{ $setting->title }}"/>
    <meta property='og:title' content="{{ $setting->title }}"/>
    <meta property='og:description' content="{!! str_limit(strip_tags($setting->meta_description), 160, ' ...') !!}"/>
    <meta property='og:url' content="{{ route('home') }}"/>
    <meta property='og:image' content="{{ asset('/uploads/setting/'.$setting->logo_path) }}"/>


    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="{!! '@'.str_replace(' ', '', $setting->title) !!}" />
    <meta name="twitter:creator" content="@HiTechParks" />
    <meta name="twitter:url" content="{{ route('home') }}" />
    <meta name="twitter:title" content="{{ $setting->title }}" />
    <meta name="twitter:description" content="{!! str_limit(strip_tags($setting->meta_description), 160, ' ...') !!}" />
    <meta name="twitter:image" content="{{ asset('/uploads/setting/'.$setting->logo_path) }}" />
    @endif
@endsection
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">



@section('content')

    <!-- main-area -->
    <main>
       @include('web.slider')

  @include('web.features')

    
  @include('web.abouthead')

  @include('web.message')
        
        @include('web.cot')

      @include('web.coursehead')



@include('web.stats')

@include('web.newshead')


@include('web.exams')



@include('web.testimonial')


@include('web.choose')

@include('web.enquiry')

     
    </main>
    <!-- main-area-end -->


<script>


document.addEventListener("DOMContentLoaded", function () {
    const statisticNumbers = document.querySelectorAll(".statistic-number");

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const count = parseInt(target.getAttribute("data-count"), 10);
                let current = 0;
                const increment = Math.ceil(count / 100);

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= count) {
                        clearInterval(timer);
                        current = count;
                    }
                    target.textContent = current;
                }, 20);
                observer.unobserve(target);
            }
        });
    });

    statisticNumbers.forEach((number) => {
        observer.observe(number);
    });
});


</script>



<!-- Include jQuery and Slick Carousel JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
    $(document).ready(function(){
        $('.courses-slider').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 4, // Show 4 slides at a time
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    });
</script>

<style>
/* General Styles */

/* Course Card */
.course-card {
    background: #ffffff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
    padding: 6px; /* Reduced padding */
    transition: transform 0.2s ease-in-out;
    border-left: 4px solid #ff6600;
    text-align: center;
    margin: 0 10px;
    max-height: 180px; /* Set max height to limit size */
    overflow: hidden; /* Prevent content overflow */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Reduce font sizes */
.course-title {
    font-size: 14px; /* Smaller title */
    font-weight: bold;
    color: #007bff;
    margin-bottom: 4px;
}

.course-info {
    font-size: 12px; /* Smaller text */
    color: #555;
    margin-bottom: 4px;
}

/* Fee Text */
.fee {
    font-size: 13px; /* Smaller text */
    font-weight: bold;
    color: #28a745;
}




</style>



@endsection