<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Post;
use App\Models\User;

class ActivityComposer {

    public function compose(View $view){

        $scopeMostPostCommanted = Cache::remember('scopeMostPostCommanted', 60, function () {
            return Post::mostPostCommanted();
        });
         $scopeMostUsersHavePosts = Cache::remember('scopeMostUsersHavePosts', 60, function () {
            return User::mostUsersHavePosts();
        });
         $scopeMostUsersHavePostsInLastMonth = Cache::remember('scopeMostUsersHavePostsInLastMonth', 60, function () {
            return User::mostUsersHavePostsInLastMonth();
        });

        $view->with([
            'scopeMostPostCommanted' => $scopeMostPostCommanted,
            'scopeMostUsersHavePosts' => $scopeMostUsersHavePosts,
            'scopeMostUsersHavePostsInLastMonth' => $scopeMostUsersHavePostsInLastMonth 

        ]);
       
    }
}