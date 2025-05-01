@props([
    'title' => 'CONTACT US',
    'showVisitUs' => false,
    'general_contents' => null
])

<div class="max-w-3xl mx-auto text-center relative z-10">
    <h2 class="text-2xl font-bold mb-2 text-yellow-400">{{ $title }}</h2>
    <p class="text-sm text-gray-300">
        <span class="text-yellow-400">{{ $general_contents?->contact_email ?? 'jambangan@culture.ph' }}</span> | 
        <span class="text-yellow-400">{{ $general_contents?->contact_number ?? '09-1234-5678' }}</span>
    </p>

    @if($showVisitUs)
        <p class="text-sm text-gray-300 mt-2">
            {{ $general_contents?->address ?? 'Western Mindanao State University' }}
        </p>
    @endif
</div> 