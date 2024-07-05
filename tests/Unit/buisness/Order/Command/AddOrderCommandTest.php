<?php

declare(strict_types=1);

namespace Tests\Unit\buisness\Order\Command;

use App\Models\User\User;
use Buisness\Order\AddOrderCommand;
use Buisness\Order\Security\CanAddOrderCommand;
use Buisness\Order\ValueObject\OrderVO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Infrastructure\Repositories\UserRepository;
use Tests\TestCase;


/**
 * @package Tests\Unit\buisness\User\Command
 * @covers
 */
class AddOrderCommandTest extends TestCase
{
    /**
     * @dataProvider addOrderProvider
     */
    public function testUserLogin(OrderVO $order_vo, int $category_id, int $result_code)
    {
        DB::beginTransaction();

        $user = User::where('login', 'login')->first();

        Auth::shouldReceive('guard')->with('api')->andReturnSelf();
        Auth::shouldReceive('user')->andReturn($user);

        try {
            $result = (new AddOrderCommand())
                ->setOrderVo($order_vo)
                ->setCategoryId($category_id)
                ->execute();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            DB::rollBack();
            $this->fail();
        }

        $this->assertEquals($result_code, $result->getStatusCode());
        DB::rollBack();
    }

    static function addOrderProvider(): array
    {
        return [
            'Успех' => [
                OrderVO::get(
                    'Новая задача',
                    'Описание задачи',
                    0,
                    ''
                ),
                2,
                200
            ],
            'нет такой категории' => [
                OrderVO::get(
                    'Новая задача',
                    'Описание задачи',
                    0,
                    ''
                ),
                0,
                404
            ],

        ];
    }

    /**
     * @dataProvider addOrderNoRuleProvider
     */
    public function testUserNoRuleLogin(OrderVO $order_vo, int $category_id, int $result_code)
    {
        $this->markTestSkipped('Добавить роли в репозиторий');
        DB::beginTransaction();

        $user = \Mockery::mock(User::class);
        $user->shouldReceive('getAuthIdentifier')->andReturn(0);
        Auth::shouldReceive('guard')->with('api')->andReturnSelf();
        Auth::shouldReceive('user')->andReturn($user);

        $userRepositoryMock = \Mockery::mock(UserRepository::class);
        $userRepositoryMock->shouldReceive('getEntityById')->with(0)->andReturn($user);

        $roleMock = \Mockery::mock(CanAddOrderCommand::class);
        //Статику не поддерживает
        $roleMock->shouldReceive('findById')->with(0, 'api')->andReturn(null);
        $roleMock->shouldReceive('hasAnyPermission')->with(null, 'api')->andReturn(false);
        $roleMock->shouldReceive('getRoleId')->with(null, 'api')->andReturn(false);

        try {
            $result = (new AddOrderCommand())
                ->setOrderVo($order_vo)
                ->setCategoryId($category_id)
                ->execute();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            DB::rollBack();
            $this->fail();
        }

        $this->assertEquals($result_code, $result->getStatusCode());
        DB::rollBack();
    }

    static function addOrderNoRuleProvider(): array
    {
        return [
            'нет прав' => [
                OrderVO::get(
                    'Новая задача',
                    'Описание задачи',
                    0,
                    ''
                ),
                1,
                404
            ],
        ];
    }
}
