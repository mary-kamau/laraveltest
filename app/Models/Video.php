<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Comment;

class Video extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }

    //Returns single comment object
    public function comment(){
        return $this->morphOne(Comment::class, 'commentable');
    }
}
