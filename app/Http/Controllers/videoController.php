<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class videoController extends Controller
{
    public function index()
    {
        return view('video');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $videos = Video::where('title', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->get();

        return view('video.search', compact('videos', 'search'));
    }
}
