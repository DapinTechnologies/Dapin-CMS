<!-- AOS & Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />

<style>
    .statistics-area {
        position: relative;
        background-color: #f8f9fa;
        overflow: hidden;
        z-index: 1;
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
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        position: relative;
        z-index: 2;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .statistic-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .statistic-icon {
        font-size: 2.2rem;
        margin-bottom: 0.75rem;
    }

    .statistic-number {
        font-size: 2rem;
        font-weight: bold;
    }

    .statistic-label {
        font-size: 1rem;
        font-weight: 500;
        color: #666;
    }
</style>

<section class="statistics-area py-5" aria-labelledby="statistics-heading">
    <div class="container">
        <header class="text-center mb-5" data-aos="fade-up">
            <h2 id="statistics-heading" class="fw-bold">Our Achievements</h2>
            <p class="text-muted">Discover our key milestones in numbers.</p>
        </header>

        <div class="row justify-content-center text-center">
            <!-- Students -->
            <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="100">
                <article class="statistic-card" role="region" aria-label="Students Enrolled">
                    <div class="statistic-icon text-primary" aria-hidden="true">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="statistic-number" data-count="5000">0</h3>
                    <p class="statistic-label">Students</p>
                </article>
            </div>

            <!-- Departments -->
            <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="200">
                <article class="statistic-card" role="region" aria-label="Departments Available">
                    <div class="statistic-icon text-success" aria-hidden="true">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="statistic-number" data-count="10">0</h3>
                    <p class="statistic-label">Departments</p>
                </article>
            </div>

            <!-- Courses -->
            <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="300">
                <article class="statistic-card" role="region" aria-label="Courses Offered">
                    <div class="statistic-icon text-warning" aria-hidden="true">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 class="statistic-number" data-count="50">0</h3>
                    <p class="statistic-label">Courses</p>
                </article>
            </div>

            <!-- Lecturers -->
            <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="400">
                <article class="statistic-card" role="region" aria-label="Qualified Lecturers">
                    <div class="statistic-icon text-danger" aria-hidden="true">
                        <i class="fas fa-chalkboard-user"></i>
                    </div>
                    <h3 class="statistic-number" data-count="200">0</h3>
                    <p class="statistic-label">Lecturers</p>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- AOS + Counter Script -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ once: true });

    document.addEventListener('DOMContentLoaded', function () {
        const counters = document.querySelectorAll('.statistic-number');
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-count');
                const count = +counter.innerText;
                const increment = target / 60;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(updateCount, 30);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    });
</script>
