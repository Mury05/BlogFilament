<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{

    use HasFactory;
    use HasTags;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image_cover',
        'category_id',
        'author_id',
        'published_at',
        'status'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /** @return MorphMany<Comment> */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
