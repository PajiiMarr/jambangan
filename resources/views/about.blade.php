<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Jambangan Cultural Dance</title>
    
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
    <nav x-data="{ 
        scrolled: false,
        lastScroll: 0,
        isVisible: true,
        init() {
            window.addEventListener('scroll', () => {
                const currentScroll = window.scrollY;
                this.scrolled = currentScroll > window.innerHeight - 400;
                
                // Show nav when scrolling up or at the top
                if (currentScroll < this.lastScroll || currentScroll < 100) {
                    this.isVisible = true;
                } else {
                    this.isVisible = false;
                }
                
                this.lastScroll = currentScroll;
            });
        }
    }" 
    :class="!isVisible ? 'opacity-0 translate-y-[-100%]' : 'opacity-100 translate-y-0'"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-500 ease-in-out transform">
        
        <div class="absolute inset-0 pointer-events-none"
             :class="scrolled ? 'bg-transparent' : 'bg-gradient-to-b from-black/40 to-transparent'"
             class="transition-all duration-500">
        </div>

        <div class="relative container mx-auto flex justify-between items-center p-4">
            <!-- Logo and Main Navigation -->
            <div class="flex items-center gap-8">
                <div class="flex items-center gap-4">
                    <a href="/" class="group">
                        <img src="{{ $general_contents->logo_path ? $general_contents->logo_path : asset('images/LogoColored.png') }}" alt="Jambangan Logo" class="h-25 w-auto transition-transform duration-300 group-hover:scale-105">
                    </a>
                </div>
                <ul class="flex space-x-6 font-thin">
                    <li><a href="{{ route('about-public') }}" class="relative text-lg text-white hover:text-yellow-400 transition duration-300 group">
                        ABOUT US<span class="absolute left-0 bottom-0 w-0 h-0.5 bg-yellow-400 transition-all duration-300 group-hover:w-full"></span>
                    </a></li>
                    <li><a href="{{ route('performances-public') }}" class="relative text-lg text-white hover:text-red-500 transition duration-300 group">
                        PERFORMANCES<span class="absolute left-0 bottom-0 w-0 h-0.5 bg-red-500 transition-all duration-300 group-hover:w-full"></span>
                    </a></li>
                    <li><a href="{{ route('events-public') }}" class="relative text-lg text-white hover:text-red-500 transition duration-300 group">
                        EVENTS<span class="absolute left-0 bottom-0 w-0 h-0.5 bg-red-500 transition-all duration-300 group-hover:w-full"></span>
                    </a></li>
                    <li><a href="{{ route('posts-public') }}" class="relative text-lg text-white hover:text-yellow-400 transition duration-300 group">
                        POSTS<span class="absolute left-0 bottom-0 w-0 h-0.5 bg-yellow-400 transition-all duration-300 group-hover:w-full"></span>
                    </a></li>
                </ul>
            </div>

            <!-- Utility Buttons -->
            <x-search-booking-icons />
        </div>
    </nav>

    <!-- ==================== -->
    <!-- HERO SECTION -->
    <!-- ==================== -->
    <section class="relative h-[60vh] flex items-center justify-center overflow-hidden"
        data-aos="fade-zoom-in"
        data-aos-easing="ease-in-back"
        data-aos-duration="1000">
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 to-transparent z-10"></div>
        <div class="absolute inset-0 bg-[url('images/best2.png')] bg-cover bg-center transform scale-110"></div>
        <div class="relative z-20 text-center px-4">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white mb-4">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-red-500 to-yellow-400 animate-text-gradient">
                    About Jambangan
                </span>
            </h1>
            <p class="text-xl sm:text-2xl text-gray-200">The Dance Ambassador of WMSU</p>
        </div>
    </section>

    <!-- ==================== -->
    <!-- MISSION & VISION SECTION -->
    <!-- ==================== -->
    <section class="py-12 sm:py-24 bg-black relative overflow-hidden"
        data-aos="fade-up"
        data-aos-duration="1000">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Mission -->
                <div class="relative z-10">
                    <h2 class="text-xl sm:text-2xl text-white font-extrabold mb-4 sm:mb-6 relative pl-6 ml-4 sm:ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-2xl sm:before:text-3xl">
                        OUR MISSION
                    </h2>
                    <p class="text-lg sm:text-xl text-gray-300 leading-relaxed">
                        {{ $general_contents['mission'] ?? 'To preserve and promote the rich cultural heritage of the Philippines through traditional dance performances, while fostering unity and pride among our members and audiences.' }}
                    </p>
                </div>

                <!-- Vision -->
                <div class="relative z-10">
                    <h2 class="text-xl sm:text-2xl text-white font-extrabold mb-4 sm:mb-6 relative pl-6 ml-4 sm:ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-2xl sm:before:text-3xl">
                        OUR VISION
                    </h2>
                    <p class="text-lg sm:text-xl text-gray-300 leading-relaxed">
                        {{ $general_contents['vision'] ?? 'To be recognized as the premier cultural dance group in the region, inspiring future generations to appreciate and continue our cultural traditions.' }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== -->
    <!-- OUR STORY SECTION -->
    <!-- ==================== -->
    <section id="aboutUs" 
        class="py-12 sm:py-24 bg-[#121212] shadow-md relative" 
        style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0.9) 3%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0.9) 97%, rgba(0, 0, 0, 1) 100%), url('images/best2.png'); background-size: cover; background-position: center;"
        data-aos="fade-up"
        data-aos-duration="1000">
        
        <div class="absolute inset-0 bg-black opacity-80"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto text-base relative z-10">
                <h2 class="text-xl sm:text-2xl text-white font-extrabold mb-4 sm:mb-6 relative pl-6 ml-4 sm:ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-2xl sm:before:text-3xl">
                    OUR STORY
                </h2>
                <div class="my-12 sm:my-24 max-w-4xl">
                    <p class="text-xl sm:text-2xl md:text-3xl font-thin text-gray-300 leading-relaxed">
                        {{ $general_contents['about_us'] }}
                    </p>
                </div>
            </div>  
        </div>
    </section>

    <!-- ==================== -->
    <!-- VALUES SECTION -->
    <!-- ==================== -->
    <section class="py-12 sm:py-24 bg-black relative overflow-hidden"
        data-aos="fade-up"
        data-aos-duration="1000">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl sm:text-2xl text-white font-extrabold mb-12 sm:mb-16 relative pl-6 ml-4 sm:ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-2xl sm:before:text-3xl">
                OUR CORE VALUES
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-[#121212] p-6 rounded-lg transform transition-all duration-300 hover:scale-105">
                    <div class="text-yellow-400 text-4xl mb-4">🎭</div>
                    <h3 class="text-xl font-bold text-white mb-4">Cultural Preservation</h3>
                    <p class="text-gray-300">We are committed to preserving and promoting the rich cultural heritage of the Philippines through traditional dance.</p>
                </div>
                <div class="bg-[#121212] p-6 rounded-lg transform transition-all duration-300 hover:scale-105">
                    <div class="text-yellow-400 text-4xl mb-4">🤝</div>
                    <h3 class="text-xl font-bold text-white mb-4">Unity & Community</h3>
                    <p class="text-gray-300">We foster a strong sense of community and unity among our members and audiences.</p>
                </div>
                <div class="bg-[#121212] p-6 rounded-lg transform transition-all duration-300 hover:scale-105">
                    <div class="text-yellow-400 text-4xl mb-4">🌟</div>
                    <h3 class="text-xl font-bold text-white mb-4">Excellence</h3>
                    <p class="text-gray-300">We strive for excellence in every performance, maintaining the highest standards of artistic expression.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== -->
    <!-- LEADERSHIP TEAM SECTION -->
    <!-- ==================== -->
    <section class="py-12 sm:py-24 bg-[#121212] relative overflow-hidden"
        data-aos="fade-up"
        data-aos-duration="1000">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl sm:text-2xl text-white font-extrabold mb-12 sm:mb-16 relative pl-6 ml-4 sm:ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-2xl sm:before:text-3xl">
                OUR LEADERSHIP TEAM
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($officers as $officer)
                    <div class="group bg-black rounded-lg shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105"
                        data-aos="fade-up"
                        data-aos-delay="{{ $loop->index * 100 }}">
                        <!-- Officer Image -->
                        <div class="relative h-64 overflow-hidden">
                            @if($officer->media)
                                <img src="{{ 'http://localhost:9000/my-bucket/' . $officer->media->file_data }}" 
                                     alt="{{ $officer->name }}"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-[#EAB308] to-[#EF4444] flex items-center justify-center">
                                    <span class="text-white text-2xl font-bold">Jambangan</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        </div>

                        <!-- Officer Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-2 group-hover:text-[#EAB308] transition-colors duration-300">
                                {{ $officer->name }}
                            </h3>
                            <p class="text-[#EAB308] font-semibold mb-4">
                                {{ $officer->position }}
                            </p>
                            <div class="space-y-2 text-gray-300">
                                @if($officer->email)
                                    <p class="flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $officer->email }}
                                    </p>
                                @endif
                                @if($officer->phone)
                                    <p class="flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        {{ $officer->phone }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ==================== -->
    <!-- CONTACT SECTION -->
    <!-- ==================== -->
    <section id="contact" 
        class="py-12 sm:py-20 bg-[#121212] text-white shadow-inner relative overflow-hidden"
        data-aos="fade-up"
        data-aos-duration="1000">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Red gradient glow at top and bottom for style -->
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-yellow-400 via-red-600 to-yellow-400 opacity-25 animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-full h-2 bg-gradient-to-r from-yellow-400 via-red-600 to-yellow-400 opacity-25 animate-pulse"></div>

            <div class="max-w-3xl mx-auto text-center relative z-10">
                <h2 class="text-3xl sm:text-4xl font-extrabold mb-4 text-yellow-400 tracking-widest drop-shadow-lg">CONTACT US</h2>
                <p class="text-base sm:text-lg text-gray-200 mb-6 sm:mb-8">
                    Interested in a performance or event collaboration?<br>
                    Reach out to us at <strong class="text-yellow-400">jambangan@culture.ph</strong>
                </p>

                <div class="max-w-md mx-auto mt-12">
                    <div class="bg-black/50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-yellow-400 mb-4">Visit Us</h3>
                        <p class="text-gray-300">
                            Western Mindanao State University<br>
                            Zamboanga City, Philippines
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== -->
    <!-- FOOTER SECTION -->
    <!-- ==================== -->
    <footer class="p-4 sm:p-6 shadow-inner text-white bg-[#121212] text-sm sm:text-base">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-left">
                &copy; 2025 Jambangan Cultural Dance Company. All rights reserved.
            </div>
            
            <!-- Social Links -->
            <div class="flex items-center">
                <h3 class="text-lg sm:text-xl font-semibold mr-4 text-yellow-400">Follow Us</h3>
                <div class="flex space-x-4">
                    <a href="https://facebook.com" target="_blank" class="group">
                        <svg class="w-8 h-8 text-white hover:text-yellow-400 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                        </svg>
                    </a>
                    <a href="https://youtube.com" target="_blank" class="group">
                        <svg class="w-8 h-8 text-white hover:text-red-500 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    <a href="https://instagram.com" target="_blank" class="group">
                        <svg class="w-8 h-8 text-white hover:text-yellow-400 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.281-.059 1.689-.073 4.849-.073zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="https://tiktok.com" target="_blank" class="group">
                        <svg class="w-8 h-8 text-white hover:text-red-500 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.53.02C13.84 0 15.14.01 16.44 0c.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ==================== -->
    <!-- SCRIPTS -->
    <!-- ==================== -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            once: false,
            duration: 800,
            easing: 'ease-in-out',
            offset: 100,
            delay: 100,
        });
    </script>

    <style>
        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Optional: Add animation for section backgrounds */
        section {
            transition: background-color 0.3s ease-in-out;
        }

        /* Improve animation performance */
        section {
            will-change: transform, opacity;
            backface-visibility: hidden;
        }
    </style>
</body>
</html> 