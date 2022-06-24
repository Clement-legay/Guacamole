<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:191',
        ]);

        $comment = Comment::create([
            'comment' => $request->comment,
            'user_id' => auth()->user()->id,
            'video_id' => $request->video_id ? base64_decode($request->video_id) : null,
            'previous_id' => $request->previous_id ? base64_decode($request->previous_id) : null,
        ]);

        $comment->save();

        return redirect()->back();
    }

    public function getComment($comment)
    {
        $comment = Comment::find(base64_decode($comment));

        return json_encode([
            'comment' => $comment,
        ]);
    }

    public function getReplies($comment)
    {
        $comment = Comment::find(base64_decode($comment));

        return json_encode([
            'replies' => $comment->replies()->get(),
        ]);
    }

    public function commentAPI(Request $request, $user, $video)
    {
        $user = User::find(base64_decode($user));
        $video = Video::find(base64_decode($video));

        $request->validate([
            'comment' => 'required|string|max:191',
        ]);

        $comment = Comment::create([
            'comment' => $request->comment,
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);

        $comment->save();

        return response()->json(['success' => true]);
    }

    public function replyAPI(Request $request, $user, $comment)
    {
        $user = User::find(base64_decode($user));
        $comment = Comment::find(base64_decode($comment));

        $request->validate([
            'comment' => 'required|string|max:191',
        ]);

        $comment = Comment::create([
            'comment' => $request->comment,
            'user_id' => $user->id,
            'previous_id' => $comment->id,
        ]);

        $comment->save();

        return response()->json(['success' => true]);
    }

    public function deleteAPI($comment, $user)
    {
        $user = User::find(base64_decode($user));
        $comment = Comment::find(base64_decode($comment));

        if ($comment->user_id == $user->id) {
            $comment->delete();
        }

        return response()->json(['success' => true]);
    }
}
