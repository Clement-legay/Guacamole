<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Payload;


class loginController extends Controller
{
    public function index()
    {
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->email_verified_at) {
                return redirect()->route('home');
            } else {
                Auth::logout();
                return redirect()->route('verification', base64_encode($id . '+pendingLogin'));
            }
        } else {
            return redirect()->route('login')->with('error', 'Invalid credentials');
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->back();
    }

    public function loginAPI(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = JWTFactory::claims([
                'sub' => Auth::user()->id,
                'email' => Auth::user()->email,
                'first_name' => Auth::user()->first_name,
                'last_name' => Auth::user()->last_name,
                'username' => Auth::user()->username,
                'profile_picture' => Auth::user()->profile_picture,
                'color' => Auth::user()->color,
                'role' => Auth::user()->role()->id,
                'iat' => time(),
                'exp' => time() + (60 * 60 * 24 * 30),
            ])->make();
            $token = JWTAuth::encode($user);
            if (Auth::user()->email_verified_at) {
                return response()->json(['success' => true, 'user' => $user]);
            } else {
                Auth::logout();
                return response()->json(['success' => false, 'error' => 'Email not verified']);
            }
        } else {
            return response()->json(['success' => false, 'error' => 'Invalid credentials']);
        }
    }
}
