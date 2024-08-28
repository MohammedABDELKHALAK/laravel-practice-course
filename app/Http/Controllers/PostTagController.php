<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class PostTagController extends Controller
{
    public function index($id){
        $tag = Tag::find($id);

        return view('posts.index', [
            
            'posts' => $tag->post()->with(['comment','user', 'tag','comment.user'])->dernier()->get()
    ]);
    }
}
