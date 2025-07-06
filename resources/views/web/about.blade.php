@extends('web.layouts.master')
@section('title', __('About Us'))

@section('social_meta_tags')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    @if(isset($setting))
        <meta property="og:type" content="website">
        <meta property='og:site_name' content="{{ $setting->title }}"/>
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="{!! '@'.str_replace(' ', '', $setting->title) !!}" />
        <meta name="twitter:creator" content="@HiTechParks" />
    @endif
@endsection

@section('content')

<main>
    <!-- Hero Section -->
    <section class="breadcrumb-area py-5 bg-dark-blue text-white">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-12">
                    <h1 class="display-4 fw-bold mb-4">{{ __('About NIBS Technical College') }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-70">{{ __('navbar_home') }}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{ __('About') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- About Content Section -->
    <section class="py-5 bg-white">
        <div class="container">
            @if($about)
            <!-- Dynamic Content Section -->
            <div class="row g-5 align-items-center">
                <!-- Left: Text Content -->
                <div class="col-lg-6 order-lg-1 order-2">
                    <h2 class="fw-bold mb-4 text-dark-blue">{{ $about->title }}</h2>
                    <p class="lead text-muted mb-4">{{ $about->short_desc }}</p>
                    <div class="mb-4 text-gray-700">{!! $about->description !!}</div>
                </div>

                <!-- Right: Media Content (Image + Video) -->
                <div class="col-lg-6 order-lg-2 order-1">
                    @if($about->attach)
                        <div class="text-center mb-4">
                            <img src="{{ asset('uploads/about-us/'.$about->attach) }}" 
                                 alt="{{ $about->title }}" 
                                 class="img-fluid rounded w-100 shadow-lg mb-4"
                                 style="max-height: 400px; object-fit: cover;">
                        </div>
                    @endif
                    
                    @if($about->video_id)
                        <div class="ratio ratio-16x9 shadow-lg rounded-lg overflow-hidden">
                            <iframe src="https://www.youtube.com/embed/{{ $about->video_id }}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen 
                                    class="rounded-lg">
                            </iframe>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Features Section -->
            @if($about->features)
            <div class="mt-5 pt-4">
                <h3 class="fw-semibold mb-4 text-dark-blue">Our Key Features</h3>
                <div class="row g-4">
                    @foreach(json_decode($about->features, true) ?? [] as $feature)
                        <div class="col-md-6">
                            <div class="feature-card p-4 rounded-lg bg-light border-start border-4 border-dark-blue h-100">
                                <i class="bi bi-check-circle-fill text-dark-blue me-2"></i> 
                                <span class="text-dark">{{ $feature }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            @endif

            <!-- Vision & Mission Section -->
            <div class="row mb-5 mt-5">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="icon-box bg-light-blue text-dark-blue mb-3">
                                <i class="bi bi-eye-fill fs-2"></i>
                            </div>
                            <h3 class="text-dark-blue">Vision Statement</h3>
                            <p class="lead">To be a dynamic center of excellence in the delivery of high-quality, relevant industry-based training and education.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="icon-box bg-light-green text-dark-blue mb-3">
                                <i class="bi bi-bullseye fs-2"></i>
                            </div>
                            <h3 class="text-dark-blue">Our Motto</h3>
                            <p class="lead">"Developing Character, Skills & Competence."</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Founder's Message -->
            <div class="row my-5 py-4 align-items-center">
                <div class="col-lg-5">
                    <img src="{{ asset('assets/images/founder.jpg') }}" alt="Founder Lizzie Wanyoike" class="img-fluid rounded shadow-lg w-100">
                </div>
                <div class="col-lg-7 mt-4 mt-lg-0">
                    <h2 class="text-dark-blue mb-4">Founder's Message</h2>
                    <div class="message-content">
                        <p>Welcome to the world of possibilities at NIBS Technical College! Your interest in joining our exceptional institution is truly appreciated. Get ready to embark on an exciting journey towards academic excellence fused with dynamic courses that redefine leadership.</p>
                        
                        <p>With a remarkable 24-year legacy, NIBS Technical College has been at the forefront of delivering top-notch technical education and training. We offer a diverse range of courses, from Artisan and Craft Certificates to Diplomas and Advanced Diplomas, all designed to equip you not only with theoretical knowledge but also hands-on practical expertise essential for your success.</p>
                        
                        <p>Rest assured, our commitment to quality is unwavering. Endorsed by the Ministry of Education and authorized by the Technical and Vocational Education and Training Authority (TVETA), we guarantee a superior education and practical training that aligns with industry standards.</p>
                        
                        <div class="signature mt-4">
                            <p class="mb-1 fw-bold">Lizzie Wanyoike,</p>
                            <p class="text-muted">Principal</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Timeline -->
            <div class="row my-5 py-4">
                <div class="col-12">
                    <h2 class="text-dark-blue mb-5 text-center">Our History</h2>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-year">1999</div>
                            <div class="timeline-content">
                                <h4>Establishment</h4>
                                <p>Incorporated on 19th March 1999 under the Companies Act (Cap 486), as Nairobi Institute of Business Studies (NIBS) as a private tertiary college mandated to offer market driven courses. We commenced operations in June 1999 with a total of 25 students pursuing Secretarial and Business courses in the Agriculture House Building, along Moi Avenue in Nairobi CBD.</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-year">2004</div>
                            <div class="timeline-content">
                                <h4>Expansion</h4>
                                <p>Due to the increase in student population as a result of quality training, there was a need to acquire more training space. We secured space in the Cooperative House Building along Moi Avenue. We introduced Hospitality, Tourism and ICT courses in addition to the Secretarial and Business courses. Our student population had hit 600 with a matching staff population of 45 (both teaching & non teaching).</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-year">2009</div>
                            <div class="timeline-content">
                                <h4>Relocation</h4>
                                <p>The then government acquired some Offices in some of the floors of the Cooperative House Building and this changed the level of security and control of access in and out of the building. We relocated to Ronald Ngala Building along Ronald Ngala street. We introduced Journalism course due to the market demand of having trained professional journalists.</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-year">2010</div>
                            <div class="timeline-content">
                                <h4>Thika Road Campus</h4>
                                <p>Our Thika Road Campus was officially opened by the then Minister for Planning, and Gatanga MP, Hon. Peter Kenneth. We introduced Community Development and Social work course and had to rebrand to NIBS College from NAIROBI INSTITUTE OF BUSINESS STUDIES, to reflect the variety of programmes that we were offering then.</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-year">2012</div>
                            <div class="timeline-content">
                                <h4>Rongai Campus</h4>
                                <p>We established our Rongai Campus with the main aim of providing quality training and education to students from Kajiado County.</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-year">2016</div>
                            <div class="timeline-content">
                                <h4>Rebranding to NIBS Technical College</h4>
                                <p>Introduced more technical courses in Engineering, Fashion, Cosmetology, Fashion and Interior Design to meet the emerging needs of the job industry. We rebranded to NIBS Technical College. Around this period, we established Thika Town Campus as well as NIBS Elearning Center.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accreditation -->
            <div class="row my-5 py-4">
                <div class="col-12">
                    <h2 class="text-dark-blue mb-4 text-center">Accreditation & Recognition</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h4 class="text-dark-blue">Government Recognition</h4>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item bg-transparent">Ministry of Education</li>
                                        <li class="list-group-item bg-transparent">Technical and Vocational Education and Training Authority (TVETA)</li>
                                        <li class="list-group-item bg-transparent">Kenya National Examinations Council (KNEC)</li>
                                        <li class="list-group-item bg-transparent">Kenya National Qualifications Authority (KNQA)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h4 class="text-dark-blue">Quality Assurance</h4>
                                    <p>We maintain ongoing quality assurance processes to ensure our programs meet the highest standards of education and training. Our courses are designed to meet industry demands and are recognized by leading businesses and higher education institutions.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partners -->
            <div class="row my-5 py-4">
                <div class="col-12">
                    <h2 class="text-dark-blue mb-4 text-center">Our Partners</h2>
                    <div class="text-center">
                        <p>At NIBS Technical College, we believe in the power of collaboration and partnerships. We have established strategic partnerships with various industry organizations, educational institutions, and research centers to enhance the learning experience and create opportunities for our students.</p>
                        
                        <div class="partners-logos mt-4 d-flex flex-wrap justify-content-center align-items-center gap-4">
                            <img src="{{ asset('assets/images/partner1.png') }}" alt="Partner 1" class="img-fluid" style="max-height: 80px;">
                            <img src="{{ asset('assets/images/partner2.png') }}" alt="Partner 2" class="img-fluid" style="max-height: 80px;">
                            <img src="{{ asset('assets/images/partner3.png') }}" alt="Partner 3" class="img-fluid" style="max-height: 80px;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campuses -->
            <div class="row my-5 py-4">
                <div class="col-12">
                    <h2 class="text-dark-blue mb-4 text-center">Our Campuses</h2>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card campus-card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="campus-icon mb-3">
                                        <i class="bi bi-building fs-1 text-dark-blue"></i>
                                    </div>
                                    <h5>Thika Road Campus</h5>
                                    <p class="small">Along Thika Superhighway on Exit 13</p>
                                    <div class="mt-2">
                                        <a href="#" class="btn btn-sm btn-outline-dark-blue">View Location</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card campus-card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="campus-icon mb-3">
                                        <i class="bi bi-bank fs-1 text-dark-blue"></i>
                                    </div>
                                    <h5>Nairobi CBD Campus</h5>
                                    <p class="small">3rd Floor of AGRHO House Building along Moi Avenue</p>
                                    <div class="mt-2">
                                        <a href="#" class="btn btn-sm btn-outline-dark-blue">View Location</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card campus-card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="campus-icon mb-3">
                                        <i class="bi bi-laptop fs-1 text-dark-blue"></i>
                                    </div>
                                    <h5>NIBS Open Campus</h5>
                                    <p class="small">Virtual and online learning platform</p>
                                    <div class="mt-2">
                                        <a href="#" class="btn btn-sm btn-outline-dark-blue">Explore</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card campus-card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="campus-icon mb-3">
                                        <i class="bi bi-house-door fs-1 text-dark-blue"></i>
                                    </div>
                                    <h5>Ongata Rongai Campus</h5>
                                    <p class="small">1km Off Magadi Road towards Maasai Lodge</p>
                                    <div class="mt-2">
                                        <a href="#" class="btn btn-sm btn-outline-dark-blue">View Location</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection

@push('styles')
<style>
    /* Color Theme */
    :root {
        --dark-blue: #0a2463;
        --light-blue: #e6f0ff;
        --light-green: #e6ffe6;
        --accent: #4cc9f0;
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --dark-color: #14213d;
        --light-color: #f8f9fa;
        --text-color: #495057;
        --text-light: #6c757d;
    }
    
    .btn-outline-dark-blue {
        color: var(--dark-blue);
        border-color: var(--dark-blue);
    }
    
    .btn-outline-dark-blue:hover {
        background-color: var(--dark-blue);
        color: white;
    }
    
    /* Icon Boxes */
    .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .bg-light-blue {
        background-color: var(--light-blue);
    }
    
    .bg-light-green {
        background-color: var(--light-green);
    }
    
    /* Timeline */
    .timeline {
        position: relative;
        padding-left: 50px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--dark-blue);
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 30px;
        opacity: 0;
        transform: translateX(20px);
    }
    
    .timeline-year {
        position: absolute;
        left: -50px;
        top: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--dark-blue);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    
    .timeline-content {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        position: relative;
    }
    
    .timeline-content::before {
        content: '';
        position: absolute;
        left: -10px;
        top: 15px;
        width: 0;
        height: 0;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
        border-right: 10px solid #f8f9fa;
    }
    
    /* Campus Cards */
    .campus-card {
        transition: all 0.3s ease;
    }
    
    .campus-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .campus-icon {
        color: var(--dark-blue);
    }
    
    /* Feature Cards */
    .feature-card {
        transition: all 0.3s ease;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        background-color: white !important;
    }
    
    /* Hero Section */
    .breadcrumb-area {
        background: linear-gradient(135deg, var(--dark-blue), #1e3b8a);
        position: relative;
        overflow: hidden;
    }
    
    .breadcrumb-area::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd' opacity='0.1'%3E%3Cg fill='%23ffffff' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .timeline {
            padding-left: 30px;
        }
        
        .timeline-year {
            left: -30px;
            width: 30px;
            height: 30px;
            font-size: 0.8rem;
        }
        
        .order-md-1 {
            order: 1 !important;
        }
        .order-md-2 {
            order: 2 !important;
        }
        
        .display-4 {
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .display-4 {
            font-size: 1.8rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Animation for timeline items
    document.addEventListener('DOMContentLoaded', function() {
        const timelineItems = document.querySelectorAll('.timeline-item');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateX(0)';
                }
            });
        }, { threshold: 0.1 });
        
        timelineItems.forEach((item, index) => {
            item.style.transition = `all 0.5s ease ${index * 0.1}s`;
            observer.observe(item);
        });
    });
</script>
@endpush