<?php

use App\Http\Controllers\PostController;
use App\Http\Livewire\PostDetailsModal;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/view-more/{post}', [PostController::class, 'post.details'])->name('view-more');
Route::get('/post/{id}/details', [PostController::class, 'show'])->name('post.details');
Route::get('/post/{id}/details', [PostController::class, 'show'])->name('post.edit');


// Ajoutez cette ligne pour enregistrer le composant Livewire sur une route
// Route::get('/post/{id}/details', PostDetailsModal::class)->name('post.details');



