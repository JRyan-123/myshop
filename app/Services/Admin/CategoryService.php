<?php

namespace App\Services\Admin;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    
    public function saveCategory(array $data)
    {
        return Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);
    }

    public function updateCategory(Category $category, array $data)
    {
        return $category->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);
    }
}
