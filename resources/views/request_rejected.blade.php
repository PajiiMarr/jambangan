<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Rejected - Jambangan Cultural Dance</title>
    
    @vite(['resources/css/landingpage.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-black text-white font-sans">
    <section class="relative h-[70vh] flex flex-col items-center justify-center text-center px-6"
             data-aos="fade-up" data-aos-duration="1000">
        <div class="absolute inset-0 bg-[url('{{ asset('images/best2.png') }}')] bg-cover bg-center brightness-[.3]"></div>
        <div class="relative z-10 max-w-2xl">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold bg-gradient-to-r from-yellow-400 via-red-500 to-yellow-400 text-transparent bg-clip-text mb-6">
                Registration Rejected
            </h1>
            <p class="text-xl sm:text-2xl text-gray-300 mb-8">
                Unfortunately, your registration with Jambangan Cultural Dance was not approved. <br>
                Please check your details or contact us for further assistance.
            </p>
            <a href="{{ route('home-public') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 px-6 rounded-lg transition duration-300">
                Return to Homepage
            </a>
        </div>
    </section>

    <!-- Optional Section (e.g., support or next steps) -->
    <section class="py-12 bg-[#121212]" data-aos="fade-up" data-aos-duration="1000">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold text-white mb-4">Need Assistance?</h2>
            <p class="text-gray-400 text-lg">
                If you believe there was an error or would like more information, feel free to reach out to us at support@jambangan.com.
            </p>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>AOS.init();</script>
</body>
</html>
