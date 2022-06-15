<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Video;
use App\Models\View;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        if (isset($_GET['category'])) {
            $categorySelected = Category::find($_GET['category']);

            $mostViewedThisWeek = View::countViewsByCat(now()->subWeek(), $categorySelected, 24);

            return view('welcome', compact('mostViewedThisWeek', 'categories', 'categorySelected'));
        } else {

            $mostViewedThisWeek = View::countViewsAll(now()->subWeek(), 24);

            return view('welcome', compact( 'mostViewedThisWeek', 'categories'));
        }

    }
}