<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function showMore(Post $post)
    {
        // Passer les informations du post au modal
        return view('posts.view-more', compact('post'));
    }
}
