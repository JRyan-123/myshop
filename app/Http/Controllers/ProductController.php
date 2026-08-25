<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Fetch products with filter
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->with('category')
            ->active()
            ->search($request->search)
            ->category($request->category)
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('Products/Index', [
            'products' => ProductResource::collection($products),
            'categories' => Category::orderBy('name')
                ->get(['id', 'name', 'slug']),
            'filters' => $request->only([
                'search',
                'category',
            ]),
        ]);
    }


    /**
     * show product with recommended books
     *
     * @param Product $product
     * @return void
     */
    public function show(Product $product)
    {
        return Inertia::render('Products/Show', [
            'product' => ProductResource::make($product),
            'recommendedProducts' => Product::query()
                ->active()
                ->inRandomOrder()
                ->limit(3)
                ->get(),
        ]);
    }
}
