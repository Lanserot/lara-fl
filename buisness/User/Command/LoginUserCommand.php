<?php

declare(strict_types=1);


namespace Buisness\User\Command;


use Buisness\User\ValueObject\UserVO;
use Illuminate\Http\JsonResponse;
use Infrastructure\BaseCommand;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Repositories\UserRepository;
use Infrastructure\Tools\JsonFormatter;
use App\Enums\HttpStatuses;
use Tymon\JWTAuth\Facades\JWTAuth;

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

        $credentials = ['login' => $this->user_vo->getLogin(), 'password' => $this->user_vo->getPassword()];

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60 * 60
        ]);
    }
}
