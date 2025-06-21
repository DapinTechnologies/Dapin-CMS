<!-- Examination Bodies Section -->
<!-- AOS CSS -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<!-- Examination Bodies Section -->
<section class="exam-bodies-section py-5" style="background: #f1f3f5;" aria-labelledby="exam-bodies-heading">
    <div class="container">
        <header class="text-center mb-5" data-aos="fade-up" data-aos-duration="800">
            <h2 id="exam-bodies-heading" class="fw-bold h2">Accredited Examination Bodies in Kenya</h2>
            <p class="text-muted">Our institution is officially recognized and accredited by top national and international examination authorities.</p>
        </header>

        <div class="row justify-content-center text-center g-4">
            <!-- KNEC -->
            <article class="col-md-4 col-sm-6" itemscope itemtype="https://schema.org/Organization" data-aos="fade-right" data-aos-delay="100" data-aos-duration="800">
                <div class="exam-body-card p-4 shadow-sm bg-white rounded" itemprop="department">
                    <img src="<?php echo e(asset('uploads/logos/knec.jpg')); ?>" alt="Kenya National Examinations Council (KNEC) Logo" style="height: 60px;" class="mb-3" itemprop="logo">
                    <h3 class="h5" itemprop="name">KNEC</h3>
                    <p class="text-muted small" itemprop="description">Kenya National Examinations Council - the national assessment body in Kenya.</p>
                </div>
            </article>

            <!-- KASNEB -->
            <article class="col-md-4 col-sm-6" itemscope itemtype="https://schema.org/Organization" data-aos="fade-up" data-aos-delay="200" data-aos-duration="800">
                <div class="exam-body-card p-4 shadow-sm bg-white rounded" itemprop="department">
                    <img src="<?php echo e(asset('uploads/logos/kasneb.png')); ?>" alt="KASNEB Logo - Kenya Accountants and Secretaries Examinations Board" style="height: 60px;" class="mb-3" itemprop="logo">
                    <h3 class="h5" itemprop="name">KASNEB</h3>
                    <p class="text-muted small" itemprop="description">Kenya Accountants and Secretaries National Examinations Board - a professional certification body in Kenya.</p>
                </div>
            </article>

            <!-- City & Guilds -->
            <article class="col-md-4 col-sm-6" itemscope itemtype="https://schema.org/Organization" data-aos="fade-left" data-aos-delay="300" data-aos-duration="800">
                <div class="exam-body-card p-4 shadow-sm bg-white rounded" itemprop="department">
                    <img src="<?php echo e(asset('uploads/logos/city.png')); ?>" alt="City and Guilds International Certification Logo" style="height: 60px;" class="mb-3" itemprop="logo">
                    <h3 class="h5" itemprop="name">City & Guilds</h3>
                    <p class="text-muted small" itemprop="description">City & Guilds - a globally recognized vocational education and certification authority.</p>
                </div>
            </article>
        </div>
    </div>
</section>


<style>
    .exam-body-card:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }
</style>



<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        AOS.init({ once: true });
    });
</script>
<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/exams.blade.php ENDPATH**/ ?>