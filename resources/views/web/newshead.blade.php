<!-- Glide.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.core.min.css" />

<!-- News & Media Section -->
<section class="news-section pt-3 pb-5" aria-labelledby="news-heading">
    <div class="container">
        <header class="text-center mb-4">
            <h2 id="news-heading" class="fw-bold">Latest News & Media</h2>
            <p class="text-muted">Stay updated with the latest stories, updates, and press releases.</p>
        </header>

        @php
            use App\Models\News;
            $newsItems = News::where('status', 1)->orderBy('date', 'desc')->get();
        @endphp

        @if($newsItems->count())
        <div class="glide" id="newsCarousel">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @foreach($newsItems as $news)
                        <li class="glide__slide">
                            <article class="news-card" itemscope itemtype="https://schema.org/NewsArticle">
                                <div class="news-content">
                                    <header>
                                        <h3 class="news-title" itemprop="headline">{{ $news->title }}</h3>
                                        <time class="news-date" itemprop="datePublished" datetime="{{ $news->date }}">
                                            <i class="fas fa-calendar-alt text-primary"></i>
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
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Arrows -->
            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fas fa-chevron-left"></i></button>
                <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
        @else
            <p class="text-center text-muted">No news articles available at the moment.</p>
        @endif
    </div>
</section>

<!-- Styles (merge with your current styles) -->
<style>
    .news-section {
        background-color: #f9f9f9;
    }

    .glide__slide {
        padding: 0 10px;
    }

    .glide__arrows {
        display: flex;
        justify-content: space-between;
        padding: 0 10px;
        margin-top: 10px;
    }

    .glide__arrow {
        background: #fff;
        border: none;
        padding: 10px;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        color: #007bff;
        font-size: 1.2rem;
        transition: background 0.3s ease;
    }

    .glide__arrow:hover {
        background: #007bff;
        color: #fff;
    }

    .news-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .news-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .news-content {
        padding: 20px;
    }

    .news-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 10px;
    }

    .news-description {
        font-size: 0.95rem;
        color: #495057;
        margin-bottom: 16px;
        line-height: 1.6;
    }

    .news-date {
        font-size: 0.85rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .news-date i {
        margin-right: 6px;
    }

    .news-read-more {
        display: block;
        text-align: center;
        padding: 12px;
        background-color: #007bff;
        color: #fff;
        font-weight: 500;
        font-size: 0.95rem;
        text-decoration: none;
        transition: background 0.3s ease;
        border-top: 1px solid #eee;
    }

    .news-read-more:hover {
        background-color: #0056b3;
    }

    .news-read-more i {
        margin-left: 5px;
    }
</style>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/glide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Glide('#newsCarousel', {
            type: 'carousel',
            perView: 3,
            gap: 24,
            breakpoints: {
                992: { perView: 2 },
                576: { perView: 1 }
            }
        }).mount();
    });
</script>
