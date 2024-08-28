<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;

//use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        /**
        *best way to use policy just in controller you need to put this format $this->authorize('update', $post)
        *you nedd just also the method you need in Policy
        **/ 
        'App\Models\Post' => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('page.secret', function($user){
            return $user->is_admin;
        });

        // to use the format like below use this in controller  $this->authorize('post.update', $post);
        //Gate::resource('post', 'App\Policies\PostPolicy');
        
        // to use the format like below use this in controller $this->authorize('post', $post)
         //Gate::define('post', 'App\Policies\PostPolicy@update');

        // Gate::define("posts.update", function ($user, $post) {
        //     return $user->id === $post->user_id;
        // });

        // Gate::define("posts.delete", function ($user, $post) {
        //     return $user->id === $post->user_id;
        // });


        /* this Gate with method before will apply before all previous Gate 
        this action to gave autority for Admin to update or delete or both */

        Gate::before(function ($user, $ability) {
             if ($user->is_admin && in_array($ability, ['delete', 'restore'])) {
                return true;
             }
         });

    }
}
