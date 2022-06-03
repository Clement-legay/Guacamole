<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Video;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        if (isset($_GET['category'])) {
            $categorySelected = Category::find($_GET['category']);
            $lastVideos = Video::where('id_categorie', $_GET['category'])
                ->orderBy('id', 'desc')
                ->take(12)
                ->get();
            $mostViewedVideos = Video::where('id_categorie', $_GET['category'])
                ->orderBy('views', 'desc')
                ->take(12)
                ->get();

            return view('welcome', compact('lastVideos', 'mostViewedVideos', 'categories', 'categorySelected'));
        } else {
            $lastVideos = Video::orderBy('id', 'desc')
                ->take(12)
                ->get();;
            $mostViewedVideos = Video::orderBy('views', 'desc')
                ->take(12)
                ->get();

            return view('welcome', compact('lastVideos', 'mostViewedVideos', 'categories'));
        }

    }
}
