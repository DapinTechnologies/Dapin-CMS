
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

        <div class="glide" id="reasonsCarousel">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    <!-- Reason 1 -->
                    <li class="glide__slide">
                        <div class="reason-card">
                            <div class="reason-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="reason-content">
                                <h3 class="reason-title">Academic Excellence</h3>
                                <p class="reason-description">Learn from distinguished faculty members who are leaders in their fields. Our innovative curriculum is designed to challenge and inspire you to reach your full potential.</p>
                            </div>
                        </div>
                    </li>

                    <!-- Reason 2 -->
                    <li class="glide__slide">
                        <div class="reason-card">
                            <div class="reason-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="reason-content">
                                <h3 class="reason-title">Career Success</h3>
                                <p class="reason-description">Our graduates are highly sought after by top employers. With career services starting in your first year, we prepare you for professional success from day one.</p>
                            </div>
                        </div>
                    </li>

                    <!-- Reason 3 -->
                    <li class="glide__slide">
                        <div class="reason-card">
                            <div class="reason-icon">
                                <i class="fas fa-globe-americas"></i>
                            </div>
                            <div class="reason-content">
                                <h3 class="reason-title">Global Reach</h3>
                                <p class="reason-description">Study abroad, engage in global projects, and experience different cultures. We prepare you to thrive in a connected, international world.</p>
                            </div>
                        </div>
                    </li>

                    <!-- Reason 4 -->
                    <li class="glide__slide">
                        <div class="reason-card">
                            <div class="reason-icon">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                            <div class="reason-content">
                                <h3 class="reason-title">Community Support</h3>
                                <p class="reason-description">From mentoring to mental health, we support your journey. Join a close-knit, inclusive environment where you belong and succeed.</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Arrows -->
            <div class="glide__arrows text-center mt-4" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left me-2" data-glide-dir="<"><i class="fas fa-chevron-left"></i></button>
                <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fas fa-chevron-right"></i></button>
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
