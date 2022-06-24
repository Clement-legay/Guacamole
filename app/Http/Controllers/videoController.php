<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessVideo;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Video;
use App\Models\View;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
        $videoName = explode('/', $video->video)[count(explode('/', $video->video)) - 1];
        $videoNoExt = explode('.', $videoName)[0];

        Storage::deleteDirectory('app/public/videos/' . $videoNoExt);

        Storage::delete('app/public/thumbnails/' . $videoNoExt . 'jpg');

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

        if (Auth::user() && Auth::user()->lastView($video->id)) {
            $view = Auth::user()->lastView($video->id);
        } else {
            $view = View::create([
                'video_id' => $video->id,
                'user_id' => auth()->user()->id ?? null,
                'time_watched' => 0
            ]);
            $view->save();
        }

        return view('video.player', compact('video', 'view'));
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
                $video = $request->file('video')->hashName();
            } else {
                return redirect()->back()->with('error', 'Error uploading video');
            }
        }

        $duration = FFMpeg::open('public/uploads/' . $request->file('video')->hashName())->getDurationInSeconds();
//        $link = $this->encryptHLS($request->file('video')->hashName());

        if ($request->hasFile('thumbnail')) {
            $return = $request->file('thumbnail')->store('public/thumbnails');
            if ($return) {
                $thumbnail = 'storage/thumbnails/' . $request->file('thumbnail')->hashName();
            } else {
                return redirect()->back()->with('error', 'Error uploading thumbnail');
            }
        } else {
            $thumbnail = $this->generateThumbnail($request->file('video')->hashName());
        }

        $video = Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'video' => $video,
            'thumbnail' => $thumbnail,
            'type' => $request->type,
            'user_id' => auth()->user()->id,
            'status' => 'processing',
            'category_id' => $category->id,
            'duration' => $duration,
        ]);

        foreach (explode(' ', $request->tags) as $tag) {
            Tag::create(['name' => $tag, 'video_id' => $video->id]);
        }

        // create job to process video
        ProcessVideo::dispatch($video);

        return redirect()->route('video.details', base64_encode($video->id));
    }

    public function generateThumbnail($videoName)
    {
        $ffmpeg = FFMpeg::open('public/uploads/' . $videoName);
        $ffmpeg->getFrameFromSeconds(1)
            ->export()
            ->toDisk('public')
            ->save('/thumbnails/' . explode('.', $videoName)[0] . '.jpg');

        return 'storage/thumbnails/' . explode('.', $videoName)[0];
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

    public function getVideos()
    {
        $page = request('page') ?? 1;
        $limit = request('limit') ?? 10;

        $videos = Video::all()->sortByDesc('created_at')->forPage($page, $limit);

        return response()->json([
            'videos' => $videos,
            'total' => Video::all()->count()
        ]);
    }

    public function getVideo($video)
    {
        $video = Video::find(base64_decode($video));

        return response()->json([
            'video' => $video
        ]);
    }

    public function getVideoStats($video)
    {
        $video = Video::find(base64_decode($video));
        $props = request('props') ?? 'views,likes,dislikes,comments';
        $props = explode(',', $props);

        $stats = [
            'views' => $video->views()->count(),
            'likes' => $video->likes()->count(),
            'dislikes' => $video->dislikes()->count(),
            'comments' => $video->comments()->count(),
        ];

        $result = [];

        foreach ($props as $prop) {
            if (array_key_exists($prop, $stats)) {
                $result[$prop] = $stats[$prop];
            }
        }

        return response()->json([
            'stats' => $result
        ]);
    }

    public function getVideoComments($video)
    {
        $video = Video::find(base64_decode($video));

        $page = request('page') ?? 1;
        $limit = request('limit') ?? 10;

        $comments = $video->comments()->orderBy('created_at', 'desc')->forPage($page, $limit)->get();

        return response()->json([
            'comments' => $comments
        ]);
    }
}
