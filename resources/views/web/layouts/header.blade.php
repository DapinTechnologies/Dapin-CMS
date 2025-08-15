<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/your-code.js" crossorigin="anonymous"></script>

<!-- HEADER WRAPPER -->
<div id="header-wrapper">

    <!-- TOP HEADER BAR (Desktop only) -->
    <div class="header-top d-none d-md-flex align-items-center" id="topbar">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <ul class="d-flex list-unstyled mb-0 align-items-center small-links w-100 justify-content-evenly text-white">
                @isset($topbarSetting->phone)
                    <li><i class="fas fa-phone-alt me-1"></i><a href="tel:{{ str_replace(' ', '', $topbarSetting->phone) }}">{{ $topbarSetting->phone }}</a></li>
                @endisset
                @isset($topbarSetting->email)
                    <li><i class="fas fa-envelope me-1"></i><a href="mailto:{{ $topbarSetting->email }}">{{ $topbarSetting->email }}</a></li>
                @endisset
                <li><i class="fas fa-user-graduate me-1"></i><a href="{{ route('student.login') }}">Student Portal</a></li>
                <li><i class="fas fa-user-tie me-1"></i><a href="{{ route('login') }}">Staff Portal</a></li>
                <li><i class="fas fa-book-reader me-1"></i><a href="#">E-learning</a></li>
                <li><i class="fas fa-book me-1"></i><a href="{{ route('materialhome') }}">Digital Library</a></li>
                <li><i class="fas fa-user-plus me-1"></i><a href="{{ route('application.index') }}">Join Now</a></li>
                <li><i class="fas fa-chalkboard-teacher me-1"></i><a href="#">E-Courses</a></li>
            </ul>
        </div>
    </div>

    @if(session('toastr'))
    <script>
        toastr.{{ session('toastr')['type'] }}(
            "{{ session('toastr')['message'] }}",
            "{{ session('toastr')['title'] }}"
        );
    </script>
@endif
    <!-- MAIN HEADER -->
    <header class="header-area header-three" id="main-header">
        <div class="menu-area">
            <div class="container">
                <div class="second-menu">
                    <div class="row align-items-center py-2">

                        <!-- Logo -->
                        <div class="col-6 col-lg-3 d-flex align-items-center">
                            @if(isset($setting))
                                <div class="logo" style="max-height: 50px; overflow: hidden;">
                                    <a href="{{ route('home') }}">
                                        <img src="{{ asset('/uploads/setting/'.$setting->logo_path) }}" alt="logo" style="max-height: 40px; width: auto;">
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Mobile Menu Button -->
                        <div class="col-6 d-lg-none text-end">
                            <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
                                <i class="fas fa-bars fa-lg text-dark"></i>
                            </button>
                        </div>

                        <!-- Desktop Menu -->
                        <div class="col-lg-9 d-none d-lg-block">
                            <div class="main-menu text-end">
                                <nav>
                                    <ul class="mb-0 d-flex justify-content-end list-unstyled">
                                        <li class="{{ Request::path() == '/' ? 'current' : '' }}"><a href="{{ route('home') }}">{{ __('navbar_home') }}</a></li>
                                        <li class="{{ Request::is('course*') ? 'current' : '' }}"><a href="{{ route('course') }}">{{ __('navbar_course') }}</a></li>
<li class="{{ Request::is('web/admission*') ? 'current' : '' }}">
    <a href="{{ url('admission') }}">Admission</a>
</li>
                                        
                                        <li class="{{ Request::is('event*') ? 'current' : '' }}"><a href="{{ route('event') }}">{{ __('navbar_event') }}</a></li>
                                        <li class="{{ Request::is('faq*') ? 'current' : '' }}"><a href="{{ route('faq') }}">{{ __('navbar_faqs') }}</a></li>
                                        <li class="{{ Request::is('gallery*') ? 'current' : '' }}"><a href="{{ route('gallery') }}">{{ __('navbar_gallery') }}</a></li>
                                        <li class="{{ Request::is('news*') ? 'current' : '' }}"><a href="{{ route('news') }}">{{ __('navbar_news') }}</a></li>
                                        <li class="{{ Request::is('about*') ? 'current' : '' }}"><a href="{{ route('aboutus') }}">{{ __('About Us') }}</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>

