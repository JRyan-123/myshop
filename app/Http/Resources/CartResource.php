<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'cartItems' => $this->cartItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'title' => $item->product->title,
                    'author' => $item->product->author,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'image_path' => $item->product->image_path,
                    'stock' => $item->product->stock,

                ];
            }),

        ];
    }
}
