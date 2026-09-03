<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Http\Resources\ProductResource;
use App\Interfaces\Admin\ProductInterface;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Services\Admin\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $product_service
    ) {}

    /**
     * handles books
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->with('category')
            ->search($request->search)
            ->category($request->category)
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Products/Index', [
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
     * edit page on process
     *
     * @return void
     */
    public function edit()
    {
        return Inertia::render('Admin/Products/Edit');
    }



    /**
     * create book view page
     *
     * @return void
     */
    public function create()
    {
        return Inertia::render('Admin/Products/Create', [
            'categories' => Category::orderBy('name')
                ->get(['id', 'name', 'slug']),
        ]);
    }



    /**
     * handles save book
     *
     * @param ProductStoreRequest $request
     * @return void
     */
    public function store(ProductStoreRequest $request)
    {
        $this->product_service->createBook($request->validated());

        return redirect()->route('admin.products.index')
                ->with('success', 'Created new book successfully!');
    }
}
