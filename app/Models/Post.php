<?php

namespace App\Models;

use App\Models\Scopes\LatastScope;
use App\Models\Scopes\AdminShowDeleteScope;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'slug', 'active', 'user_id'];



    //morphOne method to use imageable champ

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    // //morphMany method to use commentable champ
    public function comment()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // //morphToMany method to use taggable champ
    public function tag()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    //  public function image(){
    //     return $this->hasOne(Image::class);
    // }

    // public function comment()
    // {
    //     return $this->hasMany(Comment::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function tag(){
    //     return $this->belongsToMany(Tag::class)->withTimestamps();
    // }

    // public function image(){
    //     return $this->hasOne(Image::class);
    // }

    public function scopeDernier(Builder $query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeMostPostCommanted(Builder $query)
    {
        return $query->withCount('comment')->take(5)->orderBy('comment_count', 'desc')->get();
    }


    // ******************if you didn't use softeDelete  this is mean physic delete method it is not good for prof career*******************

    public  static function boot()
    {
        // i put this global scope befor parrent:boot() because of sofdelete is also a scope tha why the soft delete 
        //will stop our global scope instead we have trashed() in it
        static::addGlobalScope(new AdminShowDeleteScope);

        parent::boot();
        // this global scope to use it you have to create Scopes folder and creat file.php like LatastScope
        // but best practice local scope
        // static::addGlobalScope(new LatastScope);

        // deleting: to delete also the comments thoses have forgien keys with post    
        static::deleting(function (Post $post) {
            $post->comment()->delete();
        });



        // deleting: to delete also the images thoses have forgien keys with post    
        static::deleting(function (Post $post) {
            $post->image()->delete();
        });


        static::restoring(function (Post $post) {
            $post->image()->restore();
        });


        //to stop getting data from the cache when user get updating him post to show the new change
        static::updating(function (Post $post) {
            Cache::forget("post-show-{$post->id}");
        });

        static::restoring(function (Post $post) {
            $post->comment()->restore();
        });
    }
}
