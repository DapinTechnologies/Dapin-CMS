<?php $__env->startSection('title', __('About Us')); ?>

<?php $__env->startSection('social_meta_tags'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <?php if(isset($setting)): ?>
        <meta property="og:type" content="website">
        <meta property='og:site_name' content="<?php echo e($setting->title); ?>"/>
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="<?php echo '@'.str_replace(' ', '', $setting->title); ?>" />
        <meta name="twitter:creator" content="@HiTechParks" />
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<main>
    <!-- Hero Section -->
    <section class="breadcrumb-area py-5 bg-dark-blue text-white">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-12">
                    <h1 class="display-4 fw-bold mb-4"><?php echo e(__('About Us')); ?></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>" class="text-white-70"><?php echo e(__('navbar_home')); ?></a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page"><?php echo e(__('About')); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <style>
        .about-text-dark {
    color: #212529 !important; /* Bootstrap's text-dark color */
}
    </style>

    <!-- About Content Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <?php if($about): ?>
            <!-- Dynamic Content Section -->
            <div class="row g-5 align-items-center">
              <div class="col-lg-6 order-lg-1 order-2">
    <h2 class="fw-bold mb-4 text-dark"><?php echo e($about->title); ?></h2>
    

<p class="lead mb-4 text-dark">
    <?php echo e(htmlspecialchars_decode(strip_tags($about->short_desc, '<p><br><strong><em>'))); ?>

</p>
    <div class="mb-4 text-dark" style="color: #212529 !important;"><?php echo $about->description; ?></div>
</div>

                <!-- Right: Media Content (Image + Video) -->
                <div class="col-lg-6 order-lg-2 order-1">
                    <?php if($about->attach): ?>
                        <div class="text-center mb-4">
                            <img src="<?php echo e(asset('uploads/about-us/'.$about->attach)); ?>" 
                                 alt="<?php echo e($about->title); ?>" 
                                 class="img-fluid rounded w-100 shadow-lg mb-4"
                                 style="max-height: 400px; object-fit: cover;">
                        </div>
                    <?php endif; ?>
                    
                    <?php if($about->video_id): ?>
                        <div class="ratio ratio-16x9 shadow-lg rounded-lg overflow-hidden">
                            <iframe src="https://www.youtube.com/embed/<?php echo e($about->video_id); ?>" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen 
                                    class="rounded-lg">
                            </iframe>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Features Section -->
            <?php if($about->features): ?>
            <div class="mt-5 pt-4">
                <h3 class="fw-semibold mb-4 text-dark-blue">Our Key Features</h3>
                <div class="row g-4">
                    <?php $__currentLoopData = json_decode($about->features, true) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6">
                            <div class="feature-card p-4 rounded-lg bg-light border-start border-4 border-dark-blue h-100">
                                <i class="bi bi-check-circle-fill text-dark-blue me-2"></i> 
                                <span class="text-dark"><?php echo e($feature); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
            <?php endif; ?>

            <!-- Vision & Mission Section -->
            <div class="row mb-5 mt-5">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="icon-box bg-light-blue text-dark-blue mb-3">
                                <i class="bi bi-eye-fill fs-2"></i>
                            </div>
                            <h3 class="text-dark">Vision Statement</h3>
                            <p class="lead text-dark">To be a dynamic center of excellence in the delivery of high-quality, relevant industry-based training and education.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="icon-box bg-light-green text-dark-blue mb-3">
                                <i class="bi bi-bullseye fs-2"></i>
                            </div>
                            <h3 class="text-dark">Our Motto</h3>
                            <p class="lead text-dark">"Developing Character, Skills & Competence."</p>
                        </div>
                    </div>
                </div>
            </div>

            



<section class="values-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title text-dark">Our Core Values</h2>
            <div class="section-divider bg-dark"></div>
        </div>
        
        <div class="row g-4">
            <?php $__currentLoopData = App\Models\CoreValue::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3 col-sm-6">
                <div class="value-card text-center p-4 h-100 border-0 shadow-sm bg-white">
                    <div class="value-icon mb-3">
                        <i class="bi bi-<?php echo e($value->icon); ?> fs-1 text-dark"></i>
                    </div>
                    <h4 class="mb-3 text-dark"><?php echo e($value->title); ?></h4>
                    <p class="mb-0 text-dark"><?php echo e($value->description); ?></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<style>
    .values-section {
        /* Ensures all text remains black */
        --bs-body-color: #212529;
        --bs-heading-color: #212529;
    }
    .section-divider {
        width: 80px;
        height: 3px;
        margin: 0 auto;
    }
    .value-card {
        transition: transform 0.3s ease;
    }
    .value-card:hover {
        transform: translateY(-5px);
    }
</style>

            <!-- Founder's Message -->
            <div class="row my-5 py-4 align-items-center">
             <?php
    use App\Models\Director;
    $director = Director::first();  // Fetch the first director or add any condition if you need to
?>

<div class="row my-5 py-4">
    <div class="col-lg-5">
        <!-- Check if the director has an image -->
        <?php if($director && $director->image): ?>
             <img src="<?php echo e(url($director->image)); ?>" alt="Founder <?php echo e($director->name); ?>" class="img-fluid rounded shadow-lg w-100">
        <?php else: ?>
            <img src="<?php echo e(asset('assets/images/founder.jpg')); ?>" alt="Founder <?php echo e($director->name); ?>" class="img-fluid rounded shadow-lg w-100">
        <?php endif; ?>
    </div>
    <div class="col-lg-7 mt-4 mt-lg-0">
        <h2 class="text-dark mb-4">Director's Message</h2>
        <div class="message-content">
            <!-- Display the director's message -->
            <?php if($director): ?>
                <p class="text-dark"><?php echo e($director->message); ?></p>
            <?php else: ?>
                <p class="text-dark">No message available from the founder.</p>
            <?php endif; ?>
        </div>
        <div class="signature mt-4">
            <p class="mb-1 fw-bold text-dark"><?php echo e($director->name ?? 'Founder'); ?></p>
            <p class="text-muted"><?php echo e($director->title ?? 'Director'); ?></p>
        </div>
    </div>
</div>


<?php
    use App\Models\Web\AboutUsPartner;
    $partners = AboutUsPartner::orderBy('order', 'asc')->get();
?>

<section class="modern-partners py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Our Trusted Partners</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Collaborating with industry leaders to deliver excellence</p>
        </div>
        
        <div class="partner-grid">
            <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="partner-card">
                <div class="partner-logo-container">
                    <?php if($partner->logo): ?>
                        <img src="<?php echo e(asset('uploads/about-us/partners/' . $partner->logo)); ?>" 
                             alt="<?php echo e($partner->name); ?>" 
                             class="partner-logo"
                             loading="lazy">
                    <?php else: ?>
                        <img src="<?php echo e(asset('assets/images/default-partner-logo.png')); ?>" 
                             alt="Default Logo" 
                             class="partner-logo"
                             loading="lazy">
                    <?php endif; ?>
                </div>
                <div class="partner-content">
                    <h3 class="partner-name"><?php echo e($partner->name); ?></h3>
                    <p class="partner-description"><?php echo e(\Illuminate\Support\Str::limit($partner->description, 120)); ?></p>
                  <a href="<?php echo e(Str::startsWith($partner->url, 'http') ? $partner->url : 'https://'.$partner->url); ?>" 
   target="_blank" 
   class="partner-link">
   Visit Website
</a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<style>
.modern-partners {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 4rem 0;
}

.section-header {
    max-width: 700px;
    margin: 0 auto;
}

.section-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #212529;
    margin-bottom: 1rem;
    position: relative;
}

