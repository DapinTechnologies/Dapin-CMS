@php
/**
 * Generate Google Calendar URL
 */
function generateGoogleCalendarUrl($event)
{
    $startTime = date('Ymd\THis', strtotime($event->date . ' ' . $event->time));
    $endTime = date('Ymd\THis', strtotime($event->date . ' ' . $event->time . ' +2 hours')); // Default 2 hour duration
    
    $params = [
        'action' => 'TEMPLATE',
        'text' => $event->title,
        'dates' => $startTime . '/' . $endTime,
        'details' => strip_tags($event->description),
        'location' => $event->address ?? '',
        'sprop' => 'website:' . url('/'),
        'sprop' => 'name:' . config('app.name')
    ];
    
    return 'https://calendar.google.com/calendar/render?' . http_build_query($params);
}

/**
 * Generate Apple Calendar .ics file download
 */
function generateAppleCalendarUrl($event)
{
    // Generate ICS content directly
    $start = date('Ymd\THis', strtotime($event->date . ' ' . $event->time));
    $end = date('Ymd\THis', strtotime($event->date . ' ' . $event->time . ' +2 hours'));
    $created = date('Ymd\THis\Z');
    $uid = $event->id . '@' . parse_url(config('app.url'), PHP_URL_HOST);
    
    $icsContent = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//" . config('app.name') . "//EN
CALSCALE:GREGORIAN
BEGIN:VEVENT
UID:{$uid}
DTSTAMP:{$created}
DTSTART:{$start}
DTEND:{$end}
SUMMARY:{$event->title}
DESCRIPTION:" . strip_tags(str_replace(["\r", "\n"], ' ', $event->description)) . "
LOCATION:{$event->address}
END:VEVENT
END:VCALENDAR";
    
    // Return a data URL for direct download
    $base64 = base64_encode($icsContent);
    return "data:text/calendar;charset=utf-8;base64," . $base64;
}

/**
 * Generate Outlook Calendar URL
 */
function generateOutlookCalendarUrl($event)
{
    $startTime = date('Y-m-d\TH:i:s', strtotime($event->date . ' ' . $event->time));
    $endTime = date('Y-m-d\TH:i:s', strtotime($event->date . ' ' . $event->time . ' +2 hours'));
    
    $params = [
        'path' => '/calendar/action/compose',
        'rru' => 'addevent',
        'subject' => $event->title,
        'startdt' => $startTime,
        'enddt' => $endTime,
        'body' => strip_tags($event->description),
        'location' => $event->address ?? ''
    ];
    
    return 'https://outlook.live.com/calendar/0/deeplink/compose?' . http_build_query($params);
}

/**
 * Generate Yahoo Calendar URL
 */
function generateYahooCalendarUrl($event)
{
    $startTime = date('Ymd\THis', strtotime($event->date . ' ' . $event->time));
    $endTime = date('Ymd\THis', strtotime($event->date . ' ' . $event->time . ' +2 hours'));
    
    $params = [
        'v' => 60,
        'view' => 'd',
        'type' => 20,
        'title' => $event->title,
        'st' => $startTime,
        'et' => $endTime,
        'desc' => strip_tags($event->description),
        'in_loc' => $event->address ?? ''
    ];
    
    return 'https://calendar.yahoo.com/?' . http_build_query($params);
}

// Generate the calendar URLs for this event
$googleCalendarUrl = generateGoogleCalendarUrl($event);
$appleCalendarUrl = generateAppleCalendarUrl($event);
$outlookCalendarUrl = generateOutlookCalendarUrl($event);
$yahooCalendarUrl = generateYahooCalendarUrl($event);

// Get all events for the events list (you'll need to pass this from controller)
// For now, we'll use the related events or create a placeholder
$allEvents = isset($allEventsList) ? $allEventsList : ($relatedEvents ?? []);
@endphp

@extends('web.layouts.master')
@section('title', __('navbar_event'))

