<?php

declare(strict_types=1);


namespace Buisness\User\Command;


use Buisness\User\ValueObject\UserVO;
use Illuminate\Auth\GenericUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Infrastructure\Interfaces\ICommand;
use Infrastructure\Repositories\UserRepository;
use Tools\HttpStatuses;

/**
 * @see \Tests\Unit\buisness\User\Command\LoginUserCommandTest
 */
final class LoginUserCommand implements ICommand
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
            $user = (new UserRepository())->getByLogin($this->user_vo);
        } catch (\Exception $e) {
            return response()->json()->setStatusCode(HttpStatuses::ERROR);
        }
        if ($user->isNull()) {
            return response()->json()->setStatusCode(HttpStatuses::NOT_FOUND);
        }
        Auth::login(new GenericUser($user->toArray()));
        if (Auth::check()) {
            return response()->json()->setStatusCode(HttpStatuses::SUCCESS);
        }

        return response()->json()->setStatusCode(HttpStatuses::ERROR);
    }
}
