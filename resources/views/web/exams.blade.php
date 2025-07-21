

<!-- Examination Bodies Section -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.core.min.css" rel="stylesheet">

<section class="exam-bodies-section py-5" style="background: #f1f3f5;" aria-labelledby="exam-bodies-heading">
    <div class="container">
        <header class="text-center mb-5" data-aos="fade-up" data-aos-duration="800">
            <h2 id="exam-bodies-heading" class="fw-bold h2">Accredited Examination Bodies in Kenya</h2>
            <p class="text-muted">Our institution is officially recognized and accredited by top national and international examination authorities.</p>
        </header>
@php
    use App\Models\Web\AboutUsPartner;
    $examBodies = AboutUsPartner::all();
@endphp

<section class="exam-bodies-section py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Our Examination Bodies</h2>
        
        <div id="examBodiesCarousel" class="glide exam-bodies-glide">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @foreach($examBodies as $examBody)
                        <li class="glide__slide px-2">
                            <div class="card border-0 h-100 shadow-sm">
                                <div class="card-body text-center p-4">
                                    <!-- Logo with proper path and fallback -->
                                    @php
                                        $logoPath = 'uploads/about-us/partners/' . $examBody->logo;
                                        $defaultLogo = 'images/default-logo.png';
                                        $logoExists = !empty($examBody->logo) && file_exists(public_path($logoPath));
                                    @endphp
                                    
                                    <img src="{{ $logoExists ? asset($logoPath) : asset($defaultLogo) }}" 
                                         alt="{{ $examBody->name }} Logo"
                                         class="img-fluid mb-3 mx-auto d-block"
                                         style="height: 80px; width: auto; object-fit: contain;"
                                         loading="lazy"
                                         onerror="this.onerror=null;this.src='{{ asset($defaultLogo) }}'">
                                    
                                    <h3 class="h5 mb-3">{{ $examBody->name }}</h3>
                                    <p class="text-muted small mb-0">
                                        {{ \Illuminate\Support\Str::words($examBody->description, 15, '...') }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Navigation arrows -->
            <div class="glide__arrows d-md-none" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                    <i class="fas fa-chevron-left fa-lg"></i>
                </button>
                <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                    <i class="fas fa-chevron-right fa-lg"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<style>
.exam-bodies-section {
    background: linear-gradient(to bottom, #f8f9fa, #ffffff);
}
.glide__slide {
    padding: 0 10px;
}
.card {
    transition: all 0.3s ease;
    border-radius: 10px;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.glide__arrow {
    background: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    opacity: 0.9;
}
.glide__arrow:hover {
    background: #f8f9fa;
}
.glide__arrow i {
    color: #495057;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Glide('#examBodiesCarousel', {
        type: 'carousel',
        perView: 4,
        gap: 20,
        breakpoints: {
            992: { perView: 3 },
            768: { perView: 2 },
            576: { perView: 1 }
        }
    }).mount();
});
</script>
@endpush

<style>
.exam-bodies-section {
    background-color: #f8f9fa;
}
.exam-body-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
}
.exam-body-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
.glide__arrow {
    background: rgba(255,255,255,0.7);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
.glide__arrow i {
    color: #333;
}
</style>

    </div>
</section>

<style>
.exam-body-card {
    transition: all 0.3s ease;
}
.exam-body-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}
.exam-bodies-glide .glide__slide {
    padding: 0 12px;
}

@media (max-width: 768px) {
    .exam-bodies-glide {
        position: relative;
        padding: 0 20px;
    }

    .exam-bodies-glide .glide__arrows {
        display: flex;
        justify-content: space-between;
        position: absolute;
        top: 40%;
        left: 0;
        right: 0;
        padding: 0 10px;
        pointer-events: none;
    }

    .exam-bodies-glide .glide__arrow {
        width: 36px;
        height: 36px;
        background: #fff;
        border: none;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        font-size: 1rem;
        color: #007bff;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: auto;
    }

    .exam-bodies-glide .glide__arrow:hover {
        background: #007bff;
        color: #fff;
    }
}
</style>

<!-- JS Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/glide.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Glide('#examBodiesCarousel', {
            type: 'carousel',
            perView: 3,
            gap: 24,
            breakpoints: {
                992: { perView: 2 },
                768: { perView: 1 }
            }
        }).mount();

        AOS.init({ once: true });
    });
</script>
