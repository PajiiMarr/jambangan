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
<link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
<link
    href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
    rel="stylesheet"
/>
<link rel="stylesheet" href="https://balkangraph.com/js/latest/OrgChart.css" />
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/timegrid/main.min.js"></script>
<script src="https://cdn.balkan.app/orgchart.js"></script>



@vite(['resources/css/app.css', 'resources/js/app.js'])
{{--@livewireStyles--}}
@fluxAppearance
