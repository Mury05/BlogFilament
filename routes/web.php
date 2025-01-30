<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $posts = Post::latest()->take(6)->get(); // Récupère les 6 derniers posts
    return view('welcome', compact('posts'));
});

Route::get('/', function () {
    $posts = Post::latest()->take(6)->get();
    return view('welcome', compact('posts'));
})->name('home');


Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

// Routes pour les commentaires
Route::middleware('auth')->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

});



