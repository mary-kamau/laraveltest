<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\PostTag;
use App\Models\Comment;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title'];

    public function user(){
        return $this->belongsTo(User::class)->withDefault([
            'name' =>'Guest User'
        ]);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id')
        ->using(PostTag::class)
        ->withTimestamps()
        ->withPivot('status');
    }

    //Returns collection of comments
    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }

    //Returns single comment object
    public function comment(){
        return $this->morphOne(Comment::class, 'commentable');
    }
}
