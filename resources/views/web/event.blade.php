@extends('web.layouts.master')
@section('title', __('navbar_event'))
@section('content')

    <!-- main-area -->
    <main>

        <!-- breadcrumb-area -->
        <section class="breadcrumb-area d-flex  p-relative align-items-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-12 col-lg-12">
                        <div class="breadcrumb-wrap text-left">
                            <div class="breadcrumb-title">
                                <h2>{{ __('navbar_event') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="breadcrumb-wrap2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('navbar_home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('navbar_event') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->
                   
        <!-- event-area -->
        <section class="shop-area pt-120 pb-120 p-relative " data-animation="fadeInUp animated" data-delay=".2s">
            <div class="container">
                <div class="row">
                 
                    @foreach($events as $event)
                    <div class="col-lg-4 col-md-6  wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                        <div class="event-item mb-30 hover-zoomin">
                            <div class="thumb">
                                <a href="{{ route('event.single', ['id' => $event->id, 'slug' => $event->slug]) }}">
                                    <img src="{{ asset('uploads/web-event/'.$event->attach) }}" alt="Event">
                                </a>
                            </div>
                            <div class="event-content" style="color: #666;"> <!-- Lighter dark text color for event content -->
                                
                                <div class="date"><strong>{{ date("d", strtotime($event->date)) }}</strong> {{ date("M, Y", strtotime($event->date)) }}</div>
                                
                                <h3>
                                    <a href="{{ route('event.single', ['id' => $event->id, 'slug' => $event->slug]) }}" style="color: #666;"> <!-- Lighter dark color for title -->
                                        {{ $event->title }}
                                    </a>
                                </h3>

                                <p>{!! str_limit(strip_tags($event->description), 100, ' ...') !!}</p>

                                <div class="time" style="color: #666;"> <!-- Lighter dark color for time and address -->
                                    <span>
                                        @if(isset($setting->time_format))
                                            {{ date($setting->time_format, strtotime($event->time)) }}
                                        @else
                                            {{ date("h:i A", strtotime($event->time)) }}
                                        @endif
                                    </span>
                                    <i class="fal fa-long-arrow-right"></i> 
                                    <strong>{{ $event->address }}</strong>
                                </div>
                            </div>                       
                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="pagination-wrap mt-20 text-center">
                            <nav>
                                <ul class="pagination">
                                    {{ $events->appends(Request::only('search'))->links() }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- event-area-end -->
               
    </main>
    <!-- main-area-end -->

@endsection

<!-- Additional Custom Styles for Color -->
<style>
    .event-content {
        color: #666 !important; /* Apply lighter dark color to event descriptions */
    }

    .event-content h3 a {
        color: #666 !important; /* Apply lighter dark color to event titles */
    }

    .time {
        color: #666 !important; /* Apply lighter dark color to time and address */
    }
</style>
