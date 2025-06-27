<footer class="footer-modern text-white pt-5" style="background-color: #141b22; font-family: 'Jost', sans-serif;">
    <div class="container pb-4">
        <div class="row gy-4">

            <!-- Social Media -->
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="fw-bold mb-3" style="color: #ff7350;"><?php echo e(__('footer_socials')); ?></h5>
                <div class="d-flex gap-3 flex-wrap">
                    <?php if(isset($socialSetting->facebook)): ?>
                        <a href="<?php echo e($socialSetting->facebook); ?>" class="social-icon" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if(isset($socialSetting->instagram)): ?>
                        <a href="<?php echo e($socialSetting->instagram); ?>" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if(isset($socialSetting->twitter)): ?>
                        <a href="<?php echo e($socialSetting->twitter); ?>" class="social-icon" target="_blank"><i class="fab fa-twitter"></i></a>
                    <?php endif; ?>
                    <?php if(isset($socialSetting->linkedin)): ?>
                        <a href="<?php echo e($socialSetting->linkedin); ?>" class="social-icon" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    <?php endif; ?>
                    <?php if(isset($socialSetting->pinterest)): ?>
                        <a href="<?php echo e($socialSetting->pinterest); ?>" class="social-icon" target="_blank"><i class="fab fa-pinterest"></i></a>
                    <?php endif; ?>
                    <?php if(isset($socialSetting->youtube)): ?>
                        <a href="<?php echo e($socialSetting->youtube); ?>" class="social-icon" target="_blank"><i class="fab fa-youtube"></i></a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="fw-bold mb-3" style="color: #ff7350;"><?php echo e(__('footer_links')); ?></h5>
                <ul class="list-unstyled footer-links">
                    <?php if(Route::has('student.login')): ?>
                        <li><a href="<?php echo e(route('student.login')); ?>"><?php echo e(__('field_student')); ?> <?php echo e(__('field_login')); ?></a></li>
                    <?php endif; ?>
                    <?php if(Route::has('login')): ?>
                        <li><a href="<?php echo e(route('login')); ?>"><?php echo e(__('field_staff')); ?> <?php echo e(__('field_login')); ?></a></li>
                    <?php endif; ?>
                    <?php $application = App\Models\ApplicationSetting::status(); ?>
                    <?php if(isset($application)): ?>
                        <li><a href="<?php echo e(route('application.index')); ?>"><?php echo e(__('navbar_admission')); ?></a></li>
                    <?php endif; ?>
                    <?php $__currentLoopData = $footer_pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $footer_page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e(route('page.single', ['slug' => $footer_page->slug])); ?>"><?php echo e($footer_page->title); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

            <!-- Campus Area -->
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="fw-bold mb-3" style="color: #ff7350;">Quick Links</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Main Campus</a></li>
                    <li><a href="#">Nairobi Campus</a></li>
                    <li><a href="#">Library Resources</a></li>
                    <li><a href="#">eLearning Portal</a></li>
                    <li><a href="#">Latest News</a></li>
                    <li><a href="#">Research Updates</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="fw-bold mb-3" style="color: #ff7350;"><?php echo e(__('footer_contact')); ?></h5>
                <ul class="list-unstyled footer-contact">
                    <?php if(isset($topbarSetting->phone)): ?>
                        <li><i class="fas fa-phone me-2"></i><a href="tel:<?php echo e(str_replace(' ', '', $topbarSetting->phone)); ?>"><?php echo e($topbarSetting->phone); ?></a></li>
                    <?php endif; ?>
                    <?php if(isset($topbarSetting->email)): ?>
                        <li><i class="fas fa-envelope me-2"></i><a href="mailto:<?php echo e($topbarSetting->email); ?>"><?php echo e($topbarSetting->email); ?></a></li>
                    <?php endif; ?>
                    <?php if(isset($topbarSetting->address)): ?>
                        <li><i class="fas fa-map-marker-alt me-2"></i><?php echo e($topbarSetting->address); ?></li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>

    <div class="footer-bottom py-3 border-top border-secondary-subtle mt-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start">
            <div class="mb-2 mb-md-0">
                <?php if(isset($setting->copyright_text)): ?>
                    <small class="text-white-50">&copy; <?php echo strip_tags($setting->copyright_text, '<a><b><i><u><strong>'); ?></small>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>

<style>
    body {
        font-family: 'Jost', sans-serif;
    }

    .footer-links li,
    .footer-contact li {
        margin-bottom: 0.5rem;
    }

    .footer-links a,
    .footer-contact a {
        color: #fff;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-links a:hover,
    .footer-contact a:hover {
        color: #ff7350;
    }

    .social-icon {
        background-color: #1a5086;
        color: #fff;
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 0.85rem;
        transition: background 0.3s ease;
    }

    .social-icon:hover {
        background-color: #fff;
        color: #141b22;
    }

    .footer-bottom {
        background-color: #204162;
    }
</style>
<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/layouts/footer.blade.php ENDPATH**/ ?>