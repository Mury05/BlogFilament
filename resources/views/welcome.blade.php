@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Derniers Articles</h1>

    <div class="grid grid-cols-2 lg:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
        @foreach ($posts as $post)
        <div class="bg-gray-100 rounded-lg shadow-lg overflow-hidden ">
            <h2 class="text-2xl mb-3 text-blue-500">{{ $post->title }}</h2>
            <!-- Image sous forme de carte -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-4 flex items-center justify-center">
                @if($post->image_cover)
                <img src="{{ asset('storage/' . $post->image_cover) }}" alt="{{ $post->title }}" class="max-w-full h-48 object-contain">
                @else
                <div class="h-48 flex items-center justify-center bg-gray-200 text-gray-500">
                    Aucune image
                </div>
                @endif
            </div>

            <!-- Contenu sous l'image -->
            <div class="p-4 flex flex-col flex-grow">
                <p class="text-gray-600 text-sm flex-grow">{{ Str::limit(strip_tags($post->content), 100, '...') }}</p>

                <!-- Bouton "Lire plus" plus petit et bien aligné -->
                <div class="mt-4">
                    <a href="{{ route('posts.show', $post->slug) }}"
                       class="inline-block bg-blue-600 text-white px-4 py-1.5 rounded-lg hover:bg-blue-700 transition text-sm">
                        Lire plus
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
