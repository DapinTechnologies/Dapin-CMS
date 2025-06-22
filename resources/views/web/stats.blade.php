
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- AOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
    <!-- Glide.js for carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.core.min.css">
<style>
    .statistic-card {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        min-height: 200px;
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
    padding: 0 16px;
}

.statistics-glide .statistic-card {
    width: 100%;
    max-width: 360px;
}


        .statistics-glide .glide__arrows {
            display: flex;
            justify-content: space-between;
            position: absolute;
            top: 40%;
            left: 0;
            right: 0;
            padding: 0 15px;
            z-index: 10;
        }

        .statistics-glide .glide__arrow {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #fff;
            border: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            color: #343a40;
            font-size: 1rem;
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
            margin-top: 15px;
            gap: 8px;
        }

        .statistics-glide .glide__bullet {
            width: 10px;
            height: 10px;
            background: rgba(0,0,0,0.3);
            border-radius: 50%;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .statistics-glide .glide__bullet--active {
            background: #343a40;
            transform: scale(1.2);
        }
    }

    @media (min-width: 769px) {
        .mobile-carousel {
            display: none;
        }
    }
</style>





    <section class="statistics-area">
        

            <!-- Desktop Grid (visible on medium screens and above) -->
            <div class="desktop-grid">
                <div class="row justify-content-center text-center">
                    <!-- Students -->
                    <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="100">
                        <article class="statistic-card" role="region" aria-label="Students Enrolled">
                            <div class="statistic-icon text-primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3 class="statistic-number" data-count="5000">0</h3>
                            <p class="statistic-label">Students</p>
                        </article>
                    </div>

                    <!-- Departments -->
                    <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="200">
                        <article class="statistic-card" role="region" aria-label="Departments Available">
                            <div class="statistic-icon text-success">
                                <i class="fas fa-building"></i>
                            </div>
                            <h3 class="statistic-number" data-count="12">0</h3>
                            <p class="statistic-label">Departments</p>
                        </article>
                    </div>

                    <!-- Courses -->
                    <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="300">
                        <article class="statistic-card" role="region" aria-label="Courses Offered">
                            <div class="statistic-icon text-warning">
                                <i class="fas fa-book"></i>
                            </div>
                            <h3 class="statistic-number" data-count="58">0</h3>
                            <p class="statistic-label">Courses</p>
                        </article>
                    </div>

                    <!-- Lecturers -->
                    <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="400">
                        <article class="statistic-card" role="region" aria-label="Qualified Lecturers">
                            <div class="statistic-icon text-danger">
                                <i class="fas fa-chalkboard-user"></i>
                            </div>
                            <h3 class="statistic-number" data-count="215">0</h3>
                            <p class="statistic-label">Lecturers</p>
                        </article>
                    </div>
                </div>
            </div>

            <!-- Mobile Carousel (visible on small screens) -->
            <div class="mobile-carousel">
            <div class="glide statistics-glide">

                    <div class="glide__track" data-glide-el="track">
                        <div class="glide__slides">
                            <!-- Students -->
                            <div class="glide__slide">
                                <article class="statistic-card" role="region" aria-label="Students Enrolled">
                                    <div class="statistic-icon text-primary">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h3 class="statistic-number" data-count="5000">0</h3>
                                    <p class="statistic-label">Students</p>
                                </article>
                            </div>

                            <!-- Departments -->
                            <div class="glide__slide">
                                <article class="statistic-card" role="region" aria-label="Departments Available">
                                    <div class="statistic-icon text-success">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <h3 class="statistic-number" data-count="12">0</h3>
                                    <p class="statistic-label">Departments</p>
                                </article>
                            </div>

                            <!-- Courses -->
                            <div class="glide__slide">
                                <article class="statistic-card" role="region" aria-label="Courses Offered">
                                    <div class="statistic-icon text-warning">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <h3 class="statistic-number" data-count="58">0</h3>
                                    <p class="statistic-label">Courses</p>
                                </article>
                            </div>

                            <!-- Lecturers -->
                            <div class="glide__slide">
                                <article class="statistic-card" role="region" aria-label="Qualified Lecturers">
                                    <div class="statistic-icon text-danger">
                                        <i class="fas fa-chalkboard-user"></i>
                                    </div>
                                    <h3 class="statistic-number" data-count="215">0</h3>
                                    <p class="statistic-label">Lecturers</p>
                                </article>
                            </div>
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


