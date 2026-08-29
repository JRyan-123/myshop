<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Exceptions\InvalidTransitionException;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'shipping_address' => 'array',
            'status' => OrderStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('order_number', 'like', "%{$search}%")
                ->orWhere('shipping_address->name', 'like', "%{$search}%")
                ->orWhere('shipping_address->phone', 'like', "%{$search}%");
        });
    }

    public function scopeStatus($query, $status)
    {
        if (!$status) {
            return $query;
        }
        return $query->where('status', $status);
    }

    public function transitionTo(OrderStatus $newStatus)
    {
        if (!in_array($newStatus, $this->status->allowedTransitions())) {
            throw new InvalidTransitionException("The transition is invalid!");
        }

         $this->update([
            'status' => $newStatus,
        ]);
    }
}
