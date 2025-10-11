<!-- Required Styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .exam-bodies-section {
        background: linear-gradient(to bottom, #f8f9fa, #ffffff);
        padding: 4rem 0;
    }

    /* Grid Layout */
    .exam-bodies-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    /* Carousel Layout */
    .exam-bodies-carousel-container {
        position: relative;
    }

    .exam-bodies-carousel-inner {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        gap: 24px;
        padding-bottom: 1rem;
    }

    /* Desktop - show 3 cards */
    .exam-bodies-carousel-inner > div {
        flex: 0 0 calc(33.333% - 16px);
        scroll-snap-align: start;
        min-width: calc(33.333% - 16px);
    }

    /* Card Styles */
    .exam-body-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        height: 100%;
        border: none;
    }

    .exam-body-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .exam-body-card .card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .exam-body-card img {
        height: 80px;
        width: auto;
        object-fit: contain;
        margin-bottom: 1rem;
    }

    .exam-body-card h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.75rem;
    }

    .exam-body-card p {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0;
    }

    /* Arrows */
    .exam-bodies-carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        color: #007bff;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        border: none;
        z-index: 10;
        opacity: 0.9;
    }

    .exam-bodies-carousel-btn:hover {
        opacity: 1;
        background: #f8f9fa;
    }

    .exam-bodies-carousel-btn i {
        font-size: 16px;
    }

    .prev-btn { left: -20px; }
    .next-btn { right: -20px; }

    /* Mobile Styles */
    @media (max-width: 767px) {
        .exam-bodies-grid {
            display: none;
        }
        
        .exam-bodies-carousel-inner > div {
            flex: 0 0 calc(100% - 24px);
            min-width: calc(100% - 24px);
        }
        
        .exam-bodies-carousel-container {
            padding: 0 20px;
        }
    }

    /* Hide scrollbar */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<!-- Examination Bodies Section -->
