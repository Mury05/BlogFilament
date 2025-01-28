<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($posts as $post)
        <div class="bg-white shadow-lg rounded-lg p-4">
            <img src="{{ $post->image_cover }}" alt="{{ $post->title }}" class="rounded-lg mb-4">
            <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
            <p class="text-gray-600">{{ Str::limit($post->content, 100) }}</p>
            <div class="mt-4 flex justify-between items-center">
                <a href="{{ route('post.details', $post->id) }}" class="text-blue-500 hover:text-blue-700">View More</a>
                <a href="{{ route('post.edit', $post->id) }}" class="text-green-500 hover:text-green-700">Edit</a>
            </div>
        </div>
    @endforeach
</div>
