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
        DB::table('Users')->delete();
        DB::table('Videos')->delete();
        DB::table('Categories')->delete();
        DB::table('Comments')->delete();
        DB::table('Likes')->delete();
        DB::table('Roles')->delete();

        \App\Models\Role::factory(1)->create();
        \App\Models\User::factory(200)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Video::factory(100)->create();
        \App\Models\Comment::factory(200)->create();
        \App\Models\Like::factory(200)->create();
    }
}
