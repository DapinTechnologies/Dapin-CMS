
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- AOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
    <!-- Glide.js for carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.core.min.css">
   <style>
    :root {
        --primary: #ff6600; /* Orange theme */
        --secondary: #3f37c9;
        --accent: #4cc9f0;
        --light: #f8f9fa;
        --dark: #212529;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f2f5;
        color: #333;
    }

    .statistics-area {
        position: relative;
        background-color: #f8f9fa;
        overflow: hidden;
        z-index: 1;
        padding: 80px 0;
    }

    .statistics-area::before {
        content: "";
        position: absolute;
        top: -80px;
        left: 0;
        width: 100%;
        height: 200px;
        background: url('https://www.svgrepo.com/show/353755/abstract-shapes.svg') no-repeat center;
        background-size: cover;
        opacity: 0.05;
        z-index: 0;
    }

    .statistic-card {
        background: #ffffff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        position: relative;
        z-index: 2;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        height: 100%;
        text-align: center;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .statistic-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    .statistic-icon {
        font-size: 40px;
        color: var(--primary);
        margin-bottom: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, rgba(255, 102, 0, 0.1), rgba(255, 102, 0, 0.05));
    }

    .statistic-number {
        font-size: 36px;
        font-weight: bold;
        color: var(--primary);
        margin-bottom: 10px;
        font-family: 'Arial Rounded MT Bold', 'Arial', sans-serif;
        letter-spacing: -1px;
    }

    .statistic-label {
        font-size: 18px;
        font-weight: 600;
        color: #555;
        margin-bottom: 0;
    }

    .section-header {
        margin-bottom: 60px;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 1rem;
        position: relative;
        display: inline-block;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: var(--primary);
        border-radius: 2px;
    }

    .section-subtitle {
        font-size: 1.2rem;
        color: #666;
        max-width: 700px;
        margin: 0 auto;
    }

    /* Mobile Carousel */
    .mobile-carousel {
        display: none;
        padding: 20px 0 60px;
    }

    .glide__slide {
        padding: 10px;
    }

    .glide__bullets {
        position: absolute;
        bottom: 20px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .glide__bullet {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(0,0,0,0.2);
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .glide__bullet--active {
        background: var(--primary);
        transform: scale(1.2);
    }

    .glide__arrows {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 15px;
        transform: translateY(-50%);
    }

    .glide__arrow {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: white;
        border: none;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        color: var(--primary);
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .glide__arrow:hover {
        background: var(--primary);
        color: white;
        transform: scale(1.1);
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .statistics-area {
            padding: 60px 0;
        }

        .statistic-card {
            padding: 25px;
        }

        .statistic-icon {
            width: 80px;
            height: 80px;
            font-size: 2.4rem;
        }

        .statistic-number {
            font-size: 2.4rem;
        }

        .section-title {
            font-size: 2.2rem;
        }
    }

    @media (max-width: 768px) {
        .desktop-grid {
            display: none;
        }

        .mobile-carousel {
            display: block;
        }

        .statistics-area {
            padding: 50px 0;
        }

        .section-header {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 2rem;
        }

        .section-subtitle {
            font-size: 1.1rem;
        }

        .statistic-card {
            padding: 30px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .statistic-icon {
            width: 70px;
            height: 70px;
            font-size: 2rem;
            margin-bottom: 1.2rem;
        }

        .statistic-number {
            font-size: 2.2rem;
        }

        .statistic-label {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 576px) {
        .statistics-area {
            padding: 40px 0;
        }

        .section-title {
            font-size: 1.8rem;
        }

        .section-subtitle {
            font-size: 1rem;
        }

        .statistic-card {
            padding: 25px 15px;
        }

        .statistic-icon {
            width: 60px;
            height: 60px;
            font-size: 1.8rem;
        }

        .statistic-number {
            font-size: 2rem;
        }

        .glide__arrow {
            width: 36px;
            height: 36px;
            font-size: 1rem;
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
<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/stats.blade.php ENDPATH**/ ?>