@section('social_meta_tags')
    @if(isset($setting))
    <meta property="og:type" content="website">
    <meta property='og:site_name' content="{{ $setting->title }}"/>
    <meta property='og:title' content="{{ $event->title }}"/>
    <meta property='og:description' content="{!! str_limit(strip_tags($event->description), 160, ' ...') !!}"/>
    <meta property='og:url' content="{{ route('event.single', ['id' => $event->id, 'slug' => $event->slug]) }}"/>
    <meta property='og:image' content="{{ asset('uploads/web-event/'.$event->attach) }}"/>

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="{!! '@'.str_replace(' ', '', $setting->title) !!}" />
    <meta name="twitter:creator" content="@HiTechParks" />
    <meta name="twitter:url" content="{{ route('event.single', ['id' => $event->id, 'slug' => $event->slug]) }}" />
    <meta name="twitter:title" content="{{ $event->title }}" />
    <meta name="twitter:description" content="{!! str_limit(strip_tags($event->description), 160, ' ...') !!}" />
    <meta name="twitter:image" content="{{ asset('uploads/web-event/'.$event->attach) }}" />
    @endif
@endsection

@section('content')

    <!-- main-area -->
    <main>

        <!-- breadcrumb-area -->
        <section class="breadcrumb-area d-flex p-relative align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-12 col-lg-12">
                        <div class="breadcrumb-wrap text-center">
                            <div class="breadcrumb-title">
                                <h1 class="text-white mb-3">{{ $event->title }}</h1>
                                <div class="event-meta-banner">
                                    <span class="meta-item">
                                        <i class="far fa-calendar-alt me-2"></i>
                                        {{ date("d F, Y", strtotime($event->date)) }}
                                    </span>
                                    <span class="meta-item">
                                        <i class="far fa-clock me-2"></i>
                                        @if(isset($setting->time_format))
                                            {{ date($setting->time_format, strtotime($event->time)) }}
                                        @else
                                            {{ date("h:i A", strtotime($event->time)) }}
                                        @endif
                                    </span>
                                    @if(!empty($event->address))
                                    <span class="meta-item">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        {{ $event->address }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->
                   
        <!-- Event Detail -->
        <section class="event-detail-section py-80">
            <div class="container">
                <div class="row">
                    <!-- Main Content -->
                    <div class="col-lg-8 col-md-12">
                        <div class="event-main-content">
                            <!-- Event Image -->
                            <div class="event-hero-image mb-5">
                                <img src="{{ asset('uploads/web-event/'.$event->attach) }}" 
                                     alt="{{ $event->title }}" 
                                     class="img-fluid rounded-3 shadow-lg w-100"
                                     style="height: 500px; object-fit: cover;">
                            </div>

                            <!-- Event Description -->
                            <div class="event-description mb-5">
                                <div class="description-content">
                                    {!! $event->description !!}
                                </div>
                            </div>

                            <!-- Share Section -->
                            <div class="share-section bg-light rounded-3 p-4">
                                <h5 class="mb-3"><i class="fas fa-share-alt me-2 text-primary"></i>Share This Event</h5>
                                <div class="social-share-buttons">
                                    <a target="_blank" 
                                       href="https://www.facebook.com/sharer/sharer.php?u={{ route('event.single', ['id' => $event->id, 'slug' => $event->slug]) }}"
                                       class="btn btn-facebook me-2 mb-2">
                                        <i class="fab fa-facebook-f me-2"></i>Facebook
                                    </a>
                                    
                                    <a target="_blank" 
                                       href="https://twitter.com/intent/tweet?text={{ urlencode(str_limit(strip_tags($event->title), 100, ' ...')) }}&url={{ route('event.single', ['id' => $event->id, 'slug' => $event->slug]) }}"
                                       class="btn btn-twitter me-2 mb-2">
                                        <i class="fab fa-twitter me-2"></i>Twitter
                                    </a>

                                    <a target="_blank" 
                                       href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('event.single', ['id' => $event->id, 'slug' => $event->slug]) }}&title={{ urlencode($event->title) }}"
                                       class="btn btn-linkedin me-2 mb-2">
                                        <i class="fab fa-linkedin-in me-2"></i>LinkedIn
                                    </a>

                                    <a href="mailto:?subject={{ urlencode($event->title) }}&body={{ urlencode(route('event.single', ['id' => $event->id, 'slug' => $event->slug])) }}"
                                       class="btn btn-outline-primary me-2 mb-2">
                                        <i class="fas fa-envelope me-2"></i>Email
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4 col-md-12">
                        <div class="event-sidebar">
                            <!-- Event Details Card -->
                            <div class="event-details-card card border-0 shadow-lg mb-4">
                                <div class="card-header bg-primary text-white py-3">
                                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Event Details</h5>
                                </div>
                                <div class="card-body p-4">
                                    <div class="event-detail-item mb-4">
                                        <div class="detail-icon">
                                            <i class="far fa-calendar-alt text-primary"></i>
                                        </div>
                                        <div class="detail-content">
                                            <h6 class="mb-1">Date</h6>
                                            <p class="mb-0 text-dark fw-semibold">{{ date("d F, Y", strtotime($event->date)) }}</p>
                                        </div>
                                    </div>

                                    @if(!empty($event->time))
                                    <div class="event-detail-item mb-4">
                                        <div class="detail-icon">
                                            <i class="far fa-clock text-primary"></i>
                                        </div>
                                        <div class="detail-content">
                                            <h6 class="mb-1">Time</h6>
                                            <p class="mb-0 text-dark fw-semibold">
                                                @if(isset($setting->time_format))
                                                {{ date($setting->time_format, strtotime($event->time)) }}
                                                @else
                                                {{ date("h:i A", strtotime($event->time)) }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($event->address))
                                    <div class="event-detail-item mb-4">
                                        <div class="detail-icon">
                                            <i class="fas fa-map-marker-alt text-primary"></i>
                                        </div>
                                        <div class="detail-content">
                                            <h6 class="mb-1">Location</h6>
                                            <p class="mb-0 text-dark fw-semibold">{{ $event->address }}</p>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Add to Calendar - NOW WORKING -->
                                    <div class="add-to-calendar mt-4">
                                        <h6 class="mb-3">Add to Calendar</h6>
                                        <div class="calendar-buttons">
                                            <!-- Google Calendar -->
                                            <a href="{{ $googleCalendarUrl }}" 
                                               target="_blank"
                                               class="btn btn-outline-danger btn-sm me-2 mb-2">
                                                <i class="fab fa-google me-1"></i>Google
                                            </a>
                                            
                                            <!-- Apple Calendar -->
                                            <a href="{{ $appleCalendarUrl }}" 
                                               download="{{ Str::slug($event->title) }}.ics"
                                               class="btn btn-outline-dark btn-sm me-2 mb-2">
                                                <i class="fab fa-apple me-1"></i>Apple
                                            </a>
                                            
                                            <!-- Outlook Calendar -->
                                            <a href="{{ $outlookCalendarUrl }}" 
                                               target="_blank"
                                               class="btn btn-outline-primary btn-sm me-2 mb-2">
                                                <i class="fab fa-microsoft me-1"></i>Outlook
                                            </a>

                                            <!-- Yahoo Calendar -->
                                            <a href="{{ $yahooCalendarUrl }}" 
                                               target="_blank"
                                               class="btn btn-outline-purple btn-sm mb-2">
                                                <i class="fab fa-yahoo me-1"></i>Yahoo
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- All Events List Card - REPLACED QUICK ACTIONS -->
                            <div class="all-events-card card border-0 shadow-lg">
                                <div class="card-header bg-info text-white py-3">
                                    <h5 class="mb-0"><i class="fas fa-list-alt me-2"></i>All Events</h5>
                                </div>
                                <div class="card-body p-4">
                                    @if(count($allEvents) > 0)
                                        <div class="events-list">
                                            @foreach($allEvents as $otherEvent)
                                                <div class="event-list-item {{ $otherEvent->id == $event->id ? 'current-event' : '' }}">
                                                    <a href="{{ route('event.single', ['id' => $otherEvent->id, 'slug' => $otherEvent->slug]) }}" 
                                                       class="d-flex align-items-center py-2 text-decoration-none event-link">
                                                        <div class="event-bullet me-3">
                                                            <i class="fas fa-calendar-day text-primary"></i>
                                                        </div>
                                                        <div class="event-info flex-grow-1">
                                                            <h6 class="mb-1 event-title {{ $otherEvent->id == $event->id ? 'text-primary fw-bold' : 'text-dark' }}">
                                                                {{ $otherEvent->title }}
                                                            </h6>
                                                            <small class="text-muted event-date">
                                                                <i class="far fa-clock me-1"></i>
                                                                {{ date("M d, Y", strtotime($otherEvent->date)) }}
                                                            </small>
                                                        </div>
                                                        @if($otherEvent->id == $event->id)
                                                            <span class="badge bg-primary ms-2">Current</span>
                                                        @endif
                                                    </a>
                                                </div>
                                                @if(!$loop->last)
                                                    <hr class="my-2">
                                                @endif
                                            @endforeach
                                        </div>
                                        
                                        <!-- View All Events Button -->
                                        <div class="text-center mt-3">
                                            <a href="{{ route('event') }}" class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-eye me-1"></i>View All Events
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-center py-3">
                                            <i class="fas fa-calendar-times text-muted fa-2x mb-2"></i>
                                            <p class="text-muted mb-0">No other events available</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Event Detail -->

        <!-- Related Events -->
        @if(isset($relatedEvents) && count($relatedEvents) > 0)
        <section class="related-events py-60 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center mb-5">
                            <h2 class="mb-3">Related Events</h2>
                            <p class="text-muted">Discover other events you might be interested in</p>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    @foreach($relatedEvents as $relatedEvent)
                    <div class="col-lg-4 col-md-6">
                        <div class="event-card card border-0 shadow-sm h-100">
                            <img src="{{ asset('uploads/web-event/'.$relatedEvent->attach) }}" 
                                 class="card-img-top" 
                                 alt="{{ $relatedEvent->title }}"
                                 style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $relatedEvent->title }}</h5>
                                <div class="event-meta mb-3">
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ date("M d, Y", strtotime($relatedEvent->date)) }}
                                    </small>
                                    <small class="text-muted ms-3">
                                        <i class="far fa-clock me-1"></i>
                                        {{ date("h:i A", strtotime($relatedEvent->time)) }}
                                    </small>
                                </div>
                                <p class="card-text text-muted small">
                                    {{ str_limit(strip_tags($relatedEvent->description), 100) }}
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <a href="{{ route('event.single', ['id' => $relatedEvent->id, 'slug' => $relatedEvent->slug]) }}" 
                                   class="btn btn-primary btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
       
    </main>
    <!-- main-area-end -->
