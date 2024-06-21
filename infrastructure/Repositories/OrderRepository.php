<?php

declare(strict_types=1);

namespace Infrastructure\Repositories;

use App\Models\Order\Order;
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
            $user = Order::create(array_merge($order_vo->toArray(), ['user_id' => auth('api')->user()->getAuthIdentifier()]));
            $this->last_id = $user->id;
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
