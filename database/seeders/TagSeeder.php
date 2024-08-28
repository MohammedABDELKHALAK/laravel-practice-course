<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = collect(["Travel", "Science", "Cars", "Books", "Training", "Sport", "Technology"]);

        $tags->each(function($tag){
        $tagName = new Tag();
        $tagName->name = $tag;
        $tagName->save();

        });
    }
}
