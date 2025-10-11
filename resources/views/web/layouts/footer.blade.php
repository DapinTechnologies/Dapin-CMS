<footer class="footer-modern text-white pt-5" style="background-color: #141b22; font-family: 'Jost', sans-serif;">
    <div class="container pb-4">
        <div class="row gy-4">

            <!-- Social Media -->
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="fw-bold mb-3" style="color: #ff7350;">{{ __('footer_socials') }}</h5>
                <div class="d-flex gap-3 flex-wrap">
                    @isset($socialSetting->facebook)
                        <a href="{{ $socialSetting->facebook }}" class="social-icon" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    @endisset
                    @isset($socialSetting->instagram)
                        <a href="{{ $socialSetting->instagram }}" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>
                    @endisset
                    @isset($socialSetting->twitter)
                        <a href="{{ $socialSetting->twitter }}" class="social-icon" target="_blank"><i class="fab fa-twitter"></i></a>
                    @endisset
                    @isset($socialSetting->linkedin)
                        <a href="{{ $socialSetting->linkedin }}" class="social-icon" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    @endisset
                    @isset($socialSetting->pinterest)
                        <a href="{{ $socialSetting->pinterest }}" class="social-icon" target="_blank"><i class="fab fa-pinterest"></i></a>
                    @endisset
                    @isset($socialSetting->youtube)
                        <a href="{{ $socialSetting->youtube }}" class="social-icon" target="_blank"><i class="fab fa-youtube"></i></a>
                    @endisset
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="fw-bold mb-3" style="color: #ff7350;">{{ __('footer_links') }}</h5>
                <ul class="list-unstyled footer-links">
                    @if (Route::has('student.login'))
                        <li><a href="{{ route('student.login') }}">{{ __('field_student') }} {{ __('field_login') }}</a></li>
                    @endif
                    @if (Route::has('login'))
                        <li><a href="{{ route('login') }}">{{ __('field_staff') }} {{ __('field_login') }}</a></li>
                    @endif
                    @php $application = App\Models\ApplicationSetting::status(); @endphp
                    @isset($application)
                        <li><a href="{{ route('application.index') }}">{{ __('navbar_admission') }}</a></li>
                    @endisset
                    @foreach($footer_pages as $footer_page)
                        <li><a href="{{ route('page.single', ['slug' => $footer_page->slug]) }}">{{ $footer_page->title }}</a></li>
                    @endforeach
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
                <h5 class="fw-bold mb-3" style="color: #ff7350;">{{ __('footer_contact') }}</h5>
                <ul class="list-unstyled footer-contact">
                    @isset($topbarSetting->phone)
                        <li><i class="fas fa-phone me-2"></i><a href="tel:{{ str_replace(' ', '', $topbarSetting->phone) }}">{{ $topbarSetting->phone }}</a></li>
                    @endisset
                    @isset($topbarSetting->email)
                        <li><i class="fas fa-envelope me-2"></i><a href="mailto:{{ $topbarSetting->email }}">{{ $topbarSetting->email }}</a></li>
                    @endisset
                    @isset($topbarSetting->address)
                        <li><i class="fas fa-map-marker-alt me-2"></i>{{ $topbarSetting->address }}</li>
                    @endisset
                </ul>
            </div>

        </div>
    </div>

    <div class="footer-bottom py-3 border-top border-secondary-subtle mt-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start">
            <div class="mb-2 mb-md-0">
                @isset($setting->copyright_text)
                    <small class="text-white-50">&copy; {!! strip_tags($setting->copyright_text, '<a><b><i><u><strong>') !!}</small>
                @endisset
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