.section-divider {
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #3a86ff, #8338ec);
    margin: 0 auto 1.5rem;
    border-radius: 3px;
}

.section-subtitle {
    color: #6c757d;
    font-size: 1.1rem;
}

.partner-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.partner-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 2rem 1.5rem;
}

.partner-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.partner-logo-container {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    border: 1px solid #f1f1f1;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    padding: 15px;
}

.partner-logo {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
    border-radius: 50%;
}

.partner-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.partner-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #212529;
    margin-bottom: 0.75rem;
}

.partner-description {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    flex: 1;
}

.partner-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(90deg, #3a86ff, #8338ec);
    color: white;
    padding: 0.6rem 1.25rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    margin-top: auto;
}

.partner-link svg {
    margin-left: 8px;
    transition: transform 0.3s ease;
}

.partner-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(58, 134, 255, 0.3);
}

.partner-link:hover svg {
    transform: translateX(3px);
}

/* Responsive Design */
@media (max-width: 992px) {
    .partner-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
}

@media (max-width: 768px) {
    .section-title {
        font-size: 1.8rem;
    }
    
    .partner-grid {
        gap: 1.5rem;
    }
    
    .partner-card {
        padding: 1.5rem 1rem;
    }
    
    .partner-logo-container {
        width: 100px;
        height: 100px;
    }
}