<!-- Mobile Menu Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
    <!-- Offcanvas Header with Close Button -->
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="mobileMenuLabel">Menu</h5>
        <!-- Close Button -->
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">{{ __('navbar_home') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('course') }}">{{ __('navbar_course') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('event') }}">{{ __('navbar_event') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('faq') }}">{{ __('navbar_faqs') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('gallery') }}">{{ __('navbar_gallery') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('news') }}">{{ __('navbar_news') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('aboutus') }}">{{ __('About Us') }}</a></li>
        </ul>
        
        <!-- Mobile Quick Links -->
        <div class="mt-4">
            <h6 class="text-muted mb-3">Quick Links</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('student.login') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-user-graduate me-2"></i>Student Portal</a>
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-user-tie me-2"></i>Staff Portal</a>
                <a href="{{ route('application.index') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-user-plus me-2"></i>Join Now</a>
            </div>
        </div>
    </div>
</div>

<!-- STYLES -->
<style>
    body {
        padding-top: 90px;
    }

    /* Top Header */
    .header-top {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1049;
        background-color: #003366;
        color: white;
        font-size: 0.72rem;
        padding: 2px 0;
        height: 24px;
    }

    .header-top a {
        color: #ffffff;
        text-decoration: none;
        font-size: 0.72rem;
        transition: all 0.2s ease;
    }

    .header-top a:hover {
        color: #a7c4ff;
    }

    /* Main Header */
    .header-area {
        position: fixed;
        top: 24px;
        width: 100%;
        z-index: 1050;
        background-color: #ffffff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    /* Desktop Menu */
    .main-menu ul li {
        margin: 0 10px;
    }

    .main-menu ul li a {
        padding: 10px 0;
        display: inline-block;
        text-transform: uppercase;
        color: #333;
        font-size: 14px;
        text-decoration: none;
        position: relative;
    }

    .main-menu ul li a:after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 0;
        width: 0;
        height: 2px;
        background-color: #4361ee;
        transition: width 0.3s ease;
    }

    .main-menu ul li a:hover:after,
    .main-menu ul li.current a:after {
        width: 100%;
    }

    .main-menu ul li a:hover,
    .main-menu ul li.current a {
        color: #4361ee;
        font-weight: 500;
    }

    /* Mobile Menu */
    .offcanvas {
        max-width: 280px;
    }

    .navbar-toggler {
        font-size: 1.25rem;
        background: none;
    }

    .nav-link {
        padding: 12px 0;
        border-bottom: 1px solid #f1f1f1;
        font-weight: 500;
    }

    .nav-link:hover {
        color: #4361ee;
    }

    /* Mobile Quick Links Buttons */
    .offcanvas .btn {
        font-size: 0.75rem; /* Smaller font size */
        padding: 6px 12px;  /* Reduced padding */
        border-radius: 4px; /* Optional: for rounded corners */
    }

    /* Responsive Adjustments */
    @media (max-width: 991.98px) {
        body {
            padding-top: 70px;
        }
        
        .header-area {
            top: 0;
            padding: 5px 0;
        }
        
        .header-top {
            display: none !important;
        }
        
        .logo img {
            max-height: 35px !important;
        }
    }

    @media (max-width: 767.98px) {
        .offcanvas {
            max-width: 75%;
        }
    }
</style>

<script>
    // Make header sticky on scroll
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.header-area');
        if (window.scrollY > 50) {
            header.style.boxShadow = '0 2px 5px rgba(0,0,0,0.1)';
        } else {
            header.style.boxShadow = '0 4px 10px rgba(0,0,0,0.1)';
        }
    });
</script>
