<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like($video, $user=null)
    {
        $userId = $user ? User::find(base64_decode($user))->id : Auth::id();
        $video = Video::find(base64_decode($video));

        if (Like::where('user_id', $userId)->where('video_id', $video->id)->exists())
        {
            if (Like::where('user_id', $userId)->where('video_id', $video->id)->first()->is_liked == 1) {
                if ($user) {
                    return response()->json(['success' => true, 'message' => 'Liked']);
                } else {
                    return redirect()->back();
                }
            } else {
                Like::where('user_id', $userId)->where('video_id', $video->id)->update(['is_liked' => 1]);
                if ($user) {
                    return response()->json(['success' => true, 'message' => 'Liked']);
                } else {
                    return redirect()->back();
                }
            }
        } else {
            $like = Like::create([
                'user_id' => $userId,
                'video_id' => $video->id,
                'is_liked' => 1
            ]);

            $like->save();

            if ($user) {
                return response()->json(['success' => true, 'message' => 'Liked']);
            } else {
                return redirect()->back();
            }
        }
    }

    public function dislike($video, $user=null)
    {
        $userId = $user ? User::find(base64_decode($user))->id : Auth::id();
        $video = Video::find(base64_decode($video));

        if (Like::where('user_id', $userId)->where('video_id', $video->id)->exists())
        {
            if (Like::where('user_id', $userId)->where('video_id', $video->id)->first()->is_liked == 0) {
                if ($user) {
                    return response()->json(['success' => true, 'message' => 'Liked']);
                } else {
                    return redirect()->back();
                }
            } else {
                Like::where('user_id', $userId)->where('video_id', $video->id)->update(['is_liked' => 0]);
                if ($user) {
                    return response()->json(['success' => true, 'message' => 'Liked']);
                } else {
                    return redirect()->back();
                }
            }
        } else {
            $like = Like::create([
                'user_id' => $userId,
                'video_id' => $video->id,
                'is_liked' => 0
            ]);

            $like->save();

            if ($user) {
                return response()->json(['success' => true, 'message' => 'Liked']);
            } else {
                return redirect()->back();
            }
        }
    }

    public function deleteOpinion($video, $user=null)
    {
        $userId = $user ? User::find(base64_decode($user))->id : Auth::id();
        $video = Video::find(base64_decode($video));

        if (Like::where('user_id', $userId)->where('video_id', $video->id)->exists())
        {
            Like::where(['user_id' => $userId, 'video_id' => $video->id])->delete();
            if ($user) {
                return response()->json(['success' => true, 'message' => 'Liked']);
            } else {
                return redirect()->back();
            }
        } else {
            if ($user) {
                return response()->json(['success' => true, 'message' => 'Liked']);
            } else {
                return redirect()->back();
            }
        }
    }
}
