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
            'user_id' => $this->faker->numberBetween(1,200),
            'category_id' => $this->faker->numberBetween(1,10),
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->sentence,
            'thumbnail' => 'https://picsum.photos/id/' . $this->faker->numberBetween(1, 999) . '/1920/1080',
            'video' => 'videoTest.mp4',
            'duration' => $this->faker->numberBetween(1, 1000000),
            'status' => 'online',
            'type' => 'public',
        ];
    }
}