@media (max-width: 576px) {
    .modern-partners {
        padding: 3rem 0;
    }
    
    .section-title {
        font-size: 1.6rem;
    }
    
    .partner-grid {
        grid-template-columns: 1fr;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }
}
</style>




<?php
    use App\Models\Web\AboutUsAccreditation;
    $accreditations = AboutUsAccreditation::orderBy('order', 'asc')->get();
?>

<!-- Accreditation Section -->
<section class="accreditation-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Our Accreditations</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Recognized by leading educational and professional bodies</p>
        </div>

        <div class="accreditation-grid">
            <?php $__currentLoopData = $accreditations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accreditation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="accreditation-card">
                <div class="accreditation-logo-container">
                    <?php if($accreditation->logo): ?>
                        <img src="<?php echo e(asset('uploads/about-us/accreditations/' . $accreditation->logo)); ?>" 
                             alt="<?php echo e($accreditation->name); ?>" 
                             class="accreditation-logo"
                             loading="lazy">
                    <?php else: ?>
                        <div class="default-logo">
                            <i class="fas fa-certificate"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="accreditation-content">
                    <h3 class="accreditation-name"><?php echo e($accreditation->name); ?></h3>
                    <p class="accreditation-description">
                        <?php echo e(\Illuminate\Support\Str::limit($accreditation->description, 20)); ?>

                    </p>
                    <?php if($accreditation->url): ?>
                    <a href="<?php echo e(Str::startsWith($accreditation->url, 'http') ? $accreditation->url : 'https://'.$accreditation->url); ?>" 
                       target="_blank" 
                       class="accreditation-link">
                        Visit Website <i class="fas fa-external-link-alt ms-2"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<style>
.accreditation-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.section-header {
    max-width: 700px;
    margin: 0 auto;
}

.section-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 1rem;
}

.section-divider {
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #3a86ff, #8338ec);
    margin: 0 auto 1.5rem;
}

.section-subtitle {
    color: #6c757d;
    font-size: 1.1rem;
}

.accreditation-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.accreditation-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.accreditation-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.accreditation-logo-container {
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: #f8f9fa;
    border-bottom: 1px solid #eee;
}

.accreditation-logo {
    max-width: 100%;
    max-height: 100px;
    width: auto;
    height: auto;
    object-fit: contain;
}

.default-logo {
    font-size: 3rem;
    color: #3a86ff;
}

.accreditation-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.accreditation-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 0.75rem;
}

.accreditation-description {
    color: #4a4a4a;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    flex: 1;
}

.accreditation-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(90deg, #3a86ff, #8338ec);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    margin-top: auto;
    font-size: 0.9rem;
}

.accreditation-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(58, 134, 255, 0.3);
    color: white;
}

/* Responsive Design */
@media (max-width: 992px) {
    .accreditation-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
}

@media (max-width: 768px) {
    .section-title {
        font-size: 1.8rem;
    }
    
    .accreditation-grid {
        gap: 1.5rem;
    }
    
    .accreditation-logo-container {
        height: 120px;
        padding: 1.5rem;
    }
    
    .accreditation-logo {
        max-height: 80px;
    }
}

