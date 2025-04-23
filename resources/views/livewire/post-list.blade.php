<div class="w-full">
    @forelse ($posts as $post)
        <div class="bg-gray-50 rounded-lg p-4 mb-4 duration-100 ease-in-out">
            <h3 class="text-xl font-semibold">{{ $post->title }}</h3>
            <p class="text-black dark:text-white">{{ $post->content }}</p>

            <div class="grid grid-cols-2 gap-4 mt-2">
                @foreach ($post->media as $media)
                    <div class="p-2 rounded">
                        @if ($media->type === 'image')
                            <img src="{{ $media->file_url }}" alt="image" class="rounded" />
                        @elseif ($media->type === 'video')
                            <video class="rounded" controls>
                                <source src="{{ $media->file_url }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="rounded-xl bg-gray-50 p-8 flex flex-col items-center justify-center mt-4">
            <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
            </svg>
            <p class="text-gray-500 font-medium">Create posts to view here...</p>
        </div>
    @endforelse

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
