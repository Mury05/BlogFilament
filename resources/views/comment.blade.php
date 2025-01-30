<!-- resources/views/comment.blade.php -->

<div class="mt-8 p-4 border-t">
    <h2 class="text-2xl font-semibold mb-4">Commentaires ({{ $post->comments->count() }})</h2>

    <!-- Affichage des Commentaires -->
    @foreach($post->comments as $comment)
        <div class="mb-4 p-3 border rounded-md bg-gray-50">
            <p class="font-semibold">
            {{ $comment->author->name }} 
                <span class="text-gray-500 text-xs">({{ $comment->created_at->format('d M Y H:i') }})</span>
            </p>
            <p class="text-gray-700">{{ $comment->content }}</p>

            @if(auth()->check() && auth()->user()->id === $comment->author_id)
                <!--Bouton de suppression pour user ayant ajouté le commentaire -->
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Supprimer ce commentaire</button>
                </form>

                <!-- Lien pour modifier le commentaire -->
                <a href="{{ route('comments.edit', $comment->id) }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">Modifier ce commentaire</a>
            @endif
        </div>
    @endforeach

    <!-- Formulaire pour Ajouter un Commentaire -->
    @auth
        <div class="mt-6 p-4 bg-gray-100 border rounded-md">
            <h3 class="text-lg font-semibold">Ajouter un commentaire</h3>
            <form action="{{ route('comments.store') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div class="mb-4">
                    <textarea name="content" rows="4" class="w-full p-2 border rounded-md" placeholder="Écrivez votre commentaire..." required></textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Ajouter le commentaire</button>
            </form>
        </div>
    @else
        <p class="text-gray-500 mt-4">Vous devez être connecté pour ajouter un commentaire.</p>
    @endauth
</div>
