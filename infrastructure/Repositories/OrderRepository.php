<?php

declare(strict_types=1);

namespace Infrastructure\Repositories;

use App\Models\Category\Category;
use App\Models\Order\Order;
use Buisness\Category\ValueObject\CategoryVO;
use Buisness\Order\Entity\NullOrderEntity;
use Buisness\Order\Entity\OrderEntity;
use Buisness\Order\ValueObject\OrderVO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Infrastructure\Interfaces\Order\IOrderEntity;
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

    public function getEntityById(int $id): IOrderEntity
    {
        $order = $this->getModelById($id);

        if(is_null($order)){
            return new NullOrderEntity();
        }

        $category = Category::query()
            ->join('order_to_category', 'order_to_category.category_id', '=', 'categories.id')
            ->where('order_to_category.order_id', '=', $id)
            ->first();

        if(is_null($category)){
            return new NullOrderEntity();
        }

        return new OrderEntity(
            $this->orderMapper->ModelToVo($order),
            CategoryVO::get($category->name, $category->name_rus),
            $order->user_id
        );
    }

    public function getModelById(int $id): ?Model
    {
        return Order::query()
            ->where('id', '=', $id)
            ->first();
    }

    public function getLastId(): int
    {
        return $this->last_id;
    }

    public function getOrderOwnerId(int $id): ?int
    {
        return Order::query()
            ->where('id', '=', $id)
            ->pluck('user_id')
            ->first();
    }
}
