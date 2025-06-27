<!-- Required Styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.core.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .news-section {
        background-color: #f9f9f9;
        padding: 4rem 0;
    }

    .glide__slide {
        padding: 0 12px;
        height: auto;
    }

    .glide__arrows {
        display: none;
    }

    @media (max-width: 768px) {
        .glide {
            position: relative;
            padding: 0 20px;
        }

        .glide__arrows {
            display: block;
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .glide__arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            color: #007bff;
            pointer-events: auto;
        }

        .glide__arrow--left {
            left: -15px;
        }

        .glide__arrow--right {
            right: -15px;
        }
    }

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

    .news-icon {
        text-align: center;
        margin-bottom: 15px;
    }

    .news-icon svg {
        width: 64px;
        height: 64px;
        fill: #007bff;
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
</style>


<!-- News & Media Section -->
<section class="news-section pt-3 pb-5" aria-labelledby="news-heading">
    <div class="container">
        <header class="text-center mb-4">
            <h2 id="news-heading" class="fw-bold">Latest News & Media</h2>
            <p class="text-muted">Stay updated with the latest stories, updates, and press releases.</p>
        </header>

        <?php
            use App\Models\Web\News;
            $newsItems = News::where('status', 1)->orderBy('date', 'desc')->get();
        ?>

        <?php if($newsItems->count()): ?>
            <div class="glide" id="newsCarousel">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        <?php $__currentLoopData = $newsItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="glide__slide">
                                <article class="news-card" itemscope itemtype="https://schema.org/NewsArticle">
                                    <!-- News Image with Badge -->
                                    <div class="news-image position-relative">
                                        <?php if($news->attach): ?>
                                            <img src="<?php echo e(asset('uploads/news/' . $news->attach)); ?>"
                                                 alt="<?php echo e($news->title); ?>"
                                                 class="img-fluid rounded-top"
                                                 itemprop="image">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('images/placeholder-news.jpg')); ?>"
                                                 alt="<?php echo e($news->title); ?>"
                                                 class="img-fluid rounded-top"
                                                 itemprop="image">
                                        <?php endif; ?>

                                        <?php if($news->badge): ?>
                                            <span class="news-badge badge bg-danger position-absolute top-0 start-0 m-2">
                                                <?php echo e($news->badge); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="news-content">
                                        <header>
                                            <h3 class="news-title" itemprop="headline"><?php echo e($news->title); ?></h3>
                                            <time class="news-date" itemprop="datePublished" datetime="<?php echo e($news->date); ?>">
                                                <i class="fas fa-calendar-alt text-primary"></i>
                                                <?php echo e(\Carbon\Carbon::parse($news->date)->format('M d, Y')); ?>

                                            </time>
                                        </header>

                                        <p class="news-description" itemprop="description">
                                            <?php echo e(Str::limit(strip_tags($news->description), 150, '...')); ?>

                                        </p>
                                    </div>

                                    <a href="<?php echo e(route('news.single', ['id' => $news->id, 'slug' => $news->slug])); ?>"
                                       class="news-read-more" itemprop="url">
                                        Read More <i class="fas fa-arrow-right"></i>
                                    </a>
                                </article>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <!-- Carousel Arrows -->
                <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">No news articles available at the moment.</p>
        <?php endif; ?>
    </div>
</section>
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
<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/newshead.blade.php ENDPATH**/ ?>