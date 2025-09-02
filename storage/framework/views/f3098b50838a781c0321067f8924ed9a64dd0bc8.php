<div class="header-top second-header d-none d-md-flex align-items-center" style="background-color: var(--primary-color); padding: 5px 0;">
    <div class="container-fluid d-flex justify-content-between align-items-center" style="max-width: 900px; padding: 0 15px;">

        <!-- Social Media Icons (Far Left) -->
        <div class="header-social d-flex align-items-center me-auto">
            <?php if(isset($topbarSetting) && $topbarSetting->social_status == 1): ?>
                <?php $__currentLoopData = ['facebook', 'instagram', 'twitter', 'linkedin']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(isset($socialSetting->$social)): ?>
                        <a href="<?php echo e($socialSetting->$social); ?>" target="_blank" class="social-icon me-2">
                            <i class="fab fa-<?php echo e($social); ?>"></i>
                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>

        <!-- Contact and Portal Links (Right) -->
        <div class="header-cta d-flex align-items-center">
            <ul class="d-flex list-unstyled mb-0 align-items-center small-links">

                <?php if(isset($topbarSetting->phone)): ?>
                    <li class="me-3 d-flex align-items-center">
                        <img src="<?php echo e(asset('web/img/icon/phone-call.png')); ?>" alt="Phone" class="icon-sm me-1">
                        <a href="tel:<?php echo e(str_replace(' ', '', $topbarSetting->phone)); ?>"><?php echo e($topbarSetting->phone); ?></a>
                    </li>
                <?php endif; ?>

                <?php if(isset($topbarSetting->email)): ?>
                    <li class="me-3 d-flex align-items-center">
                        <img src="<?php echo e(asset('web/img/icon/mailing.png')); ?>" alt="Mail" class="icon-sm me-1">
                        <a href="mailto:<?php echo e($topbarSetting->email); ?>"><?php echo e($topbarSetting->email); ?></a>
                    </li>
                <?php endif; ?>

                <!-- Portals -->
                <li class="me-3"><a href="<?php echo e(route('student.login')); ?>">Student Portal</a></li>
                <li class="me-3"><a href="<?php echo e(route('login')); ?>">Admin Portal</a></li>
                <li class="me-3"><a href="#">E-learning</a></li>
                <li><a href="<?php echo e(route('materialhome')); ?>">Digital Library</a></li>
            </ul>
        </div>

    </div>
</div>


<style>

   :root {
    --primary-color: #24556a;
    --secondary-color: #ff6b6b;
    --text-color: #ffffff;
    --icon-color: #ffffff;
}

.header-top {
    background-color: var(--primary-color);
    font-size: 0.8rem;
}

.header-social .social-icon {
    font-size: 0.85rem;
    color: var(--icon-color);
}

.header-social .social-icon:hover {
    color: var(--secondary-color);
}

.header-cta a {
    color: var(--text-color);
    font-size: 0.75rem;
    text-decoration: none;
}

.header-cta a:hover {
    color: var(--secondary-color);
}

.icon-sm {
    width: 16px;
    height: 16px;
    filter: invert(100%);
}

.small-links li {
    font-size: 0.75rem;
}
@media (min-width: 768px) {
    .header-top {
        padding: 3px 0; /* Reduce vertical space */
        font-size: 0.75rem; /* Slightly smaller font */
    }

    .header-cta a,
    .small-links li {
        font-size: 0.72rem;
    }

    .header-social .social-icon {
        font-size: 0.75rem;
    }

    .icon-sm {
        width: 14px;
        height: 14px;
    }

    .container-fluid {
        max-width: 850px !important; /* Optional: slightly narrower container */
        padding: 0 10px !important;
    }

    .header-cta ul {
        gap: 10px;
    }
}
.navbar {
    padding-top: 0.2rem;
    padding-bottom: 0.4rem;
}

</style><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/web/layouts/nav.blade.php ENDPATH**/ ?>