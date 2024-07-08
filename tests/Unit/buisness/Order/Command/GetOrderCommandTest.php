<?php

declare(strict_types=1);

namespace Tests\Unit\buisness\Order\Command;

use Buisness\Order\GetOrderCommand;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * @package Tests\Unit\buisness\User\Command
 * @covers \Buisness\Order\GetOrderCommand
 */
class GetOrderCommandTest extends TestCase
{
    /**
     * @dataProvider GetOrderProvider
     */
    public function testGetOrder(int $order_id, int $result_code, string $title = '')
    {
        $result = (new GetOrderCommand())
            ->setOrderId($order_id)
            ->execute();
        $this->assertEquals($result_code, $result->getStatusCode());
        if($result->getStatusCode() == Response::HTTP_OK){
            $data = json_decode($result->getData()->message, true);
            $this->assertEquals($title, $data['title']);
        }
    }

    static function GetOrderProvider(): array
    {
        return [
            'Успех' => [
                1,
                Response::HTTP_OK,
                '3д бмв'
            ],
            'Не найден' => [
                0,
                Response::HTTP_NOT_FOUND
            ]
        ];
    }

}
