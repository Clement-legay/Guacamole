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

    public function watch($video)
    {
        $video = Video::find(base64_decode($video));

        return view('video.player', compact('video'));
    }

    public function create()
    {
        return view('video.manage.create');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'title' => 'required|max:191',
            'description' => 'required|max:191',
            'video' => 'required|mimes:mp4,mov,ogg,qt',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'type' => 'required',
        ]);

        Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'video' => $request->video->store('videos'),
            'thumbnail' => $request->thumbnail->store('thumbnails'),
            'type' => $request->type,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('video.manage');
    }

    public function show($video)
    {
        $video = Video::find(base64_decode($video));

        return view('video.manage.show', compact('video'));
    }

    public function edit($video)
    {
        $video = Video::find(base64_decode($video));

        return view('video.manage.show', compact('video'));
    }

    public function dashboard($video)
    {
        $video = Video::find(base64_decode($video));

        return view('video.manage.show', compact('video'));
    }

    public function comments($video)
    {
        $video = Video::find(base64_decode($video));

        return view('video.manage.show', compact('video'));
    }
}
