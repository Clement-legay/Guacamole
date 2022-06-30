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
            'isAdmin' => 1,

            'canWatchVideos' => 1,
            'canCreateVideo' => 1,
            'canUpdateVideo' => 1,
            'canUpdateOthersVideo' => 1,
            'canDeleteVideo' => 1,
            'canDeleteOthersVideo' => 1,

            'canViewUser' => 1,
            'canCreateUser' => 1,
            'canUpdateUserSelf' => 1,
            'canUpdateUserOther' => 1,
            'canDeleteUserSelf' => 1,
            'canDeleteUserOther' => 1,
            'canUpdateUserRole' => 1,

            'canViewRoles' => 1,
            'canCreateRole' => 1,
            'canUpdateRole' => 1,
            'canDeleteRole' => 1,

            'canViewComments' => 1,
            'canCreateComment' => 1,
            'canUpdateCommentSelf' => 1,
            'canUpdateCommentOther' => 1,
            'canDeleteCommentSelf' => 1,
            'canDeleteCommentOther' => 1,
        ];
    }
}
