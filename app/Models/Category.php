<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name',
    ];

    static function searchCategory($search, $limit)
    {
        return Category::where('category_name', 'like', '%' . $search . '%')->take($limit)->get();
    }

    public function viewsFrom()
    {
        return $this->hasManyThrough(View::class, Video::class, 'category_id', 'video_id', 'id', 'video_id');
    }
}
