<div class="header-top second-header d-none d-md-flex align-items-center" style="background-color: #003366; padding: 0; margin-top: 0;">
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
                        <a href="tel:<?php echo e(str_replace(' ', '', $topbarSetting->phone)); ?>" style="color: #ffffff;"><?php echo e($topbarSetting->phone); ?></a>
                    </li>
                <?php endif; ?>

                <?php if(isset($topbarSetting->email)): ?>
                    <li class="me-3 d-flex align-items-center">
                        <img src="<?php echo e(asset('web/img/icon/mailing.png')); ?>" alt="Mail" class="icon-sm me-1">
                        <a href="mailto:<?php echo e($topbarSetting->email); ?>" style="color: #ffffff;"><?php echo e($topbarSetting->email); ?></a>
                    </li>
                <?php endif; ?>

                <!-- Portals -->
                <li class="me-3"><a href="<?php echo e(route('student.login')); ?>" style="color: #ffffff;">Student Portal</a></li>
                <li class="me-3"><a href="<?php echo e(route('login')); ?>" style="color: #ffffff;">Admin</a></li>
                <li class="me-3"><a href="#" style="color: #ffffff;">E-learning</a></li>
                <li><a href="<?php echo e(route('materialhome')); ?>" style="color: #ffffff;">Digital Library</a></li>
                <li><a href="<?php echo e(route('application.index')); ?>" style="color: #ffffff;">Apply</a></li>
                 <li><a href="" style="color: #ffffff;">E-Rourses</a></li>
            </ul>
        </div>

    </div>
</div>

<style>
   :root {
        --primary-color: #094b8d; /* Dark Blue */
        --secondary-color: #ff6b6b;
        --text-color: #ffffff;
        --icon-color: #ffffff;
    }

    .header-top {
        background-color: var(--primary-color);
        font-size: 0.8rem;
        margin-top: 0 !important; /* Ensure no margin at the top */
        padding: 0 !important; /* Remove any padding at the top */
        position: relative;
        z-index: 999; /* Ensure it is on top of any other content */
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
            padding: 0; /* Remove padding */
            font-size: 0.75rem;
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
            max-width: 850px !important;
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
    .header-top {
    transition: transform 0.3s ease-in-out;
}

</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let lastScrollTop = 0;
        const headerTop = document.querySelector(".header-top");

        window.addEventListener("scroll", function () {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop) {
                // Scrolling down
                headerTop.style.transform = "translateY(-100%)";
            } else {
                // Scrolling up
                headerTop.style.transform = "translateY(0)";
            }

            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // Avoid negative scroll
        });
    });
</script>
<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/layouts/nav.blade.php ENDPATH**/ ?>