<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_user' => $this->faker->numberBetween(1,20),
            'id_video' => $this->faker->numberBetween(1,10),
            'is_liked' => $this->faker->boolean,
        ];
    }
}
