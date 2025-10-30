<section id="home" class="slider-area fix p-relative">
    <div id="customCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($sliders as $index => $slider)
                <div class="carousel-item @if($index === 0) active @endif">
                    <div class="single-slider slider-bg" style="background-image: url('{{ asset('uploads/slider/'.$slider->attach) }}'); background-size: cover; background-position: center; min-height: 400px;">
                        <div class="overlay" style="background: rgba(20,27,34,0.5); position:absolute; top:0; left:0; width:100%; height:100%;"></div>
                        <div class="container" style="position:relative; z-index:2;">
                            <div class="row">
                                <div class="col-lg-7 col-md-7">
                                    <div class="slider-content s-slider-content mt-130 text-white">
                                        <h2 class="animated-title">
                                            @php
                                                $words = explode(' ', $slider->title);
                                                $totalDelay = 0;
                                            @endphp
                                            
                                            @foreach($words as $word)
                                                <span class="word">
                                                    @foreach(str_split($word) as $char)
                                                        <span class="letter" style="animation-delay: {{ $totalDelay }}s">{{ $char }}</span>
                                                        @php $totalDelay += 0.1; @endphp
                                                    @endforeach
                                                </span>
                                                @php $totalDelay += 0.2; @endphp
                                            @endforeach
                                        </h2>

                                        <p data-animation="fadeInUp" data-delay=".6s">
                                            {!! strip_tags($slider->sub_title, '<b><u><i><br>') !!}
                                        </p>

                                        @if(!empty($slider->button_link))
                                            <div class="slider-btn mt-30">
                                                <a href="{{ $slider->button_link }}" target="_blank" class="btn btn-slider-cta" data-animation="fadeInLeft" data-delay=".4s">
                                                    {{ $slider->button_text ?? 'Learn More' }} <i class="fas fa-arrow-right ms-2"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 p-relative"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#customCarousel" data-bs-slide="prev">
            <span class="carousel-arrow" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#customCarousel" data-bs-slide="next">
            <span class="carousel-arrow" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<style>
    /* Modern Slider Button */
    .btn-slider-cta {
        background: linear-gradient(45deg,rgb(245, 77, 10), #f9c74f);
        color: white !important;
        font-weight: 600;
        border: none;
        border-radius: 50px;
        padding: 0.85rem 2rem;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(248, 150, 30, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-slider-cta:hover, 
    .btn-slider-cta:focus {
        color: white !important;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(248, 150, 30, 0.4);
    }
    
    .btn-slider-cta:active {
        transform: translateY(1px);
    }
    
    .btn-slider-cta::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: 0.5s;
    }
    
    .btn-slider-cta:hover::before {
        left: 100%;
    }
    
    .btn-slider-cta i {
        transition: transform 0.3s ease;
    }
    
    .btn-slider-cta:hover i {
        transform: translateX(5px);
    }

    /* COMPLETELY CLEAN ANIMATED TITLE - NO ORANGE UNDERLINE */
    .animated-title, 
    .animated-title *,
    .animated-title .word,
    .animated-title .letter {
        text-decoration: none !important;
        border: none !important;
        border-bottom: none !important;
        background: none !important;
        background-image: none !important;
        box-shadow: none !important;
        text-shadow: none !important;
        outline: none !important;
        color: white !important;
        filter: none !important;
        -webkit-text-fill-color: white !important;
        -webkit-text-stroke: none !important;
        -webkit-background-clip: initial !important;
        -webkit-text-fill-color: initial !important;
    }

    /* Animated Title container */
    .animated-title {
        font-size: 4.5rem;
        font-weight: 800;
        line-height: 1.2;
        white-space: normal;
        transform: none;
        margin-bottom: 1rem;
        /* Remove any potential gradient backgrounds */
        background: none !important;
        background-image: none !important;
        -webkit-background-clip: initial !important;
        -webkit-text-fill-color: white !important;
    }

    /* Word container - creates space between words */
    .word {
        display: inline-block;
        margin-right: 0.5rem;
        /* Ensure no background effects */
        background: none !important;
        background-image: none !important;
    }

    /* Animate each letter one by one - NO ORANGE EFFECTS */
    .animated-title .letter {
        display: inline-block;
        opacity: 0;
        transform: translateY(20px) scale(0.95);
        animation: letterFadeIn 0.6s ease-out forwards;
        /* Pure white text with no effects */
        color: white !important;
        background: none !important;
        background-image: none !important;
        text-shadow: none !important;
        -webkit-text-fill-color: white !important;
        -webkit-text-stroke: none !important;
    }

    /* Keyframes - keep it clean */
    @keyframes letterFadeIn {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.95);
            /* No background effects during animation */
            background: none !important;
            text-shadow: none !important;
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
            /* No background effects after animation */
            background: none !important;
            text-shadow: none !important;
        }
    }

    /* Extra cleanup for pseudo-elements */
    .animated-title::before,
    .animated-title::after,
    .animated-title .word::before,
    .animated-title .word::after,
    .animated-title .letter::before,
    .animated-title .letter::after {
        display: none !important;
        content: '' !important;
        border: none !important;
        border-bottom: none !important;
        background: none !important;
        background-image: none !important;
    }

    /* Adjustments for "move down little" */
    .slider-content {
        margin-top: 150px;
    }

    /* Responsive design adjustments */
    @media (max-width: 767.98px) {
        .slider-area {
            margin-bottom: 20px !important;
            padding-bottom: 10px !important;
        }

        .service-details-two {
            margin-top: 10px !important;
            padding-top: 10px !important;
        }

        .slider-content {
            margin-top: 100px !important;
        }

        .animated-title {
            font-size: 2.5rem;
        }
    }
</style>