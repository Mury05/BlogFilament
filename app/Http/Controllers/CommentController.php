<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'post_id' => 'required|exists:posts,id'
        ]);

        $post = Post::findOrFail($request->post_id);
        $post->comments()->create([
            'content' => $request->content,
            'author_id' => Auth::id(),
            'post_id' => $post->id, // Ajout de la clé étrangère post_id
        ]);

        return redirect()->route('posts.show', $post->slug)->with('success', 'Commentaire ajouté avec succès');
    }


    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        // Vérifie si l'utilisateur est bien celui qui a créé le commentaire

        if ($comment->author_id !== Auth::id()) {
        $post = Post::findOrFail($comment->post_id);
            return redirect()->route('post.show', $post->slug)->with('error', 'Vous ne pouvez modifier que vos propres commentaires.');
        }

        return view('comment.edit', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::findOrFail($id);

        // Vérifie si l'utilisateur est bien celui qui a créé le commentaire
        $post = Post::findOrFail($comment->post_id);
        if ($comment->author_id !== Auth::id()) {
            return redirect()->route('posts.show', $post->slug)->with('error', 'Vous ne pouvez modifier que vos propres commentaires.');
        }

        // Met à jour le commentaire
        $comment->content = $request->content;
        $comment->save();
        return redirect()->route('posts.show', $post->slug)->with('success', 'Commentaire mis à jour avec succès.');
    }

    public function destroy(Comment $comment)
    {
        // Vérifier que l'utilisateur est bien celui qui a posté le commentaire
        $post = Post::findOrFail($comment->post_id);
        if ($comment->author_id !== Auth::id()) {
            return redirect()->route('posts.show', $post->slug)->with('error', 'Vous ne pouvez supprimer que vos propres commentaires.');
        }

        $comment->delete();

        return redirect()->route('posts.show', $post->slug)->with('success', 'Commentaire supprimé.');
    }
}
