<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Role;
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

    public function roles()
    {
        $roles = Role::all();
        return view('admin.roles', compact('roles'));
    }

    public function user($id)
    {
        $users = User::all();
        $userSelected = User::find(base64_decode($id));
        $roles = Role::all();
        return view('admin.users', compact('userSelected', 'users', 'roles'));
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
