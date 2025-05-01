
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts - Jambangan Cultural Dance</title>
    
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
    <!-- Navigation Section -->
    <nav x-data="{ 
        scrolled: false,
        lastScroll: 0,
        isVisible: true,
        init() {
            window.addEventListener('scroll', () => {
                const currentScroll = window.scrollY;
                this.scrolled = currentScroll > window.innerHeight - 400;
                
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

    <!-- Hero Section -->
    <section class="relative h-[40vh] flex items-center justify-center overflow-hidden"
        data-aos="fade-zoom-in"
        data-aos-easing="ease-in-back"
        data-aos-duration="1000">
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 to-transparent z-10"></div>
        <div class="absolute inset-0 bg-[url('images/best2.png')] bg-cover bg-center transform scale-110"></div>
        <div class="relative z-20 text-center px-4">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white mb-4">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-red-500 to-yellow-400 animate-text-gradient">
                    Latest Updates
                </span>
            </h1>
            <p class="text-xl sm:text-2xl text-gray-200">Stay connected with our latest news and updates</p>
        </div>
    </section>

    <!-- Posts Section -->
    <section class="py-12 sm:py-24 bg-black relative overflow-hidden"
        data-aos="fade-up"
        data-aos-duration="1000">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Posts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <article class="bg-[#121212] rounded-lg shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-[1.02]">
                        <!-- Post Image -->
                        @if($post->media->isNotEmpty())
                            <div class="relative h-64 overflow-hidden">
                                <img src="{{ 'http://localhost:9000/my-bucket/' . $post->media->first()->file_data }}" 
                                     alt="{{ $post->title }}"
                                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            </div>
                        @endif

                        <!-- Post Content -->
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="text-sm text-yellow-400">{{ \Carbon\Carbon::parse($post->created_at)->format('M d, Y') }}</span>
                                @if($post->event_id)
                                    <span class="text-sm text-gray-400">•</span>
                                    <span class="text-sm text-gray-400">Event</span>
                                @endif
                                @if($post->performance_id)
                                    <span class="text-sm text-gray-400">•</span>
                                    <span class="text-sm text-gray-400">Performance</span>
                                @endif
                            </div>

                            <h2 class="text-2xl font-bold text-white mb-4 hover:text-yellow-400 transition-colors duration-300">
                                <a href="{{ route('post.details', $post->post_id) }}">{{ $post->title }}</a>
                            </h2>
                            
                            <p class="text-gray-300 mb-6 line-clamp-3">{{ $post->content }}</p>

                            <!-- Post Actions -->
                            <div class="flex items-center justify-between">
                                <a href="{{ route('post.details', $post->post_id) }}" 
                                   class="text-yellow-400 hover:text-yellow-300 transition-colors duration-300">
                                    Read More
                                </a>
                                <button class="flex items-center gap-2 text-gray-400 hover:text-yellow-400 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                    <span>Share</span>
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
>>>>>>> d8f6815115400387eaee60e73e006d5ed25b8f09
            </div>
        </div>
    </section>

    <!-- Footer Section -->
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

    <!-- Scripts -->
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

        /* Line clamp for post content */
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</body>
</html>