@endsection

@push('styles')
<style>
    /* Modern CSS Variables */
    :root {
        --primary-color: #2290ef;
        --secondary-color: #382ef9;
        --success-color: #24afd9;
        --info-color: #17a2b8;
        --dark-color: #2b2d42;
        --light-color: #f8f9fa;
        --gradient-primary: linear-gradient(135deg, #1e2e73 0%, #eae9ec 100%);
        --gradient-secondary: linear-gradient(135deg, #e5e1e5 0%, #f5576c 100%);
        --shadow-lg: 0 10px 25px rgba(0,0,0,0.1);
        --shadow-xl: 0 20px 40px rgba(0,0,0,0.15);
        --border-radius: 12px;
    }

    /* Event Detail Section */
    .event-detail-section {
        background: var(--light-color);
    }

    /* Breadcrumb Area Modernization */
    .breadcrumb-area {
        padding: 100px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .breadcrumb-area::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--gradient-primary);
        z-index: 1;
    }

    .breadcrumb-wrap {
        position: relative;
        z-index: 2;
    }

    .event-meta-banner {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    .meta-item {
        background: rgba(255,255,255,0.2);
        padding: 8px 16px;
        border-radius: 50px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        font-weight: 500;
    }

    /* Event Main Content */
    .event-hero-image {
        position: relative;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }

    .event-hero-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(67,97,238,0.1), rgba(63,55,201,0.1));
        z-index: 1;
    }

    .event-hero-image img {
        transition: transform 0.3s ease;
    }

    .event-hero-image:hover img {
        transform: scale(1.02);
    }

    /* Event Description */
    .event-description {
        background: white;
        border-radius: var(--border-radius);
        padding: 40px;
        box-shadow: var(--shadow-lg);
    }

    .description-content {
        line-height: 1.8;
        color: #555;
        font-size: 1.1rem;
    }

    .description-content h1,
    .description-content h2,
    .description-content h3,
    .description-content h4,
    .description-content h5,
    .description-content h6 {
        color: var(--dark-color);
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .description-content p {
        margin-bottom: 1.5rem;
    }

    /* Share Section */
    .share-section {
        border-left: 4px solid var(--primary-color);
    }

    .social-share-buttons .btn {
        border-radius: 50px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-facebook {
        background: #1877f2;
        color: white;
        border: none;
    }

    .btn-twitter {
        background: #1da1f2;
        color: white;
        border: none;
    }

    .btn-linkedin {
        background: #0077b5;
        color: white;
        border: none;
    }

    .btn-outline-purple {
        border-color: #720e9e;
        color: #720e9e;
    }

    .btn-outline-purple:hover {
        background-color: #720e9e;
        color: white;
    }

    .social-share-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* Event Sidebar */
    .event-sidebar {
        position: sticky;
        top: 100px;
    }

    .event-details-card,
    .all-events-card {
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    .card-header {
        border: none;
        font-weight: 600;
    }

    /* Event Detail Items */
    .event-detail-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 15px;
        background: #f8f9ff;
        border-radius: 10px;
        border-left: 3px solid var(--primary-color);
    }

    .detail-icon {
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(67,97,238,0.2);
        flex-shrink: 0;
    }

    .detail-icon i {
        font-size: 1.1rem;
    }

    .detail-content h6 {
        color: #666;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 5px;
    }

    /* Calendar Buttons */
    .calendar-buttons .btn {
        border-radius: 20px;
        font-size: 0.8rem;
        padding: 6px 12px;
    }

    /* All Events List Styles */
    .all-events-card {
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    .events-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .event-list-item {
        transition: all 0.3s ease;
    }

    .event-list-item:hover {
        background-color: #f8f9fa;
        border-radius: 8px;
    }

    .event-list-item.current-event {
        background-color: #e3f2fd;
        border-radius: 8px;
        border-left: 3px solid var(--primary-color);
    }

    .event-link {
        color: inherit;
        transition: all 0.3s ease;
    }

    .event-link:hover {
        color: var(--primary-color);
    }

    .event-bullet {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .event-title {
        font-size: 0.9rem;
        line-height: 1.3;
        transition: color 0.3s ease;
    }

    .event-date {
        font-size: 0.75rem;
    }

    .current-event .event-title {
        font-weight: 600;
    }

    /* Scrollbar styling for events list */
    .events-list::-webkit-scrollbar {
        width: 6px;
    }

    .events-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .events-list::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .events-list::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Related Events */
    .related-events {
        background: white;
    }

    .event-card {
        border-radius: var(--border-radius);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
    }

    .event-card .card-img-top {
        transition: transform 0.3s ease;
    }

    .event-card:hover .card-img-top {
        transform: scale(1.05);
    }

    /* Responsive Design */
    @media (max-width: 991.98px) {
        .event-meta-banner {
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
        
        .event-sidebar {
            position: static;
            margin-top: 40px;
        }
        
        .event-hero-image img {
            height: 350px;
        }
        
        .events-list {
            max-height: 300px;
        }
    }

    @media (max-width: 767.98px) {
        .breadcrumb-area {
            padding: 80px 0 40px;
        }
        
        .event-description {
            padding: 25px;
        }
        
        .event-hero-image img {
            height: 250px;
        }
        
        .social-share-buttons .btn {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .calendar-buttons .btn {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .events-list {
            max-height: 250px;
        }
    }

    /* Animation Classes */
    .fade-in {
        animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Utility Classes */
    .py-60 { padding: 60px 0; }
    .py-80 { padding: 80px 0; }
</style>
@endpush

@push('scripts')
<script>
    // Add fade-in animation to elements
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.event-main-content, .event-sidebar');
        elements.forEach((el, index) => {
            el.style.animationDelay = (index * 0.1) + 's';
            el.classList.add('fade-in');
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endpush