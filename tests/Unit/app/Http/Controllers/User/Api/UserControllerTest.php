<?php

declare(strict_types=1);

namespace Tests\Unit\app\Http\Controllers\User\Api;

use App\Http\Controllers\User\Api\UserController;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

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
        DB::beginTransaction();

        try {
            $controller = (new UserController());
            $request = new Request();
            $request->merge($data);
            $result = $controller->store($request);
        }catch (\Exception $e){
            var_dump($e->getMessage());
            DB::rollBack();
            $this->fail();
        }

        $this->assertEquals($code, $result->getStatusCode());
        DB::rollBack();
    }

    static function storeProvider(): array
    {
        //TODO:сделать заглушку для бд, на создание нового пользователя
        return [
            'Не хватает пароля' => [['login' => 'login'], Response::HTTP_BAD_REQUEST],
            'Не хватает мыла' => [['email' => 'email'], Response::HTTP_BAD_REQUEST],
            'Не хватает логина' => [['password' => 'password'], Response::HTTP_BAD_REQUEST],
            'Пароли разные' => [[
                'login' => 'login',
                'email' => 'mail@mail.ru',
                'password' => 'password',
                'password_repeat' => 'password_repeat',
            ], Response::HTTP_BAD_REQUEST],
            'Логин занят' => [[
                'login' => 'login',
                'email' => 'test@mail.ru',
                'password' => 'password',
                'password_repeat' => 'password',
            ], Response::HTTP_FOUND],
            'Мыло занято' => [[
                'login' => 'login',
                'email' => 'test@mail.ru',
                'password' => 'password',
                'password_repeat' => 'password',
            ], Response::HTTP_FOUND],
        ];
    }

    /**
     * @dataProvider updateProvider
     */
    public function testUpdate(array $data, int $code, int $id)
    {

        DB::beginTransaction();

        try {
            $user = User::where('login', 'login')->first();
            Auth::shouldReceive('user')->andReturn($user);

            $controller = (new UserController());
            $request = new Request();
            $request->merge($data);
            $result = $controller->update($request, $id);
        }catch (\Exception $e){
            var_dump($e->getMessage());
            DB::rollBack();
            $this->fail();
        }

        DB::rollBack();
        $this->assertEquals($code, $result->getStatusCode());
    }


    static function updateProvider(): array
    {
        return [
            'меняем мыло' => [['email' => 'test12@mail.ru', 'login' => 'login'], Response::HTTP_OK, 10],
            'мыло занято' => [['email' => 'test@example.com', 'login' => 'login'], Response::HTTP_FOUND, 10],
        ];
    }
}
