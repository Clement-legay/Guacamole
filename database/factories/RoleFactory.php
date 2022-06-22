<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'canCreate' => 1,
            'canUpdate' => 1,
            'canDelete' => 1,
            'canComment' => 1,
            'canDeleteVideo' => 1,
            'canDeleteComment' => 1,
            'canBanUser' => 1,
        ];
    }
}
