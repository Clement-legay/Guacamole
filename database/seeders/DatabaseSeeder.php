<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::factory(1)->create();
        \App\Models\User::factory(20)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Video::factory(10)->create();
        \App\Models\Comment::factory(20)->create();
        \App\Models\Like::factory(200)->create();
    }
}
