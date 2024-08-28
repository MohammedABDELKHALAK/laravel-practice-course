<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = User::all();

        if($users->count() == 0) {
            $this->command->info("please create some users !");
            return;
        }
        
        $nbPosts = (int)$this->command->ask("How many of post you want generate ?", 30);
        
        Post::factory($nbPosts)->make()->each(function ($post) use ($users) {
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
