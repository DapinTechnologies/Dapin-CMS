@php
use App\Models\Course;
$courses = Course::where('status', 1)->orderBy('faculty')->get();
@endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<style>
/* Hide scrollbar */
.hide-scrollbar::-webkit-scrollbar { display: none; }
.hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

/* Course Card */
.course-card {
    background: linear-gradient(145deg, #ffffff, #f7f7f7);
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    height: auto;
    padding: 1.5rem;
    border: 1px solid #eaeaea;
    min-height: 380px;
}

.course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
}

/* Carousel styles */
.course-carousel-container {
    position: relative;
}

.course-carousel-inner {
    display: flex;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
    gap: 1rem;
    padding-bottom: 1rem;
}

.course-carousel-inner > div {
    flex: 0 0 calc(100% - 2rem);
    scroll-snap-align: start;
}

/* Desktop specific styles */
@media (min-width: 768px) {
    /* Grid style for 3 or fewer courses */
    .course-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }
    
    /* Carousel style for more than 3 courses */
    .desktop-carousel > div {
        flex: 0 0 calc(33.333% - 1rem);
    }
}

/* Mobile specific styles */
@media (max-width: 767px) {
    .course-carousel-inner > div {
        flex: 0 0 calc(100% - 2rem);
    }
    
    .course-grid {
        display: none;
    }
}

/* Arrows */
.course-carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 36px;
    height: 36px;
    background-color: white;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    z-index: 10;
    border: none;
    opacity: 0.8;
}

.course-carousel-btn:hover {
    opacity: 1;
}

.course-carousel-btn i {
    font-size: 16px;
    color: #4a5568;
}

.prev-btn { left: -18px; }
.next-btn { right: -18px; }
</style>

