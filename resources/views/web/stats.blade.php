
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- AOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
    <!-- Glide.js for carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.core.min.css">
  <style>
    /* Statistics Slide Container */
    .statistics-glide .glide__slide {
        padding: 0 10px;
        display: flex;
        justify-content: center;
        box-sizing: border-box;
    }

    /* Statistics Arrows Container */
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

    /* Bullets for Statistics Glide */
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
        // Initialize AOS
        AOS.init({
            once: true,
            duration: 800,
            easing: 'ease-out-quad'
        });
        
        // Initialize Glide carousel for mobile
        if (window.innerWidth <= 768) {
            const glide = new Glide('.glide', {
                type: 'carousel',
                perView: 1,
                gap: 20,
                autoplay: 4000,
                hoverpause: true,
                animationDuration: 600
            });
            
            glide.mount();
        }
        
        // Counter animation
        document.addEventListener('DOMContentLoaded', function () {
            const startCounter = (element) => {
                const counter = element;
                const target = +counter.getAttribute('data-count');
                const count = +counter.innerText;
                
                if (count >= target) return;
                
                const increment = target / 50;
                let current = count;
                
                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.innerText = Math.ceil(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.innerText = target;
                    }
                };
                
                updateCounter();
            };
            
            // Start counters for desktop grid
            const gridCounters = document.querySelectorAll('.desktop-grid .statistic-number');
            gridCounters.forEach(counter => {
                startCounter(counter);
            });
            
            // Start counters for mobile carousel (only active slide)
            if (window.innerWidth <= 768) {
                const glideInstance = new Glide('.glide');
                
                glideInstance.on('run.after', () => {
                    const activeSlide = document.querySelector('.glide__slide--active .statistic-number');
                    if (activeSlide && activeSlide.innerText === '0') {
                        startCounter(activeSlide);
                    }
                });
                
                // Start the first slide counter
                const firstSlide = document.querySelector('.glide__slide--active .statistic-number');
                if (firstSlide) {
                    startCounter(firstSlide);
                }
                
                glideInstance.mount();
            }
        });
    </script>
