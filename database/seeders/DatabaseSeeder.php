<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        DB::table('Subscribes')->delete();
        DB::table('Views')->delete();
        DB::table('Tags')->delete();

        \App\Models\Role::factory(1)->create();
        \App\Models\User::factory(200)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Video::factory(100)->create();
        \App\Models\Comment::factory(200)->create();
        \App\Models\Like::factory(200)->create();
        \App\Models\Subscribe::factory(4000)->create();
        \App\Models\View::factory(4000)->create();
        \App\Models\Tag::factory(600)->create();
    }
}
