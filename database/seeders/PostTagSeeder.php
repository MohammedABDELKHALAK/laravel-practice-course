<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\Post;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagsCount = Tag::count();

        Post::all()->each(function($post) use ($tagsCount) {

                $take = random_int(1,$tagsCount );

                $tagsId = Tag::inRandomOrder()->take($take)->get()->pluck('id');

                $post->tag()->sync($tagsId );

        });
    }
}
