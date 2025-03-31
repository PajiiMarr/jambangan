<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jambangan Cultural Dance</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="bg-[#0D0D0D] text-[#FFD700] font-monterchi">

    <!-- 🌿 Navbar -->
    <nav class="bg-[#8B0000] text-[#FFD700] p-4 shadow-md border-b-4 border-[#FFD700]">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo.png') }}" alt="Jambangan Logo" class="h-12 w-auto">
                <h1 class="text-xl font-bold text-[#FFD700] tracking-widest uppercase">Jambangan Cultural Dance</h1>
            </div>

            <ul class="flex space-x-6 font-semibold">
                <li><a href="#" class="hover:text-white transition duration-300">Home</a></li>
                <li><a href="#" class="hover:text-white transition duration-300">About Us</a></li>
                <li><a href="#" class="hover:text-white transition duration-300">Posts</a></li>
                <li><a href="#" class="hover:text-white transition duration-300">Performances</a></li>
                <li><a href="#" class="hover:text-white transition duration-300">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- 🎭 Hero Section (Fullscreen Background Carousel with Text Overlay) -->
    <div x-data="{ 
        current: 0, 
        slides: [
            { image: '{{ asset('images/best.png') }}', caption: 'Pangalay - A dance of the Tausug people' },
            { image: '{{ asset('images/test2.png') }}', caption: 'Singkil - A royal dance of the Maranao' },
            { image: '{{ asset('images/dance3.png') }}', caption: 'Tinikling - The famous bamboo dance of the Philippines' },
        ] 
    }" 
    x-init="setInterval(() => current = (current + 1) % slides.length, 6000)" 
    class="relative w-full h-screen flex items-center justify-center text-white overflow-hidden">

        <!-- Background Image Carousel -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="current === index" 
                class="absolute inset-0 w-full h-full bg-cover bg-center transition-opacity duration-1000 ease-in-out"
                :style="'background-image: url(' + slide.image + ');'">
            </div>
        </template>

        <!-- Fallback Background Color -->
        <div class="absolute inset-0 bg-[#121212]" x-show="!slides.length"></div>

        <!-- Centered Text -->
        <div class="relative z-10 text-center px-6">
            <h1 class="text-5xl font-bold drop-shadow-lg">Jambangan, the Dance Ambassador of WMSU</h1>
            <p class="text-xl mt-4 drop-shadow-lg" x-text="slides[current].caption"></p>
        </div>

        <!-- Navigation Buttons -->
        <button @click="current = (current - 1 + slides.length) % slides.length" 
                class="absolute left-4 bg-white bg-opacity-30 hover:bg-opacity-50 text-white px-4 py-2 rounded-full text-2xl">
            ‹
        </button>
        <button @click="current = (current + 1) % slides.length" 
                class="absolute right-4 bg-white bg-opacity-30 hover:bg-opacity-50 text-white px-4 py-2 rounded-full text-2xl">
            ›
        </button>
    </div>

    <!-- ✨ About Section -->
    <section class="py-12 px-6 bg-[#121212] shadow-md border-t-4 border-[#FFD700]">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-extrabold text-[#FFD700] mb-6">About Us</h2>
            <p class="text-lg text-gray-300 leading-relaxed">
                Jambangan Cultural Dance is a celebration of the Filipino soul and the rich Spanish heritage that defines it. Our performances are a tribute to elegance, tradition, and artistry.
            </p>
        </div>
    </section>

       <!-- 🕊 Performances Showcase -->
       <section class="py-12">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-center text-[#FFD700] mb-8 tracking-wide">Our Performances</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-[#222] p-6 rounded-lg shadow-xl">
                    <img src="/images/dance1.png" class="w-full h-48 object-cover rounded-lg border-2 border-[#FFD700] shadow-lg">
                    <h3 class="text-xl font-semibold mt-4 text-[#FFD700]">Tinikling</h3>
                    <p class="text-sm text-gray-400">The national dance of the Philippines, showcasing grace and agility.</p>
                </div>
                <div class="bg-[#222] p-6 rounded-lg shadow-xl">
                    <img src="/images/dance2.png" class="w-full h-48 object-cover rounded-lg border-2 border-[#FFD700] shadow-lg">
                    <h3 class="text-xl font-semibold mt-4 text-[#FFD700]">Pandanggo sa Ilaw</h3>
                    <p class="text-sm text-gray-400">A dance of flickering lights, representing balance and elegance.</p>
                </div>
                <div class="bg-[#222] p-6 rounded-lg shadow-xl">
                    <img src="/images/dance3.png" class="w-full h-48 object-cover rounded-lg border-2 border-[#FFD700] shadow-lg">
                    <h3 class="text-xl font-semibold mt-4 text-[#FFD700]">Singkil</h3>
                    <p class="text-sm text-gray-400">A royal dance of the Maranao people, showcasing precision and poise.</p>
                </div>
            </div>
        </div>
    </section>


        <!-- 👑 Leadership Section -->
    <section class="py-12 px-6 bg-[#121212] shadow-md border-t-4 border-[#FFD700]">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="text-4xl font-extrabold text-[#FFD700] mb-6 tracking-wide">Meet Our Leaders</h2>
            <p class="text-lg text-gray-300 mb-8">Guiding the Jambangan Cultural Dance Company with passion and dedication.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
            <!-- 🎭 President Card -->
            <div class="bg-[#222] p-6 rounded-lg shadow-xl text-center">
                <img src="/images/president.jpg" class="w-40 h-40 object-cover mx-auto rounded-full border-4 border-[#FFD700] shadow-lg">
                <h3 class="text-xl font-semibold mt-4 text-[#FFD700]">Juan Dela Cruz</h3>
                <p class="text-gray-400 text-sm">President & Artistic Director</p>
                <p class="text-sm text-gray-300 mt-2">A visionary leader dedicated to preserving and promoting Philippine culture through dance.</p>
            </div>

            <!-- 🎭 Director Card -->
            <div class="bg-[#222] p-6 rounded-lg shadow-xl text-center">
                <img src="/images/director.jpg" class="w-40 h-40 object-cover mx-auto rounded-full border-4 border-[#FFD700] shadow-lg">
                <h3 class="text-xl font-semibold mt-4 text-[#FFD700]">Maria Santos</h3>
                <p class="text-gray-400 text-sm">Dance Director</p>
                <p class="text-sm text-gray-300 mt-2">An expert choreographer leading our dancers in breathtaking performances.</p>
            </div>

            <!-- 🎭 Operations Manager Card -->
            <div class="bg-[#222] p-6 rounded-lg shadow-xl text-center">
                <img src="/images/manager.jpg" class="w-40 h-40 object-cover mx-auto rounded-full border-4 border-[#FFD700] shadow-lg">
                <h3 class="text-xl font-semibold mt-4 text-[#FFD700]">Carlos Mendoza</h3>
                <p class="text-gray-400 text-sm">Operations Manager</p>
                <p class="text-sm text-gray-300 mt-2">Ensuring seamless event planning and cultural showcases worldwide.</p>
            </div>
        </div>
    </section>
<!-- 📅 Calendar of Events Section -->
<section class="py-12 px-6 bg-[#121212] shadow-md border-t-4 border-[#FFD700]">
    <div class="max-w-6xl mx-auto text-center">
        <h2 class="text-4xl font-extrabold text-[#FFD700] mb-6 tracking-wide">Calendar of Events</h2>
        <p class="text-lg text-gray-300 mb-8">Stay updated with our upcoming cultural performances and activities.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
        <!-- 🎭 Event Card 1 -->
        <div class="relative bg-[#222] rounded-lg shadow-xl border-2 border-[#FFD700] overflow-hidden">
            <!-- Image Placeholder -->
            <div class="h-40 bg-gray-700 flex items-center justify-center text-gray-400">
                <span class="text-lg">Image Placeholder</span>
            </div>
            <!-- Date Badge -->
            <div class="absolute top-4 left-4 bg-[#FFD700] text-[#8B0000] font-bold px-4 py-2 rounded shadow-md">
                <span class="text-lg">APR</span>
                <span class="block text-3xl">15</span>
            </div>
            <!-- Event Info -->
            <div class="p-6">
                <h3 class="text-xl font-semibold text-[#FFD700]">Pangalay Showcase</h3>
                <p class="text-gray-400 text-sm mt-2">An elegant dance performance celebrating the heritage of the Tausug people.</p>
            </div>
        </div>

        <!-- 🎭 Event Card 2 -->
        <div class="relative bg-[#222] rounded-lg shadow-xl border-2 border-[#FFD700] overflow-hidden">
            <div class="h-40 bg-gray-700 flex items-center justify-center text-gray-400">
                <span class="text-lg">Image Placeholder</span>
            </div>
            <div class="absolute top-4 left-4 bg-[#FFD700] text-[#8B0000] font-bold px-4 py-2 rounded shadow-md">
                <span class="text-lg">MAY</span>
                <span class="block text-3xl">10</span>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-semibold text-[#FFD700]">Singkil Royal Dance</h3>
                <p class="text-gray-400 text-sm mt-2">A mesmerizing performance of the Maranao royal dance with intricate footwork.</p>
            </div>
        </div>

        <!-- 🎭 Event Card 3 -->
        <div class="relative bg-[#222] rounded-lg shadow-xl border-2 border-[#FFD700] overflow-hidden">
            <div class="h-40 bg-gray-700 flex items-center justify-center text-gray-400">
                <span class="text-lg">Image Placeholder</span>
            </div>
            <div class="absolute top-4 left-4 bg-[#FFD700] text-[#8B0000] font-bold px-4 py-2 rounded shadow-md">
                <span class="text-lg">JUN</span>
                <span class="block text-3xl">05</span>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-semibold text-[#FFD700]">Tinikling Festival</h3>
                <p class="text-gray-400 text-sm mt-2">Experience the thrill of the Philippine bamboo dance at its finest.</p>
            </div>
        </div>
    </div>
</section>

    <section class="py-12 px-6 bg-[#8B0000] text-white border-t-4 border-[#FFD700] shadow-xl">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-6 tracking-wide">Get in Touch</h2>
            <p class="text-lg">Interested in a performance? Contact us at <strong class="text-[#FFD700]">jambangan@culture.ph</strong></p>
        </div>
    </section>

    <!-- 🏛 Footer -->
    <footer class="bg-[#0D0D0D] p-6 text-center text-[#FFD700] border-t-4 border-[#FFD700] shadow-inner">
        &copy; 2024 Jambangan Cultural Dance Company. All rights reserved.
    </footer>

</body>
</html>
    
