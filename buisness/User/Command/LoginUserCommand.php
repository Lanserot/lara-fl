<?php

declare(strict_types=1);


namespace Buisness\User\Command;


use Buisness\User\ValueObject\UserVO;
use Illuminate\Auth\GenericUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Infrastructure\BaseCommand;
use Infrastructure\Repositories\UserRepository;
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
            $user = (new UserRepository())->getByLogin($this->user_vo);
        } catch (\Exception $e) {
            return $this->jsonAnswer(HttpStatuses::ERROR);
        }
        if ($user->isNull()) {
            return $this->jsonAnswer(HttpStatuses::NOT_FOUND);
        }
        Auth::login(new GenericUser($user->toArray()));
        if (Auth::check()) {
            return $this->jsonAnswer(HttpStatuses::SUCCESS);
        }

        return $this->jsonAnswer(HttpStatuses::ERROR);
    }
}
