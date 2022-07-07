<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\verificationToken;
use App\Models\Video;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function other($user)
    {
        $user = User::find(base64_decode($user));

        return view('user.channel', compact('user'));
    }

    public function upload()
    {
        return view('user.profile.content', ['upload' => true]);
    }

    public function verify($token)
    {
        if (verificationToken::all()->where('token', $token)->first()) {
            $tokenDecoded = base64_decode($token);
            $id = explode('+', $tokenDecoded)[0];
            $limitDate = explode('+', $tokenDecoded)[1];

            if (time() > $limitDate) {
                $status = 'expired';
                return view('Auth.verification', compact('token', 'status'));
            } else {
                $user = User::find($id);
                if ($user->email_verified_at) {
                    $status = 'already';
                    return view('Auth.verification', compact('token', 'status'));
                } else {
                    $user->email_verified_at = now();
                    $user->save();

                    $user->sendEmailConfirmationNotification();

                    $status = 'success';
                    return view('Auth.verification', compact('token', 'status'));
                }
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function verification($token)
    {
        $tokenDecoded = base64_decode($token);
        $user = User::find(explode('+', $tokenDecoded)[0]);

        if ($user->email_verified_at) {
            return redirect()->route('home');
        } else {
            $status = explode('+', $tokenDecoded)[1];
            return view('Auth.verification', compact('user', 'status'));
        }
    }

    public function resend($user)
    {
        $user = User::find(base64_decode($user));

        if ($user->email_verified_at) {
            return redirect()->route('home');
        } else {
            $user->sendEmailVerificationNotification();
            return redirect()->route('verification', base64_encode($user->id . '+pending'));
        }
    }

    public function profile()
    {
        return view('user.profile.account');
    }

    public function dashboard()
    {
        return view('user.profile.dashboard');
    }

    public function comments() {
        return view('user.profile.comments');
    }

    public function edit($user)
    {
        $user = User::find(base64_decode($user));

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $user)
    {
        $user = User::find(base64_decode($user));

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'color' => 'required',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner_image' =>  'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->color = $request->color;
        $user->profile_image = $request->profile_image;
        $user->banner_image = $request->banner_image;
        $user->role = $request->role;
        $user->save();

        return redirect()->back();
    }

    public function adminUpdate(Request $request, $user)
    {
        $user = User::find(base64_decode($user));

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required'
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->save();

        return redirect()->back();
    }

    public function adminDelete($user)
    {
        $user = User::find(base64_decode($user));

        $user->delete();

        return redirect()->route('admin.users');
    }

    public function getUser($user)
    {
        $user = User::find(base64_decode($user));

        return response()->json([
            'user' => $user
        ]);
    }

    public function getUserSubscribers($user)
    {
        $details = request('details') ?? 0;
        $page = request('page') ?? 1;
        $limit = request('limit') ?? 10;

        $user = User::find(base64_decode($user));

        if ($details) {
            return response()->json([
                'subscribers' => $user->subscribers()->forPage($page, $limit)->get(),
            ]);
        } else {
            return response()->json([
                'subscribers' => $user->subscribers()->count()
            ]);
        }
    }

    public function getUserSubscriptions($user)
    {
        $details = request('details') ?? 0;
        $page = request('page') ?? 1;
        $limit = request('limit') ?? 10;

        $user = User::find(base64_decode($user));

        if ($details) {
            return response()->json([
                'subscriptions' => $user->subscriptions()->forPage($page, $limit)->get(),
            ]);
        } else {
            return response()->json([
                'subscriptions' => $user->subscriptions()->count()
            ]);
        }
    }

    public function getUserHasView($user, $video)
    {
        $user = User::find(base64_decode($user));
        $video = Video::find(base64_decode($video));

        $view = $user->hasView($video->id) ?? View::create([
                'user_id' => $user->id,
                'video_id' => $video->id,
            ]);

        return response()->json([
            'hasView' => $view
        ]);
    }

    public function getUserHistory($user)
    {
        $user = User::find(base64_decode($user));
        $page = request('page') ?? 1;
        $limit = request('limit') ?? 10;

        return response()->json([
            'history' => $user->history()->orderBy('created_at', 'desc')->groupBy('video_id')->forPage($page, $limit)->get()
        ]);
    }
}
