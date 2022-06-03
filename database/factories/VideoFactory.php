<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Video>
 */
class VideoFactory extends Factory
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
            'id_categorie' => $this->faker->numberBetween(1,10),
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'token' => Str::random(10),
            'thumbnail' => $this->faker->imageUrl(),
            'video' => public_path('videoTest.mp4'),
            'views' => $this->faker->numberBetween(1,10000),
            'duration' => $this->faker->time('H:i:s'),
            'status' => 'online',
            'type' => 'public',
        ];
    }
}
