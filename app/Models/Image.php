<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['path'];


    // i made this in comment status because of from now am using morph
    // morph: we use it to stock for example posts's and users's images in same table images in database

    public function post(){
        return $this->belongsTo(Post::class);
    }

    // must be be same name of the champ this prefix name with champ in images table in database
    public function imageable(){
        return $this->morphTo();
    }



    
    public  static function boot()
    {

        parent::boot();


       
    }
}