<section class="exam-bodies-section py-5" aria-labelledby="exam-bodies-heading">
    <div class="container">
        <header class="text-center mb-5">
            <h2 id="exam-bodies-heading" class="fw-bold">Accredited Examination Bodies in Kenya</h2>
            <p class="text-muted">Our institution is officially recognized and accredited by top national and international examination authorities.</p>
        </header>

        @php
            use App\Models\Web\AboutUsPartner;
            $examBodies = AboutUsPartner::all();
        @endphp

        @if($examBodies->count())
            <!-- Desktop View - Grid or Carousel -->
            <div class="d-none d-md-block">
                @if($examBodies->count() <= 3)
                    <!-- Grid Layout for 3 or fewer exam bodies -->
                    <div class="exam-bodies-grid">
                        @foreach($examBodies as $examBody)
                            <div class="exam-body-card card">
                                <div class="card-body">
                                    @php
                                        $logoPath = 'uploads/about-us/partners/' . $examBody->logo;
                                        $defaultLogo = 'images/default-logo.png';
                                        $logoExists = !empty($examBody->logo) && file_exists(public_path($logoPath));
                                    @endphp
                                    
                                    <img src="{{ $logoExists ? asset($logoPath) : asset($defaultLogo) }}" 
                                         alt="{{ $examBody->name }} Logo"
                                         loading="lazy"
                                         onerror="this.onerror=null;this.src='{{ asset($defaultLogo) }}'">
                                    
                                    <h3>{{ $examBody->name }}</h3>
                                    <p class="text-muted">
                                        {{ \Illuminate\Support\Str::words($examBody->description, 15, '...') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Carousel Layout for more than 3 exam bodies -->
                    <div class="exam-bodies-carousel-container">
                        <button class="exam-bodies-carousel-btn prev-btn" onclick="slideExamBodiesCarousel(-1, 'desktop')">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        
                        <div class="exam-bodies-carousel-inner hide-scrollbar" id="exam-bodies-carousel-desktop">
                            @foreach($examBodies as $examBody)
                                <div>
                                    <div class="exam-body-card card">
                                        <div class="card-body">
                                            @php
                                                $logoPath = 'uploads/about-us/partners/' . $examBody->logo;
                                                $defaultLogo = 'images/default-logo.png';
                                                $logoExists = !empty($examBody->logo) && file_exists(public_path($logoPath));
                                            @endphp
                                            
                                            <img src="{{ $logoExists ? asset($logoPath) : asset($defaultLogo) }}" 
                                                 alt="{{ $examBody->name }} Logo"
                                                 loading="lazy"
                                                 onerror="this.onerror=null;this.src='{{ asset($defaultLogo) }}'">
                                            
                                            <h3>{{ $examBody->name }}</h3>
                                            <p class="text-muted">
                                                {{ \Illuminate\Support\Str::words($examBody->description, 15, '...') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button class="exam-bodies-carousel-btn next-btn" onclick="slideExamBodiesCarousel(1, 'desktop')">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Mobile View - Always Carousel -->
            <div class="d-md-none">
                <div class="exam-bodies-carousel-container">
                    <button class="exam-bodies-carousel-btn prev-btn" onclick="slideExamBodiesCarousel(-1, 'mobile')">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    
                    <div class="exam-bodies-carousel-inner hide-scrollbar" id="exam-bodies-carousel-mobile">
                        @foreach($examBodies as $examBody)
                            <div>
                                <div class="exam-body-card card">
                                    <div class="card-body">
                                        @php
                                            $logoPath = 'uploads/about-us/partners/' . $examBody->logo;
                                            $defaultLogo = 'images/default-logo.png';
                                            $logoExists = !empty($examBody->logo) && file_exists(public_path($logoPath));
                                        @endphp
                                        
                                        <img src="{{ $logoExists ? asset($logoPath) : asset($defaultLogo) }}" 
                                             alt="{{ $examBody->name }} Logo"
                                             loading="lazy"
                                             onerror="this.onerror=null;this.src='{{ asset($defaultLogo) }}'">
                                        
                                        <h3>{{ $examBody->name }}</h3>
                                        <p class="text-muted">
                                            {{ \Illuminate\Support\Str::words($examBody->description, 15, '...') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button class="exam-bodies-carousel-btn next-btn" onclick="slideExamBodiesCarousel(1, 'mobile')">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        @else
            <p class="text-center text-muted">No examination bodies available at the moment.</p>
        @endif
    </div>
</section>

<script>
function slideExamBodiesCarousel(direction, type) {
    const carouselId = `exam-bodies-carousel-${type}`;
    const carousel = document.getElementById(carouselId);
    const slides = carousel.querySelectorAll('div');
    
    if (slides.length === 0) return;
    
    // Calculate slide width based on viewport
    let slideWidth = slides[0].offsetWidth;
    if (type === 'desktop') {
        // For desktop carousel, scroll by 3 slides at a time
        slideWidth = slides[0].offsetWidth * 3;
    }
    
    // Add gap between slides (24px)
    const gap = 24;
    slideWidth += gap;
    
    carousel.scrollBy({ 
        left: direction * slideWidth, 
        behavior: 'smooth' 
    });
}

// Hide arrows when at the start/end of carousel
document.addEventListener('DOMContentLoaded', function() {
    const checkCarouselPosition = (carouselId, prevBtn, nextBtn) => {
        const carousel = document.getElementById(carouselId);
        if (!carousel) return;
        
        const updateButtons = () => {
            const scrollLeft = carousel.scrollLeft;
            const scrollWidth = carousel.scrollWidth;
            const clientWidth = carousel.clientWidth;
            
            if (prevBtn) {
                prevBtn.style.display = scrollLeft <= 0 ? 'none' : 'flex';
            }
            if (nextBtn) {
                nextBtn.style.display = scrollLeft + clientWidth >= scrollWidth - 1 ? 'none' : 'flex';
            }
        };
        
        carousel.addEventListener('scroll', updateButtons);
        updateButtons();
    };
    
    // Initialize for both carousels
    checkCarouselPosition(
        'exam-bodies-carousel-desktop',
        document.querySelector('#exam-bodies-carousel-desktop').parentElement.querySelector('.prev-btn'),
        document.querySelector('#exam-bodies-carousel-desktop').parentElement.querySelector('.next-btn')
    );
    
    checkCarouselPosition(
        'exam-bodies-carousel-mobile',
        document.querySelector('#exam-bodies-carousel-mobile').parentElement.querySelector('.prev-btn'),
        document.querySelector('#exam-bodies-carousel-mobile').parentElement.querySelector('.next-btn')
    );
});
</script>