<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jambangan Cultural Dance</title>
    
    <!-- Stylesheets -->
    @vite(['resources/css/landingpage.css', 'resources/js/app.js'])
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.png') }}">
    <link href="https://fonts.google.com/specimen/DM+Serif+Text?categoryFilters=Feeling:%2FExpressive%2FBusiness" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    
    <!-- Scripts (deferred) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js" defer></script>
</head>

<body class="bg-black">
    <!-- ==================== -->
    <!-- NAVIGATION SECTION -->
    <!-- ==================== -->
    <nav x-data="{ scrolled: false }" 
         x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > window.innerHeight - 400)" 
         :class="scrolled ? 'opacity-0 pointer-events-none' : 'opacity-100 pointer-events-auto'"
         class="fixed top-0 left-0 w-full z-50 transition-all duration-10 ease-in-out">
        
        <div class="absolute inset-0 pointer-events-none"
             :class="scrolled ? '' : 'bg-gradient-to-b from-black/40 to-transparent'">
        </div>

        <div class="relative container mx-auto flex justify-between items-center p-4">
            <!-- Logo and Main Navigation -->
            <div class="flex items-center gap-8">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/LogoColored.png') }}" alt="Jambangan Logo" class="h-25 w-auto">
                </div>
                <ul class="flex space-x-6 font-thin">
                    <li><a href="#" class="relative text-lg text-white hover:text-red-500 transition duration-300 group">
                        HOME<span class="absolute left-0 bottom-0 w-0 h-0.5 bg-red-500 transition-all duration-300 group-hover:w-full"></span>
                    </a></li>
                    <li><a href="#aboutUs" class="relative text-lg text-white hover:text-yellow-400 transition duration-300 group">
                        ABOUT US<span class="absolute left-0 bottom-0 w-0 h-0.5 bg-yellow-400 transition-all duration-300 group-hover:w-full"></span>
                    </a></li>
                    <li><a href="#events" class="relative text-lg text-white hover:text-red-500 transition duration-300 group">
                        EVENTS<span class="absolute left-0 bottom-0 w-0 h-0.5 bg-red-500 transition-all duration-300 group-hover:w-full"></span>
                    </a></li>
                    <li><a href="#events" class="relative text-lg text-white hover:text-yellow-400 transition duration-300 group">
                        POSTS<span class="absolute left-0 bottom-0 w-0 h-0.5 bg-yellow-400 transition-all duration-300 group-hover:w-full"></span>
                    </a></li>
                    <li><a href="#performances" class="relative text-lg text-white hover:text-red-500 transition duration-300 group">
                        PERFORMANCES<span class="absolute left-0 bottom-0 w-0 h-0.5 bg-red-500 transition-all duration-300 group-hover:w-full"></span>
                    </a></li>
                    <li><a href="#contact" class="relative text-lg text-white hover:text-yellow-400 transition duration-300 group">
                        CONTACT<span class="absolute left-0 bottom-0 w-0 h-0.5 bg-yellow-400 transition-all duration-300 group-hover:w-full"></span>
                    </a></li>
                </ul>
            </div>

            <!-- Utility Buttons -->
            <div class="flex items-center space-x-4">
                <a href="#search" class="group relative">
                    <img src="{{ asset('images/search.svg') }}" alt="Search" class="h-8 w-8 transition-all duration-300 group-hover:scale-110 group-hover:rotate-12">
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-red-500 to-yellow-400 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#booking" class="group relative">
                    <img src="{{ asset('images/bookings.svg') }}" alt="Booking" class="h-8 w-8 transition-all duration-300 group-hover:scale-110 group-hover:-rotate-12">
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-yellow-400 to-red-500 transition-all duration-300 group-hover:w-full"></span>
                </a>
            </div>
        </div>
    </nav>

    <!-- ==================== -->
    <!-- HERO SECTION -->
    <!-- ==================== -->
    <section data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-duration="1000" class="relative">
        <div class="relative w-full h-screen flex items-center justify-center text-white overflow-hidden">
            <!-- Background Slides -->
            @foreach($cover_medias as $index => $item)
                <div class="bg-gradient-to-b absolute inset-0 w-full h-full bg-cover bg-center transition-opacity duration-1000 ease-in-out"
                    style="background-image: url('{{ isset($item['file_data']) ? 'http://127.0.0.1:9000/my-bucket/' . $item['file_data'] : asset('images/placeholder.png') }}');"
                    @if ($index != 0) style="display: none;" @endif>
                </div>
            @endforeach

            <!-- Gradient Overlays -->
            <div class="absolute inset-0 pointer-events-none z-0" 
                 style="background: linear-gradient(to bottom, rgba(0,0,0,0) 80%, rgba(0,0,0,0.7) 97%, rgba(0,0,0,1) 100%);">
            </div>
            
            <div class="absolute inset-0 z-0 opacity-20 mix-blend-overlay animate-gradient-shift" 
                 style="background: linear-gradient(45deg, rgba(234, 179, 8, 0.3) 0%, rgba(239, 68, 68, 0.3) 50%, rgba(234, 179, 8, 0.3) 100%); background-size: 200% 200%;">
            </div>

            <div class="absolute inset-0 bg-[#121212]" 
                 @if($cover_medias->isEmpty()) style="display: block;" @else style="display: none;" @endif>
            </div>

            <!-- Hero Content -->
            <div class="shadow-text relative z-10 text-center drop-shadow-2xl px-6">
                <h1 class="text-5xl drop-shadow-2xl font-extrabold">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-red-500 to-yellow-400 animate-text-gradient">
                        Jambangan
                    </span>
                    <span class="text-white">: the Dance Ambassador of WMSU</span>
                </h1>
                <p class="text-xl mt-4 drop-shadow-2xl" id="slide-caption"></p>
            </div>

            <!-- Carousel Controls -->
            <button onclick="prevSlide()" 
                    class="absolute left-4 z-10 bg-black/30 hover:bg-yellow-400/20 text-white hover:text-yellow-400 px-4 py-2 rounded-full text-2xl transition-all duration-300 border border-transparent hover:border-yellow-400">
                &lt;
            </button>
            <button onclick="nextSlide()" 
                    class="absolute right-4 z-10 bg-black/30 hover:bg-red-500/20 text-white hover:text-red-500 px-4 py-2 rounded-full text-2xl transition-all duration-300 border border-transparent hover:border-red-500">
                &gt;
            </button>

            <!-- Scroll Indicator -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
                <div class="w-8 h-8 border-b-2 border-r-2 border-yellow-400 rotate-45"></div>
                <div class="w-8 h-8 border-b-2 border-r-2 border-red-500 rotate-45 mt-2"></div>
            </div>
        </div>
    </section>

    <!-- ==================== -->
    <!-- ABOUT SECTION -->
    <!-- ==================== -->
    <section id="aboutUs" data-aos="fade-right" class="my-24 py-50 px-6 bg-[#121212] shadow-md relative" 
             style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0.9) 3%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0.9) 97%, rgba(0, 0, 0, 1) 100%), url('images/best2.png'); background-size: cover; background-position: center;">
        
        <div class="absolute inset-0 bg-black opacity-80"></div>

        <div class="max-w-SxL mx-auto text-base relative z-10">
            <h2 class="text-2xl text-white font-extrabold mb-6 relative pl-6 ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-3xl">
                OUR STORY
            </h2>
            <div class="my-24 max-w-4xl px-10">
                <p class="text-3xl font-thin text-gray-300 leading-relaxed">
                    {{ $general_contents['about_us'] }}
                </p>
            </div>
        </div>  
    </section>

    <!-- ==================== -->
    <!-- PERFORMANCES SECTION -->
    <!-- ==================== -->
    <section id="performances" data-aos="fade-right" class="py-16 bg-black">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl text-white font-extrabold mb-6 relative pl-6 ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-3xl">
                PERFORMANCES
            </h2>

            <!-- Performance Gallery -->
            <div class="flex overflow-x-auto space-x-6 pb-4 scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-gray-800 snap-x snap-mandatory">
                @foreach ($performances as $performance)
                    <div class="group relative flex-shrink-0 min-w-[350px] h-[420px] bg-[#1E1E1E] rounded-lg shadow-2xl overflow-hidden transition-transform duration-300 transform hover:scale-105 snap-start">
                        @if ($performance->media)
                            <img src="{{ 'http://localhost:9000/my-bucket/' . $performance->media->file_data }}"
                                 alt="{{ $performance->title }}"
                                 class="w-full h-full object-cover absolute inset-0 z-0 transition duration-500">
                        @endif

                        <div class="absolute inset-0 z-10 bg-black/40 backdrop-blur-md flex items-center justify-center transition-opacity duration-500 group-hover:opacity-0">
                            <h3 class="text-4xl sm:text-5xl font-extrabold text-white text-center px-6 leading-snug tracking-wide drop-shadow-lg">
                                {{ $performance->title }}
                            </h3>
                        </div>

                        <div class="relative z-20 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500 text-white flex flex-col justify-end h-full bg-gradient-to-t from-black/80 via-transparent to-transparent">
                            <h3 class="text-xl font-semibold text-[#FFD700] mb-2">{{ $performance->title }}</h3>
                            <p class="text-sm text-gray-300">{{ $performance->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ==================== -->
    <!-- EVENTS SECTION -->
    <!-- ==================== -->
    <section id="events" data-aos="fade-left" class="py-12 px-6 bg-black shadow-md">
        <div class="max-w-6xl px-6">
            <h2 class="text-2xl text-white font-extrabold mb-6 relative pl-6 ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-3xl">
                UPCOMING
            </h2>
        </div>
        
        <div class="flex justify-center items-center max-w-6xl mx-auto space-x-6">
            @foreach ($events as $event)
                <div class="relative w-[350px] h-[300px] bg-[#1D1D1D] rounded-lg shadow-2xl overflow-hidden transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <div class="h-40 bg-cover bg-center flex items-center justify-center text-white text-2xl font-semibold relative sm:text-xl md:text-2xl lg:text-3xl" 
                         style="background-image: url('{{ asset('images/placeholder.png') }}');">
                        <div class="absolute inset-0 bg-gradient-to-r from-black opacity-50"></div>
                        <img src="{{ asset('images/placeholder.png') }}" alt="Image Placeholder" class="w-full h-full object-cover">
                    </div>
                    
                    <div class="absolute top-4 left-4 font-bold text-5xl z-10 sm:text-4xl md:text-5xl lg:text-6xl">
                        <span class="block">{{ \Carbon\Carbon::parse($event->start)->format('M') }}</span>
                        <span class="block text-6xl sm:text-5xl md:text-6xl lg:text-7xl">{{ \Carbon\Carbon::parse($event->start)->format('d') }}</span>
                    </div>
                    
                    <div class="p-5">
                        <h3 class="text-2xl font-semibold sm:text-xl md:text-2xl lg:text-3xl">{{ $event->title }}</h3>
                        <p class="text-gray-300 text-sm mt-4 sm:text-xs md:text-sm lg:text-base">{{ $event->location }}</p>
                    </div>
                </div>
            @endforeach
            <a href="">See More</a>
        </div>
    </section>

    <!-- ==================== -->
    <!-- LEADERSHIP SECTION -->
    <!-- ==================== -->
    <section data-aos="fade-left" class="py-12 px-6 bg-black shadow-md">
        <div class="max-w-5xl">
            <h2 class="text-2xl text-white font-extrabold mb-6 relative pl-6 ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-3xl">
                MEET OUR LEADERS
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
            <div class="bg-[#222] p-6 rounded-lg shadow-xl text-center">
                <img src="/images/president.jpg" class="w-40 h-40 object-cover mx-auto rounded-full border-4 shadow-lg">
                <h3 class="text-xl font-semibold mt-4 text-white">Juan Dela Cruz</h3>
                <p class="text-gray-400 text-sm">President & Artistic Director</p>
                <p class="text-sm text-gray-300 mt-2">A visionary leader dedicated to preserving and promoting Philippine culture through dance.</p>
            </div>

            <div class="bg-[#222] p-6 rounded-lg shadow-xl text-center">
                <img src="/images/director.jpg" class="w-40 h-40 object-cover mx-auto rounded-full border-4 shadow-lg">
                <h3 class="text-xl font-semibold mt-4 text-white">Maria Santos</h3>
                <p class="text-gray-400 text-sm">Dance Director</p>
                <p class="text-sm text-gray-300 mt-2">An expert choreographer leading our dancers in breathtaking performances.</p>
            </div>

            <div class="bg-[#222] p-6 rounded-lg shadow-xl text-center">
                <img src="/images/manager.jpg" class="w-40 h-40 object-cover mx-auto rounded-full border-4 shadow-lg">
                <h3 class="text-xl font-semibold mt-4 text-white">Carlos Mendoza</h3>
                <p class="text-gray-400 text-sm">Operations Manager</p>
                <p class="text-sm text-gray-300 mt-2">Ensuring seamless event planning and cultural showcases worldwide.</p>
            </div>
        </div>
    </section>
    
<!-- ==================== -->
<!-- CONTACT SECTION -->
<!-- ==================== -->
<section id="contact" data-aos="fade-right" class="py-20 px-6 bg-[#121212] text-white shadow-inner relative overflow-hidden">

    <!-- Red gradient glow at top and bottom for style -->
    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-yellow-400 via-red-600 to-yellow-400 opacity-25 animate-pulse"></div>
    <div class="absolute bottom-0 left-0 w-full h-2 bg-gradient-to-r from-yellow-400 via-red-600 to-yellow-400 opacity-25 animate-pulse"></div>

    <div class="max-w-3xl mx-auto text-center relative z-10">
        <h2 class="text-4xl font-extrabold mb-4 text-yellow-400 tracking-widest drop-shadow-lg">BOOK US</h2>
        <p class="text-lg text-gray-200 mb-8">Interested in a performance or event collaboration?<br>Reach out to us at <strong class="text-yellow-400">jambangan@culture.ph</strong></p>

        <!-- Call to Action Button -->
        <a href="#booking"
           class="inline-block bg-red-600 hover:bg-yellow-400 text-white hover:text-black font-semibold py-3 px-8 rounded-full shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105 ring-2 ring-yellow-400">
            Go to Bookings →
        </a>
    </div>
</section>


    <!-- ==================== -->
    <!-- FOOTER -->
    <!-- ==================== -->
    <footer class="p-6 text-center shadow-inner text-white bg-[#121212]">
        &copy; 2025 Jambangan Cultural Dance Company. All rights reserved.
    </footer>

    <!-- ==================== -->
    <!-- SCRIPTS -->
    <!-- ==================== -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script>
        // Carousel functionality
        let currentSlide = 0;
        const slides = @json($cover_medias);
        const captions = slides.map(slide => `${slide.title ?? ''} - ${slide.subtitle ?? ''}`);
        const slideElements = document.querySelectorAll('.bg-cover');
    
        function updateSlide() {
            slideElements.forEach((slide, index) => {
                slide.style.display = index === currentSlide ? 'block' : 'none';
            });
            document.getElementById('slide-caption').textContent = captions[currentSlide];
        }
    
        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            updateSlide();
        }
    
        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            updateSlide();
        }
    
        // Initialize
        updateSlide();
        setInterval(nextSlide, 6000);
        
        // AOS initialization
        AOS.init({
            once: true,
            duration: 800,
            easing: 'ease-in-out',
        });
    </script>

    <style>
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes text-gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient-shift {
            animation: gradient-shift 8s ease infinite;
        }
        .animate-text-gradient {
            background-size: 200% 200%;
            animation: text-gradient 4s ease infinite;
        }
        .animate-bounce {
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0) translateX(-50%); }
            40% { transform: translateY(-20px) translateX(-50%); }
            60% { transform: translateY(-10px) translateX(-50%); }
        }
    </style>
</body>
</html>