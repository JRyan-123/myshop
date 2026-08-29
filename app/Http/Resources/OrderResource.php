<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_number' => $this->order_number,
            'date' => $this->created_at->format('M d, Y'),

            'total' => $this->total,
            'subtotal' => $this->subtotal,
            'shipping_fee' => $this->shipping_fee,
            'details' => $this->shipping_address,


            'order_items' => $this->orderItems->map(function ($item) {
                return [
                    'product_name' => $item->product_name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'image_path' => $item->product->image_path,
                ];
            }),
            'shipping_address' => [
                'name' => $this->shipping_address['name'],
                'phone' => $this->shipping_address['phone'],
                'city' => $this->shipping_address['city'],
                'street' => $this->shipping_address['street'],
            ],
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->label(),

                'transitions' => collect($this->status->allowedTransitions())
                    ->map(fn ($status) => [
                        'value' => $status->value,
                        'label' => $status->label(),
                    ])->values(),

            ],


        ];
    }
}
