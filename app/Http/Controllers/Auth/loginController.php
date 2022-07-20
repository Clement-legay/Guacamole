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
            $id = Auth::user()->id;
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
            if (Auth::user()->email_verified_at) {
                $id = Auth::user()->id;
                return response()->json(['success' => true, 'id' => $id]);
            } else {
                Auth::logout();
                return response()->json(['success' => false, 'error' => 'Email not verified']);
            }
        } else {
            return response()->json(['success' => false, 'error' => 'Invalid credentials']);
        }
    }
}
