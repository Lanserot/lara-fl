<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Order\OrderToCategory;

class CreateOrderCategoryRelationship
{
    public function handle(OrderCreated $event)
    {
        OrderToCategory::create([
            'category_id' => $event->getCategoryId(),
            'order_id' => $event->getOrderId()
        ]);
    }
}
