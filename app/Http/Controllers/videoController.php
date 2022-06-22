<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
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

    public function delete($video)
    {
        $video = Video::find(base64_decode($video));

        unlink(storage_path('app/public/videos/' . explode('/', $video->video)[count(explode('/', $video->video)) - 1]));

        unlink(storage_path('app/public/thumbnails/' . explode('/', $video->thumbnail)[count(explode('/', $video->thumbnail)) - 1]));

        $video->delete();

        return redirect()->route('profile.content');
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
            'category' => 'required',
        ]);

        $category = Category::firstOrCreate(['category_name' => $request->category]);

        if ($request->hasFile('video')) {
            $return = $request->file('video')->store('public/uploads');
            if ($return) {
                $video = 'storage/uploads/' . $request->file('video')->hashName();
            } else {
                return redirect()->back()->with('error', 'Error uploading video');
            }
        }

        $ffmpeg = FFMpeg::open('public/uploads/' . $request->file('video')->hashName());
        $duration = $ffmpeg->getDurationInSeconds();
        $link = $this->encryptHLS($request->file('video')->hashName());

        unlink(storage_path('app/public/uploads/' . $request->file('video')->hashName()));

        if ($request->hasFile('thumbnail')) {
            $return = $request->file('thumbnail')->store('public/thumbnails');
            if ($return) {
                $thumbnail = 'storage/thumbnails/' . $request->file('thumbnail')->hashName();
            } else {
                return redirect()->back()->with('error', 'Error uploading thumbnail');
            }
        }

        $video = Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'video' => $link,
            'thumbnail' => $thumbnail,
            'type' => $request->type,
            'user_id' => auth()->user()->id,
            'category_id' => $category->id,
            'duration' => $duration,
        ]);

        foreach (explode(' ', $request->tags) as $tag) {
            Tag::create(['name' => $tag, 'video_id' => $video->id]);
        }

        return redirect()->route('video.details', base64_encode($video->id));
    }

    public function encryptHLS($videoName)
    {
        $highBitRate = (new X264('aac'))->setKiloBitrate(1058);

        $video = FFMpeg::open('public/uploads/' . $videoName)
                    ->exportForHLS()
                    ->addFormat($highBitRate)
                    ->toDisk('public')
                    ->save('/videos/' . explode('.', $videoName)[0] . '.m3u8');

        return 'storage/videos/' . explode('.', $videoName)[0] . '.m3u8';
    }
    public function update(Request $request, $video)
    {
        $video = Video::find(base64_decode($video));

        $request->validate([
            'title' => 'required|max:191',
            'description' => 'required|max:191',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'type' => 'required',
            'category' => 'required',
        ]);

        $category = Category::firstOrCreate(['category_name' => $request->category]);

        if ($request->hasFile('thumbnail')) {
            $return = $request->file('thumbnail')->store('public/thumbnails');
            if ($return) {
                $thumbnail = 'storage/thumbnails/' . $request->file('thumbnail')->hashName();
            } else {
                return redirect()->back()->with('error', 'Error uploading thumbnail');
            }
        }

        $video->update([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $thumbnail ?? $video->thumbnail,
            'type' => $request->type,
            'category_id' => $category->id,
        ]);

        $video->tags()->delete();

        foreach (explode(' ', $request->tags) as $tag) {
            Tag::firstOrCreate(['name' => $tag, 'video_id' => $video->id]);
        }

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

        return view('video.manage.dashboard', compact('video'));
    }

    public function comments($video)
    {
        $video = Video::find(base64_decode($video));

        return view('video.manage.comments', compact('video'));
    }
}
