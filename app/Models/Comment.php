<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment',
        'user_id',
        'video_id',
        'previous_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }

    public function video()
    {
        return $this->belongsTo(Video::class)->first();
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'previous_id');
    }

    public function id64() {
        return base64_encode($this->id);
    }
}
