@isset($callToAction)
<!-- CTA Section with Education Icon Background -->
<section class="cta-area position-relative py-4" style="background-color: #125875;" aria-labelledby="cta-title" itemscope itemtype="https://schema.org/CreativeWork">
    <meta itemprop="name" content="{{ $callToAction->title }}">
    <meta itemprop="description" content="{{ $callToAction->sub_title }}">

    <!-- Education Icon SVG Background -->
    <div class="cta-bg-icon" aria-hidden="true">
        <svg viewBox="0 0 64 64" fill="none" class="education-icon-svg">
            <path d="M2 16L32 2L62 16L32 30L2 16Z" stroke="#ffffff20" stroke-width="2"/>
            <path d="M2 24L32 40L62 24" stroke="#ffffff30" stroke-width="2"/>
        </svg>
    </div>

    <div class="container position-relative">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-8 text-center text-lg-left">
                <header class="section-title cta-title" data-aos="fade-right" data-aos-duration="1000">
                    <h2 id="cta-title" itemprop="headline" class="text-white fw-bold">{{ $callToAction->title }}</h2>
                    <p itemprop="text" class="text-light mb-0">{{ $callToAction->sub_title }}</p>
                </header>
            </div>
            <div class="col-lg-4 text-center text-lg-right mt-3 mt-lg-0">
                <div class="cta-btn s-cta-btn" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    @if(isset($callToAction->button_link))
                    <a href="{{ $callToAction->button_link }}" target="_blank" rel="noopener noreferrer" class="btn ss-btn smoth-scroll" itemprop="url">
                        {{ $callToAction->button_text }} <i class="fal fa-long-arrow-right" aria-hidden="true"></i>
                        <span class="sr-only">Go to {{ $callToAction->button_text }}</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Styles -->
<style>
.cta-area {
    overflow: hidden;
}
.cta-bg-icon {
    position: absolute;
    top: 10%;
    left: 50%;
    transform: translateX(-50%);
    z-index: 0;
    opacity: 0.15;
}
.education-icon-svg {
    width: 160px;
    height: 160px;
}
.cta-area .container {
    z-index: 2;
    position: relative;
}
</style>

<!-- AOS Library -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        AOS.init({ once: true, offset: 100 });
    });
</script>
@endisset
