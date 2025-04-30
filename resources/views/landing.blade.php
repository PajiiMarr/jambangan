<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jambangan Cultural Dance</title>
    @vite(['resources/css/landingpage.css', 'resources/js/app.js'])
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js" defer></script>
    <link href="https://fonts.google.com/specimen/DM+Serif+Text?categoryFilters=Feeling:%2FExpressive%2FBusiness" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />


</head>

    <nav 
    x-data="{ scrolled: false }" 
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > window.innerHeight - 100)" 
    :class="scrolled 
        ? 'bg-[#0D0D0D] bg-opacity-95 backdrop-blur-sm shadow-md' 
        : 'bg-transparent'" 
    class="fixed top-0 left-0 w-full z-50 transition-all duration-500 ease-in-out"

    <div class="absolute inset-0 pointer-events-none" 
         :class="scrolled 
            ? '' 
            : 'bg-gradient-to-b from-[#0d0d0d]/70 to-transparent'">
    </div>

    <div class="relative container mx-auto flex justify-between items-center p-4">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo.svg') }}" alt="Jambangan Logo" class="h-12 w-auto">
            <h1 class="text-xl font-bold tracking-widest uppercase">{{ $general_contents['site_title']}}</h1>
        </div>

        <ul class="flex space-x-6 font-semibold">
            <li><a href="#" class="text-lg hover:text-white transition duration-300">Home</a></li>
            <li><a href="#aboutUs" class="text-lg hover:text-white transition duration-300">About Us</a></li>
            <li><a href="#events" class="text-lg hover:text-white transition duration-300">Events</a></li>
            <li><a href="#events" class="text-lg hover:text-white transition duration-300">Posts</a></li>
            <li><a href="#performances" class="text-lg hover:text-white transition duration-300">Performances</a></li>
            <li><a href="#contact" class="text-lg hover:text-white transition duration-300">Contact</a></li>
        </ul>
    </div>