@media (max-width: 576px) {
    .accreditation-section {
        padding: 3rem 0;
    }
    
    .section-title {
        font-size: 1.6rem;
    }
    
    .accreditation-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
    use App\Models\Web\AboutUsHistory;
    $histories = AboutUsHistory::orderBy('order', 'asc')->get();
?>

<div class="progress-timeline">
    <div class="container">
        <h2 class="timeline-header">Our Journey Through Time</h2>
        <div class="timeline-progress">
            <div class="timeline-line"></div>
            <?php $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="milestone">
                    <div class="milestone-marker"></div>
                    <div class="milestone-year"><?php echo e($history->year); ?></div>
                    <div class="milestone-card">
                        <div class="milestone-content">
                            <h3><?php echo e($history->title); ?></h3>
                            <div class="milestone-details">
                                <?php if($history->image): ?>
                                    <div class="milestone-image">
                                        <img src="<?php echo e(asset('uploads/about-us/history/' . $history->image)); ?>" 
                                            alt="<?php echo e($history->title); ?>" 
                                            loading="lazy">
                                    </div>
                                <?php endif; ?>
                                <div class="milestone-text">
                                    <p><?php echo e($history->description); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<style>
.progress-timeline {
    padding: 3rem 0;
    background-color: #f8fafc;
}

.timeline-header {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 4rem; /* Increased from 3rem */
    color: #1e3a8a;
    position: relative;
}

.timeline-header::after {
    content: '';
    display: block;
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #1d4ed8);
    margin: 1.5rem auto 0; /* Increased from 1rem */
    border-radius: 2px;
}

.timeline-progress {
    position: relative;
    max-width: 1000px;
    margin: 0 auto;
    padding-left: 40px;
}

.timeline-line {
    position: absolute;
    left: 20px;
    top: 20px; /* Added to create space below header */
    bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, #3b82f6, #1d4ed8);
    z-index: 1;
}

.milestone {
    position: relative;
    margin-bottom: 3.5rem; /* Increased bottom margin for more space between items */
    z-index: 2;
    padding-top: 10px; /* Added space above each milestone */
}

.milestone-marker {
    position: absolute;
    left: -50px; /* Increased the left space to create more space between dots */
    top: 15px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #1d4ed8;
    border: 4px solid #bfdbfe;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
}

.milestone-year {
    position: absolute;
    left: -110px; /* Increased space to the left of the year for more room */
    top: 10px;
    width: 60px;
    text-align: right;
    font-weight: 600;
    color: #1e3a8a;
    font-size: 0.95rem;
}

/* Rest of the CSS remains the same */
.milestone-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    margin-left: 30px;
    border-left: 3px solid #3b82f6;
}

.milestone-content h3 {
    font-size: 1.2rem;
    color: #1e3a8a;
    margin-top: 0;
    margin-bottom: 1rem;
}

.milestone-details {
    display: flex;
    gap: 1.5rem;
    align-items: flex-start;
}

.milestone-image {
    flex: 0 0 180px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

.milestone-image img {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.3s ease;
}

.milestone-image:hover img {
    transform: scale(1.03);
}

.milestone-text {
    flex: 1;
}

.milestone-text p {
    font-size: 0.95rem;
    line-height: 1.7;
    color: #4b5563;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .timeline-progress {
        padding-left: 30px;
    }
    
    .timeline-line {
        left: 15px;
        width: 3px;
        top: 15px; /* Adjusted for mobile */
    }
    
    .milestone-marker {
        left: -30px;
        width: 16px;
        height: 16px;
        top: 12px; /* Adjusted for mobile */
    }
    
    .milestone-year {
        left: -70px;
        width: 50px;
        top: 8px; /* Adjusted for mobile */
    }
    
    .milestone-details {
        flex-direction: column;
        gap: 1rem;
    }
    
    .milestone-image {
        flex: 0 0 auto;
        width: 100%;
        max-width: 250px;
        margin: 0 auto;
    }
}

@media (max-width: 576px) {
    .timeline-progress {
        padding-left: 20px;
    }
    
    .milestone-marker {
        left: -20px;
        top: 10px; /* Adjusted for small mobile */
    }
    
    .milestone-year {
        left: -50px;
        width: 40px;
        font-size: 0.85rem;
        top: 6px; /* Adjusted for small mobile */
    }
    
    .milestone-card {
        margin-left: 20px;
        padding: 1.2rem;
    }
    
    .milestone-content h3 {
        font-size: 1.1rem;
    }
    
    .milestone-text p {
        font-size: 0.9rem;
    }
}
</style>


        </div>
    </section>


<?php
use App\Models\web\Testimonial;
$testimonials = Testimonial::where('status', 1)->latest()->take(3)->get();
?>

