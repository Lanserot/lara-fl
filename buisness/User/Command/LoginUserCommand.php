<?php

declare(strict_types=1);


namespace Buisness\User\Command;


use Buisness\User\UserVO;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\GenericUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Infrastructure\Repositories\UserRepository;
use Tools\HttpStatuses;

/**
 * @see \Tests\Unit\buisness\User\Command\LoginUserCommandTest
 */
final class LoginUserCommand
{
    private array $data = [];

    /**
     * @throws \Exception
     */
    public function execute(): JsonResponse
    {
        if(empty($this->data)){
            throw new \Exception();
        }
        try {
            $user = (new UserRepository())->getByLogin($this->data[UserVO::KEY_LOGIN]);
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

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }
}
