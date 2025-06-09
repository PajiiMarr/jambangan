<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>

    @php
        $defaultTitle = 'Jambangan';
        $routeName = request()->route() ? request()->route()->getName() : null;
        $title = str_starts_with($routeName, 'settings') ? 'Settings' : ($title ?? $defaultTitle);
    @endphp
    {{ $title }}
</title>


<link rel="icon" type="image/svg+xml" href="{{ url('/favicon.svg') }}">
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<!-- OrgChart core and plugin (both from the same domain) -->
<link rel="stylesheet" href="https://balkangraph.com/js/latest/OrgChart.css" />
<script src="https://balkan.app/js/OrgChart.js"></script>
{{-- <script src="https://balkan.app/js/OrgChart.editUI.js"></script> --}}

@vite(['resources/css/app.css'])
{{--@livewireStyles--}}
@fluxAppearance
