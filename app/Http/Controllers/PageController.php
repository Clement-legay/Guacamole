<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Video;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class PageController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $categories = Auth::user()->interestCategories();
            if (isset($_GET['category'])) {
                $categorySelected = Category::find($_GET['category']);

                $mostViewedThisWeek = View::countViewsByCat($categorySelected, 24);

                return view('welcome', compact('mostViewedThisWeek', 'categories', 'categorySelected'));
            } else {

                $mostViewedThisWeek = View::countViewsAll(now()->subWeek(), 24);

                return view('welcome', compact( 'mostViewedThisWeek', 'categories'));
            }

        } else {
            $categories = Category::mostViewed();
            if (isset($_GET['category'])) {
                $categorySelected = Category::find($_GET['category']);

                $mostViewedThisWeek = View::countViewsByCat($categorySelected, 24);

                return view('welcome', compact('mostViewedThisWeek', 'categories', 'categorySelected'));
            } else {

                $mostViewedThisWeek = View::countViewsAll(now()->subWeek(), 24);

                return view('welcome', compact( 'mostViewedThisWeek', 'categories'));
            }
        }
    }
}
