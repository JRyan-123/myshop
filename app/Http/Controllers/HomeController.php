<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * home page with categories and 4 featured books
     *
     * @return void
     */
    public function index()
    {
        return Inertia::render('Home', [
            'featuredBooks' => Product::latest()->take(4)->get(),
            'categories' => Category::withCount('products')->latest()->take(6)->get(),
        ]);
    }
}
