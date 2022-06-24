<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscribeController extends Controller
{
    public function subscribe($user)
    {
        $user = User::find(base64_decode($user));

        if (Auth::user()->isSubscribedTo($user)) {
            return redirect()->back();
        }
        else {
            $subscribe = Subscribe::create(
                [
                    'user_id' => Auth::id(),
                    'user_subscribe_id' => $user->id,
                ]
            );

            $subscribe->save();

            return redirect()->back();
        }
    }

    public function unsubscribe($user)
    {
        $user = User::find(base64_decode($user));

        if (Auth::user()->isSubscribedTo($user)) {
            Subscribe::where('user_id', Auth::id())->where('user_subscribe_id', $user->id)->delete();

            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function sendSubscribe($user, $channel)
    {
        $user = User::find(base64_decode($user));
        $channel = User::find(base64_decode($channel));

        if ($user->isSubscribedTo($channel)) {
            return response()->json(['success' => false, 'message' => 'You are already subscribed to this channel']);
        }
        else {
            $subscribe = Subscribe::create(
                [
                    'user_id' => $user->id,
                    'user_subscribe_id' => $channel->id,
                ]
            );

            $subscribe->save();

            return response()->json(['success' => true, 'message' => 'You are now subscribed to this channel']);
        }
    }

    public function sendUnsubscribe($user, $channel)
    {
        $user = User::find(base64_decode($user));
        $channel = User::find(base64_decode($channel));

        if ($user->isSubscribedTo($channel)) {
            Subscribe::where('user_id', $user->id)->where('user_subscribe_id', $channel->id)->delete();

            return response()->json(['success' => true, 'message' => 'You are now unsubscribed from this channel']);
        } else {
            return response()->json(['success' => false, 'message' => 'You are not subscribed to this channel']);
        }
    }
}
