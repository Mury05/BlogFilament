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
                <button data-modal-toggle="edit-comment-modal-{{ $comment->id }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">Modifier ce commentaire</button>
            
            @endif
        </div>


        <!-- Modal de modification -->
        <div id="edit-comment-modal-{{ $comment->id }}" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 flex justify-center items-center">
            <div class="relative p-4 bg-white rounded-lg w-96">
                <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h3 class="text-lg font-semibold mb-4">Modifier le commentaire</h3>

                    <div class="mb-4">
                        <textarea name="content" rows="4" class="w-full p-2 border rounded-md" required>{{ old('content', $comment->content) }}</textarea>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Mettre à jour le commentaire</button>

                    <!-- Bouton pour fermer le modal -->
                    <button type="button" data-modal-toggle="edit-comment-modal-{{ $comment->id }}" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </form>
            </div>
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

<script>
    // Script pour ouvrir et fermer les modals
    document.querySelectorAll('[data-modal-toggle]').forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-modal-toggle');
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        });
    });
</script>
