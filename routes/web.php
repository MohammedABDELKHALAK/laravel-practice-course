<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/home', [ HomeController::class, 'home' ] )->name('home');

//Route::get('/posts/{id}/{author?}', [HomeController::class, 'blog'])->name('blog-post');

//just for showing up static view
//Route::view('/', 'home');


//Route::get('/about', [App\HomeController::class, 'about'])->name('about');

Route::get('/secret', [App\Http\Controllers\HomeController::class, 'secretpage'])
->name('secret')
->middleware('can:page.secret');

Route::get('/posts/archive', [App\Http\Controllers\PostController::class, 'archive'])->name('archive');
Route::get('/posts/all', [App\Http\Controllers\PostController::class, 'all'])->name('all');
Route::resource('posts', App\Http\Controllers\PostController::class);
//Route::resource('posts', App\Http\Controllers\CommentController::class);
//Route::resource('users', App\Http\Controllers\UserController::class);
Route::delete('/posts/{id}/restore', [App\Http\Controllers\PostController::class, 'restore']);
Route::delete('/posts/{id}/forcedelete', [App\Http\Controllers\PostController::class, 'forcedelete']);

Route::get('/posts/tag/{id}/{tagname}',  [App\Http\Controllers\PostTagController::class, 'index'] )->name('post.tag.index');

Route::resource('posts.comments',  App\Http\Controllers\CommentController::class )->only(['store']);
Route::resource('users',  App\Http\Controllers\UserController::class );

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



