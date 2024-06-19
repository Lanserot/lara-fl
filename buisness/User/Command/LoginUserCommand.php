<?php

declare(strict_types=1);


namespace Buisness\User\Command;


use Buisness\User\ValueObject\UserVO;
use Illuminate\Auth\GenericUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Infrastructure\BaseCommand;
use Infrastructure\Interfaces\IUserMapper;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Mapper\User\UserMapper;
use Infrastructure\Repositories\UserRepository;
use Infrastructure\Tools\JsonFormatter;
use Tools\HttpStatuses;

/**
 * @see \Tests\Unit\buisness\User\Command\LoginUserCommandTest
 */
final class LoginUserCommand extends BaseCommand
{
    private UserVO $user_vo;

    public function __construct(UserVO $user_vo)
    {
        $this->user_vo = $user_vo;
    }

    /**
     * @throws \Exception
     */
    public function execute(): JsonResponse
    {
        if($this->user_vo->isNull()){
            throw new \Exception();
        }
        try {
            /** @var UserRepository $rep */
            $rep = app(IUserRepository::class);
            $user = $rep->getByLogin($this->user_vo);
        } catch (\Exception $e) {
            return JsonFormatter::makeAnswer((HttpStatuses::ERROR)->value);
        }
        if (!$user->getId()) {
            return JsonFormatter::makeAnswer((HttpStatuses::NOT_FOUND)->value);
        }
        /** @var UserMapper $mapper */
        $mapper = app(IUserMapper::class);
        Auth::login(new GenericUser($mapper->entityToArray($user)));
        if (Auth::check()) {
            return JsonFormatter::makeAnswer((HttpStatuses::SUCCESS)->value);
        }

        return JsonFormatter::makeAnswer((HttpStatuses::ERROR)->value);
    }
}
