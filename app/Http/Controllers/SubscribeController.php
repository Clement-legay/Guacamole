<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscribeController extends Controller
{
    public function subscribe(User $user)
    {
        if (Auth::user()->isSubscribedTo($user)) {
            return redirect()->back();
        }
        else {
            $subscribe = Subscribe::create(
                [
                    'user_id' => Auth::user()->id,
                    'user_subscribe_id' => $user->id,
                ]
            );

            $subscribe->save();

            return redirect()->back();
        }
    }

    public function unsubscribe(User $user)
    {
        if (Auth::user()->isSubscribedTo($user)) {
            Subscribe::where('user_id', Auth::user()->id)->where('user_subscribe_id', $user->id)->delete();

            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
