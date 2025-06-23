
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.core.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .news-section {
            background-color: #f9f9f9;
            padding: 4rem 0;
        }

        .section-header {
            margin-bottom: 3rem;
        }

        .glide__slide {
            padding: 0 12px;
            height: auto;
        }

        /* Hide arrows globally */
        .glide__arrows {
            display: none;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            .glide {
                position: relative;
                padding: 0 20px; /* Reduced side padding for wider cards */
            }

            .glide__track {
                padding: 0;
            }

            .glide__arrows {
                display: block;
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                transform: translateY(-50%);
                width: 100%;
                pointer-events: none;
            }

            .glide__arrow {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                width: 36px;
                height: 36px;
                background: #fff;
                border: none;
                border-radius: 50%;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
                color: #007bff;
                font-size: 1rem;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
                pointer-events: auto;
                z-index: 2;
            }

            .glide__arrow--left {
                left: -15px;
            }

            .glide__arrow--right {
                right: -15px;
            }

            .glide__arrow:hover {
                background: #007bff;
                color: #fff;
                transform: translateY(-50%) scale(1.1);
            }
            
            /* Card adjustments for mobile */
            .news-card {
                max-height: 400px; /* Limit card height on mobile */
            }
            
            .news-content {
                overflow-y: auto; /* Make content scrollable */
                max-height: 280px; /* Limit content height */
                padding: 15px;
            }
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
            flex-grow: 1;
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

        .mobile-center-demo {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
            z-index: 1000;
            display: none;
        }

        @media (max-width: 768px) {
            .mobile-center-demo {
                display: block;
            }
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
            use App\Models\News;
            $newsItems = News::where('status', 1)->orderBy('date', 'desc')->get();
        ?>

        <?php if($newsItems->count()): ?>
        <div class="glide" id="newsCarousel">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    <?php $__currentLoopData = $newsItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="glide__slide">
                            <article class="news-card" itemscope itemtype="https://schema.org/NewsArticle">
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

            <!-- Arrows -->
            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fas fa-chevron-left"></i></button>
                <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fas fa-chevron-right"></i></button>
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
    </script><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/newshead.blade.php ENDPATH**/ ?>