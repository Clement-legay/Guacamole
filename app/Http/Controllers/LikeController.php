<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like($video)
    {
        $video = Video::find(base64_decode($video));

        if (Like::where('user_id', Auth::user()->id)->where('video_id', $video->id)->exists())
        {
            if (Like::where('user_id', Auth::user()->id)->where('video_id', $video->id)->first()->is_liked == 1) {
                return redirect()->back();
            } else {
                Like::where('user_id', Auth::user()->id)->where('video_id', $video->id)->update(['is_liked' => 1]);
                return redirect()->back();
            }
        } else {
            $like = Like::create([
                'user_id' => Auth::id(),
                'video_id' => $video->id,
                'is_liked' => 1
            ]);

            $like->save();

            return redirect()->back();
        }
    }

    public function dislike($video)
    {
        $video = Video::find(base64_decode($video));

        if (Like::where('user_id', Auth::user()->id)->where('video_id', $video->id)->exists())
        {
            if (Like::where('user_id', Auth::user()->id)->where('video_id', $video->id)->first()->is_liked == 0) {
                return redirect()->back();
            } else {
                Like::where('user_id', Auth::user()->id)->where('video_id', $video->id)->update(['is_liked' => 0]);
                return redirect()->back();
            }
        } else {
            $like = Like::create([
                'user_id' => Auth::id(),
                'video_id' => $video->id,
                'is_liked' => 0
            ]);

            $like->save();

            return redirect()->back();
        }
    }

    public function deleteOpinion($video)
    {
        $video = Video::find(base64_decode($video));

        if (Like::where('user_id', Auth::user()->id)->where('video_id', $video->id)->exists())
        {
            Like::where(['user_id' => Auth::id(), 'video_id' => $video->id])->delete();
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
