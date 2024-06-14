<?php

declare(strict_types=1);

namespace Tests\Unit\app\Http\Controllers\User;

use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Tests\TestCase;
use Tools\HttpStatuses;

/**
 * Class UserControllerTest
 * @package Tests\Unit\app\Http\Controllers\User
 * @covers \App\Http\Controllers\User\UserController
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
            'Не хватает пароля' => ['CONTENT_TYPE' => ['login' => 'login'], HttpStatuses::BAD_REQUEST],
            'Не хватает мыла' => [['email' => 'email'], HttpStatuses::BAD_REQUEST],
            'Не хватает логина' => [['password' => 'password'], HttpStatuses::BAD_REQUEST],
            'Пароли разные' => [[
                'login' => 'login',
                'email' => 'mail@mail.ru',
                'password' => 'password',
                'password_repeat' => 'password_repeat',
            ], HttpStatuses::BAD_REQUEST],
            'Логин занят' => [[
                'login' => 'login',
                'email' => 'test@mail.ru',
                'password' => 'password',
                'password_repeat' => 'password',
            ], HttpStatuses::FOUND],
            'Мыло занято' => [[
                'login' => 'login',
                'email' => 'test@mail.ru',
                'password' => 'password',
                'password_repeat' => 'password',
            ], HttpStatuses::FOUND],
        ];
    }

}
