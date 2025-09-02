<?php if(count($testimonials) > 0): ?>
<section class="testimonial-area py-5 bg-light" id="testimonials" aria-labelledby="testimonial-heading" itemscope itemtype="https://schema.org/Review">
    <div class="container">
        <header class="text-center mb-5" data-aos="fade-up">
            <h2 id="testimonial-heading" class="fw-bold" itemprop="name">What Our Clients Say</h2>
            <p class="text-muted" itemprop="description">Hear from some of our satisfied students and partners about their learning experience with us.</p>
        </header>

        <div class="row justify-content-center">
            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="<?php echo e(100 * $key); ?>">
                    <article class="single-testimonial text-center px-4 py-4 shadow-sm bg-white rounded h-100"
                             data-toggle="modal" data-target="#testimonialModal<?php echo e($key); ?>" style="cursor: pointer;"
                             itemscope itemprop="review" itemtype="https://schema.org/Review">
                        <div class="quote-icon mb-3">
                            <img src="<?php echo e(asset('web/img/testimonial/qt-icon.png')); ?>" alt="Quote Icon" loading="lazy" width="40">
                        </div>
                        <p class="testimonial-text text-muted fst-italic" itemprop="reviewBody">
                            <?php echo e(Str::limit(strip_tags($testimonial->description), 100, '...')); ?>

                        </p>
                        <div class="testi-author mt-4" itemprop="author" itemscope itemtype="https://schema.org/Person">
                            <img src="<?php echo e(asset('uploads/testimonial/'.$testimonial->attach)); ?>"
                                 alt="Photo of <?php echo e($testimonial->name); ?>"
                                 class="rounded-circle mb-2"
                                 style="width: 70px; height: 70px; object-fit: cover;" loading="lazy" itemprop="image">
                            <h6 class="mb-0" itemprop="name"><?php echo e($testimonial->name); ?></h6>
                            <?php if($testimonial->designation): ?>
                                <small class="text-muted" itemprop="jobTitle"><?php echo e($testimonial->designation); ?></small>
                            <?php endif; ?>
                        </div>
                    </article>

                    <!-- Modal -->
                    <div class="modal fade" id="testimonialModal<?php echo e($key); ?>" tabindex="-1" aria-labelledby="testimonialModalLabel<?php echo e($key); ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="testimonialModalLabel<?php echo e($key); ?>"><?php echo e($testimonial->name); ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="<?php echo e(asset('uploads/testimonial/'.$testimonial->attach)); ?>"
                                         alt="Full testimonial image of <?php echo e($testimonial->name); ?>"
                                         class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                                    <p class="text-muted fst-italic"><?php echo e(strip_tags($testimonial->description)); ?></p>
                                    <?php if($testimonial->designation): ?>
                                        <p class="text-muted small"><strong><?php echo e($testimonial->designation); ?></strong></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>


<style>
    .single-testimonial:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }
</style>


<style>
    .single-testimonial {
        transition: all 0.3s ease;
        min-height: 350px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .single-testimonial:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .testimonial-text {
        font-size: 0.95rem;
        line-height: 1.6;
    }
</style>

<?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/web/testimonial.blade.php ENDPATH**/ ?>