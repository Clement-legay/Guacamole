<?php

namespace App\Http\Controllers;

use App\Models\View;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function update($id)
    {
        $time = request('time');

        $view = View::find(base64_decode($id));
        $view->time_watched = $time;
        $view->save();

        return response()->json(['success' => true]);
    }
}
