<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $id = Auth::user()->id;
            if (Auth::user()->email_verified_at) {
                return redirect()->route('home');
            } else {
                Auth::logout();
                return redirect()->route('verification', base64_encode($id . '+pendingLogin'));
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('home');
    }
}
