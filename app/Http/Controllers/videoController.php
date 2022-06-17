<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Video;
use App\Models\View;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSVideoFilters;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

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

        $view = View::create([
            'video_id' => $video->id,
            'user_id' => auth()->user()->id ?? null,
            'time_watched' => 0
        ]);

        $view->save();

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

        $category = Category::where('category_name', $request->category)->first();

        if ($request->hasFile('video')) {
            $lowFormat = (new X264('aac'))->setKiloBitrate(500);
            $highFormat = (new X264('aac'))->setKiloBitrate(1000);

            FFMpeg::open($request->file('video'))
                ->exportForHLS()
                ->addFormat($lowFormat, function (HLSVideoFilters $filters) {
                    $filters->resize(1280, 720);
                })
                ->addFormat($highFormat, function (HLSVideoFilters $filters) {
                    $filters->resize(1920, 1080);
                })
                ->toDisk('public')
                ->save('videos/videoTest.m3u8');

            $this->info('Video processing finished.');



            $request->file('video')->store('public/videos');
            $video = 'storage/videos/' . $request->file('video')->hashName();
        }

        if ($request->hasFile('thumbnail')) {
            $request->file('thumbnail')->store('public/thumbnails');
            $thumbnail = 'storage/thumbnails/' . $request->file('thumbnail')->hashName();
        }



        dd('no upload for now');

        $video = Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'video' => $video,
            'thumbnail' => $thumbnail,
            'type' => $request->type,
            'user_id' => auth()->user()->id,
            'category_id' => $category->id,
            'duration' => 0,
        ]);

        return redirect()->route('video.details', base64_encode($video->id));
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
