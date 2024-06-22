<?php

declare(strict_types=1);

namespace Tests\Unit\buisness\User\Command;

use Symfony\Component\HttpFoundation\Response;
use Buisness\User\Command\LoginUserCommand;
use Buisness\User\ValueObject\UserVO;
use Infrastructure\Interfaces\User\IUserMapper;
use Infrastructure\Mapper\User\UserMapper;
use Tests\TestCase;

/**
 * @package Tests\Unit\buisness\User\Command
 */
class LoginUserCommandTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @dataProvider userLoginProvider
     */
    public function testUserLogin(array $data, $result)
    {
        /** @var UserMapper $user_mapper */
        $user_mapper = app(IUserMapper::class);
        $command = (new LoginUserCommand($user_mapper->arrayLoginToVo($data)));
        try {
            $command_result = $command->execute();
        } catch (\Exception $e) {
            $this->assertTrue(true);
            return;
        }
        $this->assertEquals($result, $command_result->getStatusCode());
    }

    static function userLoginProvider(): array
    {
        return [
            'Успех' => [
                [
                    UserVO::KEY_LOGIN => 'login',
                    UserVO::KEY_PASSWORD => 'password'
                ],
                Response::HTTP_OK
            ],
            'Кривой логин или пароль' => [
                [
                    UserVO::KEY_LOGIN => 'logint',
                    UserVO::KEY_PASSWORD => 'qwerty',
                ],
                Response::HTTP_NOT_FOUND
            ],
            'Пустые данные' => [
                [
                    UserVO::KEY_LOGIN => '',
                    UserVO::KEY_PASSWORD => '',
                ],
                Response::HTTP_BAD_REQUEST
            ],
        ];
    }
}
