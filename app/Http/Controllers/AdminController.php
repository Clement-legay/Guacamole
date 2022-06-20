<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function videos()
    {
        $videos = Video::all();
        return view('admin.videos', compact('videos'));
    }

    public function comments()
    {
        $comments = Comment::whereNotNull('video_id')->get();
        return view('admin.comments', compact('comments'));
    }
}
