<?php

declare(strict_types=1);

namespace Infrastructure\Repositories;

use App\Models\Order\Order;
use Buisness\Order\ValueObject\OrderVO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Infrastructure\Interfaces\Order\IOrderMapper;
use Infrastructure\Interfaces\Order\IOrderRepository;

/**
 * Class OrderRepository
 * @package Infrastructure\Repositories
 */
class OrderRepository implements IOrderRepository
{
    private IOrderMapper $orderMapper;

    public function __construct(IOrderMapper $orderMapper)
    {
        $this->orderMapper = $orderMapper;
    }

    private int $last_id = 0;

    public function save(OrderVO $order_vo): bool
    {
        DB::beginTransaction();
        try {
            $order_array = $this->orderMapper->VoToArray($order_vo);
            $order_array['user_id'] = auth('api')->user()->getAuthIdentifier();
            $order = Order::create($order_array);
            $this->last_id = $order->id;
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return false;
        }

        return true;
    }

    public function getById(int $id): array
    {
        $order = Order::query()
            ->select('orders.*',
                'categories.name as category_name',
                'categories.name_rus as category_name_rus')
            ->join('order_to_category', 'order_to_category.order_id', '=', 'orders.id')
            ->join('categories', 'categories.id', '=', 'order_to_category.category_id')
            ->where('order_id', '=', $id)
            ->first();
        if (is_null($order)) {
            return [];
        }

        return $order->toArray();
    }

    public function getLastId(): int
    {
        return $this->last_id;
    }
}
