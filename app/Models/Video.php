<?php

namespace App\Models;

use FFMpeg\Format\Video\X264;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
        'status',
        'description',
        'type',
        'user_id',
        'category_id',
        'duration',
        'processState',
        'quality'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }

    public function ready()
    {
        return $this->title && $this->thumbnail && $this->description && $this->category_id;
    }

    public function thumbnail()
    {
        if ($this->thumbnail) {
            return asset($this->thumbnail);
        } else {
            return $this->getFrameForHtml($this->duration * 0.1);
        }
    }

    public function quality()
    {
        $quality = (int) explode('x', $this->quality)[0];
        return $quality < 1080 ? 'low' : ($quality > 1440 ? 'high' : 'medium');
    }

    public function setProgress($progress)
    {
        $this->processState = $progress;
        $this->save();
    }

    public function getProgress() {
        dd((int) $this->processState);
    }

    public function setDone($link, $status)
    {
        $this->video = $link;
        $this->status = $status;
        $this->save();
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->first();
    }

    public function sinceWhen()
    {
        return $this->created_at->diffForHumans();
    }

    public function getFrame($timestamp)
    {
        if (count(explode('storage/', $this->video)) > 1) {
            $video = FFMpeg::open('public/' . explode('storage/', $this->video)[1]);
        } else {
            $video = FFMpeg::open('public/uploads/' . $this->video);
        }
        $frame = $video->getFrameFromSeconds($timestamp);
        $frame = $frame->export()->getFrameContents();

        return base64_encode($frame);
    }

    function getFrameForHtml($timestamp)
    {
        if (count(explode('storage/', $this->video)) > 1) {
            $video = FFMpeg::open('public/' . explode('storage/', $this->video)[1]);
        } else {
            $video = FFMpeg::open('public/uploads/' . $this->video);
        }

        $frame = $video->getFrameFromSeconds($timestamp);
        $frame = $frame->export()->getFrameContents();

        return 'data:image/JFIF;base64,' . base64_encode($frame);
    }

    public function getDuration()
    {
        $hours = gmdate('H', $this->duration) > 0 ? gmdate('H', $this->duration) : false;
        $minutes = gmdate('i', $this->duration) > 0 ? gmdate('i', $this->duration) : 00;
        $seconds = gmdate('s', $this->duration) > 0 ? gmdate('s', $this->duration) : 00;

        if ($hours) {
            return $hours . ':' . $minutes . ':' . $seconds;
        } else {
            return $minutes . ':' . $seconds;
        }
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function id64()
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
        return Tag::join('tag_assignments', 'tag_assignments.tag_id', '=', 'tags.id')
            ->where('tag_assignments.video_id', $this->id);
    }

    public function tagsAssignments()
    {
        return $this->hasMany(TagAssignment::class);
    }

    public function tagsName()
    {
        return Tag::join('tag_assignments', 'tag_assignments.tag_id', '=', 'tags.id')
            ->where('video_id', $this->id)
            ->select('tags.name')
            ->get()
            ->pluck('name')
            ->implode(' ');
    }

    public function viewCountById($betweenFirst, $betweenLast)
    {
        return $this->hasMany(View::class)->whereBetween('created_at', [$betweenFirst, $betweenLast])->get()->count();
    }

    public function viewTimeWatched($betweenFirst, $betweenLast)
    {
        return $this->hasMany(View::class)->whereBetween('created_at', [$betweenFirst, $betweenLast])->get()->sum('time_watched');
    }

//    public function video()
//    {
//        $encryptionKey = HLSExporter::generateEncryptionKey();
//
//        $lowBitrate = (new X264('aac'))->setKiloBitrate(128);
//        $midBitrate = (new X264('aac'))->setKiloBitrate(256);
//        $highBitrate = (new X264('aac'))->setKiloBitrate(512);
//        $ultraBitrate = (new X264('aac'))->setKiloBitrate(1024);
//
//        FFMpeg::open(asset($this->video))
//            ->exportForHLS()
//            ->withEncryptionKey($encryptionKey)
//            ->addFormat($lowBitrate)
//            ->addFormat($midBitrate)
//            ->addFormat($highBitrate)
//            ->addFormat($ultraBitrate)
//            ->save('encrypted_video.m3u8');
//    }
}
