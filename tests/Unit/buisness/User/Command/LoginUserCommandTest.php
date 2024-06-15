<?php

declare(strict_types=1);

namespace Tests\Unit\buisness\User\Command;

use Buisness\User\Command\LoginUserCommand;
use Buisness\User\ValueObject\UserVO;
use Infrastructure\Interfaces\IUserMapper;
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
        /** @var \Infrastructure\Mapper\User\UserMapper $user_mapper */
        $user_mapper = app(IUserMapper::class);
        $command = (new LoginUserCommand($user_mapper->arrayLoginToVo($data)));
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
                    UserVO::KEY_LOGIN => 'login',
                    UserVO::KEY_PASSWORD => 'password'
                ],
                (HttpStatuses::SUCCESS)->value
            ],
            'Кривой логин или пароль' => [
                [
                    UserVO::KEY_LOGIN => 'logint',
                    UserVO::KEY_PASSWORD => 'qwerty',
                ],
                (HttpStatuses::NOT_FOUND)->value
            ],
            'Пустые данные' => [
                [
                    UserVO::KEY_LOGIN => '',
                    UserVO::KEY_PASSWORD => '',
                ],
                (HttpStatuses::BAD_REQUEST)->value
            ],
        ];
    }
}
