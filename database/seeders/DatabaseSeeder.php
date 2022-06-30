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
        DB::table('users')->delete();
        DB::table('tags')->delete();
        DB::table('videos')->delete();
        DB::table('categories')->delete();
        DB::table('comments')->delete();
        DB::table('likes')->delete();
        DB::table('roles')->delete();
        DB::table('subscribes')->delete();
        DB::table('views')->delete();
        DB::table('tag_assignments')->delete();

        \App\Models\Role::factory(1)->create();
        \App\Models\User::factory(200)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Video::factory(100)->create();
        \App\Models\Comment::factory(200)->create();
        \App\Models\Like::factory(200)->create();
        \App\Models\Subscribe::factory(4000)->create();
        \App\Models\View::factory(4000)->create();
        \App\Models\Tag::factory(600)->create();
        \App\Models\TagAssignment::factory(1000)->create();
    }
}
