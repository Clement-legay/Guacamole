<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function videos()
    {
        return $this->hasManyThrough(Video::class, TagAssignment::class);
    }

    public function viewsFrom()
    {
        return $this->hasManyThrough(View::class, TagAssignment::class, 'tag_id', 'video_id', 'id', 'video_id');
    }
}
