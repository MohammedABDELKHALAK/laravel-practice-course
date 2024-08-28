<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $titel = $this->faker->sentence();
        return [
            'title' => $titel ,
            'content' => $this->faker->realText(100),
            'slug' => Str::slug($titel,'-'),
            'active' => $this->faker->boolean(),
           // 'updated_at' => $this->faker->dateTimeBetween('-3 years')


        ];
    }
}
