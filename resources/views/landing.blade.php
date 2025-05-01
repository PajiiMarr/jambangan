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
                        <img src="{{ $general_contents && $general_contents->logo_path ? $general_contents->logo_path : asset('images/LogoColored.png') }}" alt="Jambangan Logo" class="h-25 w-auto transition-transform duration-300 group-hover:scale-105">
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
            <div class="flex items-center space-x-4">
                <div x-data="{ searchOpen: false }" class="relative">
                    <button @click="searchOpen = true" class="group relative cursor-pointer">
                        <img src="{{ asset('images/search.svg') }}" 
                             alt="Search" 
                             class="h-8 w-8 transition-all duration-300 group-hover:scale-110 group-hover:rotate-12"
                             :class="searchOpen ? 'opacity-0 scale-0' : 'opacity-100 scale-100'">
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-red-500 to-yellow-400 transition-all duration-300 group-hover:w-full"></span>
                    </button>
                    
                    <!-- Search Box -->
                    <div x-show="searchOpen" 
                         @click.away="searchOpen = false"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 -top-1 w-64">
                        <div class="relative">
                            <input type="text" 
                                   class="w-full rounded-lg bg-transparent border border-white/20 px-4 py-2 pl-10 text-white placeholder-white/50 focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50"
                                   placeholder="Search..."
                                   x-model="searchQuery"
                                   @keyup.enter="performSearch">
                            <div class="absolute left-3 top-2">
                                <svg class="h-5 w-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('bookings-public') }}" class="group relative">
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
                <div class="bg-gradient-to-b absolute inset-0 w-full h-full bg-cover bg-center transition-opacity duration-300 ease-in-out opacity-0"
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
            <div class="shadow-text relative z-10 text-center drop-shadow-2xl px-4 sm:px-6">
                <h1 class="text-3xl sm:text-4xl md:text-5xl drop-shadow-2xl font-extrabold">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-red-500 to-yellow-400 animate-text-gradient">
                        Jambangan
                    </span>
                    <span class="text-white block sm:inline">: the Dance Ambassador of WMSU</span>
                </h1>
                <p class="text-lg sm:text-xl mt-4 drop-shadow-2xl" id="slide-caption"></p>
            </div>

            <!-- Progress Bar -->
            <div class="absolute bottom-0 left-0 w-full h-1 bg-black/30 z-20">
                <div id="progress-bar" class="h-full bg-gradient-to-r from-yellow-400 via-red-500 to-yellow-400" style="width: 0%"></div>
            </div>

            <!-- Carousel Controls -->
            <button onclick="prevSlide()" 
                    class="absolute left-2 sm:left-4 z-10 bg-black/30 hover:bg-yellow-400/20 text-white hover:text-yellow-400 px-2 sm:px-4 py-2 rounded-full text-xl sm:text-2xl transition-all duration-300 border border-transparent hover:border-yellow-400">
                &lt;
            </button>
            <button onclick="nextSlide()" 
                    class="absolute right-2 sm:right-4 z-10 bg-black/30 hover:bg-red-500/20 text-white hover:text-red-500 px-2 sm:px-4 py-2 rounded-full text-xl sm:text-2xl transition-all duration-300 border border-transparent hover:border-red-500">
                &gt;
            </button>
        </div>
    </section>

    <!-- ==================== -->
    <!-- MAIN CONTENT SECTIONS -->
    <!-- ==================== -->
    <main class="space-y-24">
        <!-- About Section -->
        <section id="aboutUs" 
            data-aos="fade-up" 
            data-aos-duration="1000" 
            class="py-12 sm:py-24 bg-[#121212] shadow-md relative" 
            style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0.9) 3%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0.9) 97%, rgba(0, 0, 0, 1) 100%), url('images/best2.png'); background-size: cover; background-position: center;">
            
            <div class="absolute inset-0 bg-black opacity-80"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-5xl mx-auto text-base relative z-10">
                    <h2 class="text-xl sm:text-2xl text-white font-extrabold mb-4 sm:mb-6 relative pl-6 ml-4 sm:ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-2xl sm:before:text-3xl">
                        OUR STORY
                    </h2>
                    <div class="my-12 sm:my-24 max-w-4xl">
                        <p class="text-xl sm:text-2xl md:text-3xl font-thin text-gray-300 leading-relaxed">
                            {{ $general_contents?->about_us ?? 'About us information coming soon.' }}
                        </p>
                        <div class="mt-8">
                            <a href="/about" 
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-red-500 hover:from-red-500 hover:to-yellow-400 text-black hover:text-white rounded-full font-semibold transition-all duration-300 transform hover:scale-105">
                                Learn More About Us
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>  
            </div>
        </section>

        <!-- Performances Section -->
        <section id="performances" 
            data-aos="fade-right" 
            data-aos-duration="800" 
            data-aos-offset="300" 
            class="py-8 sm:py-16 bg-black">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-xl sm:text-2xl text-white font-extrabold mb-12 sm:mb-16 relative pl-6 ml-4 sm:ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-2xl sm:before:text-3xl z-50">
                    PERFORMANCES
                </h2>

                <!-- Performance Carousel -->
                <div class="relative z-10">
                    <!-- Performance Cards -->
                    <div class="flex overflow-x-auto space-x-4 sm:space-x-6 pb-4 snap-x snap-mandatory [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                        @foreach ($performances as $performance)
                            <div class="group relative flex-shrink-0 min-w-[220px] sm:min-w-[280px] h-[380px] sm:h-[480px] bg-[#1E1E1E] rounded-lg shadow-2xl overflow-hidden transition-all duration-300 transform hover:scale-105 hover:min-w-[280px] hover:sm:min-w-[350px] hover:h-[420px] hover:sm:h-[520px] snap-start mx-2">
                                <!-- Image Container -->
                                <div class="absolute inset-0 overflow-hidden">
                                    @if ($performance->media)
                                        <img src="{{ 'http://localhost:9000/my-bucket/' . $performance->media->file_data }}"
                                             alt="{{ $performance->title }}"
                                             class="w-full h-full object-cover absolute inset-0 z-0 transition-transform duration-500 group-hover:scale-110">
                                    @endif
                                </div>

                                <!-- Smoke Effect Overlay -->
                                <div class="absolute inset-0 z-10 bg-gradient-to-t from-black/90 via-black/60 to-black/40 transition-opacity duration-500 group-hover:opacity-0"></div>

                                <!-- Content -->
                                <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-6 z-20">
                                    <div class="space-y-2.5 sm:space-y-3">
                                        <span class="inline-block px-2.5 py-1 text-xs sm:text-sm font-semibold text-yellow-400 bg-black/50 rounded-full">
                                            {{ $performance->type }}
                                        </span>
                                        <h3 class="text-lg sm:text-xl font-bold text-white group-hover:text-yellow-400 transition-colors duration-300">
                                            {{ $performance->title }}
                                        </h3>
                                        <p class="text-xs sm:text-sm text-gray-300 line-clamp-2 leading-relaxed">
                                            {{ $performance->description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Navigation Arrows -->
                    <button class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-black/50 hover:bg-yellow-400/20 text-white hover:text-yellow-400 p-2 rounded-full transition-all duration-300 z-30" onclick="scrollPerformances('left')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-black/50 hover:bg-red-500/20 text-white hover:text-red-500 p-2 rounded-full transition-all duration-300 z-30" onclick="scrollPerformances('right')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Single View More Button -->
                    <div class="mt-8 text-center">
                        <a href="/performances" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-red-500 hover:from-red-500 hover:to-yellow-400 text-black hover:text-white rounded-full font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            View All Performances
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Events Section -->
        <section id="upcoming-events" class="py-8 sm:py-12 bg-black shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-xl sm:text-2xl text-white font-extrabold mb-4 sm:mb-6 relative pl-6 ml-4 sm:ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-2xl sm:before:text-3xl">
                    UPCOMING EVENTS
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    @foreach ($events as $event)
                        <div class="relative bg-black rounded-lg shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105 border border-gray-800 group"
                             data-aos="fade-up" 
                             data-aos-delay="{{ $loop->index * 100 }}">
                            <!-- Image Container -->
                            <div class="h-40 sm:h-48 bg-gray-900 relative">
                                <img src="{{ asset('images/placeholder.png') }}" alt="Event Image" class="w-full h-full object-cover opacity-50 group-hover:opacity-70 transition-opacity duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                            </div>

                            <!-- Date Badge -->
                            <div class="absolute top-2 sm:top-4 left-2 sm:left-4 bg-black text-white rounded-lg overflow-hidden border border-gray-700 group-hover:border-[#EAB308] transition-colors duration-300">
                                <div class="px-4 sm:px-6 py-2 text-center">
                                    <span class="text-xl sm:text-2xl font-bold block text-gray-400 group-hover:text-[#EAB308]">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('M') }}
                                    </span>
                                    <span class="text-2xl sm:text-4xl font-black block">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Event Info -->
                            <div class="p-4 sm:p-6">
                                <h3 class="text-lg sm:text-xl font-bold text-white">
                                    {{ $event->title }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-2">
                                    {{ $event->location }}
                                </p>
                                <div class="mt-4">
                                    <a href="{{ route('events.show', $event->event_id) }}" class="inline-block bg-black text-white px-3 sm:px-4 py-2 rounded-lg border border-gray-800 hover:border-[#8B0000] transition-all duration-300 text-sm sm:text-base group">
                                        Learn More 
                                        <span class="inline-block transform translate-x-0 group-hover:translate-x-1 transition-transform duration-300">→</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Posts Section -->
        <section id="posts" class="py-8 sm:py-12 bg-black shadow-md"
            data-aos="fade-up"
            data-aos-duration="800"
            data-aos-offset="200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-xl sm:text-2xl text-white font-extrabold mb-4 sm:mb-6 relative pl-6 ml-4 sm:ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-2xl sm:before:text-3xl">
                    RECENT POSTS
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    @foreach ($posts->take(3) as $index => $post)
                        <div class="group bg-[#222] rounded-lg shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105"
                             data-aos="fade-up"
                             data-aos-delay="{{ $index * 100 }}">
                            
                            <!-- Post Image -->
                            <div class="relative h-48 overflow-hidden">
                                @if($post->media->isNotEmpty())
                                    <img src="{{ 'http://localhost:9000/my-bucket/' . $post->media->first()->file_data }}" 
                                         alt="{{ $post->title }}"
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#EAB308] to-[#EF4444] flex items-center justify-center">
                                        <span class="text-white text-2xl font-bold">Jambangan</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                            </div>

                            <!-- Post Content -->
                            <div class="p-4 sm:p-6">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-sm text-[#EAB308]">{{ \Carbon\Carbon::parse($post->created_at)->format('M d, Y') }}</span>
                                    <span class="text-sm text-gray-400">•</span>
                                    <span class="text-sm text-gray-400">{{ $post->media->count() }} media</span>
                                </div>
                                
                                <h3 class="text-lg sm:text-xl font-semibold text-white mb-2 group-hover:text-[#EAB308] transition-colors duration-300">
                                    {{ $post->title }}
                                </h3>
                                
                                <p class="text-sm text-gray-300 mb-4 line-clamp-2">
                                    {{ $post->content }}
                                </p>

                                <a href="/posts/{{ $post->id }}" 
                                   class="inline-flex items-center text-sm text-[#EAB308] hover:text-[#EF4444] transition-colors duration-300">
                                    Read More
                                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- View All Posts Button -->
                <div class="mt-8 text-center">
                    <a href="/posts" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#EAB308] to-[#EF4444] hover:from-[#EF4444] hover:to-[#EAB308] text-black hover:text-white rounded-full font-semibold transition-all duration-300 transform hover:scale-105">
                        View All Posts
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" 
            class="py-12 sm:py-20 bg-[#121212] text-white shadow-inner relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Red gradient glow at top and bottom for style -->
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-yellow-400 via-red-600 to-yellow-400 opacity-25 animate-pulse"></div>
                <div class="absolute bottom-0 left-0 w-full h-2 bg-gradient-to-r from-yellow-400 via-red-600 to-yellow-400 opacity-25 animate-pulse"></div>

                <div class="max-w-3xl mx-auto text-center relative z-10">
                    <h2 class="text-3xl sm:text-4xl font-extrabold mb-4 text-yellow-400 tracking-widest drop-shadow-lg">BOOK US</h2>
                    <p class="text-base sm:text-lg text-gray-200 mb-6 sm:mb-8">
                        Interested in a performance or event collaboration?<br>
                        Reach out to us at <strong class="text-yellow-400">jambangan@culture.ph</strong>
                    </p>

                    <a href="{{ route('bookings-public') }}"
                       class="inline-block bg-red-600 hover:bg-yellow-400 text-white hover:text-black font-semibold py-2 sm:py-3 px-6 sm:px-8 rounded-full shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105 ring-2 ring-yellow-400 text-sm sm:text-base">
                        Go to Bookings →
                    </a>
                </div>
            </div>
        </section>
    </main>

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
        // Carousel functionality
        let currentSlide = 0;
        const slides = @json($cover_medias);
        const captions = slides.map(slide => `${slide.title ?? ''} - ${slide.subtitle ?? ''}`);
        const slideElements = document.querySelectorAll('.bg-cover');
        const progressBar = document.getElementById('progress-bar');
        let progressInterval;
        let progress = 0;
        const SLIDE_DURATION = 12000; // 12 seconds in milliseconds
        const PROGRESS_STEPS = 200;
        const PROGRESS_INTERVAL = SLIDE_DURATION / PROGRESS_STEPS; // 60ms per step
    
        function updateSlide() {
            // First fade out current slide
            slideElements[currentSlide].style.opacity = '0';
            
            // After fade out, update display and fade in new slide
            setTimeout(() => {
                slideElements.forEach((slide, index) => {
                    slide.style.display = index === currentSlide ? 'block' : 'none';
                });
                document.getElementById('slide-caption').textContent = captions[currentSlide];
                slideElements[currentSlide].style.opacity = '1';
            }, 300); // Match the CSS transition duration
        }
    
        function resetProgress() {
            progress = 0;
            progressBar.style.transition = 'none';
            progressBar.style.width = '0%';
            // Force a reflow
            progressBar.offsetHeight;
            progressBar.style.transition = 'width 100ms linear';
            clearInterval(progressInterval);
            startProgress();
        }
    
        function startProgress() {
            progressInterval = setInterval(() => {
                progress += 0.5; // Adjusted for 200 steps
                progressBar.style.width = `${progress}%`;
                if (progress >= 100) {
                    clearInterval(progressInterval);
                    nextSlide();
                }
            }, PROGRESS_INTERVAL);
        }
    
        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            updateSlide();
            // Wait for the slide transition to complete before resetting progress
            setTimeout(resetProgress, 50);
        }
    
        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            updateSlide();
            // Wait for the slide transition to complete before resetting progress
            setTimeout(resetProgress, 50);
        }
    
        // Initialize
        updateSlide();
        startProgress();
        
        // New AOS initialization
        AOS.init({
            once: false,
            duration: 800,
            easing: 'ease-in-out',
            offset: 100,
            delay: 100,
        });

        // Performance Carousel Navigation
        function scrollPerformances(direction) {
            const container = document.querySelector('.flex.overflow-x-auto');
            const scrollAmount = 400; // Adjust this value to control scroll distance
            
            if (direction === 'left') {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }
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

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('search', () => ({
                searchOpen: false,
                searchQuery: '',
                searchResults: [],
                
                performSearch() {
                    // This is a placeholder for actual search functionality
                    // You would typically make an API call here
                    this.searchResults = [
                        {
                            id: 1,
                            type: 'Performance',
                            title: 'Sample Performance',
                            description: 'A beautiful cultural dance performance',
                            url: '#performances'
                        },
                        {
                            id: 2,
                            type: 'Event',
                            title: 'Upcoming Event',
                            description: 'Join us for an amazing cultural showcase',
                            url: '#upcoming-events'
                        },
                        {
                            id: 3,
                            type: 'Post',
                            title: 'Latest News',
                            description: 'Read about our latest achievements',
                            url: '#posts'
                        }
                    ];
                }
            }));
        });
    </script>
</body>
</html>