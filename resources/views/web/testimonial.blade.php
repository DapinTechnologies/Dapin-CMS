@if(count($testimonials) > 0)
<section class="testimonial-area py-5 bg-light" id="testimonials" aria-labelledby="testimonial-heading" itemscope itemtype="https://schema.org/Review">
    <div class="container">
        <header class="text-center mb-5" data-aos="fade-up">
            <h2 id="testimonial-heading" class="fw-bold" itemprop="name">What Our Clients Say</h2>
            <p class="text-muted" itemprop="description">Hear from some of our satisfied students and partners about their learning experience with us.</p>
        </header>

        <!-- Desktop grid (visible on lg and up) -->
        <div class="row justify-content-center d-none d-lg-flex">
            @foreach($testimonials as $key => $testimonial)
                <div class="col-md-6 col-lg-4 mb-4">
                    <article class="single-testimonial text-center px-4 py-4 shadow-sm bg-white rounded h-100"
                             data-toggle="modal" data-target="#testimonialModal{{ $key }}" style="cursor: pointer;"
                             itemscope itemprop="review" itemtype="https://schema.org/Review">
                        <div class="quote-icon mb-3">
                            <img src="{{ asset('web/img/testimonial/qt-icon.png') }}" alt="Quote Icon" loading="lazy" width="40">
                        </div>
                        <p class="testimonial-text text-muted fst-italic" itemprop="reviewBody">
                            {{ Str::limit(strip_tags($testimonial->description), 100, '...') }}
                        </p>
                        <div class="testi-author mt-4" itemprop="author" itemscope itemtype="https://schema.org/Person">
                            <img src="{{ asset('uploads/testimonial/'.$testimonial->attach) }}"
                                 alt="Photo of {{ $testimonial->name }}"
                                 class="rounded-circle mb-2"
                                 style="width: 70px; height: 70px; object-fit: cover;" loading="lazy" itemprop="image">
                            <h6 class="mb-0" itemprop="name">{{ $testimonial->name }}</h6>
                            @if($testimonial->designation)
                                <small class="text-muted" itemprop="jobTitle">{{ $testimonial->designation }}</small>
                            @endif
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <!-- Mobile carousel (only on small/medium screens) -->
        <div class="d-lg-none">
            <div class="glide" id="testimonialCarousel">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        @foreach($testimonials as $key => $testimonial)
                            <li class="glide__slide px-2">
                                <article class="single-testimonial text-center px-4 py-4 shadow-sm bg-white rounded h-100"
                                         data-toggle="modal" data-target="#testimonialModal{{ $key }}" style="cursor: pointer;"
                                         itemscope itemprop="review" itemtype="https://schema.org/Review">
                                    <div class="quote-icon mb-3">
                                        <img src="{{ asset('web/img/testimonial/qt-icon.png') }}" alt="Quote Icon" loading="lazy" width="40">
                                    </div>
                                    <p class="testimonial-text text-muted fst-italic" itemprop="reviewBody">
                                        {{ Str::limit(strip_tags($testimonial->description), 100, '...') }}
                                    </p>
                                    <div class="testi-author mt-4" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                        <img src="{{ asset('uploads/testimonial/'.$testimonial->attach) }}"
                                             alt="Photo of {{ $testimonial->name }}"
                                             class="rounded-circle mb-2"
                                             style="width: 70px; height: 70px; object-fit: cover;" loading="lazy" itemprop="image">
                                        <h6 class="mb-0" itemprop="name">{{ $testimonial->name }}</h6>
                                        @if($testimonial->designation)
                                            <small class="text-muted" itemprop="jobTitle">{{ $testimonial->designation }}</small>
                                        @endif
                                    </div>
                                </article>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fas fa-chevron-left"></i></button>
                    <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>

        <!-- Modals -->
        @foreach($testimonials as $key => $testimonial)
            <div class="modal fade" id="testimonialModal{{ $key }}" tabindex="-1" aria-labelledby="testimonialModalLabel{{ $key }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="testimonialModalLabel{{ $key }}">{{ $testimonial->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ asset('uploads/testimonial/'.$testimonial->attach) }}"
                                 alt="Full testimonial image of {{ $testimonial->name }}"
                                 class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                            <p class="text-muted fst-italic">{{ strip_tags($testimonial->description) }}</p>
                            @if($testimonial->designation)
                                <p class="text-muted small"><strong>{{ $testimonial->designation }}</strong></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

<!-- Glide CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.core.min.css" />

<!-- Custom Styles -->
<style>
    .single-testimonial {
        transition: all 0.3s ease;
        min-height: 350px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .single-testimonial:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .testimonial-text {
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Mobile carousel arrow styles */
    @media (max-width: 991.98px) {
        #testimonialCarousel {
            position: relative;
        }

        #testimonialCarousel .glide__arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: #fff;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            color: #007bff;
            font-size: 1.1rem;
            z-index: 10;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        #testimonialCarousel .glide__arrow--left { left: -10px; }
        #testimonialCarousel .glide__arrow--right { right: -10px; }

        #testimonialCarousel .glide__slide {
            padding: 0 10px;
        }
    }
</style>

<!-- Glide JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/glide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.innerWidth < 992) {
            new Glide('#testimonialCarousel', {
                type: 'carousel',
                perView: 1,
                gap: 20
            }).mount();
        }
    });
</script>
