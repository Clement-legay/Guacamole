<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessVideo;
use App\Models\Category;
use App\Models\Tag;
use App\Models\TagAssignment;
use App\Models\User;
use App\Models\Video;
use App\Models\View;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

        $chanel = User::selectRaw('users.*')->withCount('chanelViews')->where('username', 'like', '%' . $search . '%')->orderBy('chanel_views_count', 'desc')->first();

        $videos = Video::where(function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        })
            ->where('type', 'public')
            ->where('status', 'online')
            ->get();

        return view('video.search', compact('videos', 'search', 'chanel'));
    }

    public function watch($video)
    {
        $video = Video::find(base64_decode($video));

        if (Auth::user() && Auth::user()->lastView($video->id)) {
            $view = Auth::user()->lastView($video->id);
            if ($view->time_watched > ($video->duration * 0.75)) {
                $view = View::create([
                    'video_id' => $video->id,
                    'user_id' => auth()->user()->id ?? null,
                    'time_watched' => 0
                ]);
                $view->save();
            }
            $view->updated_at = now();
            $view->save();
        } else {
            $view = View::create([
                'video_id' => $video->id,
                'user_id' => auth()->user()->id ?? null,
                'time_watched' => 0
            ]);
            $view->save();
        }

        if ($video->type == 'private') {
            if (Auth::user() && Auth::id() == $video->user_id) {
                return view('video.player', compact('video', 'view'));
            } elseif (Auth::user() && Auth::user()->role()->isAdmin) {
                return view('video.player', compact('video', 'view'));
            } else {
                $view->delete();
                return redirect()->route('home');
            }
        } else {
            return view('video.player', compact('video', 'view'));
        }
    }

    public function create()
    {
        return view('video.manage.create');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'title' => 'required|max:191|regex:/^[a-zA-Z0-9\s\!#".,?\'&çéàù%:#êèôûâîïöüäë€_\-()œ$£]*$/u',
            'description' => 'required|max:191|regex:/^[a-zA-Z0-9\s\!#".,?\'&çéàù%:#êèôûâîïöüäë€_\-()œ$£]*$/u',
            'video' => 'required|mimes:mp4,mov,ogg,qt',
            'thumbnail_cropped' => 'required',
            'type' => 'required',
            'category' => 'required|max:191|regex:/^[a-zA-Z0-9\-_]+$/',
        ]);

        $image_64 = $request->input('thumbnail_cropped');

        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

        $replace = substr($image_64, 0, strpos($image_64, ',')+1);

        $image = str_replace($replace, '', $image_64);

        $image = str_replace(' ', '+', $image);

        $imageName = 'thumbnails/' . Str::random(35) . '.' . $extension;

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
            $return = Storage::disk('public')->put($imageName, base64_decode($image));
            if ($return) {
                $thumbnail = 'storage/' . $imageName;
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
            $tag = Tag::firstOrCreate(['name' => $tag]);
            TagAssignment::create([
                'video_id' => $video->id,
                'tag_id' => $tag->id,
            ]);
        }

        // create job to process video
        ProcessVideo::dispatch($video)->delay(now()->addSeconds(5));

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
            'title' => 'required|max:191|regex:/^[a-zA-Z0-9\s\!#".,?\'&çéàù%:#êèôûâîïöüäë€_\-()œ$£]*$/u',
            'description' => 'required|max:191|regex:/^[a-zA-Z0-9\s\!#".,?\'&çéàù%:#êèôûâîïöüäë€_\-()œ$£]*$/u',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'type' => 'required',
            'category' => 'required|string|max:191|regex:/^[a-zA-Z0-9\-_]+$/',
        ]);

        $category = Category::firstOrCreate(['category_name' => $request->category]);

        if ($request->hasFile('thumbnail')) {
            $image_64 = $request->input('thumbnail_cropped');
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',')+1);
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $imageName = 'thumbnails/' . Str::random(35) . '.' . $extension;
            $return = Storage::disk('public')->put($imageName, base64_decode($image));
            if ($return) {
                $thumbnail = 'storage/' . $imageName;
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

        $video->tagsAssignments()->delete();

        foreach (explode(' ', $request->tags) as $tag) {
            $tag = Tag::firstOrCreate(['name' => $tag]);
            $assignment = TagAssignment::create([
                'tag_id' => $tag->id,
                'video_id' => $video->id,
            ]);

            $assignment->save();
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

        $comments = $video->comments()->orderBy('comments.created_at', 'desc')->join('users', 'users.id', '=', 'comments.user_id')->select('comments.*', 'users.*')->forPage($page, $limit)->get();

        return response()->json([
            'comments' => $comments
        ]);
    }

    public function history()
    {
        $historyVideos = Auth::user()->history()->get();

        return view('video.history', compact('historyVideos'));
    }

    public function liked()
    {
        $likedVideos = Auth::user()->likedVideos()->get();

        return view('video.liked', compact('likedVideos'));
    }

    public function uploadVideoAPI(Request $request, $user)
    {
        $user = User::find(base64_decode($user));

        $request->validate([
            'title' => 'required|max:191',
            'description' => 'required|max:191',
            'video' => 'required',
            'type' => 'required',
            'category' => 'required',
        ]);



//        $image_64 = $request->input('thumbnail_cropped');
//
//        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
//
//        $replace = substr($image_64, 0, strpos($image_64, ',')+1);
//
//        $image = str_replace($replace, '', $image_64);
//
//        $image = str_replace(' ', '+', $image);
//
//        $imageName = 'thumbnails/' . Str::random(35) . '.' . $extension;
//
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

//        if ($request->hasFile('thumbnail')) {
//            $return = Storage::disk('public')->put($imageName, base64_decode($image));
//            if ($return) {
//                $thumbnail = 'storage/' . $imageName;
//            } else {
//                return redirect()->back()->with('error', 'Error uploading thumbnail');
//            }
//        } else {
//            $thumbnail = $this->generateThumbnail($request->file('video')->hashName());
//        }

        $video = Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'video' => $video,
            'thumbnail' => 'https://i.ytimg.com/',
            'type' => $request->type,
            'user_id' => $user->id,
            'status' => 'processing',
            'category_id' => $category->id,
            'duration' => $duration,
        ]);

        foreach (explode(' ', $request->tags) as $tag) {
            $tag = Tag::firstOrCreate(['name' => $tag]);
            TagAssignment::create([
                'video_id' => $video->id,
                'tag_id' => $tag->id,
            ]);
        }

        // create job to process video
        ProcessVideo::dispatch($video)->delay(now()->addSeconds(5));

        return redirect()->route('video.details', base64_encode($video->id));
    }
}
