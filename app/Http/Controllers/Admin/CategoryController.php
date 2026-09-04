<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $category_service
    ) {}

    public function index(Request $request)
    {
        $search = $request->string('search')->trim()->toString();

        return Inertia::render('Admin/Category/Index', [
            'categories' => Category::withCount('products')
                ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
                ->orderBy('name')
                ->paginate(10)
                ->withQueryString(),
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function store(CategoryStoreRequest $request)
    {
        $this->category_service->saveCategory($request->validated());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }



    public function update(Category $category, CategoryStoreRequest $request)
    {
        $this->category_service->updateCategory($category, $request->validated());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
