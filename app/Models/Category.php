<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name',
    ];

    protected $hidden = [
        'id_user',
        'id_video',

    ];

    static function searchCategory($search, $limit)
    {
        return Category::where('category_name', 'like', '%' . $search . '%')->take($limit)->get();
    }
}
