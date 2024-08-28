<?php

namespace App\Http\Controllers;


use App\Http\Requests\StorePost;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'archive']);
    }


    public function index()
    {

        // the Cache and other variables like $scopeMostPostCommanted ....
        // in a App\Http\ViewComposer\ActivityComposer connect with this PostControleres views by AppServiceProvider
        //$post = Post::withCount('comment')->get();

        //dernier() is a scopeDernier() is declared in Post.php
        return view(
            'posts.index',

            //comment.user this is mean nested relationship to retreve comment with its users
            [
                'posts' => Post::withCount('comment')->with(['comment', 'user', 'tag', 'image', 'comment.user'])->dernier()->get(),

                'tab' => 'list'
            ]
        );
    }

    // public function archive()
    // {
    //     //$post = Post::withTrashed()->onlyTrashed()->withCount('comment')->get();
    //     return view(
    //         'posts.index',
    //         ['posts' => Post::onlyTrashed()->withCount('comment')->get(), 'tab' => 'archive']
    //     );
    // }

    // public function all()
    // {
    //     //$post = Post::withCount('comment')->get();
    //     //->orderBy('updated_at', 'desc') is use it in scopes folder for don't repeat same formate
    //     return view(
    //         'posts.index',
    //         ['posts' => Post::withTrashed()->withCount('comment')->get(), 'tab' => 'all']
    //     );
    // }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        // i have to check how save data by using this method in request folder
        // $validatedata = $request->validated();

        // $validatedata['user_id'] = $request->user()->id;
        // $post = Post::create($validatedata);
        //************************************************************* */

        //other way to save data

        $data = $request->only(['title', 'content']);
        
        $data['slug'] = Str::slug($data['title'], '-');
        $data['active'] = false;
        //$data['user_id'] = auth()->user()->id;
        $data['user_id'] = Auth::user()->id;
        $post = Post::create($data);

        //upload picture for current post
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('posts_images');
            //Storage::putFile('name of the folder', $file) this other way by  using facade Storage 
            $image = new Image(['path' => $path]);
            $post->image()->save($image);
        }
        //other way to save data
        // $posts = new Post();
        // $posts->title = $request->input('title');
        // $posts->content = $request->input('content');
        // $posts->slug =  Str::slug($request->input('title'), "-");
        /**** to get user_id using this method you need to put input type hidden in the form *****/
        // $posts->user_id =  $request->input('userid');
        // $posts->active = false;

        // $posts->save();

        $request->session()->flash('status', 'Task was created successful!');


        //redirect works just for Route name those have GET method
        //return redirect("/posts");
        return redirect()->route("posts.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cacheshow = Cache::remember("post-show-{$id}", 60, function () use ($id) {
            return Post::with(['tag', 'comment'])->findOrFail($id);
        });

        //dernier() is a scopeDernier() is declared in Comment.php
        //$comments = Comment::where('post_id', $id)->dernier()->get();

        return view('posts.show', ['posts' =>  $cacheshow]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        // if (Gate::denies('post.update', $post)) {
        //     abort(403, 'you cannot update !!!');
        // }

        $this->authorize('update', $post);


        return view('posts.edit', [
            'post' =>  $post

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {

        // $request->validate([
        //     'title' => 'required|min:4|max:100',
        //     'content' => 'required|min:4|max:100',
        // ]);
        $post = Post::findOrFail($id);
        //$this->authorize('post.update', $post);
        //   if(Gate::denies('post.update', $post)){
        //       abort(403, 'you cannot update !!!');
        //  }


        // if (Gate::denies('post.update', $post)) {
        //     abort(403, 'you cannot update !!!');
        // }

        //$this->authorize('update', $post);

        //update: new upload picture for current post and remove old one from database and picture from folder posts_images

        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->slug = Str::slug($request->input('title'), "-");
        $post->active = false;
        $post->save();

        //update: new upload picture for current post and remove old one from database and picture from folder posts_images

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('posts_images');
            //Storage::putFile('name of the folder', $file) this other way by  using facade Storage 

            if ($post->image) {
                //to delete old one
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            } else {
                // i am using make instead of create 
                //because in morph relationship it will create a champ for imageable_type i had to use make to fill the champ automatically
                $post->image()->save(Image::make(['path' => $path]));
            }
        }

        $request->session()->flash('status', 'Task was updated succefuly!');

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        // $post->delete();
        // destroy doesn't need to select data like delete()
        $this->authorize('delete', $post);
        $post = Post::destroy($id);;


        return redirect()->route('posts.index');
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->where('id', $id)->first();
        $this->authorize('restore', $post);
        $post->restore();
        return redirect()->back();
    }


    public function forcedelete($id)
    {
        $post = Post::onlyTrashed()->where('id', $id)->first();
        // Delete the file from folder storage
        Storage::delete($post->path);
        $post->forceDelete();
        return redirect()->back();
    }
}
