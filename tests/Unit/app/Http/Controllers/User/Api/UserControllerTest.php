<?php

declare(strict_types=1);

namespace Tests\Unit\app\Http\Controllers\User\Api;

use App\Http\Controllers\User\Api\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tools\HttpStatuses;

/**
 * Class UserControllerTest
 * @package Tests\Unit\app\Http\Controllers\User
 * @covers \App\Http\Controllers\User\Api\UserController
 */
class UserControllerTest extends TestCase
{

    /**
     * @dataProvider storeProvider
     */
    public function testStore(array $data, int $code)
    {
        $controller = (new UserController());
        $request = new Request();
        $request->merge($data);
        $result = $controller->store($request);
        $this->assertEquals($code, $result->getStatusCode());
    }

    static function storeProvider(): array
    {
        return [
            'Не хватает пароля' => [['login' => 'login'], (HttpStatuses::BAD_REQUEST)->value],
            'Не хватает мыла' => [['email' => 'email'], (HttpStatuses::BAD_REQUEST)->value],
            'Не хватает логина' => [['password' => 'password'], (HttpStatuses::BAD_REQUEST)->value],
            'Пароли разные' => [[
                'login' => 'login',
                'email' => 'mail@mail.ru',
                'password' => 'password',
                'password_repeat' => 'password_repeat',
            ], (HttpStatuses::BAD_REQUEST)->value],
            'Логин занят' => [[
                'login' => 'login',
                'email' => 'test@mail.ru',
                'password' => 'password',
                'password_repeat' => 'password',
            ], (HttpStatuses::FOUND)->value],
            'Мыло занято' => [[
                'login' => 'login',
                'email' => 'test@mail.ru',
                'password' => 'password',
                'password_repeat' => 'password',
            ], (HttpStatuses::FOUND)->value],
        ];
    }

    /**
     * @dataProvider updateProvider
     */
    public function testUpdate(array $data, int $code)
    {

        $user = User::where('login', 'login')->first();
        Auth::shouldReceive('user')->andReturn($user);

        $controller = (new UserController());
        $request = new Request();
        $request->merge($data);
        $result = $controller->update($request);
        $this->assertEquals($code, $result->getStatusCode());
    }


    static function updateProvider(): array
    {
        return [
            'меняем мыло' => [['email' => 'test12@mail.ru', 'login' => 'login'], (HttpStatuses::SUCCESS)->value],
            'мыло занято' => [['email' => 'test12@mail.ru', 'login' => 'login'], (HttpStatuses::FOUND)->value],
            'меняю обратно' => [['email' => 'test@example.com', 'login' => 'login'], (HttpStatuses::SUCCESS)->value],
        ];
    }
}
