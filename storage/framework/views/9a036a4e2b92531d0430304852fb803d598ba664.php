<?php $__env->startSection('title', __('Admission Process')); ?>

<?php $__env->startPush('styles'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<style>
    :root {
        --primary: #4361ee;
        --secondary: #3f37c9;
        --accent: #f72585;
        --light: #f8f9fa;
        --dark: #212529;
        --success: #4cc9f0;
        --warning: #f8961e;
        --info: #4895ef;
        --primary-soft: rgba(67, 97, 238, 0.1);
        --success-soft: rgba(76, 201, 240, 0.1);
        --warning-soft: rgba(248, 150, 30, 0.1);
        --info-soft: rgba(72, 149, 239, 0.1);
        --danger-soft: rgba(220, 53, 69, 0.1);
    }
    
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        line-height: 1.6;
        color: var(--dark);
        scroll-behavior: smooth;
    }
    
    .hero-section {
        background: linear-gradient(135deg, var(--secondary), var(--primary));
        color: white;
        padding: 6rem 0 5rem;
        position: relative;
        overflow: hidden;
        clip-path: ellipse(100% 100% at 50% 0%);
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        bottom: -50px;
        left: 0;
        right: 0;
        height: 100px;
        background: url("data:image/svg+xml,%3Csvg viewBox='0 0 1200 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0,0V7.23C0,65,120,120,240,120S480,65,600,7.23C720-50,840-50,960,7.23S1080,65,1200,7.23V0Z' fill='white'/%3E%3C/svg%3E") center bottom/cover no-repeat;
    }
    
    .process-step {
        position: relative;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        border-radius: 16px;
        background-color: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
        border: 1px solid rgba(0,0,0,0.03);
        height: 100%;
    }
    
    .process-step:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    
    .step-number {
        position: absolute;
        top: -25px;
        left: 25px;
        width: 60px;
        height: 60px;
        background: linear-gradient(45deg, var(--accent), #ff7096);
        color: white;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.8rem;
        box-shadow: 0 10px 20px rgba(247, 37, 133, 0.3);
    }
    
    .course-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
        margin-bottom: 2rem;
        height: 100%;
    }
    
    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    
    .course-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 1.75rem;
        position: relative;
        overflow: hidden;
    }
    
    .course-header::after {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .mode-badge {
        font-size: 0.8rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        display: inline-flex;
        align-items: center;
        font-weight: 500;
    }
    
    .mode-badge i {
        margin-right: 5px;
        font-size: 0.7rem;
    }
    
    .requirement-list {
        list-style-type: none;
        padding-left: 0;
    }
    
    .requirement-list li {
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
    }
    
    .requirement-list li:last-child {
        border-bottom: none;
    }
    
    .requirement-list li i {
        margin-right: 12px;
        color: var(--primary);
        background: rgba(67, 97, 238, 0.1);
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .cta-section {
        background: linear-gradient(135deg, var(--secondary), var(--primary));
        color: white;
        padding: 5rem 0;
        position: relative;
        overflow: hidden;
    }
    
    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .btn-light {
        background-color: white;
        color: var(--primary);
        font-weight: 600;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        transition: all 0.3s ease;
    }
    
    .btn-light:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .btn-outline-light {
        border-width: 2px;
        font-weight: 600;
        border-radius: 50px;
        padding: calc(0.75rem - 2px) 2rem;
    }
    
    .breadcrumb-area {
        background: linear-gradient(135deg, var(--secondary), var(--primary));
        padding: 3rem 0;
        color: white;
    }
    
    .breadcrumb-title h2 {
        font-weight: 700;
        font-size: 2.5rem;
    }

    /* Improved grades area styling */
    .grades-container {
        background-color: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .grade-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .grade-item:last-child {
        border-bottom: none;
    }

    .grade-icon {
        margin-right: 12px;
        color: var(--primary);
        background: rgba(67, 97, 238, 0.1);
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .grade-text {
        color: #495057;
        font-weight: 500;
    }

    .course-body {
        padding: 1.75rem;
        background-color: white;
    }

    .section-title {
        color: var(--primary);
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    @media (max-width: 768px) {
        .hero-section {
            padding: 4rem 0 3rem;
            clip-path: ellipse(150% 100% at 50% 0%);
        }
        
        .process-step {
            padding: 2rem 1.5rem;
        }
        
        .step-number {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
            top: -20px;
        }
        
        .breadcrumb-title h2 {
            font-size: 2rem;
        }

        .course-body {
            padding: 1.25rem;
        }
    }

    .modern-heading {
    font-size: 2.2rem; /* Larger font size */
    font-weight: 700;  /* Bold text */
    letter-spacing: 1px; /* Slight spacing between letters */
    text-transform: uppercase; /* All uppercase letters */
    color: #1c1c1c; /* Darker text color */
    text-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); /* Light shadow for emphasis */
    transition: color 0.3s ease-in-out;
}

.modern-heading:hover {
    color: var(--primary); /* Change color on hover */
    text-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* Darker shadow on hover */
}

</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- breadcrumb-area -->
<section class="breadcrumb-area d-flex align-items-center p-relative">
  
</section>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-4 fw-bold mb-4">Begin Your Educational Journey</h1>
                <p class="lead mb-4">Join our vibrant community of learners and start shaping your future today with our simple admission process.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#application-process" class="btn btn-light btn-lg hover-lift">
                        <i class="fas fa-list-check me-2"></i> Admission Process
                    </a>
                    <a href="#courses" class="btn btn-outline-light btn-lg hover-lift">
                        <i class="fas fa-graduation-cap me-2"></i> Our Courses
                    </a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block" data-aos="fade-left">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                         alt="Students studying" 
                         class="img-fluid rounded-4 shadow-lg"
                         style="border: 8px solid rgba(255,255,255,0.2);">
                    <div class="position-absolute bottom-0 start-0 bg-white p-3 rounded-3 shadow-sm" style="transform: translate(-20%, 20%);">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">2500+</h5>
                                <small class="text-muted">Happy Students</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Admission Process -->
<section id="application-process" class="py-6">
    <div class="container">
        <div class="text-center mb-6" data-aos="fade-up">
            <span class="badge bg-primary-soft text-primary mb-3">How to Apply</span>
            <h2 class="fw-bold">Admission Process</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">Follow these simple steps to join our institution and begin your journey to success</p>
        </div>

        <div class="row g-4">
            <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo e(($index + 1) * 100); ?>">
                    <div class="process-step">
                        <div class="step-number"><?php echo e($index + 1); ?></div>
                        <h3 class="h4"><?php echo e($step->title); ?></h3>
                        <p class="text-muted"><?php echo e($step->description); ?></p>

                        <?php if($step->requirements): ?>
                           <ul class="requirement-list mt-3">
    <?php $__currentLoopData = json_decode($step->requirements); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requirement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li style="color: #212529;"> <i class="fas fa-check"></i> <?php echo e($requirement); ?></li>  <!-- Added dark color -->
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>

                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<!-- CTA Section -->
<section class="cta-section py-6 position-relative overflow-hidden" style="background: linear-gradient(135deg, #32519a 0%, #1e3a8a 100%);">
    <div class="position-absolute top-0 end-0 w-100 h-100 opacity-10">
        <div class="position-absolute end-0" style="width: 600px; height: 600px; background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%); transform: translate(30%, -30%);"></div>
    </div>
    
    <div class="container position-relative z-index-1">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0">
               <h3 class="display-5 fw-bold mb-3 text-white">Ready to Transform Your Future?</h3>
               <p class="lead mb-0 text-white-80">Join our community of ambitious learners and take the first step toward your dream career</p>
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
            </div>
            
            <div class="col-lg-4 text-lg-end">
                <a href="<?php echo e(route('application.index')); ?>" class="btn btn-light btn-lg px-4 py-3 fw-bold hover-lift">
                    Start Application
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
                <div class="mt-3 text-white-60 small">
                    <i class="fas fa-shield-alt me-1"></i> Secure application process
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Transition -->
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Dapin-CMS/resources/views/web/admission_process.blade.php ENDPATH**/ ?>