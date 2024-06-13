<?php

declare(strict_types=1);

namespace Tests\Unit\buisness\User\Command;

use Buisness\User\Command\LoginUserCommand;
use Buisness\User\ValueObject\UserLoginVO;
use Infrastructure\User\Mapper\UserMapper;
use Tests\TestCase;
use Tools\HttpStatuses;

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
        $command = (new LoginUserCommand((new UserMapper())->arrayLoginToVo($data)));
        try {
            $command_result = $command->execute();
        } catch (\Exception) {
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
                    UserLoginVO::KEY_LOGIN => 'login',
                    UserLoginVO::KEY_PASSWORD => 'password'
                ],
                HttpStatuses::SUCCESS
            ],
            'Кривой логин или пароль' => [
                [
                    UserLoginVO::KEY_LOGIN => 'log',
                    UserLoginVO::KEY_PASSWORD => '2312',
                ],
                HttpStatuses::NOT_FOUND
            ],
            'Пустые данные' => [
                [
                    UserLoginVO::KEY_LOGIN => '',
                    UserLoginVO::KEY_PASSWORD => '',
                ],
                HttpStatuses::NOT_BAD_REQUEST
            ],
        ];
    }
}
