@if(count($features) > 0)
<!-- service-area -->
<section class="service-details-two p-relative">
    <div class="container">
        <div class="row">
            @foreach($features as $key => $feature)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4"> <!-- added mb-4 for spacing -->
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
<!-- service-area-end -->
@endif
