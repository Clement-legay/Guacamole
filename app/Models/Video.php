<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'video',
        'thumbnail',
        'description',
        'type',
    ];

    protected $hidden = [
        'id_user',
        'id_video',
        'is_liked',
        'is_disliked',
        'duration',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function sinceWhen()
    {
        return $this->created_at->diffForHumans();
    }
}
