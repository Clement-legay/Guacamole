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

    public function viewsFrom()
    {
        return $this->hasManyThrough(View::class, TagAssignment::class, 'tag_id', 'video_id', 'id', 'video_id');
    }

    public function videos()
    {
        return $this->hasManyThrough(Video::class, TagAssignment::class, 'tag_id', 'id', 'video_id', 'video_id');
    }

    public function views()
    {
        return $this->hasManyThrough(View::class, TagAssignment::class, 'tag_id', 'video_id', 'id', 'video_id');
    }

    static function mostViewed()
    {
        return Tag::withCount(array(
            'views' => function ($query) {
                $query->whereBetween('views.updated_at', [now()->subDay(2), now()]);
            }
        ))
            ->orderBy('views_count', 'desc');
    }

}
