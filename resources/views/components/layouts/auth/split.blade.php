<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-gradient-to-r from-red-500 to-yellow-400 antialiased text-gray-900 dark:text-white">

    <div class="flex items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-6">
            {{-- App Logo & Name --}}
            <div class="text-center">
                <a href="{{ route('home-public') }}"
                   class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white/10 text-white text-2xl font-bold shadow-md hover:bg-white/20 transition-all duration-200"
                   wire:navigate>
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-white/20">
                        <x-app-logo-icon class="h-7 w-7 fill-current text-white" />
                    </div>
                    <span>{{ config('app.name', 'Jambangan') }}</span>
                </a>
            </div>

            {{-- Login Card --}}
            <div class="rounded-xl bg-white/80 p-8 shadow-xl backdrop-blur-md dark:bg-neutral-900/80">
                {{ $slot }}
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('redirect-to', event => {
            window.location.href = event.detail;
        });
    </script>
    
    @fluxScripts
</body>
</html>
