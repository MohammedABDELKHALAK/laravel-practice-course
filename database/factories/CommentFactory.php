<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            'content' => $this->faker->realText(100),
            //'updated_at' => $this->faker->dateTimeBetween('-3 months')
            
        ];

    }
}
