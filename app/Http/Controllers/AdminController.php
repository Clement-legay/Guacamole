<?php

namespace App\Http\Controllers;

use App\Models\Apikey;
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
        $searchUser = request('search');
        $roleSelected = request('role');
        $page = request('page') ?? 1;

        $roles = Role::all();
        $users = User::where(function ($query) use ($roleSelected) {
            if ($roleSelected) {
                $query->where('role_id', $roleSelected);
            }
        })
        ->where(function ($query) use ($searchUser)
        {
            if ($searchUser) {
                $query->where('username', 'like', '%' . $searchUser . '%')
                    ->orWhere('first_name', 'like', '%' . $searchUser . '%')
                    ->orWhere('last_name', 'like', '%' . $searchUser . '%');
            }
        })->limit(30)->offset($page * 30 - 30)->get();

        return view('admin.users', compact('users', 'searchUser', 'roles', 'roleSelected'));
    }

    public function roles()
    {
        $roles = Role::all();
        return view('admin.roles', compact('roles'));
    }

    public function user($id)
    {
        $searchUser = request('search');
        $roleSelected = request('role');
        $page = request('page') ?? 1;

        $roles = Role::all();
        $users = User::where(function ($query) use ($roleSelected) {
            if ($roleSelected) {
                $query->where('role_id', $roleSelected);
            }
        })
            ->where(function ($query) use ($searchUser)
            {
                if ($searchUser) {
                    $query->where('username', 'like', '%' . $searchUser . '%')
                        ->orWhere('first_name', 'like', '%' . $searchUser . '%')
                        ->orWhere('last_name', 'like', '%' . $searchUser . '%');
                }
            })->limit(30)->offset($page * 30 - 30)->get();
        $userSelected = User::find(base64_decode($id));
        $roles = Role::all();
        return view('admin.users', compact('userSelected', 'users', 'roles', 'roleSelected', 'searchUser'));
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

    public function token()
    {
        return view('admin.headerGenerator');
    }

    public function tokenGenerate()
    {
        return view('admin.headerGenerator');
    }

    public function tokenGeneration(Request $request)
    {
        $request->validate([
            // regex only allows letters and caps
            'key' => 'required|string|max:191|regex:/^[a-zA-Z]+$/',
        ]);

        Apikey::create([
            'key' => $request->key,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.token');
    }

    public function tokenDelete()
    {
        Auth::user()->apikey()->delete();

        return redirect()->route('admin.token');
    }
}
