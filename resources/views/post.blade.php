@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-gray-100 p-6 shadow-lg rounded-lg relative">

    <h1 class="text-5xl font-bold font-serif mb-4">{{ $post->title }}</h1>

        <!-- Bouton retour -->
        <a href="{{ route('home') }}" class="absolute -top-4 left-4 bg-gray-600 text-white p-2 rounded-full hover:bg-gray-700 transition">
        <svg class="w-10 h-10 text-gray-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
        </svg>

        </a>

        <!-- Image de couverture -->
        @if($post->image_cover)
        <img src="{{ asset('storage/' . $post->image_cover) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-md mb-6">
        @endif

        <!-- Titre et Meta Info -->
        <p class="text-gray-500 text-sm mb-2">
            Publié le <span class="font-semibold">{{ \Carbon\Carbon::parse($post->published_at)->format('d M Y') }}</span> 
            par <span class="font-semibold">{{ $post->author->name }}</span>
        </p>

        <!-- Catégorie -->
        <p class="text-gray-700 text-sm mb-4">
            Catégorie : <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded-md">{{ $post->category->name }}</span>
        </p>

        <!-- Tags -->
        @if($post->tags->count() > 0)
        <div class="mb-4">
            <span class="text-gray-600 font-semibold">Tags :</span>
            @foreach($post->tags as $tag)
            <span class="inline-block bg-gray-200 text-gray-800 px-2 py-1 rounded-md text-sm mr-2">#{{ $tag->name }}</span>
            @endforeach
        </div>
        @endif

        <!-- Contenu -->
        <div class="prose max-w-none">
            {!! nl2br(e($post->content)) !!}
        </div>

        <!-- Section Commentaires -->
        <div class="mt-8 p-4 border-t">
            <h2 class="text-2xl font-semibold mb-4">Commentaires</h2>
            @if($post->comments->count() > 0)
                @foreach($post->comments as $comment)
                <div class="mb-4 p-3 border rounded-md bg-gray-50">
                    <p class="font-semibold">{{ $comment->user->name }} <span class="text-gray-500 text-xs">({{ $comment->created_at->format('d M Y H:i') }})</span></p>
                    <p class="text-gray-700">{{ $comment->content }}</p>
                </div>
                @endforeach
            @else
                <p class="text-gray-500">Aucun commentaire pour cet article.</p>
            @endif
        </div>

        <!-- Retour Accueil -->
        <a href="{{ route('home') }}" class="inline-block mt-6 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            Retour à l'accueil
        </a>
    </div>
</div>
@endsection
