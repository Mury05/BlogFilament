<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //relation entre post et comment
    public function post()
    {
        return $this->belongsTo(Post::class);
    }


    //relation entre user et comment
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
