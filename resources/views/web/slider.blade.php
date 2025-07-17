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
                                            @foreach(str_split($slider->title) as $i => $char)
                                                <span style="animation-delay: {{ $i * 0.18 }}s">{{ $char }}</span>
                                            @endforeach
                                        </h2>

                                        <p data-animation="fadeInUp" data-delay=".6s">
                                            {!! strip_tags($slider->sub_title, '<b><u><i><br>') !!}
                                        </p>

                                        @if(!empty($slider->button_link))
                                            <div class="slider-btn mt-30">
                                                <a href="{{ $slider->button_link }}" target="_blank" class="btn ss-btn mr-15" data-animation="fadeInLeft" data-delay=".4s">
                                                    {{ $slider->button_text ?? 'Learn More' }} <i class="fas fa-long-arrow-alt-right"></i>
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
/* Clean everything globally for title and all children */
.animated-title, .animated-title * {
    text-decoration: none !important;
    border: 0 !important;
    border-bottom: 0 !important;
    background: transparent !important;
    box-shadow: none !important;
    text-shadow: none !important;
    outline: none !important;
    color: inherit !important;
    filter: none !important;
}

/* Animated Title container */
.animated-title {
    font-size: 20rem; /* Increased from 15.8rem to make the title even bigger */
    font-weight: 800;
    display: flex;
    flex-wrap: wrap;
    gap: 2px;
    line-height: 1.2;
    white-space: pre-wrap;
    transform: none;
}

/* Animate each letter one by one */
.animated-title span {
    display: inline-block;
    opacity: 0;
    transform: translateY(20px) scale(0.95);
    animation: letterFadeIn 0.6s ease-out forwards;
    border-bottom: none !important;
}

/* Keyframes */
@keyframes letterFadeIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Extra cleanup for ::before/::after */
.animated-title span::before,
.animated-title span::after {
    display: none !important;
    content: '' !important;
    border: none !important;
    border-bottom: none !important;
    background: none !important;
}

/* Adjustments for "move down little" */
.slider-content {
    margin-top: 200px; /* Increased to move the title further down */
}

/* Responsive design adjustments */
@media (max-width: 767.98px) {
    /* Reduce bottom space below the slider */
    .slider-area {
        margin-bottom: 20px !important;
        padding-bottom: 10px !important;
    }

    /* Reduce top space above services section */
    .service-details-two {
        margin-top: 10px !important;
        padding-top: 10px !important;
    }

    /* Optionally reduce inner padding for smaller screens */
    .slider-content {
        margin-top: 100px !important; /* Increased for mobile view */
    }

    /* Make title smaller on mobile to fit */
    .animated-title {
        font-size: 3.5rem; /* Adjusted for mobile screens */
    }
}
</style>
