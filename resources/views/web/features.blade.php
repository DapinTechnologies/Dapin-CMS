<!-- FIXED: Feature Services Section (limited to 3) -->
<section class="service-details-two" style="position: relative; z-index: 1;">
    <div class="container">
        <div class="row">
            @foreach($features->take(3) as $key => $feature)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="services-box07 @if($key == 1) active @endif h-100">
                    <div class="sr-contner">
                        <div class="icon mb-3 text-center">
                            <img src="{{ asset('web/img/icon/sve-icon4.png') }}" alt="{{ $feature->title }} icon" loading="lazy">
                        </div>
                        <div class="text text-center px-3">
                            <h5 class="fw-semibold">{{ $feature->title }}</h5>
                            <p>{!! $feature->description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
