<!-- Top Header -->
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Top Header -->
<div class="header-top second-header d-none d-md-flex align-items-center">
    <div class="container-fluid d-flex justify-content-center align-items-center">
        <div class="header-cta w-100">
            <ul class="d-flex justify-content-between list-unstyled mb-0 align-items-center small-links w-100">

                <?php if(isset($topbarSetting->phone)): ?>
                    <li class="d-flex align-items-center">
                        <i class="fas fa-phone-alt me-1 icon-sm"></i>
                        <a href="tel:<?php echo e(str_replace(' ', '', $topbarSetting->phone)); ?>"><?php echo e($topbarSetting->phone); ?></a>
                    </li>
                <?php endif; ?>

                <?php if(isset($topbarSetting->email)): ?>
                    <li class="d-flex align-items-center">
                        <i class="fas fa-envelope me-1 icon-sm"></i>
                        <a href="mailto:<?php echo e($topbarSetting->email); ?>"><?php echo e($topbarSetting->email); ?></a>
                    </li>
                <?php endif; ?>

                <li class="d-flex align-items-center">
                    <i class="fas fa-user-graduate me-1 icon-sm"></i>
                    <a href="<?php echo e(route('student.login')); ?>">Student Portal</a>
                </li>
                <li class="d-flex align-items-center">
                    <i class="fas fa-user-tie me-1 icon-sm"></i>
                    <a href="<?php echo e(route('login')); ?>">Staff Portal</a>
                </li>
                <li class="d-flex align-items-center">
                    <i class="fas fa-laptop-code me-1 icon-sm"></i>
                    <a href="#">E-learning</a>
                </li>
                <li class="d-flex align-items-center">
                    <i class="fas fa-book-reader me-1 icon-sm"></i>
                    <a href="<?php echo e(route('materialhome')); ?>">Digital Library</a>
                </li>
                <li class="d-flex align-items-center">
                    <i class="fas fa-user-plus me-1 icon-sm"></i>
                    <a href="<?php echo e(route('application.index')); ?>">Join Now</a>
                </li>
                <li class="d-flex align-items-center">
                    <i class="fas fa-chalkboard-teacher me-1 icon-sm"></i>
                    <a href="#">E-Courses</a>
                </li>

            </ul>
        </div>
    </div>
</div>


<!-- Header Styling -->
<style>
    :root {
        --primary-color: #003366;
        --secondary-color: #ff6b6b;
        --text-color: #ffffff;
    }

    body {
        padding-top: 40px; /* Height of fixed header */
    }

    .header-top {
        background-color: var(--primary-color);
        color: var(--text-color);
        font-size: 0.72rem;
        padding: 6px 0;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1050;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    }

    .header-cta a {
        color: var(--text-color);
        font-size: 0.72rem;
        text-decoration: none;
    }

    .header-cta a:hover {
        color: var(--secondary-color);
    }

    .icon-sm {
        font-size: 0.75rem;
        color: var(--text-color);
    }

    .small-links {
        width: 100%;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .small-links li {
        display: flex;
        align-items: center;
        white-space: nowrap;
    }

    .container-fluid {
        max-width: 100%;
        padding: 0 20px;
    }

    @media (max-width: 991.98px) {
        .header-top {
            display: none;
        }
    }
</style>

<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/layouts/nav.blade.php ENDPATH**/ ?>