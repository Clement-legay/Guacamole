<?php

namespace App\Models;

use FFMpeg\Format\Video\X264;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;
use App\Models\User;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'video',
        'thumbnail',
        'description',
        'type',
        'user_id',
        'category_id',
        'duration',
        'progress',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setProgress($progress)
    {
        $this->progress = $progress;
        $this->save();
    }

    public function setDone($link)
    {
        $this->video = $link;
        $this->status = 'online';
        $this->save();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sinceWhen()
    {
        return $this->created_at->diffForHumans();
    }

    public function getDuration()
    {
        return gmdate("H:i:s", $this->duration);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function id()
    {
        return base64_encode($this->id);
    }

    public function likes()
    {
        return $this->hasMany(Like::class)->where('is_liked', 1);
    }

    public function dislikes()
    {
        return $this->hasMany(Like::class)->where('is_liked', 0);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function tags()
    {
       return $this->hasMany(Tag::class, 'video_id');
    }

    public function tagsName()
    {
       return $this->hasMany(Tag::class, 'video_id')->get()->pluck('name')->implode(' ');
    }

    public function viewCountById($betweenFirst, $betweenLast)
    {
        return $this->hasMany(View::class)->whereBetween('created_at', [$betweenFirst, $betweenLast])->get()->count();
    }

    public function viewTimeWatched($betweenFirst, $betweenLast)
    {
        return $this->hasMany(View::class)->whereBetween('created_at', [$betweenFirst, $betweenLast])->get()->sum('time_watched');
    }

    public function video()
    {
        $encryptionKey = HLSExporter::generateEncryptionKey();

        $lowBitrate = (new X264('aac'))->setKiloBitrate(128);
        $midBitrate = (new X264('aac'))->setKiloBitrate(256);
        $highBitrate = (new X264('aac'))->setKiloBitrate(512);
        $ultraBitrate = (new X264('aac'))->setKiloBitrate(1024);

        FFMpeg::open(asset($this->video))
            ->exportForHLS()
            ->withEncryptionKey($encryptionKey)
            ->addFormat($lowBitrate)
            ->addFormat($midBitrate)
            ->addFormat($highBitrate)
            ->addFormat($ultraBitrate)
            ->save('encrypted_video.m3u8');
    }
}
