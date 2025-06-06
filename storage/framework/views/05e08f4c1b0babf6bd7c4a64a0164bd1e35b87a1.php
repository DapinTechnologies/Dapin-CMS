<?php $__env->startSection('title', __('navbar_home')); ?>

<?php $__env->startSection('social_meta_tags'); ?>
    <?php if(isset($setting)): ?>
    <meta property="og:type" content="website">
    <meta property='og:site_name' content="<?php echo e($setting->title); ?>"/>
    <meta property='og:title' content="<?php echo e($setting->title); ?>"/>
    <meta property='og:description' content="<?php echo str_limit(strip_tags($setting->meta_description), 160, ' ...'); ?>"/>
    <meta property='og:url' content="<?php echo e(route('home')); ?>"/>
    <meta property='og:image' content="<?php echo e(asset('/uploads/setting/'.$setting->logo_path)); ?>"/>


    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="<?php echo '@'.str_replace(' ', '', $setting->title); ?>" />
    <meta name="twitter:creator" content="@HiTechParks" />
    <meta name="twitter:url" content="<?php echo e(route('home')); ?>" />
    <meta name="twitter:title" content="<?php echo e($setting->title); ?>" />
    <meta name="twitter:description" content="<?php echo str_limit(strip_tags($setting->meta_description), 160, ' ...'); ?>" />
    <meta name="twitter:image" content="<?php echo e(asset('/uploads/setting/'.$setting->logo_path)); ?>" />
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
    /* General Styles */
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
    }

    .container {
        max-width: 1200px;
        margin: 10px auto;
        padding: 10px 15px;
    }

    h2 {
        text-align: center;
        color: #333;
        font-size: 24px;
        margin-bottom: 10px;
    }

    .pt-120, .pb-120 {
        padding-top: 30px !important;
        padding-bottom: 30px !important;
    }

    .courses-container, .news-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 10px;
        padding: 10px;
    }

    .course-card, .news-card {
        background: #ffffff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
        padding: 10px;
        transition: transform 0.2s ease-in-out;
        border-left: 4px solid #ff6600;
    }

    .course-card:hover, .news-card:hover {
        transform: translateY(-3px);
        background: #f6f6f6;
    }

    .course-title, .news-title {
        font-size: 16px;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 5px;
    }

    .course-info, .news-description {
        font-size: 13px;
        color: #555;
        margin-bottom: 5px;
    }

    .fee, .news-date {
        font-size: 14px;
        font-weight: bold;
        color: #28a745;
    }

    .director-image {
        width: 300px;
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
        display: block;
    }

    @media (max-width: 1024px) {
        .courses-container, .news-container {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .courses-container, .news-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 500px) {
        .courses-container, .news-container {
            grid-template-columns: repeat(1, 1fr);
        }
    }

    .about-area.about-p {
        padding-top: 20px !important;
        padding-bottom: 20px !important;
    }

    .about-content {
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }

    .director-image {
        width: 280px;
        height: 280px;
        object-fit: cover;
        margin-bottom: 10px !important;
    }

    .about-content h2,
    .about-content h5,
    .about-content p {
        margin-bottom: 8px !important;
    }

    .about-area .row {
        margin-bottom: 10px !important;
    }

    @media (max-width: 768px) {
        .about-area.about-p {
            padding-top: 15px !important;
            padding-bottom: 15px !important;
        }

        .about-content {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }
    }

    /* Director's Message Section */
    .director-message {
        background: white; /* Changed to white */
        color: #333; /* Dark text for contrast */
        padding: 20px 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .director-content {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        gap: 30px;
        max-width: 1200px;
        margin: auto;
        background: rgba(255, 255, 255, 0.9); /* Slightly transparent white */
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    .director-image img {
        width: 500px;
        height: 280px;
        object-fit: cover;
        border-radius: 50%;
        box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        border: 4px solid #ff6600;
    }

    .director-text {
        max-width: 500px;
    }

    .director-text h5 {
        font-size: 1.2em;
        margin-bottom: 8px;
        color: #333; /* Dark text for contrast */
    }

    .director-text h2 {
        font-size: 2em;
        margin-bottom: 8px;
        color: #333; /* Dark text for contrast */
    }

    .director-text p {
        font-size: 1.1em;
        line-height: 1.6em;
        margin-bottom: 8px;
        color: #555; /* Slightly lighter text */
    }

    @media (max-width: 768px) {
        .director-content {
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }
    }

    /* Statistics Section */
    .statistics-area {
        background: #f8f9fa;
        padding: 40px 0;
    }

    .statistic-card {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
        transition: transform 0.3s ease-in-out;
    }

    .statistic-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .statistic-icon {
        font-size: 40px;
        color: #ff6600;
        margin-bottom: 15px;
    }

    .statistic-number {
        font-size: 36px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .statistic-label {
        font-size: 18px;
        color: #555;
        margin-bottom: 0;
    }

    @keyframes countUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .statistic-number {
        animation: countUp 1s ease-in-out;
    }

    /* News Section */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .news-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .news-content {
        padding: 20px;
    }

    .news-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    .news-description {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .news-date {
        font-size: 12px;
        color: #888;
        display: flex;
        align-items: center;
    }

    .news-date i {
        margin-right: 5px;
    }

    .news-read-more {
        display: block;
        text-align: center;
        padding: 10px;
        background: #007bff;
        color: #fff;
        text-decoration: none;
        font-size: 14px;
        transition: background 0.3s ease;
    }

    .news-read-more:hover {
        background: #0056b3;
    }

    .news-read-more i {
        margin-left: 5px;
    }
</style>


<?php $__env->startSection('content'); ?>

    <!-- main-area -->
    <main>
        <!-- slider-area -->
        <section id="home" class="slider-area fix p-relative">
           
            <div class="slider-active" style="background: #141b22;">

                <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="single-slider slider-bg" style="background-image: url(<?php echo e(asset('uploads/slider/'.$slider->attach)); ?>); background-size: cover;">
                    <div class="overlay"></div>
                    <div class="container">
                       <div class="row">
                            <div class="col-lg-7 col-md-7">
                                <div class="slider-content s-slider-content mt-130">
                                    <h2 data-animation="fadeInUp" data-delay=".4s"><?php echo e($slider->title); ?></h2>
                                    <p data-animation="fadeInUp" data-delay=".6s"><?php echo strip_tags($slider->sub_title, '<b><u><i><br>'); ?></p>
                                    
                                    <?php if(isset($slider->button_link)): ?>
                                    <div class="slider-btn mt-30">     
                                        <a href="<?php echo e($slider->button_link); ?>" target="_blank" class="btn ss-btn mr-15" data-animation="fadeInLeft" data-delay=".4s"><?php echo e($slider->button_text); ?> <i class="fal fa-long-arrow-right"></i></a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 p-relative">
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </section>
        <!-- slider-area-end -->


        <?php if(count($features) > 0): ?>
        <!-- service-area -->
        <section class="service-details-two p-relative">
            <div class="container">
                <div class="row">
                  
                    <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="services-box07 <?php if($key == 1): ?> active <?php endif; ?>">
                            <div class="sr-contner">
                                <div class="icon">
                                    <img src="<?php echo e(asset('web/img/icon/sve-icon4.png')); ?>" alt="icon">
                                </div>
                                <div class="text">
                                    <h5><?php echo e($feature->title); ?></h5>
                                    <p><?php echo $feature->description; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 
                </div>
            </div>
        </section>
        <!-- service-area-end -->
        <?php endif; ?>
        


        
      


        <?php if(isset($about)): ?>
        <!-- about-area -->
        <section class="about-area about-p pt-120 pb-120 p-relative fix" style="background: #eff7ff;">
            <div class="animations-02"><img src="<?php echo e(asset('web/img/bg/an-img-02.png')); ?>" alt="About"></div>
            <div class="container">
                <div class="row justify-content-center align-items-center">

                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="s-about-img p-relative wow fadeInLeft animated" data-animation="fadeInLeft" data-delay=".4s">
                            <img src="<?php echo e(asset('uploads/about-us/'.$about->attach)); ?>" alt="img">
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="about-content s-about-content pl-15 wow fadeInRight animated" data-animation="fadeInRight" data-delay=".4s">
                            <div class="about-title second-title pb-25">  
                                <h5><i class="fal fa-graduation-cap"></i> <?php echo e($about->label); ?></h5>
                                <h2><?php echo e($about->title); ?></h2>
                            </div>

                            <?php echo strip_tags($about->description, '<a><b><i><u><strong>'); ?>


                            <div class="about-content2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="green2">
                                            <?php if(isset($about->mission_title)): ?>
                                            <li>
                                                <div class="abcontent">
                                                    <div class="text">
                                                        <h3><?php echo e($about->mission_title); ?></h3>
                                                        <p><?php echo strip_tags($about->mission_desc, '<a><b><i><u><strong>'); ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endif; ?>
                                            <?php if(isset($about->vision_title)): ?>
                                            <li>
                                                <div class="abcontent">
                                                    <div class="text">
                                                        <h3><?php echo e($about->vision_title); ?></h3>
                                                        <p><?php echo strip_tags($about->vision_desc, '<a><b><i><u><strong>'); ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 
                </div>
            </div>
        </section>
        <!-- about-area-end -->
        <?php endif; ?>




<section class="director-message">
    <div class="container">
        <?php $director = \App\Models\Director::first(); ?>

        <?php if($director): ?>
        <div class="director-content">
            <!-- Director's Image -->
            <div class="director-image">
                <img src="<?php echo e(url($director->image)); ?>" alt="Director Image">

              

                
                
            </div>

            <!-- Director's Message -->
            <div class="director-text">
                <h5><i class="fal fa-user-tie"></i> Message from the Director</h5>
                <h2><?php echo e($director->title); ?></h2>
                <p><?php echo e($director->message); ?></p>
                <h3><?php echo e($director->name); ?></h3>
                <p><i>Director</i></p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>




        <?php if(isset($callToAction)): ?>
        <!-- cta-area -->
        <section class="cta-area cta-bg pt-50 pb-50" style="background-color: #125875;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="section-title cta-title wow fadeInLeft animated" data-animation="fadeInDown animated" data-delay=".2s">
                            <h2><?php echo e($callToAction->title); ?></h2>
                            <p><?php echo e($callToAction->sub_title); ?></p>
                        </div>
                                         
                    </div>
                    <div class="col-lg-4 text-right"> 
                        <div class="cta-btn s-cta-btn wow fadeInRight animated mt-30" data-animation="fadeInDown animated" data-delay=".2s">
                            <?php if(isset($callToAction->button_link)): ?>
                            <a href="<?php echo e($callToAction->button_link); ?>" target="_blank" class="btn ss-btn smoth-scroll"><?php echo e($callToAction->button_text); ?> <i class="fal fa-long-arrow-right"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                
                </div>
            </div>
        </section>
        <!-- cta-area-end -->
        <?php endif; ?>




<!-- Course Area -->
<div class="container">
    <h2 class="text-center">Available Courses</h2>

    <?php
        use App\Models\Course;
        $courses = Course::where('status', 1)->orderBy('faculty')->get();
    ?>

    <div class="courses-slider">
        <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="course-card">

                <a href="<?php echo e(route('course.single', ['slug' => $course->slug])); ?>">

                <div class="course-title"><?php echo e($course->title); ?></div>
                <div class="course-info">
                    <strong>Department:</strong> <?php echo e($course->faculty); ?><br>
                    <strong>Duration:</strong> <?php echo e($course->duration); ?>

                </div>
                <div class="fee">Fee: KSH <?php echo e(number_format($course->fee, 2)); ?></div>
            </a>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center text-muted">No courses available at the moment.</p>
        <?php endif; ?>
    </div>
</div>





<!-- Statistics Section -->
<section class="statistics-area pt-60 pb-60" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section-title text-center wow fadeInUp animated" data-animation="fadeInUp" data-delay=".2s">
                    <h2>Our Achievements</h2>
                    <p>Here are some key statistics about our institution.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <!-- Students Statistic -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="statistic-card wow fadeInLeft animated" data-animation="fadeInLeft" data-delay=".4s">
                    <div class="statistic-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="statistic-content">
                        <h3 class="statistic-number" data-count="5000">0</h3>
                        <p class="statistic-label">Students</p>
                    </div>
                </div>
            </div>

            <!-- Departments Statistic -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="statistic-card wow fadeInLeft animated" data-animation="fadeInLeft" data-delay=".6s">
                    <div class="statistic-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="statistic-content">
                        <h3 class="statistic-number" data-count="10">0</h3>
                        <p class="statistic-label">Departments</p>
                    </div>
                </div>
            </div>


            <!-- Courses Statistic -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="statistic-card wow fadeInRight animated" data-animation="fadeInRight" data-delay=".4s">
                    <div class="statistic-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="statistic-content">
                        <h3 class="statistic-number" data-count="50">0</h3>
                        <p class="statistic-label">Courses</p>
                    </div>
                </div>
            </div>

            <!-- Lecturers Statistic -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="statistic-card wow fadeInRight animated" data-animation="fadeInRight" data-delay=".6s">
                    <div class="statistic-icon">
                        <i class="fa-solid fa-chalkboard-user"></i> 
                    </div>
                    <div class="statistic-content">
                        <h3 class="statistic-number" data-count="200">0</h3>
                        <p class="statistic-label">Lecturers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Statistics Section End -->
    

<div class="container">
    <h2 class="text-center mb-4"> News & Media</h2>

    <?php
        use App\Models\News;
        $newsItems = News::where('status', 1)->orderBy('date', 'desc')->get();
    ?>

    <div class="news-grid">
        <?php $__empty_1 = true; $__currentLoopData = $newsItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="news-card">
                <div class="news-content">
                    <h3 class="news-title"><?php echo e($news->title); ?></h3>
                    <p class="news-description">
                        <?php echo e(Str::limit(strip_tags($news->description), 150, '...')); ?>

                    </p>
                    <div class="news-date">
                        <i class="fas fa-calendar-alt"></i> <?php echo e(\Carbon\Carbon::parse($news->date)->format('M d, Y')); ?>

                    </div>
                </div>
                <a href="<?php echo e(route('news.single', ['id' => $news->id, 'slug' => $news->slug])); ?>" class="news-read-more">Read More <i class="fas fa-arrow-right"></i></a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center text-muted">No news articles available at the moment.</p>
        <?php endif; ?>
    </div>
</div>



<!-- Custom CSS for Modern News Section -->
<style>
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
    }
    .news-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    .news-content {
        padding: 20px;
    }
    .news-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }
    .news-description {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 15px;
    }
    .news-date {
        font-size: 12px;
        color: #888;
        display: flex;
        align-items: center;
    }
    .news-date i {
        margin-right: 5px;
    }
    .news-read-more {
        display: block;
        text-align: center;
        padding: 10px;
        background: #007bff;
        color: #fff;
        text-decoration: none;
        font-size: 14px;
        transition: background 0.3s ease;
    }
    .news-read-more:hover {
        background: #0056b3;
    }
    .news-read-more i {
        margin-left: 5px;
    }
</style>


        <?php if(count($testimonials) > 0): ?>
        <!-- testimonial-area -->
        <section class="testimonial-area pt-120 pb-115 p-relative fix">
            <div class="container">
                <div class="row">
                    
                    <div class="col-lg-12">
                        <div class="testimonial-active wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">

                            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="single-testimonial text-center">
                                <div class="qt-img">
                                    <img src="<?php echo e(asset('web/img/testimonial/qt-icon.png')); ?>" alt="img">
                                </div>
                                <p><?php echo e(Str::limit(strip_tags($testimonial->description), 100, '...')); ?></p>
                                <div class="testi-author">
                                    <img src="<?php echo e(asset('uploads/testimonial/'.$testimonial->attach)); ?>" alt="img">
                                </div>
                                <div class="ta-info">
                                    <h6><?php echo e($testimonial->name); ?></h6>
                                    <span><?php echo e($testimonial->designation ?? ''); ?></span>
                                </div>                                    
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- testimonial-area-end -->
        <?php endif; ?>
     
    </main>
    <!-- main-area-end -->


<script>


document.addEventListener("DOMContentLoaded", function () {
    const statisticNumbers = document.querySelectorAll(".statistic-number");

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const count = parseInt(target.getAttribute("data-count"), 10);
                let current = 0;
                const increment = Math.ceil(count / 100);

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= count) {
                        clearInterval(timer);
                        current = count;
                    }
                    target.textContent = current;
                }, 20);
                observer.unobserve(target);
            }
        });
    });

    statisticNumbers.forEach((number) => {
        observer.observe(number);
    });
});


</script>



<!-- Include jQuery and Slick Carousel JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
    $(document).ready(function(){
        $('.courses-slider').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 4, // Show 4 slides at a time
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    });
</script>

<style>
/* General Styles */

/* Course Card */
.course-card {
    background: #ffffff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
    padding: 6px; /* Reduced padding */
    transition: transform 0.2s ease-in-out;
    border-left: 4px solid #ff6600;
    text-align: center;
    margin: 0 10px;
    max-height: 180px; /* Set max height to limit size */
    overflow: hidden; /* Prevent content overflow */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Reduce font sizes */
.course-title {
    font-size: 14px; /* Smaller title */
    font-weight: bold;
    color: #007bff;
    margin-bottom: 4px;
}

.course-info {
    font-size: 12px; /* Smaller text */
    color: #555;
    margin-bottom: 4px;
}

/* Fee Text */
.fee {
    font-size: 13px; /* Smaller text */
    font-weight: bold;
    color: #28a745;
}




</style>


<!-- Statistics Section -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\web\index.blade.php ENDPATH**/ ?>