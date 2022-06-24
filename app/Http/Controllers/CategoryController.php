<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function searchCategory()
    {
        $search = request()->input('search');
        $limit = request()->input('limit');

        return json_encode(Category::searchCategory($search, $limit));
    }

    public function getCategories()
    {
        $page = request('page') ?? 1;
        $limit = request('limit') ?? 10;

        $categories = Category::all()->sortByDesc('created_at')->forPage($page, $limit);

        return json_encode([
            'categories' => $categories,
            'total' => Category::all()->count(),
        ]);
    }

    public function getCategory($category)
    {
        $category = Category::find(base64_decode($category));

        return json_encode([
            'category' => $category,
        ]);
    }
}
