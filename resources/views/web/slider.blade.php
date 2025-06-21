@php
    use App\Models\Web\Slider;
    use App\Models\Web\Feature;
    use Stevebauman\Purify\Facades\Purify;
    $sliders = Slider::all();
    $features = Feature::all();
@endphp

<section class="slider-area position-relative">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        @if($sliders->isNotEmpty())
            <div class="carousel-inner">
                @foreach($sliders as $key => $slider)
                    <div class="carousel-item @if($key == 0) active @endif">
                        <img src="{{ asset('Uploads/slider/' . $slider->attach) }}" class="d-block w-100" alt="{{ $slider->title }}" aria-describedby="slide-caption-{{ $key }}" loading="lazy">
                        <div class="carousel-caption text-center" id="slide-caption-{{ $key }}">
                            <h2 class="moving-letters">
                                @foreach(str_split($slider->title) as $letter)
                                    <span>{{ $letter }}</span>
                                @endforeach
                            </h2>
                            <p>{!! Purify::clean($slider->sub_title) !!}</p>
                            @if($slider->button_link)
                                <a href="{{ $slider->button_link }}" class="btn btn-primary mt-2">
                                    {{ $slider->button_text }} <i class="fas fa-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('web/img/placeholder.jpg') }}" class="d-block w-100" alt="Placeholder" aria-describedby="slide-caption-placeholder" loading="lazy">
                    <div class="carousel-caption text-center" id="slide-caption-placeholder">
                        <h2>No Sliders Available</h2>
                        <p>Please add sliders in the admin panel.</p>
                    </div>
                </div>
            </div>
        @endif

        <button class="carousel-control-prev custom-carousel-control" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev" aria-label="Previous Slide">
            <span><i class="fas fa-chevron-left"></i></span>
        </button>
      <button class="carousel-control-next custom-carousel-control" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next" aria-label="Next Slide">

            <span><i class="fas fa-chevron-right"></i></span>
        </button>
    </div>


<style>
    body {
        font-family: 'Poppins', sans-serif;
       
        color: #fff;
        overflow-x: hidden;
    }

    .slider-area {
        height: 450px;
        position: relative;
        overflow: hidden;
        margin-bottom: 100px;
    }

    .carousel-item img {
        height: 100%;
        object-fit: cover;
    }

    .carousel-caption {
        bottom: 5rem;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
        text-align: center;
        max-width: 90%;
    }

    .carousel-caption h2 span {
        display: inline-block;
        opacity: 0;
        transform: translateY(20px) scale(0.9);
        animation: letterFadeSlide 0.6s ease forwards;
    }

    @keyframes letterFadeSlide {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .custom-carousel-control {
        width: 50px;
        height: 50px;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.4);
        border: none;
        color: #fff;
        font-size: 1.5rem;
        border-radius: 50%;
    }
    .custom-carousel-control:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }
    .carousel-control-prev { left: 20px; }
    .carousel-control-next { right: 20px; }
    .feature-floating {
        position: absolute;
        bottom: -50px;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        z-index: 20;
    }

    .feature-card {
        min-height: 150px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .slider-area { height: 350px; }
        .carousel-caption h2 { font-size: 1.8rem; }
        .carousel-caption p { font-size: 1rem; }
    }
    @media (max-width: 576px) {
        .slider-area { height: 300px; }
        .carousel-caption h2 { font-size: 1.5rem; }
        .carousel-caption p { font-size: 0.9rem; }
        .feature-floating { bottom: -80px; }
        .feature-floating .col-12 { width: 100%; }
    }
    .slider-area {
    margin-top: 80px; /* Adjust this value to match your navbar height */
    height: 450px;
    position: relative;
    overflow: hidden;
    margin-bottom: 100px;
}
.carousel-caption {
    z-index: 1; /* lower than navbar's 1050 */
    position: absolute;
    bottom: 5rem;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    max-width: 90%;
}
.carousel-caption {
    bottom: 5rem;
    left: 5%; /* Align content to the left */
    transform: none; /* Remove center alignment */
    text-align: left; /* Left-align text */
    max-width: 90%;
    z-index: 10;
}

.carousel-caption h2 {
    font-weight: bold;       /* Make title bold */
    color: #fff !important;  /* Make title white */
    text-align: left;        /* Align title text to left */
}

.carousel-caption p {
    color: #fff;             /* Ensure subtitle is white too */
    text-align: left;        /* Align subtitle text to left */
}
.carousel-caption {
    bottom: 7rem;              /* Move the entire caption up (was 5rem) */
    left: 5%;
    transform: none;
    text-align: left;
    max-width: 90%;
    z-index: 10;
}
.carousel-caption h2 {
    font-weight: bold;
    font-size: 3.5rem;         /* Larger title size */
    color: #fff !important;
    text-align: left;
    line-height: 1.2;
}
@media (max-width: 768px) {
    .carousel-caption h2 {
        font-size: 2.5rem;
    }
}

@media (max-width: 576px) {
    .carousel-caption h2 {
        font-size: 2rem;
    }
}





.slider-area {
    height: 500px;
}
.carousel-caption {
    bottom: 10rem;
    left: 5%;
    transform: none;
    text-align: left;
    max-width: 90%;
    z-index: 10;
}
.carousel-caption h2 {
    font-size: 3.5rem;
    font-weight: bold;
    color: #fff !important;
    text-align: left;
    line-height: 1.2;
}
.carousel-caption p {
    font-size: 1.2rem;
    color: #fff;
    text-align: left;
    padding-bottom: 1.5rem;
}
.feature-floating {
    bottom: -70px;
}

.carousel-caption h2 {
    font-size: 4.5rem; /* increased */
    font-weight: 800;
    color: #fff !important;
    text-align: left;
    line-height: 1.2;
    letter-spacing: 1.5px;
}

</style>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function animateLetters() {
        const activeSlide = document.querySelector('.carousel-item.active');
        const letters = activeSlide?.querySelectorAll('.moving-letters span');
        if (letters) {
            letters.forEach((letter, index) => {
                letter.style.animation = 'none';
                letter.offsetHeight;
                letter.style.animation = null;
                letter.style.animationDelay = `${index * 0.1}s`;
            });
        }
    }
    document.addEventListener('DOMContentLoaded', animateLetters);
    document.getElementById('carouselExampleIndicators').addEventListener('slid.bs.carousel', animateLetters);
</script>