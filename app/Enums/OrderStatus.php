<?php

namespace App\Enums;


enum OrderStatus: string
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Processing => 'Processing',
            self::Shipped => 'Shipped',
            self::Delivered => 'Delivered',
            self::Cancelled => 'Cancelled',
        };
    }

    public function allowedTransitions()
    {
        return match($this){
            self::Pending => [
                self::Processing,
                self::Cancelled,
            ],

            self::Processing => [
                self::Shipped,
                self::Cancelled,
            ],

            self::Shipped => [
                self::Delivered
            ],

            self::Delivered,
            self::Cancelled => []
        };
    }
}
