<style>
    .statistic-card {
        background: linear-gradient(145deg, #ffffff, #f1f1f1);
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        text-align: center;
        min-height: 230px;
    }

    .statistic-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
    }

    .statistic-icon i {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .statistic-number {
        font-size: 2.2rem;
        font-weight: bold;
        margin: 0;
        color: #212529;
    }

    .statistic-label {
        font-size: 1.05rem;
        color: #6c757d;
        margin-top: 6px;
        font-weight: 500;
    }

    /* Glide only affects mobile */
    @media (max-width: 768px) {
        .desktop-grid {
            display: none;
        }

        .mobile-carousel {
            display: block;
            position: relative;
        }

        .statistics-glide .glide__slide {
            display: flex;
            justify-content: center;
            box-sizing: border-box;
            padding: 0 12px;
        }

        .statistics-glide .statistic-card {
            width: 100%;
            max-width: 90vw;
            padding: 30px 20px;
            font-size: 1.1rem;
        }

        .statistic-icon i {
            font-size: 2.8rem;
        }

        .statistic-number {
            font-size: 2.5rem;
        }

        .statistics-glide .glide__arrows {
            display: flex;
            justify-content: space-between;
            position: absolute;
            top: 45%;
            left: 0;
            right: 0;
            padding: 0 10px;
            z-index: 10;
        }

        .statistics-glide .glide__arrow {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #fff;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            color: #343a40;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s ease;
        }

        .statistics-glide .glide__arrow:hover {
            background: #343a40;
            color: #fff;
        }

        .statistics-glide .glide__bullets {
            display: flex;
            justify-content: center;
            margin-top: 16px;
            gap: 10px;
        }

        .statistics-glide .glide__bullet {
            width: 10px;
            height: 10px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 50%;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .statistics-glide .glide__bullet--active {
            background: #343a40;
            transform: scale(1.3);
        }
    }

    @media (min-width: 769px) {
        .mobile-carousel {
            display: none;
        }
    }
</style>


 @php
                        use App\Models\Statistic;
                        $statistics = Statistic::all();
                    @endphp



  <!-- Statistics Section -->
    <section class="statistics-area py-5">
        <div class="container">
            <div class="desktop-grid">
                <div class="row justify-content-center text-center">
                    @foreach($statistics as $statistic)
                        <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="100">
                            <article class="statistic-card" role="region" aria-label="{{ ucfirst($statistic->type) }}">
                                <div class="statistic-icon 
                                    @if($statistic->type == 'students') text-primary
                                    @elseif($statistic->type == 'departments') text-success
                                    @elseif($statistic->type == 'courses') text-warning
                                    @elseif($statistic->type == 'lecturers') text-danger
                                    @endif">
                                    <i class="fas 
                                        @if($statistic->type == 'students') fa-users
                                        @elseif($statistic->type == 'departments') fa-building
                                        @elseif($statistic->type == 'courses') fa-book
                                        @elseif($statistic->type == 'lecturers') fa-chalkboard-user
                                        @endif"></i>
                                </div>
                                <h3 class="statistic-number" data-count="{{ $statistic->count }}">{{ $statistic->count }}</h3>
                                <p class="statistic-label">{{ ucfirst($statistic->type) }}</p>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Mobile Carousel (visible on small screens) -->
            <div class="mobile-carousel">
                <div class="glide statistics-glide">
                    <div class="glide__track" data-glide-el="track">
                        <div class="glide__slides">
                            @foreach($statistics as $statistic)
                                <div class="glide__slide">
                                    <article class="statistic-card" role="region" aria-label="{{ ucfirst($statistic->type) }}">
                                        <div class="statistic-icon 
                                            @if($statistic->type == 'students') text-primary
                                            @elseif($statistic->type == 'departments') text-success
                                            @elseif($statistic->type == 'courses') text-warning
                                            @elseif($statistic->type == 'lecturers') text-danger
                                            @endif">
                                            <i class="fas 
                                                @if($statistic->type == 'students') fa-users
                                                @elseif($statistic->type == 'departments') fa-building
                                                @elseif($statistic->type == 'courses') fa-book
                                                @elseif($statistic->type == 'lecturers') fa-chalkboard-user
                                                @endif"></i>
                                        </div>
                                        <h3 class="statistic-number" data-count="{{ $statistic->count }}">{{ $statistic->count }}</h3>
                                        <p class="statistic-label">{{ ucfirst($statistic->type) }}</p>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="glide__arrows" data-glide-el="controls">
                        <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <div class="glide__bullets" data-glide-el="controls[nav]">
                        <button class="glide__bullet" data-glide-dir="=0"></button>
                        <button class="glide__bullet" data-glide-dir="=1"></button>
                        <button class="glide__bullet" data-glide-dir="=2"></button>
                        <button class="glide__bullet" data-glide-dir="=3"></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <!-- Glide.js for carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/glide.min.js"></script>
    
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startCounter = (element) => {
            const target = +element.getAttribute('data-count');
            let current = +element.innerText;
            if (current >= target) return;
            const increment = target / 50;
            const update = () => {
                current += increment;
                if (current < target) {
                    element.innerText = Math.ceil(current);
                    requestAnimationFrame(update);
                } else {
                    element.innerText = target;
                }
            };
            update();
        };

        // Animate all counters in desktop grid
        document.querySelectorAll('.desktop-grid .statistic-number').forEach(startCounter);

        // Initialize Glide only on mobile
        if (window.innerWidth <= 768 && document.querySelector('.statistics-glide')) {
            const glideStats = new Glide('.statistics-glide', {
                type: 'carousel',
                perView: 1,
                gap: 20,
                autoplay: 4000,
                hoverpause: true,
                animationDuration: 600
            });

            glideStats.on('run.after', () => {
                const active = document.querySelector('.statistics-glide .glide__slide--active .statistic-number');
                if (active && active.innerText === '0') startCounter(active);
            });

            glideStats.mount();

            // Start first counter
            const firstStat = document.querySelector('.statistics-glide .glide__slide--active .statistic-number');
            if (firstStat && firstStat.innerText === '0') startCounter(firstStat);
        }
    });
</script>


