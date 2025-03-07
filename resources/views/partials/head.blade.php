<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    @php
        $defaultTitle = 'Jambangan';
        $routeName = request()->route() ? request()->route()->getName() : null;
        $title = str_starts_with($routeName, 'settings') ? 'Settings' : ($title ?? $defaultTitle);
    @endphp
    {{ $title }}
</title>


<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
