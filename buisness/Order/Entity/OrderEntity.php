<?php

declare(strict_types=1);

namespace Buisness\Order\Entity;

use Buisness\Category\ValueObject\CategoryVO;
use Buisness\Order\ValueObject\OrderVO;
use Infrastructure\Interfaces\Order\IOrderEntity;

/**
 * Class OrderEntity
 * @package Buisness\Order\Entity
 */
class OrderEntity implements IOrderEntity
{
    private OrderVO $order_vo;
    private CategoryVO $category_vo;

    public function __construct(OrderVO $order_vo, CategoryVO $category_vo)
    {
        $this->order_vo = $order_vo;
        $this->category_vo = $category_vo;
    }

    public function getOrderVo(): OrderVO
    {
        return $this->order_vo;
    }

    public function getCategoryVo(): CategoryVO
    {
        return $this->category_vo;
    }
}
