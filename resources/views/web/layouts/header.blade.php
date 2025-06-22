<!-- header -->
   <style>
    /* Make the Navbar White */
.header-area {
    background-color: #ffffff; /* White background */
    padding: 10px 0; /* Reduce padding for compactness */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Optional: adds subtle shadow for better visibility */
}

.menu-area {
    padding: 0;
}

/* Logo */
.header-area .logo img {
    max-width: 180px; /* Reduce logo size */
    height: auto;
}

/* Main Menu Styling */
.main-menu ul {
    display: flex;
    justify-content: center;
    gap: 20px; /* Reduce the space between links */
    margin: 0;
    padding: 0;
    list-style: none;
}

.main-menu ul li a {
    font-size: 14px; /* Reduce font size */
    color: #333; /* Dark color for text */
    text-transform: uppercase;
    padding: 8px 12px;
    transition: color 0.3s ease;
}

.main-menu ul li a:hover {
    color: #4361ee; /* Highlight color */
}

/* Make the login/admission button compact */
.second-header-btn .btn {
    padding: 8px 20px;
    font-size: 14px;
    background-color: #4361ee; /* Button color */
    color: white;
    text-transform: uppercase;
    border-radius: 30px;
    transition: background-color 0.3s ease;
}

.second-header-btn .btn:hover {
    background-color: #ff6b6b; /* Button hover color */
}

/* Mobile Menu */
.mobile-menu {
    display: block;
    text-align: center;
    padding-top: 20px;
}

/* Header on small screens */
@media (max-width: 768px) {
    .header-top {
        padding: 10px 0;
    }

    .main-menu ul {
        flex-direction: column; /* Stack the menu items on mobile */
        gap: 10px; /* Reduced space between links */
    }

    .main-menu ul li a {
        font-size: 16px; /* Larger font size for mobile */
        padding: 10px 15px;
    }

    .second-header-btn .btn {
        font-size: 12px;
        padding: 8px 20px;
    }
}
.header-social {
    flex: 0 0 auto;
    margin-right: auto; /* Pushes the next content to the right */
    padding-left: 20px;
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
.header-area {
    margin: 0 !important;
    padding: 10px 0;
    background-color: #ffffff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}


   </style>
   <header class="header-area header-three">  
    @include('web.layouts.nav')

    <div id="header-sticky" class="menu-area">
       <div class="container-fluid d-flex justify-content-start align-items-center" style="max-width: 100%; padding: 0 15px;">

            <!-- Social Media Section -->
            <div class="header-social d-flex align-items-center">
                @if(isset($topbarSetting) && $topbarSetting->social_status == 1)
                    <span class="social-icons">
                        @foreach(['facebook', 'instagram', 'twitter', 'linkedin', 'pinterest', 'youtube'] as $social)
                            @if(isset($socialSetting->$social))
                                <a href="{{ $socialSetting->$social }}" target="_blank" style="margin-right: 10px;">
                                    <i class="fab fa-{{ $social }}"></i>
                                </a>
                            @endif
                        @endforeach
                    </span>
                @endif
            </div>

            <!-- Contact and Portal Links -->
            <div class="header-cta d-flex align-items-center">
                <ul class="d-flex list-unstyled mb-0">
                    @isset($topbarSetting->phone)
                        <li class="mr-3">
                            <div class="call-box d-flex align-items-center">
                                <div class="icon">
                                    <img src="{{ asset('web/img/icon/phone-call.png') }}" alt="Phone">
                                </div>
                                <div class="text">
                                    <a href="tel:{{ str_replace(' ', '', $topbarSetting->phone) }}">
                                        <strong>{{ $topbarSetting->phone }}</strong>
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endisset

                    @isset($topbarSetting->email)
                        <li class="mr-3">
                            <div class="call-box d-flex align-items-center">
                                <div class="icon">
                                    <img src="{{ asset('web/img/icon/mailing.png') }}" alt="Mail">
                                </div>
                                <div class="text">
                                    <a href="mailto:{{ $topbarSetting->email }}">
                                        <strong>{{ $topbarSetting->email }}</strong>
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endisset

                    <!-- Student and Admin Portal Links -->
                    <li class="ml-3">
                        <a href="{{ route('student.login') }}" class="btn btn-link text-white">Student Portal</a>
                    </li>
                    <li class="ml-3">
                        <a href="{{ route('login') }}" class="btn btn-link text-white">Admin Portal</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
