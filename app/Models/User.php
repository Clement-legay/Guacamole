<?php

namespace App\Models;

use App\Mail\UserConfirmation;
use App\Mail\UserVerification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'color',
        'profile_image',
        'banner_image',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'subscribes', 'user_subscribe_id', 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscribe::class);
    }

    public function isSubscribedTo(User $user)
    {
        return $this->subscriptions()->where('user_subscribe_id', $user->id)->exists();
    }

    public function sendEmailVerificationNotification()
    {
        Mail::to($this->email)->send(new UserVerification($this));
    }

    public function sendEmailConfirmationNotification()
    {
        Mail::to($this->email)->send(new UserConfirmation($this));
    }

    public function getAllComments()
    {
        return $this->hasManyThrough(Comment::class, Video::class);
    }

    public function mostViewedVideos($limit)
    {
        return $this->hasMany(Video::class)
            ->withCount('views')
            ->orderBy('views_count', 'desc')
            ->limit($limit);
    }

    public function getChanelViews($betweenFirst, $betweenLast)
    {
        $count = 0;
        foreach ($this->videos()->get() as $video) {
            $count += $video->viewCountById($betweenFirst, $betweenLast);
        }
        return $count;
    }

    public function getChanelTimeWatched($betweenFirst, $betweenLast)
    {
        $duration = 0;
        foreach ($this->videos()->get() as $video) {
            $duration += $video->viewTimeWatched($betweenFirst, $betweenLast);
        }

        if ($duration / 3600 < 24) {
            return floor($duration / 3600) . ' hours and ' . floor($duration % 3600 / 60) . ' minutes';
        } else {
            return floor($duration / 3600 / 24) . ' days';
        }

    }

    public function history()
    {
        return $this->hasManyThrough(Video::class, View::class, 'user_id', 'id', 'id', 'video_id')
            ->selectRaw('videos.*, views.id as view_id, views.time_watched as time_watched, views.updated_at as view_updated_at')
            ->orderBy('views.updated_at', 'desc')
            ->groupBy('video_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class)->where('is_liked', 1);
    }

    public function role() {
        return $this->belongsTo(Role::class)->first();
    }

    public function dislikes()
    {
        return $this->hasMany(Like::class)->where('is_liked', 0);
    }

    public function lastView($id) {
        return $this->hasMany(View::class)->where('video_id', $id)->orderBy('created_at', 'desc')->first();
    }

    public function profile_image($id=null)
    {
        if ($this->profile_image) {
            if ($id) {
                return "<img id='" . $id . "' width='100%' height='100%' style='border-radius: 50%' src='" . asset($this->profile_image) . "' alt='Profile Image' class='img-fluid'>";
            } else {
                return "<img width='100%' height='100%' style='border-radius: 50%' src='" . asset($this->profile_image) . "' alt='Profile Image' class='img-fluid'>";
            }
        } else {
            if ($id) {
                return "<div id='" . $id . "' style='border-radius: 50%; background: " . $this->color . "; color: white; width: 100%; height: 100%; padding-top: 17%; text-align: center; text-transform: uppercase; font-size: 2em'>" . substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1) . "</div>";
            } else {
                return "<div style='border-radius: 50%; background: " . $this->color . "; color: white; width: 100%; height: 100%; padding-top: 17%; text-align: center; text-transform: uppercase; font-size: 2em'>" . substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1) . "</div>";
            }
        }
    }

    public function hasView($id) {
        return $this->history()->orderBy('updated_at', 'desc')->where('video_id', $id)->first();
    }

    public function suggestions($limit)
    {
        $lastViews = $this->history()->limit(10)->get();

//        dd($this->mostViewedCategory(10)->get());


        $statsFromLastViews = [
            'mostUsedTag' => [],
            'mostUsedCategory' => [],
            'mostUsedChannel' => [],
        ];



        return $lastViews;
    }

    public function mostViewedCategory($limit)
    {
        return Category::selectRaw('categories.*')
            ->withCount('views', function ($query) {
                    $query->groupByRaw('videos.id')
                        ->join('videos', 'videos.category_id', '=', 'categories.id')
                        ->join('views', 'views.video_id', '=', 'videos.id')
                        ->where('views.user_id', $this->id);
                }
            )
            ->orderBy('views_from_count', 'desc');
    }

    public function mostViewedChannel($limit)
    {
        return User::selectRaw('users.*')
            ->withCount(array(
                'viewsFrom' => function ($query) {
                    $query->where('views.user_id', $this->id);
                }
            ))
            ->orderBy('views_from_count', 'desc')
            ->limit($limit);
    }

    public function mostViewedTag($limit)
    {
        return Tag::selectRaw('tags.*')
            ->withCount(array(
                'viewsFrom' => function ($query) {
                    $query->where('views.user_id', $this->id);
                }
            ))
            ->orderBy('views_from_count', 'desc')
            ->limit($limit);
    }

    public function viewsFrom()
    {
        return $this->hasManyThrough(View::class, Video::class);
    }

    public function hasLikedVideo($videoId)
    {
        return $this->likes()->where('video_id', $videoId)->exists();
    }

    public function hasDislikedVideo($videoId)
    {
        return $this->dislikes()->where('video_id', $videoId)->exists();
    }

    public function id()
    {
        return base64_encode($this->id);
    }

    public function isAdmin()
    {
        return $this->is_admin == 1;
    }

    public function likedVideos()
    {
        return $this->hasManyThrough(Video::class, Like::class, 'user_id', 'id', 'id', 'video_id')
            ->selectRaw('videos.*, likes.id as like_id, likes.is_liked as is_liked, likes.updated_at as like_updated_at')
            ->orderBy('likes.created_at', 'desc');
    }
}
