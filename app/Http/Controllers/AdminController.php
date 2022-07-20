<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Role;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $users = User::all()->lazy();
        $userSelected = User::find(base64_decode($id));
        $roles = Role::all();
        return view('admin.users', compact('userSelected', 'users', 'roles'));
    }

    public function role($id)
    {
        $roles = Role::all();
        $roleSelected = Role::find(base64_decode($id));

        if (Auth::user()->role()->id == $roleSelected->id) {
            return redirect()->route('admin.roles')->withErrors('You can not edit your own role!');
        } else {
            return view('admin.roles', compact('roleSelected', 'roles'));
        }
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