</nav>

    

    <!-- 🎭 Hero Section with AOS Animation -->
    <section data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-duration="1000" class="relative">
        <div class="relative w-full h-screen flex items-center justify-center text-white overflow-hidden">
    
            <!-- Background Slides -->
            @foreach($cover_medias as $index => $item)
                <div class="bg-gradient-to-b absolute inset-0 w-full h-full bg-cover bg-center transition-opacity duration-1000 ease-in-out"
                    style="background-image: url('{{ isset($item['file_data']) ? 'http://127.0.0.1:9000/my-bucket/' . $item['file_data'] : asset('images/placeholder.png') }}');"
                    @if ($index != 0) style="display: none;" @endif>
                </div>
            @endforeach
    
            <div class="absolute inset-0 bg-[#121212]" @if($cover_medias->isEmpty()) style="display: block;" @else style="display: none;" @endif></div>
    
            <!-- Text Overlay -->
            <div class="shadow-text relative z-10 text-center drop-shadow-2xl px-6">
                <h1 class="text-5xl font-bold drop-shadow-2xl">Jambangan: the Dance Ambassador of WMSU</h1>
                <p class="text-xl mt-4 drop-shadow-2xl" id="slide-caption"></p>
            </div>
    
            <!-- Navigation Buttons -->
            <button onclick="prevSlide()" class="absolute left-4 bg-opacity-0 hover:bg-opacity-0 text-white px-4 py-2 rounded-full text-2xl">
                &lt;
            </button>
            <button onclick="nextSlide()" class="absolute right-4 bg-opacity-0 hover:bg-opacity-0 text-white px-4 py-2 rounded-full text-2xl">
                &gt;
            </button>
    
        </div>
    </section>
    
    

    <!-- ✨ About Section -->
    <section id="aboutUs" data-aos="fade-right" class="py-12 px-6 bg-[#121212] shadow-md">
        <div class="max-w-SxL mx-auto text-center">
            <h2 class="text-4xl font-extrabold mb-6">About Us</h2>
            <p class="text-lg text-gray-300 leading-relaxed">
                {{ $general_contents['about_us'] }}
            </p>
        </div>
    </section>

    <!-- Calendar of Events -->
    <section data-aos="fade-left" class="py-12 px-6 bg-[#121212] shadow-md">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="text-4xl font-extrabold mb-6 tracking-wide sm:text-3xl md:text-4xl lg:text-5xl">Calendar of Events</h2>
            <p class="text-lg text-gray-300 mb-8 sm:text-base md:text-lg lg:text-xl">Stay updated with our upcoming cultural performances and activities.</p>
        </div>
        
        <div class="flex justify-center items-center max-w-6xl mx-auto space-x-6">
            @foreach ($events as $event)
                <div class="relative w-[350px] h-[300px] bg-[#1D1D1D] rounded-lg shadow-2xl overflow-hidden transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <!-- Image Placeholder with Gradient -->
                    <div class="h-40 bg-cover bg-center flex items-center justify-center text-white text-2xl font-semibold relative sm:text-xl md:text-2xl lg:text-3xl" style="background-image: url('{{ asset('images/placeholder.png') }}');">
                        <div class="absolute inset-0 bg-gradient-to-r from-black opacity-50"></div> <!-- Gradient overlay -->
                        <img src="{{ asset('images/placeholder.png') }}" alt="Image Placeholder" class="w-full h-full object-cover">
                    </div>
                    <!-- Date with Gradient Background -->
                    <div class="absolute top-4 left-4 font-bold text-5xl z-10 sm:text-4xl md:text-5xl lg:text-6xl">
                        <span class="block">{{ \Carbon\Carbon::parse($event->start)->format('M') }}</span>
                        <span class="block text-6xl sm:text-5xl md:text-6xl lg:text-7xl">{{ \Carbon\Carbon::parse($event->start)->format('d') }}</span>
                    </div>
                    <!-- Event Info with More Padding -->
                    <div class="p-5">
                        <h3 class="text-2xl font-semibold sm:text-xl md:text-2xl lg:text-3xl">{{ $event->title }}</h3>
                        <p class="text-gray-300 text-sm mt-4 sm:text-xs md:text-sm lg:text-base">{{ $event->location }}</p>
                    </div>
                </div>
            @endforeach
            <a href="">See More</a>
        </div>
        
    </section>

    <!-- 🕊 Performances Showcase -->
    <section id="performances" data-aos="fade-right" class="py-16 bg-[#121212]">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-12 tracking-wide text-white">Our Performances</h2>
            <div class="flex flex-wrap justify-center gap-8">
                @foreach ($performances as $performance)
                <img src="{{ 'http://localhost:9000/my-bucket/' . $performance->media->file_data }}" alt="{{ $performance->title }}" class="w-50 h-50 object-cover rounded-t-lg">
                    <div class="relative w-[300px] sm:w-[340px] md:w-[350px] h-[420px] bg-[#1E1E1E] rounded-lg shadow-2xl overflow-hidden transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                        <div class="h-64 bg-cover bg-center relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-black opacity-40"></div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-xl font-semibold text-[#FFD700] mb-2">{{ $performance->title }}</h3>
                            <p class="text-gray-300 text-sm">{{ $performance->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    


    <!-- 👑 Leadership Section -->
    <section data-aos="fade-left" class="py-12 px-6 bg-[#121212] shadow-md">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="text-4xl font-extrabold mb-6 tracking-wide">Meet Our Leaders</h2>
            <p class="text-lg text-gray-300 mb-8">Guiding the Jambangan Cultural Dance Company with passion and dedication.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
            <!-- 🎭 President Card -->
            <div class="bg-[#222] p-6 rounded-lg shadow-xl text-center">
                <img src="/images/president.jpg" class="w-40 h-40 object-cover mx-auto rounded-full border-4 shadow-lg">
                <h3 class="text-xl font-semibold mt-4"">Juan Dela Cruz</h3>
                <p class="text-gray-400 text-sm">President & Artistic Director</p>
                <p class="text-sm text-gray-300 mt-2">A visionary leader dedicated to preserving and promoting Philippine culture through dance.</p>
            </div>

            <!-- 🎭 Director Card -->
            <div class="bg-[#222] p-6 rounded-lg shadow-xl text-center">
                <img src="/images/director.jpg" class="w-40 h-40 object-cover mx-auto rounded-full border-4 shadow-lg">
                <h3 class="text-xl font-semibold mt-4"">Maria Santos</h3>
                <p class="text-gray-400 text-sm">Dance Director</p>
                <p class="text-sm text-gray-300 mt-2">An expert choreographer leading our dancers in breathtaking performances.</p>
            </div>

            <!-- 🎭 Operations Manager Card -->
            <div class="bg-[#222] p-6 rounded-lg shadow-xl text-center">
                <img src="/images/manager.jpg" class="w-40 h-40 object-cover mx-auto rounded-full border-4 shadow-lg">
                <h3 class="text-xl font-semibold mt-4"">Carlos Mendoza</h3>
                <p class="text-gray-400 text-sm">Operations Manager</p>
                <p class="text-sm text-gray-300 mt-2">Ensuring seamless event planning and cultural showcases worldwide.</p>
            </div>
        </div>
    </section>
    
    <!--Contact Section-->
    <section id="contact" data-aos="fade-right" class="py-12 px-6 bg-[#8B0000] text-white shadow-xl">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-6 tracking-wide">Book us</h2>
            <p class="text-lg">Interested in a performance? Contact us at <strong class="">jambangan@culture.ph</strong></p>
        </div>
    </section>

    <!-- 🏛 Footer -->
    <footer class="p-6 text-center shadow-inner">
        &copy; 2025 Jambangan Cultural Dance Company. All rights reserved.
    </footer>


    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
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
    
        // Initialize the first slide
        updateSlide();
    
        // Auto-rotate slides every 6 seconds
        setInterval(nextSlide, 6000);
    </script>
    <script>
        AOS.init({
            once: true,
            duration: 800,
            easing: 'ease-in-out',
        });
    </script>
</body>
</html>