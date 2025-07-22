
<style>
  .reason-card {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      border-top: 4px solid var(--primary-color);
      position: relative;
      z-index: 1;
      padding-top: 60px; /* leave room for icon */
      min-height: 350px;  /* 🟢 Reduced height */
  }

  .reason-icon {
      width: 52px;         /* smaller icon */
      height: 52px;
      background: var(--primary-color);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.6rem;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
      position: absolute;
      top: 16px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 2;
  }

  .reason-content {
      padding: 16px 20px;         /* 🟢 Reduced padding */
      margin-top: 32px;           /* 🟢 Gap between icon and text */
      text-align: center;
      flex-grow: 1;
  }

  .reason-title {
      font-size: 1.2rem;          /* 🟢 Slightly smaller */
      font-weight: 700;
      color: var(--primary-color);
      margin-bottom: 10px;
  }

  .reason-description {
      font-size: 0.95rem;         /* 🟢 Slightly smaller text */
      color: var(--text-dark);
      line-height: 1.5;
  }

  @media (max-width: 768px) {
      .reason-card {
          min-height: 320px;
      }
      .reason-title {
          font-size: 1.1rem;
      }
      .reason-description {
          font-size: 0.9rem;
      }
  }
</style>

<!-- Why Choose Us Section -->
<section class="choose-section" aria-labelledby="choose-heading">
    <div class="container">
        <div class="section-header">
            <h2 id="choose-heading">Why Choose Us?</h2>
            <p>A choice that makes the difference in your academic journey and future career</p>
        </div>
<?php
    // Fetching all the reasons from the 'reasons' table
    $reasons = \App\Models\Reason::all();
?>

     <div class="glide" id="reasonsCarousel">
    <div class="glide__track" data-glide-el="track">
        <ul class="glide__slides">
            <?php $__currentLoopData = $reasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="glide__slide">
                    <div class="reason-card">
                        <div class="reason-icon">
                            <i class="<?php echo e($reason['icon']); ?>"></i>
                        </div>
                        <div class="reason-content">
                            <h3 class="reason-title"><?php echo e($reason['title']); ?></h3>
                            <p class="reason-description"><?php echo e($reason['description']); ?></p>
                        </div>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <!-- Arrows -->
    <div class="glide__arrows text-center mt-4" data-glide-el="controls">
        <button class="glide__arrow glide__arrow--left me-2" data-glide-dir="<">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>
    </div>
</section>




<!-- Glide.js Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/glide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Glide('#reasonsCarousel', {
            type: 'carousel',
            perView: 3,
            gap: 24,
            autoplay: 4000,
            hoverpause: true,
            breakpoints: {
                1200: { perView: 2.5 },
                992: { perView: 2 },
                768: { perView: 1.5 },
                576: { perView: 1 }
            }
        }).mount();
    });
</script>
<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/choose.blade.php ENDPATH**/ ?>