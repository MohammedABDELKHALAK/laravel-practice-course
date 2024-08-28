<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // public function post(){
    //     return $this->belongsToMany(Post::class)->withTimestamps();
    // }

    public function post(){
        return $this->morphedByMany(Post::class, 'taggable')->withTimestamps();

}

public function comment(){
    return $this->morphedByMany(Comment::class, 'taggable')->withTimestamps();

}

}
