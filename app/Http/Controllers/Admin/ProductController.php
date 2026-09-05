<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;

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
            ->orderBy('stock')
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
    public function edit(Request $request, Product $product)
    {
        return Inertia::render('Admin/Products/Edit', [
            'product' => ProductResource::make($product),
            'categories' => Category::orderBy('name')
                ->get(['id', 'name', 'slug']),
            'filters' => $request->only([
                'page',
                'search',
                'category',
            ]),
        ]);
    }


    /**
     * handles update book
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return void
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->product_service->updateBook($product, $request->validated());

        return redirect()->route('admin.products.index', $request->only([
            'page',
            'search',
            'category',
        ]))
            ->with('success', 'Book updated successfully!');
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
     * @param ProductRequest $request
     * @return void
     */
    public function store(ProductRequest $request)
    {
        $this->product_service->createBook($request->validated());

        return redirect()->route('admin.products.index')
            ->with('success', 'Created new book successfully!');
    }


    /**
     * delete book
     *
     * @param Product $product
     * @return void
     */
    public function destroy(Request $request, Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index', $request->only([
            'page',
            'search',
            'category',
        ]))
            ->with('success', 'Book deleted successfully!');
    }
}
