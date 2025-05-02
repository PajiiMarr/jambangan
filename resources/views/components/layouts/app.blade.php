<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
    <flux:modal />
</x-layouts.app.sidebar>
