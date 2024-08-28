<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    //morphOne method to use imageable champ
    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

       //morphOne method to use commentable champ
       public function comment(){
        return $this->morphMany(Comment::class, 'commentable');
    }
    


    public function post(){
        return $this->hasMany(Post::class);
    }

    // public function comment(){
    //     return $this->hasMany( Comment::class);
    // }

    public function scopeMostUsersHavePosts(Builder $query){
        return $query->withCount('post')->take(5)->orderBy('post_count', 'desc')->get();
    }

    //sub queries like select * from table1 IN select table2 where ...
    public function scopeMostUsersHavePostsInLastMonth(Builder $query){
        return $query->withCount(['post' => function(Builder $query) 
        {
            $query->whereBetween(static::CREATED_AT, [now()->subMonth(1), now()]);

                }])
                ->having('post_count', '<', 30)
                ->take(4)
                ->orderBy('post_count', 'desc')->get();
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
