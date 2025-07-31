<style>
  @import url('https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,500;0,600;0,700;0,800;1,500;1,600;1,700;1,800&display=swap');
  
  body, h1, h2, h3, h4, h5, h6, p, a, button, input, textarea, .course-title, .course-info, .fee {
    font-family: 'Jost', sans-serif !important;
  }
</style>



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
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">



<?php $__env->startSection('content'); ?>

    <!-- main-area -->
    <main>
       <?php echo $__env->make('web.slider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <?php echo $__env->make('web.features', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
  <?php echo $__env->make('web.abouthead', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <?php echo $__env->make('web.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <?php echo $__env->make('web.cot', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

      <?php echo $__env->make('web.coursehead', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php echo $__env->make('web.stats', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('web.newshead', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php echo $__env->make('web.exams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php echo $__env->make('web.testimonial', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php echo $__env->make('web.choose', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('web.enquiry', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

     
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



<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Dapin-CMS/resources/views/web/index.blade.php ENDPATH**/ ?>