<section class="container mx-auto py-8 px-4" aria-labelledby="courses-heading">
    <h2 id="courses-heading" class="text-3xl font-bold text-center mb-8 text-gray-800">Our Courses</h2>

    <!-- Desktop View - Grid or Carousel -->
    <div class="hidden md:block">
        @if(count($courses) <= 3)
            <!-- Grid Layout for 3 or fewer courses -->
            <div class="course-grid">
                @foreach($courses as $course)
                <div class="course-card">
                    <a href="{{ route('course.single', ['slug' => $course->slug]) }}" class="text-decoration-none text-dark d-block">
                        <h3 class="text-xl font-bold mb-3 text-blue-700">{{ $course->title }}</h3>
                        <p class="mb-2 text-gray-600"><i class="fas fa-building mr-2 text-blue-500"></i><strong>Department:</strong> {{ $course->faculty }}</p>
                        <p class="mb-2 text-gray-600"><i class="fas fa-clock mr-2 text-blue-500"></i><strong>Duration:</strong> {{ $course->duration }}</p>
                        <p class="mb-3 text-gray-600"><i class="fas fa-money-bill-wave mr-2 text-blue-500"></i><strong>Fee:</strong> KSH {{ number_format($course->fee, 2) }}</p>
                        <div class="course-extra mt-3">
                            <p class="text-gray-700 mb-2"><strong>Description:</strong> {!! $course->description !!}</p>
                            @if($course->award)<p><strong>Award:</strong> {{ $course->award }}</p>@endif
                            @if($course->semesters)<p><strong>Semesters:</strong> {{ $course->semesters }}</p>@endif
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        @else
            <!-- Carousel Layout for more than 3 courses -->
            <div class="course-carousel-container">
                <button class="course-carousel-btn prev-btn" onclick="slideCarousel(-1, 'desktop')">
                    <i class="fas fa-chevron-left"></i>
                </button>
                
                <div class="course-carousel-inner hide-scrollbar desktop-carousel" id="carousel-desktop">
                    @foreach($courses as $course)
                    <div>
                        <div class="course-card">
                            <a href="{{ route('course.single', ['slug' => $course->slug]) }}" class="text-decoration-none text-dark d-block">
                                <h3 class="text-xl font-bold mb-3 text-blue-700">{{ $course->title }}</h3>
                                <p class="mb-2 text-gray-600"><i class="fas fa-building mr-2 text-blue-500"></i><strong>Department:</strong> {{ $course->faculty }}</p>
                                <p class="mb-2 text-gray-600"><i class="fas fa-clock mr-2 text-blue-500"></i><strong>Duration:</strong> {{ $course->duration }}</p>
                                <p class="mb-3 text-gray-600"><i class="fas fa-money-bill-wave mr-2 text-blue-500"></i><strong>Fee:</strong> KSH {{ number_format($course->fee, 2) }}</p>
                                <div class="course-extra mt-3">
                                    <p class="text-gray-700 mb-2"><strong>Description:</strong> {!! $course->description !!}</p>
                                    @if($course->award)<p><strong>Award:</strong> {{ $course->award }}</p>@endif
                                    @if($course->semesters)<p><strong>Semesters:</strong> {{ $course->semesters }}</p>@endif
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <button class="course-carousel-btn next-btn" onclick="slideCarousel(1, 'desktop')">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Mobile View - Always Carousel -->
    <div class="md:hidden">
        <div class="course-carousel-container">
            <button class="course-carousel-btn prev-btn" onclick="slideCarousel(-1, 'mobile')">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <div class="course-carousel-inner hide-scrollbar" id="carousel-mobile">
                @foreach($courses as $course)
                <div>
                    <div class="course-card">
                        <a href="{{ route('course.single', ['slug' => $course->slug]) }}" class="text-decoration-none text-dark d-block">
                            <h3 class="text-xl font-bold mb-3 text-blue-700">{{ $course->title }}</h3>
                            <p class="mb-2 text-gray-600"><i class="fas fa-building mr-2 text-blue-500"></i><strong>Department:</strong> {{ $course->faculty }}</p>
                            <p class="mb-2 text-gray-600"><i class="fas fa-clock mr-2 text-blue-500"></i><strong>Duration:</strong> {{ $course->duration }}</p>
                            <p class="mb-3 text-gray-600"><i class="fas fa-money-bill-wave mr-2 text-blue-500"></i><strong>Fee:</strong> KSH {{ number_format($course->fee, 2) }}</p>
                            <div class="course-extra mt-3">
                                <p class="text-gray-700 mb-2"><strong>Description:</strong> {!! Str::limit($course->description, 150) !!}</p>
                                @if($course->award)<p><strong>Award:</strong> {{ $course->award }}</p>@endif
                                @if($course->semesters)<p><strong>Semesters:</strong> {{ $course->semesters }}</p>@endif
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <button class="course-carousel-btn next-btn" onclick="slideCarousel(1, 'mobile')">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<script>
function slideCarousel(direction, type) {
    const carouselId = `carousel-${type}`;
    const carousel = document.getElementById(carouselId);
    const slides = carousel.querySelectorAll('div');
    
    if (slides.length === 0) return;
    
    // Calculate slide width based on viewport
    let slideWidth = slides[0].offsetWidth;
    if (type === 'desktop') {
        // For desktop carousel, we show 3 slides at a time
        slideWidth = slides[0].offsetWidth * 3;
    }
    
    // Add gap between slides (1rem = 16px)
    const gap = 16;
    slideWidth += gap;
    
    carousel.scrollBy({ 
        left: direction * slideWidth, 
        behavior: 'smooth' 
    });
}

// Hide arrows when at the start/end of carousel
document.addEventListener('DOMContentLoaded', function() {
    const checkCarouselPosition = (carouselId, prevBtn, nextBtn) => {
        const carousel = document.getElementById(carouselId);
        if (!carousel) return;
        
        const updateButtons = () => {
            const scrollLeft = carousel.scrollLeft;
            const scrollWidth = carousel.scrollWidth;
            const clientWidth = carousel.clientWidth;
            
            if (prevBtn) {
                prevBtn.style.display = scrollLeft <= 0 ? 'none' : 'flex';
            }
            if (nextBtn) {
                nextBtn.style.display = scrollLeft + clientWidth >= scrollWidth - 1 ? 'none' : 'flex';
            }
        };
        
        carousel.addEventListener('scroll', updateButtons);
        updateButtons();
    };
    
    // Initialize for both carousels
    checkCarouselPosition(
        'carousel-desktop',
        document.querySelector('#carousel-desktop').parentElement.querySelector('.prev-btn'),
        document.querySelector('#carousel-desktop').parentElement.querySelector('.next-btn')
    );
    
    checkCarouselPosition(
        'carousel-mobile',
        document.querySelector('#carousel-mobile').parentElement.querySelector('.prev-btn'),
        document.querySelector('#carousel-mobile').parentElement.querySelector('.next-btn')
    );
});
</script>