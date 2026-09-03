<?php

namespace App\Services\Admin;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createBook(array $data)
    {

        $data['slug'] = Str::slug($data['title']);

        if (isset($data['image'])) {
            $data['image_path'] = $data['image']->store('books', 'public');

            unset($data['image']);
        }

        return Product::create($data);
    }

    public function updateBook(Product $product, array $data)
    {
        $data['slug'] = Str::slug($data['title']);

        if (isset($data['image'])) {
            $data['image_path'] = $data['image']->store('books', 'public');

            unset($data['image']);
        }

        $product->update($data);

        return $product->refresh();
    }
}
