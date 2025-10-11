<!-- Required Styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .news-section {
        background-color: #f9f9f9;
        padding: 4rem 0;
    }

    /* Grid Layout */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    /* Carousel Layout */
    .news-carousel-container {
        position: relative;
        width: 100%;
    }

    .news-carousel-inner {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        gap: 24px;
        padding-bottom: 1rem;
    }

    /* Desktop - show 3 cards */
    .news-carousel-inner > div {
        flex: 0 0 calc(33.333% - 16px);
        scroll-snap-align: start;
        min-width: calc(33.333% - 16px);
    }

    /* News Card Styles */
    .news-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        height: 100%;
    }

    .news-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
    }

    .news-content {
        padding: 24px;
        flex-grow: 1;
    }

    .news-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 10px;
    }

    .news-description {
        font-size: 1rem;
        color: #495057;
        margin-bottom: 16px;
        line-height: 1.6;
    }

    .news-date {
        font-size: 0.9rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .news-date i {
        margin-right: 6px;
        color: #007bff;
    }

    .news-read-more {
        display: block;
        text-align: center;
        padding: 14px;
        background-color: #007bff;
        color: #fff;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .news-read-more:hover {
        background-color: #0056b3;
    }

    .news-read-more i {
        margin-left: 5px;
        transition: transform 0.3s ease;
    }

    .news-card:hover .news-read-more i {
        transform: translateX(3px);
    }

    .news-image {
        width: 100%;
        height: 230px;
        overflow: hidden;
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .news-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-bottom: 1px solid #e9ecef;
    }

    .news-badge {
        font-size: 0.75rem;
        padding: 5px 10px;
        background-color: #dc3545;
        color: #fff;
        border-radius: 5px;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* Arrows */
    .news-carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 36px;
        height: 36px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        color: #007bff;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        border: none;
        z-index: 10;
        opacity: 0.9;
    }

    .news-carousel-btn:hover {
        opacity: 1;
        background: #f8f9fa;
    }

    .news-carousel-btn i {
        font-size: 16px;
    }

    .prev-btn { left: -18px; }
    .next-btn { right: -18px; }

    /* Mobile Styles */
    @media (max-width: 767px) {
        .news-grid {
            display: none;
        }
        
        .news-carousel-inner > div {
            flex: 0 0 calc(100% - 24px);
            min-width: calc(100% - 24px);
        }
        
        .news-carousel-container {
            padding: 0 20px;
        }
    }

    /* Hide scrollbar */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<!-- News & Media Section -->
<section class="news-section pt-3 pb-5" aria-labelledby="news-heading">
    <div class="container">
        <header class="text-center mb-4">
            <h2 id="news-heading" class="fw-bold">Latest News & Media</h2>
            <p class="text-muted">Stay updated with the latest stories, updates, and press releases.</p>
        </header>

        @php
            use App\Models\Web\News;
            $newsItems = News::where('status', 1)->orderBy('date', 'desc')->get();
        @endphp

        @if($newsItems->count())
            <!-- Desktop View - Grid or Carousel -->
            <div class="d-none d-md-block">
                @if($newsItems->count() <= 3)
                    <!-- Grid Layout for 3 or fewer news items -->
                    <div class="news-grid">
                        @foreach($newsItems as $news)
                            <article class="news-card" itemscope itemtype="https://schema.org/NewsArticle">
                                <!-- News Image with Badge -->
                                <div class="news-image position-relative">
                                    @if($news->attach)
                                        <img src="{{ asset('uploads/news/' . $news->attach) }}"
                                             alt="{{ $news->title }}"
                                             class="img-fluid rounded-top"
                                             itemprop="image">
                                    @else
                                        <img src="{{ asset('images/placeholder-news.jpg') }}"
                                             alt="{{ $news->title }}"
                                             class="img-fluid rounded-top"
                                             itemprop="image">
                                    @endif

                                    @if($news->badge)
                                        <span class="news-badge badge bg-danger position-absolute top-0 start-0 m-2">
                                            {{ $news->badge }}
                                        </span>
                                    @endif
                                </div>

                                <div class="news-content">
                                    <header>
                                        <h3 class="news-title" itemprop="headline">{{ $news->title }}</h3>
                                        <time class="news-date" itemprop="datePublished" datetime="{{ $news->date }}">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ \Carbon\Carbon::parse($news->date)->format('M d, Y') }}
                                        </time>
                                    </header>

                                    <p class="news-description" itemprop="description">
                                        {{ Str::limit(strip_tags($news->description), 150, '...') }}
                                    </p>
                                </div>

                                <a href="{{ route('news.single', ['id' => $news->id, 'slug' => $news->slug]) }}"
                                   class="news-read-more" itemprop="url">
                                    Read More <i class="fas fa-arrow-right"></i>
                                </a>
                            </article>
                        @endforeach
                    </div>
                @else
                    <!-- Carousel Layout for more than 3 news items -->
                    <div class="news-carousel-container">
                        <button class="news-carousel-btn prev-btn" onclick="slideNewsCarousel(-1, 'desktop')">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        
                        <div class="news-carousel-inner hide-scrollbar" id="news-carousel-desktop">
                            @foreach($newsItems as $news)
                                <div>
                                    <article class="news-card" itemscope itemtype="https://schema.org/NewsArticle">
                                        <!-- News Image with Badge -->
                                        <div class="news-image position-relative">
                                            @if($news->attach)
                                                <img src="{{ asset('uploads/news/' . $news->attach) }}"
                                                     alt="{{ $news->title }}"
                                                     class="img-fluid rounded-top"
                                                     itemprop="image">
                                            @else
                                                <img src="{{ asset('images/placeholder-news.jpg') }}"
                                                     alt="{{ $news->title }}"
                                                     class="img-fluid rounded-top"
                                                     itemprop="image">
                                            @endif

                                            @if($news->badge)
                                                <span class="news-badge badge bg-danger position-absolute top-0 start-0 m-2">
                                                    {{ $news->badge }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="news-content">
                                            <header>
                                                <h3 class="news-title" itemprop="headline">{{ $news->title }}</h3>
                                                <time class="news-date" itemprop="datePublished" datetime="{{ $news->date }}">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    {{ \Carbon\Carbon::parse($news->date)->format('M d, Y') }}
                                                </time>
                                            </header>

                                            <p class="news-description" itemprop="description">
                                                {{ Str::limit(strip_tags($news->description), 150, '...') }}
                                            </p>
                                        </div>

                                        <a href="{{ route('news.single', ['id' => $news->id, 'slug' => $news->slug]) }}"
                                           class="news-read-more" itemprop="url">
                                            Read More <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </article>
                                </div>
                            @endforeach
                        </div>

                        <button class="news-carousel-btn next-btn" onclick="slideNewsCarousel(1, 'desktop')">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Mobile View - Always Carousel -->
            <div class="d-md-none">
                <div class="news-carousel-container">
                    <button class="news-carousel-btn prev-btn" onclick="slideNewsCarousel(-1, 'mobile')">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    
                    <div class="news-carousel-inner hide-scrollbar" id="news-carousel-mobile">
                        @foreach($newsItems as $news)
                            <div>
                                <article class="news-card" itemscope itemtype="https://schema.org/NewsArticle">
                                    <!-- News Image with Badge -->
                                    <div class="news-image position-relative">
                                        @if($news->attach)
                                            <img src="{{ asset('uploads/news/' . $news->attach) }}"
                                                 alt="{{ $news->title }}"
                                                 class="img-fluid rounded-top"
                                                 itemprop="image">
                                        @else
                                            <img src="{{ asset('images/placeholder-news.jpg') }}"
                                                 alt="{{ $news->title }}"
                                                 class="img-fluid rounded-top"
                                                 itemprop="image">
                                        @endif

                                        @if($news->badge)
                                            <span class="news-badge badge bg-danger position-absolute top-0 start-0 m-2">
                                                {{ $news->badge }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="news-content">
                                        <header>
                                            <h3 class="news-title" itemprop="headline">{{ $news->title }}</h3>
                                            <time class="news-date" itemprop="datePublished" datetime="{{ $news->date }}">
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($news->date)->format('M d, Y') }}
                                            </time>
                                        </header>

                                        <p class="news-description" itemprop="description">
                                            {{ Str::limit(strip_tags($news->description), 150, '...') }}
                                        </p>
                                    </div>

                                    <a href="{{ route('news.single', ['id' => $news->id, 'slug' => $news->slug]) }}"
                                       class="news-read-more" itemprop="url">
                                        Read More <i class="fas fa-arrow-right"></i>
                                    </a>
                                </article>
                            </div>
                        @endforeach
                    </div>

                    <button class="news-carousel-btn next-btn" onclick="slideNewsCarousel(1, 'mobile')">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        @else
            <p class="text-center text-muted">No news articles available at the moment.</p>
        @endif
    </div>
</section>

<script>
function slideNewsCarousel(direction, type) {
    const carouselId = `news-carousel-${type}`;
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
        'news-carousel-desktop',
        document.querySelector('#news-carousel-desktop').parentElement.querySelector('.prev-btn'),
        document.querySelector('#news-carousel-desktop').parentElement.querySelector('.next-btn')
    );
    
    checkCarouselPosition(
        'news-carousel-mobile',
        document.querySelector('#news-carousel-mobile').parentElement.querySelector('.prev-btn'),
        document.querySelector('#news-carousel-mobile').parentElement.querySelector('.next-btn')
    );
});
</script>