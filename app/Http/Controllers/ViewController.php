<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use App\Models\View;

class ViewController extends Controller
{
    public function update($id)
    {
        $time = request('time');

        $view = View::find(base64_decode($id));

        if ($view->user()) {
            $video = $view->video();

            $percentInterest = round($time / $video->duration, 1.5) * 10 + 5;
            $interest = Interest::firstOrCreate(['user_id' => $view->user()->id]);
            $userInterest = json_decode($interest->interest, true);


            if (!array_key_exists($video->category()->id, $userInterest['categories'])) {
                $userInterest['categories'][$video->category()->id] = 0;
            }

            $tags = $video->tags()->get();

            foreach ($tags as $tag) {
                if (!array_key_exists($tag->id, $userInterest['tags'])) {
                    $userInterest['tags'][$tag->id] = 0;
                }
            }

            if (!array_key_exists($video->user()->id, $userInterest['channels'])) {
                $userInterest['channels'][$video->user()->id] = 0;
            }


            foreach ($userInterest as $key => $value) {
                if ($key == 'categories') {
                    foreach ($value as $keyCat => $category) {
                        if ($video->category()->id == $keyCat) {
                            $userInterest[$key][$keyCat] += $percentInterest;
                            if ($userInterest[$key][$keyCat] > 100) $userInterest[$key][$keyCat] = 100;
                        } else {
                            $userInterest[$key][$keyCat] -= 1;
                            if ($userInterest[$key][$keyCat] < 0) $userInterest[$key][$keyCat] = 0;
                        }
                    }
                    arsort($userInterest[$key]);
                } else if ($key == 'tags') {
                    foreach ($value as $keyTag => $tag) {
                        if (in_array($keyTag, $tags)) {
                            $userInterest[$key][$keyTag] += $percentInterest;
                            if ($userInterest[$key][$keyTag] > 100) $userInterest[$key][$keyTag] = 100;
                        } else {
                            $userInterest[$key][$keyTag] -= 1;
                            if ($userInterest[$key][$keyTag] < 0) $userInterest[$key][$keyTag] = 0;
                        }
                    }
                    arsort($userInterest[$key]);
                } else if ($key == 'channels') {
                    foreach ($value as $keyCha => $channel) {
                        if ($video->user()->id == $keyCha) {
                            $userInterest[$key][$keyCha] += $percentInterest;
                            if ($userInterest[$key][$keyCha] > 100) $userInterest[$key][$keyCha] = 100;
                        } else {
                            $userInterest[$key][$keyCha] -= 1;
                            if ($userInterest[$key][$keyCha] < 0) $userInterest[$key][$keyCha] = 0;
                        }
                    }
                    arsort($userInterest[$key]);
                }
            }

            $interest->interest = json_encode($userInterest);
            $interest->save();
        }

        $view->time_watched = $time;
        $view->save();

        return response()->json(['success' => true]);
    }
}
