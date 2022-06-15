<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'video_id',
        'time_watched'
    ];

    public function countViews(Video $video)
    {
        return $this->where('video_id', $video->id)->count();
    }

    //return an array of videos with the most views
    static function countViewsAll($betweenFirst, $limit)
    {
        return Video::join('views', 'videos.id', '=', 'views.video_id')
            ->whereBetween('views.created_at', [$betweenFirst, now()])
            ->selectRaw('videos.*, count(*) as views')
            ->groupBy('id')
            ->orderBy('views', 'desc')
            ->limit($limit)
            ->get();
    }

    static function countViewsByCat($betweenFirst, Category $category, $limit)
    {
        return Video::join('views', 'videos.id', '=', 'views.video_id')
            ->whereBetween('views.created_at', [$betweenFirst, now()])
            ->where('videos.category_id', $category->id)
            ->selectRaw('videos.*, count(*) as views')
            ->groupBy('id')
            ->orderBy('views', 'desc')
            ->limit($limit)
            ->get();
    }
}
