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
    background: white;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: auto;
    padding: 1.5rem;
    border: 1px solid #eaeaea;
    min-height: 380px;
}
.course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
}

/* Desktop grid carousel (safe with Bootstrap) */
.course-carousel-inner {
    display: flex;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
}
.course-carousel-inner > div {
    flex: 0 0 90%;
    scroll-snap-align: start;
    padding: 0 0.5rem;
}

/* Arrows (mobile only) */
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
}
.course-carousel-btn i {
    font-size: 16px;
    color: #4a5568;
}
.prev-btn { left: 0; }
.next-btn { right: 0; }

/* Indicators (optional) */
.carousel-indicators {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    gap: 8px;
}
.indicator {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #cbd5e0;
    cursor: pointer;
}
.indicator.active {
    background-color: #4299e1;
    transform: scale(1.2);
}
</style>

<section class="container mx-auto py-8 px-4" aria-labelledby="courses-heading">
    <h2 id="courses-heading" class="text-3xl font-bold text-center mb-8 text-gray-800">Our Courses</h2>

    <!-- Desktop Grid -->
    <div class="hidden md:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
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

    <!-- Mobile Carousel -->
    <div class="relative md:hidden">
        <button class="course-carousel-btn prev-btn" onclick="slideCarousel(-1)"><i class="fas fa-chevron-left"></i></button>
        <div class="course-carousel-inner hide-scrollbar" id="carousel">
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
        <button class="course-carousel-btn next-btn" onclick="slideCarousel(1)"><i class="fas fa-chevron-right"></i></button>
    </div>
</section>

<script>
function slideCarousel(direction) {
    const carousel = document.getElementById('carousel');
    const slide = carousel.querySelector('div');
    const slideWidth = slide.offsetWidth + 16; // includes margin
    carousel.scrollBy({ left: direction * slideWidth, behavior: 'smooth' });
}
</script>
