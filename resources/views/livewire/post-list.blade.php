<div class="w-full ">
    @foreach ($posts as $post)
        {{-- <a href="{{ route('view-post', ['title' => $post->title]) }}"> --}}
            <div class="border rounded-lg p-4 mb-4 duration-100 ease-in-out">
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
        </a>
    @endforeach

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
