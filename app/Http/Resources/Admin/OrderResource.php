<?php

namespace App\Http\Resources\Admin;

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
            'shipping_address' => [
                'name' => $this->shipping_address['name']
            ],
            'total' => $this->total,
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->label(),
            ]
        ];
    }
}
