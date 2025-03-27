<x-layouts.app title="Jambangan | {{ $post->title }}">
    <div class="flex h-screen w-full justify-center">
        <div class="flex border w-full max-w-3xl flex-col gap-4 rounded-xl p-6 bg-white dark:bg-gray-800 ">
            <h1 class="text-2xl font-bold text-center">{{ $post->title }}</h1>
            <p class="text-black dark:text-white text-center">{{ $post->content }}</p>

            <div class="grid grid-cols-2 gap-4 mt-4">
                @foreach ($post->media as $media)
                    <div class="p-2 rounded">
                        @if ($media->type === 'image')
                            <img src="{{ $media->file_url }}" alt="image" class="rounded mx-auto" />
                        @elseif ($media->type === 'video')
                            <video class="rounded mx-auto" controls>
                                <source src="{{ $media->file_url }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>
