<?php

namespace App\Http\Controllers;

use App\Models\View;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function update($id)
    {
        return response()->json(['status' => 'ntm']);
        $time = request()->input('time');

        $view = View::find($id);
        $view->time_watched = $time;
        $view->save();

        return response()->json(['success' => true]);
    }
}
