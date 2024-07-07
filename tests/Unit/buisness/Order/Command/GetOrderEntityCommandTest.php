<?php

declare(strict_types=1);

namespace Tests\Unit\buisness\Order\Command;

use Buisness\Order\GetOrderEntityCommand;
use Infrastructure\Enums\CategoryEnum;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

/**
 * @package Tests\Unit\buisness\User\Command
 * @covers \Buisness\Order\GetOrderEntityCommand
 */
class GetOrderEntityCommandTest extends TestCase
{
    /**
     * @dataProvider GetOrderProvider
     */
    public function testGetOrder(int $order_id, int $result_code, array $result_success = [])
    {
        $result = (new GetOrderEntityCommand())
            ->setOrderId($order_id)
            ->execute();
        $this->assertEquals($result_code, $result->getStatusCode());
        if($result->getStatusCode() == ResponseAlias::HTTP_OK){
            $data = json_decode($result->getData()->message, true);
            $this->assertEquals($result_success['title'], $data['order']['title']);
            $this->assertEquals($result_success['category'], $data['category']['name']);
        }
    }

    static function GetOrderProvider(): array
    {
        return [
            'Успех' => [
                1,
                ResponseAlias::HTTP_OK,
                [
                    'title' => '3д бмв',
                    'category' => CategoryEnum::MODEL_3D->value
                ]
            ],
            'Не найден' => [
                0,
                ResponseAlias::HTTP_NOT_FOUND
            ]
        ];
    }

}
