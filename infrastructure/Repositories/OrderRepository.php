<?php

declare(strict_types=1);

namespace Infrastructure\Repositories;

use App\Models\Order\Order;
use App\Models\Order\OrderToCategory;
use Buisness\Order\ValueObject\OrderVO;
use Illuminate\Support\Facades\DB;
use Infrastructure\Interfaces\Order\IOrderRepository;

/**
 * Class OrderRepository
 * @package Infrastructure\Repositories
 */
class OrderRepository implements IOrderRepository
{
    private int $last_id = 0;

    public function save(OrderVO $order_vo): bool
    {
        DB::beginTransaction();
        try {
            $order = Order::create(array_merge($order_vo->toArray(), ['user_id' => auth('api')->user()->getAuthIdentifier()]));
            OrderToCategory::create([
               'category_id' => $order_vo->getCategoryId(),
               'order_id' => $order->id
            ]);
            $this->last_id = $order->id;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }

        return true;
    }

    public function getLastId(): int
    {
        return $this->last_id;
    }
}
