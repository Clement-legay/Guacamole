<?php

namespace App\Models;

use App\Mail\UserConfirmation;
use App\Mail\UserVerification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
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
        return $this->hasManyThrough(View::class, Video::class)->whereBetween('views.updated_at', [$betweenFirst, $betweenLast])->count();
    }

    public function chanelViews()
    {
        return $this->hasManyThrough(View::class, Video::class);
    }

    public function getChanelTimeWatched($betweenFirst, $betweenLast)
    {
        $duration = $this->hasManyThrough(View::class, Video::class)->whereBetween('views.updated_at', [$betweenFirst, $betweenLast])->selectRaw('SUM(time_watched) as duration')->get()->first()->duration;

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

    public function interest($selected=null)
    {
        if ($this->hasOne(Interest::class)->first()) {
            $interest = $this->hasOne(Interest::class)->first();
            $interest->interest = json_decode($interest->interest);

            if ($selected) {
                return $interest->interest->$selected;
            } else {
                return $interest->interest;
            }
        }
        return null;
    }

    public function interestCategories($limit=20)
    {
        $categoriesIds = [];
        if ($this->interest('tags')) {
            foreach ($this->interest('categories') as $key => $value) {
                $categoriesIds[] = $key;
                if (count($categoriesIds) == $limit) {
                    break;
                }
            }
        }

        $suggestedCategories = Category::whereIn('id', $categoriesIds)->withcount('views');
        if ($suggestedCategories->count() < $limit) {
            $fillCategories = Category::mostViewed()
                ->whereNotIn('id', $categoriesIds)
                ->limit($limit - $suggestedCategories->count());
            $suggestedCategories = $suggestedCategories->union($fillCategories);
        }

        return $suggestedCategories;
    }

    public function interestTags($limit=20)
    {
        $tagsIds = [];
        if ($this->interest('tags')) {
            foreach ($this->interest('tags') as $key => $value) {
                $tagsIds[] = $key;
                if (count($tagsIds) == $limit) {
                    break;
                }
            }
        }

        $suggestedTags = Tag::whereIn('id', $tagsIds)->withcount('views');


        if ($suggestedTags->count() < $limit) {
            $fillTags = Tag::mostViewed()
                ->whereNotIn('id', $tagsIds)
                ->limit($limit - $suggestedTags->count());

            $suggestedTags = $suggestedTags->union($fillTags);
        }

        return $suggestedTags;
    }

    public function interestChannel($limit=20)
    {
        $channelsIds = [];
        if ($this->interest('channels')) {
            foreach ($this->interest('channels') as $key => $value) {
                $channelsIds[] = $key;
                if (count($channelsIds) == $limit) {
                    break;
                }
            }
        }

        $suggestedChannels = User::whereIn('id', $channelsIds)->withcount('chanelViews');
        if ($suggestedChannels->count() < $limit) {
            $fillChannels = User::mostViewed()
                ->whereNotIn('id', $channelsIds)
                ->limit($limit - $suggestedChannels->count());
            $suggestedChannels = $suggestedChannels->union($fillChannels);
        }

        return $suggestedChannels;
    }

    public function suggestedVideos($limit)
    {
//        $ids = [];
//        if ($this->interest()) {
//            foreach ($this->interest() as $key => $value) {
//                foreach ($value as $k => $v) {
//                    $ids[$key][] = $k;
//                    if (count($ids[$key]) == $limit) {
//                        break;
//                    }
//                }
//            }
//        }
//
////        dd($ids);
//
//        // select all video not seen by user
//        $suggestedVideos = Video::join('views', 'views.video_id', '=', 'videos.id')
//            ->whereNotIn('videos.id', function ($query) {
//                if ($this->hasView($query->id)->time_watched) {
//                    $query->select('video_id')->from('views')->where('user_id', $this->id);
//                }
//            })
//            ->selectRaw('videos.*, views.id as view_id, views.time_watched as time_watched, views.updated_at as view_updated_at')
//            ->when(!empty($ids), function ($query) use ($ids) {
//                foreach ($query->get() as $key => $value) {
//                    if (isset($ids['categories'][$value->category_id])) {
//                        if (in_array($value->id, $ids[$value->category_id])) {
//                            $query->offsetUnset($key);
//                        }
//                    }
//                }
//            })
//            ->orderBy('views.updated_at', 'desc')
//            ->groupBy('video_id');
//
//        dd($suggestedVideos->get());

        return Video::withCount('views')->where('videos.status', '=', 'online')->where('videos.type', '=', 'public')->orderBy('views_count', 'desc')->whereNotIn('videos.id', $this->history()->pluck('id'))->limit($limit)->get();
    }

    public function hasLikedVideo($videoId)
    {
        return $this->likes()->where('video_id', base64_decode($videoId))->exists();
    }

    public function hasDislikedVideo($videoId)
    {
        return $this->dislikes()->where('video_id', base64_decode($videoId))->exists();
    }

    public function id64()
    {
        return base64_encode($this->id);
    }

    public function isAdmin()
    {
        return $this->isAdmin == 1;
    }

    public function likedVideos()
    {
        return $this->hasManyThrough(Video::class, Like::class, 'user_id', 'id', 'id', 'video_id')
            ->selectRaw('videos.*, likes.id as like_id, likes.is_liked as is_liked, likes.updated_at as like_updated_at')
            ->orderBy('likes.created_at', 'desc');
    }

    static function mostViewed()
    {
        return User::withCount(array(
            'chanelViews' => function ($query) {
                $query->whereBetween('views.updated_at', [now()->subDay(2), now()]);
            }
        ))
            ->orderBy('chanel_views_count', 'desc');
    }

    public function apikey()
    {
        return $this->hasOne(Apikey::class)->first();
    }
}
