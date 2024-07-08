<?php

declare(strict_types=1);

namespace Tests\Unit\buisness\Order\Command;

use Buisness\Order\CheckUserCanRespondToOrderCommand;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 * Class CheckUserCanRespondToOrderCommandTest
 * @covers \Buisness\Order\CheckUserCanRespondToOrderCommand
 */
class CheckUserCanRespondToOrderCommandTest extends TestCase
{
    /**
     * @dataProvider CanResponseProvider
     */
    public function testCanResponse(int $order_id, int $user_id, int $result_code): void
    {
        $result = (new CheckUserCanRespondToOrderCommand())
            ->setOrderId($order_id)
            ->setUserId($user_id)
            ->execute();
        $this->assertEquals($result_code, $result->getStatusCode());
    }

    static function CanResponseProvider(): array
    {
        return [
            'Успех' => [
                1,
                1,
                Response::HTTP_OK,
            ],
            'Не найден ордер' => [
                0,
                1,
                Response::HTTP_NOT_FOUND,
            ],
            'Не найден юзер' => [
                1,
                0,
                Response::HTTP_BAD_REQUEST,
            ],
            //TODO: реализовать уже отклик
//            'Уже откликнулся' => [
//                1,
//                2,
//                Response::HTTP_BAD_REQUEST,
//            ],
            //TODO: реализовать своя же заявка
//            'Уже откликнулся' => [
//                1,
//                2,
//                Response::HTTP_BAD_REQUEST,
//            ],
        ];
    }
}
