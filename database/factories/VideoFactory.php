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
            'id_user' => $this->faker->numberBetween(1,200),
            'id_categorie' => $this->faker->numberBetween(1,10),
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->sentence,
            'token' => Str::random(10),
            'thumbnail' => 'https://picsum.photos/id/' . $this->faker->numberBetween(1, 999) . '/1920/1080',
            'video' => public_path('videoTest.mp4'),
            'views' => $this->faker->numberBetween(1,10000),
            'duration' => '00:00:57',
            'status' => 'online',
            'type' => 'public',
        ];
    }
}
