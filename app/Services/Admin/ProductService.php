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



    /**
     * create a new book
     *
     * @param array $data
     * @return Product
     */
    public function createBook(array $data)
    {

        $data['slug'] = Str::slug($data['title']);

        if (isset($data['image'])) {
            $data['image_path'] = $data['image']->store('books', 'public');
            unset($data['image']);
        }

        return Product::create($data);
    }



    /**
     * Update a book
     *
     * @param Product $product
     * @param array $data
     * @return void
     */
    public function updateBook(Product $product, array $data)
    {
        $data['slug'] = Str::slug($data['title']);

        if (isset($data['image'])) {
            $data['image_path'] = $data['image']->store('books', 'public');
            unset($data['image']);
        }

        $data['is_active'] = $data['stock'] > 0;

        $product->update($data);

        return $product->refresh();
    }
}
