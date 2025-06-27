<header class="header-area header-three" style="padding-top: 10px; padding-bottom: 10px;">
    @include('web.layouts.nav')

    <div id="header-sticky" class="menu-area" style="padding: 5px 0;">
        <div class="container">
            <div class="second-menu">
                <div class="row align-items-center py-1">
                    <!-- Social Media Section - Positioned to the Extreme Left -->
                    <div class="col-xl-3 col-lg-3 d-flex align-items-center">
                        <div class="header-social d-flex align-items-center" style="margin-right: auto;">
                            @if(isset($setting))
                                <div class="logo" style="max-height: 50px; overflow: hidden;">
                                    <a href="{{ route('home') }}">
                                        <img src="{{ asset('/uploads/setting/'.$setting->logo_path) }}" alt="logo" style="max-height: 40px;">
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Main Menu Section -->
                    <div class="col-xl-8 col-lg-8">
                        <div class="main-menu text-right text-xl-right">
                            <nav id="mobile-menu">
                                <ul class="mb-0">
                                    <li class="{{ Request::path() == '/' ? 'current' : '' }}"><a href="{{ route('home') }}">{{ __('navbar_home') }}</a></li>
                                    <li class="{{ Request::is('course*') ? 'current' : '' }}"><a href="{{ route('course') }}">{{ __('navbar_course') }}</a></li>
                                    <li class="{{ Request::is('event*') ? 'current' : '' }}"><a href="{{ route('event') }}">{{ __('navbar_event') }}</a></li>
                                    <li class="{{ Request::is('faq*') ? 'current' : '' }}"><a href="{{ route('faq') }}">{{ __('navbar_faqs') }}</a></li>
                                    <li class="{{ Request::is('gallery*') ? 'current' : '' }}"><a href="{{ route('gallery') }}">{{ __('navbar_gallery') }}</a></li>
                                    <li class="{{ Request::is('news*') ? 'current' : '' }}"><a href="{{ route('news') }}">{{ __('navbar_news') }}</a></li>
                                    <li class="{{ Request::is('about*') ? 'current' : '' }}"><a href="{{ route('aboutus') }}">{{ __('About Us') }}</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Admission Button -->
                    <div class="col-xl-3 col-lg-3 d-none d-lg-block text-right text-xl-right">
                        @php 
                        $application = App\Models\ApplicationSetting::status(); 
                        @endphp
                        @isset($application)
                        <div class="login">
                            <ul class="mb-0">
                                <li>
                                    <div class="second-header-btn">
                                       <a href="{{ route('application.index') }}" target="_blank" class="btn py-1 px-3" style="font-size: 0.875rem;">{{ __('navbar_admission') }}</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        @endisset
                    </div>

                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile-menu"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
    /* Make the Header Stick at the Top */
    .header-area {
        position: fixed; /* Fix it at the top */
        top: 0;
        left: 0;
        width: 100%;
        background-color: #ffffff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000; /* Ensure the header is always above other content */
        padding-top: 10px;
        padding-bottom: 10px;
    }

    /* Adjust padding and layout for the menu area */
    .menu-area {
        padding-top: 5px;
        padding-bottom: 5px;
    }

    /* Align Social Media Icons to the Extreme Left */
    .header-social {
        margin-right: auto;
        padding-left: 0;
    }

    .header-social .social-icons a {
        color: #333;
        font-size: 16px;
        margin-right: 12px;
        transition: color 0.3s ease;
    }

    .header-social .social-icons a:hover {
        color: #4361ee;
    }

    /* Style for Logo */
    .logo img {
        max-height: 40px;
    }

    /* Style for Menu */
    .main-menu ul {
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    .main-menu ul li a {
        font-size: 14px;
        color: #333;
        text-transform: uppercase;
        padding: 8px 12px;
        transition: color 0.3s ease;
    }

    .main-menu ul li a:hover {
        color: #4361ee;
    }

    /* Style for Admission Button */
    .second-header-btn .btn {
        padding: 6px 15px;
        font-size: 0.875rem;
    }

    /* Mobile View Adjustments */
    @media (max-width: 768px) {
        .header-social .social-icons a {
            font-size: 14px;
            margin-right: 10px;
        }

        .header-cta ul {
            display: block;
            text-align: center;
        }

        .header-cta a {
            font-size: 12px;
        }
    }
</style>