<section class="testimonials-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">What People Say</h2>
            <div class="section-divider"></div>
        </div>
        
        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4">
                <div class="testimonial-card p-4 h-100">
                    <div class="rating mb-3">
                        <?php for($i = 0; $i < $testimonial->rating; $i++): ?>
                            <i class="bi bi-star-fill text-warning"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="mb-4">"<?php echo e($testimonial->content); ?>"</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="<?php echo e(asset('uploads/testimonial/' . ($testimonial->attach ?? 'assets/images/default-avatar.jpg'))); ?>" 
                                 class="rounded-circle" 
                                 width="150" 
                                 height="150"
                                 alt="<?php echo e($testimonial->name); ?>">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1"><?php echo e($testimonial->name); ?></h6>
                            <p class="text-muted mb-0"><?php echo e($testimonial->position); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center">
                <p>No testimonials available yet</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>


 - CTA Section -->
<section class="cta-section py-6 position-relative overflow-hidden" style="background: linear-gradient(135deg, #32519a 0%, #1e3a8a 100%);">
    <div class="position-absolute top-0 end-0 w-100 h-100 opacity-10">
        <div class="position-absolute end-0" style="width: 600px; height: 600px; background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%); transform: translate(30%, -30%);"></div>
    </div>
    
    <div class="container position-relative z-index-1">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0">
               <h3 class="display-5 fw-bold mb-3 text-white">Ready to Transform Your Future?</h3>
               <p class="lead mb-0 text-white text-opacity-80">Join our community of ambitious learners and take the first step toward your dream career</p>
               
               <div class="d-flex flex-wrap gap-3 mt-4">
                    <div class="d-flex align-items-center text-white">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>Simple 3-step application</span>
                    </div>
                    <div class="d-flex align-items-center text-white">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>No application fees</span>
                    </div>
                    <div class="d-flex align-items-center text-white">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>Quick response time</span>
                    </div>
                </div>
                <div class="mb-4"></div>
            </div>
            
            <div class="col-lg-4 text-lg-end">
                <a href="<?php echo e(route('application.index')); ?>" class="btn btn-light btn-lg px-4 py-3 fw-bold hover-lift">
                    Start Application
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
                <div class="mt-3 text-white text-opacity-60 small">
                    <i class="fas fa-lock me-1"></i> Secure application process
                </div>
            </div>
        </div>
    </div>
</section>


<style>
    .cta-section {
        border-radius: 0 0 1.5rem 1.5rem;
        box-shadow: 0 2rem 3rem rgba(0, 0, 0, 0.15);
    }
    .hover-lift {
        transition: all 0.3s ease;
        transform: translateY(0);
    }
    .hover-lift:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.5rem rgba(255, 255, 255, 0.15);
    }
    .text-white-80 {
        color: rgba(75, 71, 71, 0.8);
    }
    .text-white-60 {
        color: rgba(255, 255, 255, 0.6);
    }
    .z-index-1 {
        z-index: 1;
    }
</style>
<!-- After your CTA section -->
<div class="section-transition bg-white">
  <div class="wave-divider">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
      <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="#1e3a8a"></path>
      <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="#1e3a8a"></path>
      <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#fff"></path>
    </svg>
  </div>
  <div class="spacer" style="height: 6rem"></div>
</div>

<style>
  .section-transition {
    position: relative;
    margin-top: -1px; /* Connects seamlessly with CTA section */
  }
  
  .wave-divider {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    transform: rotate(180deg);
  }
  
  .wave-divider svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 100px;
  }
  
  .spacer {
    background: linear-gradient(
      to bottom, 
      rgba(255,255,255,1) 0%, 
      rgba(255,255,255,0.8) 50%, 
      rgba(255,255,255,0) 100%
    );
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .wave-divider svg {
      height: 60px;
    }
    .spacer {
      height: 4rem;
    }
  }
</style>
</main>


<style>
    /* Ensure all text is black */
    .text-dark, .lead, .text-muted, .timeline-content p, .message-content p, .feature-card span, .text-dark-blue {
        color: black !important; /* Set text color to black */
    }
</style>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Dapin-CMS/resources/views/web/about.blade.php ENDPATH**/ ?>