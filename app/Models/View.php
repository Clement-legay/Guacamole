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

    public function id64() {
        return base64_encode($this->id);
    }

    public function countViews(Video $video)
    {
        return $this->where('video_id', $video->id)->count();
    }

    //return an array of videos with the most views
    static function countViewsAll($betweenFirst, $limit)
    {
        return Video::withCount('views')
            ->orderBy('views_count', 'desc')
            ->limit($limit)
            ->where('type', 'public')
            ->where('status', 'online')
            ->get();
    }

    static function countViewsByCat(Category $category, $limit)
    {
        return Video::withCount('views')
            ->where('category_id', $category->id)
            ->orderBy('views_count', 'desc')
            ->limit($limit)
            ->where('type', 'public')
            ->where('status', 'online')
            ->get();
    }

    public function video()
    {
        return $this->belongsTo(Video::class)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }
}
