<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $posts = App\Post::all();

        // $users = App\User::all();

        // if($posts->count() == 0) {
        //     $this->command->info("please create some posts !");
        //     return;
        // }
        
        // $nbComments = (int)$this->command->ask("How many of comment you want generate ?", 100);

        // factory(App\Comment::class, $nbComments)->make()->each(function($comment) use ($posts, $users) {
        //     $comment->post_id = $posts->random()->id;
        //     $comment->user_id = $users->random()->id;
        //     $comment->save();
        // });


        $posts = Post::all();
        $users = User::all();

        if ($posts->count() === 0 || $users->count() === 0) {
            $this->command->info('There are no posts or users, so no comments will be added');
            return;
        }

        $commentsCount = (int)$this->command->ask('How many comments would you like?', 150);
        
        Comment::factory($commentsCount)->make()->each(function ($comment) use ($posts, $users) {
            $comment->commentable_id = $posts->random()->id;
            $comment->commentable_type = 'App\Models\Post';
            $comment->user_id = $users->random()->id;
            $comment->save();
        });

        Comment::factory($commentsCount)->make()->each(function ($comment) use ($users) {
            $comment->commentable_id = $users->random()->id;
            $comment->commentable_type = 'App\Models\User';
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
