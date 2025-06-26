<!-- AOS Styles -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

<section class="director-message py-4" style="background-color: #f9f9f9;">
    <div class="container">
        <?php $director = \App\Models\Director::first(); ?>

        <?php if($director): ?>
        <div class="row align-items-center">
            <!-- Director's Image -->
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0 text-center text-md-start">
                <figure class="director-image" itemscope itemtype="https://schema.org/Person" data-aos="fade-right">
                    <img src="<?php echo e(url($director->image)); ?>"
                         alt="Photo of <?php echo e($director->name); ?>, Director of the College"
                         class="director-photo-oval"
                         itemprop="image">
                    <meta itemprop="name" content="<?php echo e($director->name); ?>">
                    <meta itemprop="jobTitle" content="Director">
                </figure>
            </div>

            <!-- Director's Message -->
            <div class="col-lg-8 col-md-6">
                <article class="director-text ps-lg-4" itemscope itemtype="https://schema.org/Article" data-aos="fade-left">
                    <header>
                        <h1 class="text-uppercase text-muted mb-2 h6">
                            <i class="fal fa-user-tie me-2"></i>
                            <span itemprop="headline">Message from the Director</span>
                        </h1>
                        <h2 class="fw-bold h4 mb-3" itemprop="about"><?php echo e($director->title); ?></h2>
                    </header>

                    <!-- Quote Box -->
                    <blockquote class="director-quote mb-3" itemprop="articleBody" data-aos="fade-up" data-aos-duration="800">
                        <i class="fas fa-quote-left text-primary me-2"></i>
                        <p class="mb-0 text-dark d-inline"><?php echo e($director->message); ?></p>
                        <i class="fas fa-quote-right text-primary ms-2"></i>
                    </blockquote>

                    <footer>
                        <h3 class="fw-semibold mb-1 h5" itemprop="author"><?php echo e($director->name); ?></h3>
                        <p class="fst-italic text-muted mb-0">Director</p>
                    </footer>
                </article>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- AOS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();
</script>

<!-- Styles -->
<style>
.director-photo-oval {
    width: 200px;
    height: 260px;
    object-fit: cover;
    border-radius: 50% / 40%;
    border: 4px solid #0d6efd; /* Blue border */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    display: inline-block;
}

.director-quote {
    background-color: #fff;
    border-left: 3px solid #0d6efd;
    padding: 16px 20px;
    font-size: 1.05rem;
    line-height: 1.8;
    border-radius: 6px;
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.04);
    position: relative;
    transition: transform 0.3s ease;
}

.director-quote i.fas {
    font-size: 0.9rem;
    opacity: 0.6;
    vertical-align: top;
}

@media (max-width: 767.98px) {
    .director-message .row {
        flex-direction: column;
    }

    .director-message .col-md-6,
    .director-message .col-lg-4,
    .director-message .col-lg-8 {
        max-width: 100%;
        flex: 0 0 100%;
        text-align: center !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .director-image {
        margin-bottom: 1rem;
    }

    .director-text {
        padding-top: 0.5rem;
    }
}

/* Additional spacing cleanup for surrounding sections */
@media (max-width: 767.98px) {
    .service-details-two {
        margin-bottom: 10px !important;
        padding-bottom: 10px !important;
    }

    .about-area {
        padding-top: 30px !important;
    }
}
</style>
<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/message.blade.php ENDPATH**/ ?>