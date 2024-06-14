<?php

declare(strict_types=1);

namespace Buisness\User\Command;

use Buisness\User\Entity\UserEntity;
use Buisness\User\ValueObject\UserVO;
use Illuminate\Support\Facades\Hash;
use Infrastructure\Interfaces\ICommand;
use Infrastructure\Repositories\UserRepository;
use Tools\HttpStatuses;

/**
 * Class RegistrationUserCommand
 * @package Buisness\User\Command
 */
class RegistrationUserCommand implements ICommand
{
    private UserVO $user_vo;

    public function __construct(UserVO $user_vo)
    {
        $this->user_vo = $user_vo;
    }

    public function execute()
    {
        if ((new UserRepository())->save(
            new UserEntity(
                Hash::make($this->user_vo->getPassword()),
                $this->user_vo->getLogin(),
                $this->user_vo->getEmail(),
            )
        )) {
            return response()->json()->setStatusCode(HttpStatuses::SUCCESS);
        }

        return response()->json()->setStatusCode(HttpStatuses::ERROR);
    }
}
