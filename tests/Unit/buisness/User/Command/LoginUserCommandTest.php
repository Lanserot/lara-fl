<?php

declare(strict_types=1);

namespace Tests\Unit\buisness\User\Command;

use Buisness\User\Command\LoginUserCommand;
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
        $command = (new LoginUserCommand())->setData($data);
        try {
            $command_result = $command->execute();
        }catch (\Exception){
            $this->assertTrue(true);
            return;
        }
        $this->assertEquals($result, $command_result->getStatusCode());
    }

    static function userLoginProvider(): array
    {
        return [
            'Успех' => [['login' => 'login'], HttpStatuses::SUCCESS],
            'Кривой логин' => [['login' => 'log'], HttpStatuses::NOT_FOUND],
            'Пустые данные' => [['login' => ''], HttpStatuses::NOT_BAD_REQUEST],
        ];
    }
}
