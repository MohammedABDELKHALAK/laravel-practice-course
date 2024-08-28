<?php

namespace App\Models;

use App\Models\Scopes\LatastScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['post_id', 'content', 'user_id'];

    // public function post()
    // {
    //     return $this->belongsTo(Post::class);
    // }

    //for morphs
    public function commentable()
    {
        return $this->morphTo();
    }


    // i don't know why i had to use belongsTo instead i work by morphTo 
    // according to the chat-GPT even i'm using morphTo in same time i had to use belongTo in same time
    // but for posts i didn't use it, so this is uninderstading for me!!!!
    public function user()
    {
        return $this->belongsTo(User::class);
    }

        // //morphToMany method to use taggable champ
        public function tag()
        {
            return $this->morphToMany(Tag::class, 'taggable');
        }

    public function scopeDernier(Builder $query){
        return $query->orderBy('updated_at', 'desc');
    }

    // public function user(){
    //     return $this->BelongsTo( User::class);
    // }

    public static function boot()
    {
        parent::boot();

                //to stop getting data from the cache when user get creating a comments to show them in comments section
                static::creating(function (Comment $comment) {
                    Cache::forget("post-show-{$comment->commentable->id}");
                });

        // this global scope to use it you have to create Scopes folder and creat file.php like LatastScope
        // but best practice local scope
       // static::addGlobalScope(new LatastScope);
    }
}
