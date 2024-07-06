<?php

declare(strict_types=1);

namespace Buisness\Order\Entity;

use Buisness\Category\ValueObject\CategoryVO;
use Buisness\Order\ValueObject\OrderVO;
use Infrastructure\Interfaces\Order\IOrderEntity;

/**
 * Class NullOrderEntity
 * @package Buisness\Order\Entity
 */
class NullOrderEntity implements IOrderEntity
{
    public function getOrderVo(): OrderVO
    {
        return OrderVO::getNull();
    }

    public function getCategoryVo(): CategoryVO
    {
        return CategoryVO::getNull();
    }
}
