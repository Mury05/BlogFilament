<?php

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




