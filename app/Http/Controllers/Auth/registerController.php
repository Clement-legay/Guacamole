<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class registerController extends Controller
{

    public function index()
    {
        return view('Auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|regex:/^[a-zA-Z0-9\-_]+$/',
            'last_name' => 'required|regex:/^[a-zA-Z0-9\-_]+$/',
            'username' => 'required|unique:users|regex:/^[a-zA-Z0-9\-_]+$/',
            'color' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $role = Role::firstOrCreate(['name' => 'default']);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'color' => $request->color,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);

        $user->sendEmailVerificationNotification();

        return redirect()->route('verification', base64_encode($user->id . '+pending'));
    }

    public function registerAPI(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'color' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $role = Role::firstOrCreate(['name' => 'default']);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'color' => $request->color,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);

        $user->sendEmailVerificationNotification();

        return response()->json(['success' => true]);
    }
}
