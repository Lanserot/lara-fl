<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $order_id;
    public int $category_id;

    public function __construct(int $order_id, int $category_id)
    {
        $this->order_id = $order_id;
        $this->category_id = $category_id;
    }

    public function getOrderId(): int
    {
        return $this->order_id;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }
}
