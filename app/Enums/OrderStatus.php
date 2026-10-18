<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Processing = 'processing';
    case Shipped = 'shipped';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Failed = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Paid => 'Paid',
            self::Processing => 'Processing',
            self::Shipped => 'Shipped',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
            self::Failed => 'Failed',
        };
    }

    public function allowedTransitions()
    {
        return match ($this) {
            self::Pending => [
                self::Paid,
                self::Cancelled,
                self::Failed,
            ],

            self::Paid => [
                self::Processing,
                self::Cancelled,
            ],

            self::Processing => [
                self::Shipped,
                self::Cancelled,
            ],

            self::Shipped => [
                self::Completed
            ],

            self::Completed,
            self::Cancelled,
            self::Failed => []
        };
    }
}
